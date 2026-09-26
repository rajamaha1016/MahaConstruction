# Maha Construction — Production Deployment Guide

> **Hosting-platform independent.** This application can be deployed to any
> environment that provides a container runtime, environment variable injection,
> a persistent database, and optionally persistent object storage.
>
> No platform-specific logic exists in the application code.
> Only the *deployment tooling* (docker-entrypoint.sh, render.yaml, railway.json)
> is platform-aware — and only for convenience, not correctness.

---

## Table of Contents

1. [Architecture Overview](#1-architecture-overview)
2. [Required Environment Variables](#2-required-environment-variables)
3. [Database](#3-database)
4. [Email / SMTP](#4-email--smtp)
5. [File Storage](#5-file-storage)
6. [Docker Deployment](#6-docker-deployment)
7. [Deployment Flow](#7-deployment-flow)
8. [Existing File Migration Plan](#8-existing-file-migration-plan)
9. [Diagnostic Commands](#9-diagnostic-commands)
10. [Backup Strategy](#10-backup-strategy)
11. [Post-Deployment Verification Checklist](#11-post-deployment-verification-checklist)
12. [Platform-Specific Notes](#12-platform-specific-notes)

---

## 1. Architecture Overview

```
┌────────────────────────────────────────────────────────────────────┐
│                     MAHA CONSTRUCTION APP                         │
│                       (Docker container)                           │
│                                                                    │
│  PHP 8.2 + Apache + Laravel 11                                     │
│                                                                    │
│  Reads from environment variables:                                 │
│    APP_URL  →  production reset links / asset URLs                 │
│    DB_*     →  any persistent database                             │
│    MAIL_*   →  any SMTP provider                                   │
│    AWS_*    →  any S3-compatible object storage                    │
└──────────┬──────────────────────────────────────────┬─────────────┘
           │                                          │
           ▼                                          ▼
  ┌─────────────────┐                    ┌─────────────────────────┐
  │   DATABASE      │                    │   OBJECT STORAGE        │
  │                 │                    │                         │
  │  SQLite (disk)  │                    │  Any S3-compatible:     │
  │  MySQL/Postgres │                    │  • AWS S3               │
  │  (managed)      │                    │  • Cloudflare R2        │
  │                 │                    │  • DigitalOcean Spaces  │
  │  DB_CONNECTION  │                    │  • Backblaze B2         │
  │  DB_HOST / etc. │                    │  • MinIO (self-hosted)  │
  └─────────────────┘                    │                         │
                                         │  FILESYSTEM_DISK=s3     │
                                         │  AWS_ACCESS_KEY_ID      │
                                         │  AWS_SECRET_ACCESS_KEY  │
                                         │  AWS_BUCKET             │
                                         │  AWS_DEFAULT_REGION     │
                                         │  AWS_ENDPOINT (if R2/DO)│
                                         └─────────────────────────┘
```

---

## 2. Required Environment Variables

Set ALL of these in your hosting platform's environment/secrets panel.
**Never commit real values to Git.**

### Core Application

| Variable | Description | Example |
|---|---|---|
| `APP_NAME` | Application name | `Maha Construction` |
| `APP_ENV` | Environment | `production` |
| `APP_KEY` | Laravel encryption key (32 bytes, base64) | `base64:...` |
| `APP_URL` | **Full HTTPS URL of your application** | `https://mahaconstruction.com` |
| `APP_DEBUG` | Debug mode — always `false` in production | `false` |

> **`APP_URL` is the single most important variable.** Password-reset links,
> uploaded file URLs, and asset references all derive from it.
> Change your domain → update only this variable.

### Database

| Variable | Description | Example |
|---|---|---|
| `DB_CONNECTION` | Driver | `sqlite`, `mysql`, `pgsql` |
| `DB_HOST` | Server hostname | `db.example.com` |
| `DB_PORT` | Port | `3306` (MySQL), `5432` (Postgres) |
| `DB_DATABASE` | Database name or SQLite file path | `maha_production` |
| `DB_USERNAME` | Database user | `maha_user` |
| `DB_PASSWORD` | Database password | *(secret)* |

> For SQLite on a platform without a persistent volume, the database will be
> lost on redeployment. Use MySQL, PostgreSQL, or a managed SQLite with a
> persistent volume mount.

### Mail / SMTP

| Variable | Description | Value |
|---|---|---|
| `MAIL_MAILER` | Driver | `smtp` (production) / `log` (local dev) |
| `MAIL_HOST` | SMTP server | `smtp.gmail.com` |
| `MAIL_PORT` | SMTP port | `587` |
| `MAIL_USERNAME` | SMTP username | `youraccount@gmail.com` |
| `MAIL_PASSWORD` | SMTP password / App Password | *(secret — 16-char Google App Password)* |
| `MAIL_ENCRYPTION` | Encryption | `tls` |
| `MAIL_FROM_ADDRESS` | From address | `youraccount@gmail.com` |
| `MAIL_FROM_NAME` | From display name | `Maha Construction Admin` |

> **For Gmail:** Enable 2-Step Verification on the account, then generate a
> Google App Password at https://myaccount.google.com/apppasswords.
> Use the 16-character code (with or without spaces — both work).

### File Storage (S3-compatible)

| Variable | Description | Example |
|---|---|---|
| `FILESYSTEM_DISK` | Active storage driver | `s3` (production), `local` (dev) |
| `AWS_ACCESS_KEY_ID` | S3 key ID | *(secret)* |
| `AWS_SECRET_ACCESS_KEY` | S3 secret | *(secret)* |
| `AWS_DEFAULT_REGION` | Region | `us-east-1`, `auto` (R2) |
| `AWS_BUCKET` | Bucket name | `maha-construction-uploads` |
| `AWS_ENDPOINT` | Custom endpoint (non-AWS only) | `https://xxx.r2.cloudflarestorage.com` |
| `AWS_URL` | Public CDN / bucket URL for serving files | `https://cdn.mahaconstruction.com` |

> Leave `AWS_ENDPOINT` unset for native AWS S3.
> For Cloudflare R2: set `AWS_ENDPOINT`, `AWS_DEFAULT_REGION=auto`.
> For DigitalOcean Spaces: `AWS_ENDPOINT=https://<region>.digitaloceanspaces.com`.

### Admin

| Variable | Description | Example |
|---|---|---|
| `ADMIN_EMAIL` | Admin email for OTP password reset | `admin@example.com` |
| `ADMIN_PASSWORD` | Initial admin password (seed only) | *(secret)* |

### Optional Platform Helpers

| Variable | Description |
|---|---|
| `PLATFORM_DOMAIN` | Generic — set to `yourdomain.com`; entrypoint derives `APP_URL` from it |
| `DB_SEED_ON_BOOT` | `true` to run full seeders on startup (⚠️ overwrites data). Default: `false` |
| `LOG_CHANNEL` | Logging channel. Use `stderr` for container environments |

---

## 3. Database

### Supported databases

- **SQLite** — simple, zero-config. Use only with a **persistent volume mount** or a managed platform.
- **MySQL 8+** — recommended for production.
- **PostgreSQL 15+** — recommended for production.

### Rules

- ✅ **Safe migrations only:** `php artisan migrate --force`
- ❌ **Never run:** `php artisan migrate:fresh` or `migrate:refresh` on production
- ❌ **Never seed production** with `db:seed` unless `DB_SEED_ON_BOOT=true` explicitly set
- ✅ **Backups before migration:** always back up before running migrations on production

### SQLite + Persistent Volume

If using SQLite with a platform-mounted volume (e.g., Render Disk, Railway Volume):

```
DB_CONNECTION=sqlite
DB_DATABASE=/mnt/data/database.sqlite   # path inside the mounted volume
```

The entrypoint handles this automatically — it detects the default SQLite path and
relocates the file to the `public/uploads/.data/` directory which is typically
inside the persistent volume mount.

---

## 4. Email / SMTP

The application uses **Gmail SMTP** by default.

### Production

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=mahaconstructions2013@gmail.com
MAIL_PASSWORD=<16-char Google App Password>
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=mahaconstructions2013@gmail.com
MAIL_FROM_NAME="Maha Construction Admin"
```

### Local Development

```env
MAIL_MAILER=log
```

Emails are written to `storage/logs/laravel.log` — no real emails sent.

### Forgot Password Flow

```
Admin Login → Forgot Password → Enter email
→ Backend generates OTP + secure reset token
→ Gmail SMTP sends OTP email
→ Email contains: OTP code + APP_URL/admin/reset-password/{token}
→ Admin opens link → enters OTP → sets new password
→ Token invalidated → session revoked → login with new password
```

The reset URL is built from `APP_URL` — changing your domain only requires
updating the `APP_URL` environment variable.

---

## 5. File Storage

### Local (development only)

```env
FILESYSTEM_DISK=local
```

Files are stored in `public/uploads/`. They will be **lost on container rebuild**
unless you mount a persistent volume to `public/uploads/`.

### S3-compatible (production — recommended)

```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=<your-key>
AWS_SECRET_ACCESS_KEY=<your-secret>
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=maha-construction-uploads
AWS_ENDPOINT=             # leave empty for AWS S3
AWS_URL=                  # optional CDN URL
```

The application code uses `Storage::disk('s3')` and `Storage::disk(config('filesystems.default'))` — it is **provider-agnostic**.

### Supported S3-compatible providers

| Provider | Region | Endpoint |
|---|---|---|
| AWS S3 | e.g. `us-east-1` | (leave blank) |
| Cloudflare R2 | `auto` | `https://ACCOUNT_ID.r2.cloudflarestorage.com` |
| DigitalOcean Spaces | e.g. `sgp1` | `https://sgp1.digitaloceanspaces.com` |
| Backblaze B2 | e.g. `us-west-004` | `https://s3.us-west-004.backblazeb2.com` |
| MinIO (self-hosted) | any | `http://your-minio-host:9000` |

---

## 6. Docker Deployment

### Dockerfile

The Dockerfile contains **only application code**. It does NOT contain:
- Production credentials
- Uploaded files
- Database data
- Gmail passwords

A new Docker image can be deployed at any time and will reconnect to:
- The same database (via `DB_*` env vars)
- The same object storage (via `AWS_*` env vars)
- The same email provider (via `MAIL_*` env vars)

### docker-entrypoint.sh

Runs at container startup and:
1. Configures Apache port from `$PORT` (if set)
2. Derives `APP_URL` from platform domain variables if set
3. Syncs all platform-injected env vars into `.env` with proper quoting
4. Runs `php artisan migrate --force` (safe, non-destructive)
5. Caches Laravel config/routes/views

### Build

```bash
docker build -t maha-construction .
docker run -p 8080:80 \
  -e APP_ENV=production \
  -e APP_KEY=base64:... \
  -e APP_URL=https://yourdomain.com \
  -e MAIL_MAILER=smtp \
  -e MAIL_HOST=smtp.gmail.com \
  -e MAIL_PORT=587 \
  -e MAIL_USERNAME=youraccount@gmail.com \
  -e MAIL_PASSWORD="your app password" \
  -e MAIL_ENCRYPTION=tls \
  -e MAIL_FROM_ADDRESS=youraccount@gmail.com \
  -e DB_CONNECTION=sqlite \
  maha-construction
```

---

## 7. Deployment Flow

```
1. Push code to Git (never push .env or secrets)
         ↓
2. Hosting platform builds Docker image
         ↓
3. Hosting platform injects environment variables into container
         ↓
4. docker-entrypoint.sh runs:
   a. Syncs env vars → .env
   b. php artisan migrate --force   (non-destructive)
   c. php artisan config:cache
   d. php artisan route:cache
   e. php artisan view:cache
         ↓
5. Apache starts, app serves requests
         ↓
6. App connects to database (via DB_* vars)
7. App connects to object storage (via AWS_* vars)
8. App sends email via SMTP (via MAIL_* vars)
```

> A new deployment does **not** recreate or wipe any production data.

---

## 8. Existing File Migration Plan

> **⚠️ IMPORTANT:** Complete this before switching `FILESYSTEM_DISK` to `s3`
> on production. Do NOT switch to an empty S3 bucket without migrating first.

### Step 1 — Inventory existing files

SSH/shell into the current production container:

```bash
ls -la /var/www/html/public/uploads/
find /var/www/html/public/uploads -type f | wc -l
```

### Step 2 — Back up existing files

Download the entire `public/uploads/` directory to a safe local backup before
making any changes.

### Step 3 — Create S3 bucket

Create a bucket with your chosen provider (AWS, R2, DO Spaces, etc.).
Set bucket to **public read** or configure a CDN/signed-URL policy as needed.

### Step 4 — Copy existing files to S3

```bash
# Using AWS CLI (works for AWS S3 and compatible providers)
aws s3 sync /var/www/html/public/uploads/ s3://your-bucket-name/uploads/ \
  --endpoint-url https://your-endpoint-if-not-aws
```

### Step 5 — Verify files in S3

Confirm all files appear in the bucket. Spot-check a few URLs.

### Step 6 — Update database records (if needed)

If `filepath` column in `media_items` table stores `/uploads/filename`,
it will continue to work (the app rewrites the URL from the disk).

If `filepath` stores full URLs with the old domain:
```bash
# Update records to use S3 URLs
php artisan tinker
# >> App\Models\MediaItem::all()->each(fn($m) => ...)
```
Use the `FixStorageUrls` artisan command if broken `/storage/uploads/` paths exist:
```bash
php artisan fix:storage-urls
```

### Step 7 — Switch to S3

Add to your hosting platform Variables panel:
```
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=<key>
AWS_SECRET_ACCESS_KEY=<secret>
...
```

### Step 8 — Redeploy and verify

1. Upload a new file — confirm it appears in S3
2. Confirm existing files still display correctly (they should, if URLs are correct)
3. Redeploy again — confirm old and new files still exist

---

## 9. Diagnostic Commands

Run these via your platform's shell or `railway run` / `render shell`:

### Mail diagnostics
```bash
php artisan mail:diagnose
php artisan mail:diagnose --send-test   # sends a plain test email
```

### Storage diagnostics
```bash
php artisan storage:diagnose
php artisan storage:diagnose --write-test   # write/read/delete test
```

---

## 10. Backup Strategy

### Database

| Database | Backup method |
|---|---|
| SQLite | Copy `database.sqlite` file to off-platform storage |
| MySQL/Postgres | Use managed provider's automatic snapshot feature |
| Any | `php artisan db:dump` (if available) or `mysqldump`/`pg_dump` |

**Recommended:** Use a managed database (MySQL/Postgres) with automatic daily snapshots.

### File Storage

| Storage | Backup method |
|---|---|
| S3 / Cloudflare R2 | Enable versioning + replication to another bucket/region |
| DigitalOcean Spaces | Enable Space CDN + separate backup bucket |
| Local (not recommended for production) | External volume snapshots |

> Do NOT rely on the Docker container filesystem as a backup. Containers are
> ephemeral — treat them as disposable.

---

## 11. Post-Deployment Verification Checklist

After every fresh deployment, verify:

| # | Test | Expected Result |
|---|---|---|
| A | Open `https://yourdomain.com` | Home page loads |
| B | Open `https://yourdomain.com/admin/login` | Login page loads |
| C | Log in with admin credentials | Dashboard visible |
| D | Open Dashboard → check project/gallery content | Existing data present |
| E | Open existing uploaded image URL | Image displays |
| F | Upload a new image | Upload succeeds, image displays |
| G | Redeploy (push a trivial code change) | Container restarts |
| H | Check old uploaded image URL again | **Still displays ✅** |
| I | Check newly uploaded image again | **Still displays ✅** |
| J | Go to Forgot Password | Form loads |
| K | Enter admin email, click Send OTP | "Check your email" message |
| L | Open Gmail — confirm OTP email received | Email received with OTP |
| M | Email link starts with `https://yourdomain.com/admin/reset-password/` | Correct domain, not localhost |
| N | Click link → enter OTP → set new password | Password changed |
| O | Log in with new password | Login succeeds |
| P | Log in with old password | Login fails |

> **If test H or I fails:** Your storage is not persistent. You must either
> configure S3 or mount a persistent volume before going to production.

---

## 12. Platform-Specific Notes

### Railway

- Set `APP_URL` directly in Railway Variables panel.
- Railway also injects `RAILWAY_PUBLIC_DOMAIN` — the entrypoint uses this
  automatically if `APP_URL` is not set.
- Railway volumes must be mounted at `public/uploads` to persist local files.
- Recommended: use an external S3-compatible bucket instead of Railway volumes.

### Render

- Set `APP_URL` in Render Environment Variables.
- Render Disks must be mounted at `public/uploads` for local file persistence.
- `render.yaml` already includes a Render Disk configuration.

### DigitalOcean App Platform

- Set all env vars in the App Spec or Environment panel.
- Use a DigitalOcean Space (Spaces are S3-compatible) for file storage.
- Set `FILESYSTEM_DISK=s3` with your Spaces credentials.

### Fly.io

- Set env vars via `fly secrets set KEY=VALUE`.
- Use a Fly Volume or Tigris (S3-compatible) for storage.

### VPS / Docker Host (generic)

- Use a `.env` file on the host (never inside the image).
- Mount a persistent directory at `public/uploads`.
- Or configure S3 credentials for external storage.

### AWS ECS / GCP Cloud Run / Azure Container Apps

- Inject secrets via the platform's secret manager (Parameter Store, Secret Manager, Key Vault).
- Set `FILESYSTEM_DISK=s3` for native S3 storage.
- Set `APP_URL` to your load balancer or custom domain.
