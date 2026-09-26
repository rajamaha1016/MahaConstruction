<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class StorageDiagnose extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'storage:diagnose
                            {--write-test : Attempt a write/read/delete cycle on the configured disk}';

    /**
     * The console command description.
     */
    protected $description = 'Safely diagnose storage configuration (never exposes secret keys or credentials)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->newLine();
        $this->line('═══════════════════════════════════════════════════════');
        $this->info('  Maha Construction — Safe Storage Diagnostics');
        $this->line('═══════════════════════════════════════════════════════');
        $this->newLine();

        // ── 1. Application Environment ──────────────────────────────────
        $this->info('① Application Environment');
        $appEnv = config('app.env', app()->environment());
        $appUrl = config('app.url', '(not set)');
        $this->line("   APP_ENV = {$appEnv}");
        $this->line("   APP_URL = {$appUrl}");
        $this->newLine();

        // ── 2. Filesystem Disk ──────────────────────────────────────────
        $this->info('② Filesystem Disk');
        $disk    = config('filesystems.default', 'local');
        $diskOk  = in_array($disk, ['local', 'public', 's3'], true);
        $diskEnv = getenv('FILESYSTEM_DISK') !== false ? getenv('FILESYSTEM_DISK') : '(not set in OS env)';
        $this->line("   FILESYSTEM_DISK (config) = {$disk} " . ($diskOk ? '✅' : '⚠️  unknown disk'));
        $this->line("   FILESYSTEM_DISK (OS env) = {$diskEnv}");
        $this->newLine();

        // ── 3. S3 / Object Storage Settings ────────────────────────────
        $this->info('③ S3 / Object Storage Settings');
        if ($disk === 's3') {
            $bucket   = config('filesystems.disks.s3.bucket', null);
            $region   = config('filesystems.disks.s3.region', null);
            $endpoint = config('filesystems.disks.s3.endpoint', null);
            $url      = config('filesystems.disks.s3.url', null);
            $keySet   = !empty(config('filesystems.disks.s3.key'));
            $secretSet = !empty(config('filesystems.disks.s3.secret'));

            $this->line("   AWS_BUCKET          = " . ($bucket   ? $bucket                 : '(not set) ❌'));
            $this->line("   AWS_DEFAULT_REGION  = " . ($region   ? $region                 : '(not set) ❌'));
            $this->line("   AWS_ENDPOINT        = " . ($endpoint ? $endpoint               : '(default — uses AWS)'));
            $this->line("   AWS_URL             = " . ($url      ? $url                    : '(not set — will use default)'));
            $this->line("   AWS_ACCESS_KEY_ID   = " . ($keySet   ? '[SET] ✅'              : '[NOT SET] ❌'));
            $this->line("   AWS_SECRET_ACCESS_KEY = " . ($secretSet ? '[SET] ✅'           : '[NOT SET] ❌'));
        } else {
            $localRoot = config('filesystems.disks.' . $disk . '.root', storage_path('app'));
            $this->line("   Disk driver = local (not S3)");
            $this->line("   Local root  = {$localRoot}");
            $this->line("   ⚠️  Files stored locally will be lost on container/dyno restart in most platforms.");
            $this->line("   ⚠️  For production, set FILESYSTEM_DISK=s3 with an S3-compatible provider.");
        }
        $this->newLine();

        // ── 4. Public Upload Directory ──────────────────────────────────
        $this->info('④ Public Upload Directory (local fallback)');
        $uploadDir = public_path('uploads');
        $exists    = is_dir($uploadDir);
        $writable  = $exists && is_writable($uploadDir);
        $fileCount = $exists ? count(array_filter(scandir($uploadDir), fn($f) => !in_array($f, ['.', '..']))) : 0;
        $this->line("   Path      = {$uploadDir}");
        $this->line("   Exists    = " . ($exists   ? 'YES ✅' : 'NO ❌'));
        $this->line("   Writable  = " . ($writable ? 'YES ✅' : 'NO ❌'));
        $this->line("   Files     = {$fileCount} item(s)");
        $this->newLine();

        // ── 5. Chunk Temp Directory ─────────────────────────────────────
        $this->info('⑤ Chunk Temp Directory');
        $chunkDir     = storage_path('app/chunks');
        $chunkExists  = is_dir($chunkDir);
        $chunkWrite   = $chunkExists && is_writable($chunkDir);
        $this->line("   Path     = {$chunkDir}");
        $this->line("   Exists   = " . ($chunkExists ? 'YES ✅' : 'NO ❌'));
        $this->line("   Writable = " . ($chunkWrite  ? 'YES ✅' : 'NO ❌'));
        $this->newLine();

        // ── 6. Optional Write Test ──────────────────────────────────────
        if ($this->option('write-test')) {
            $this->info('⑥ Disk Write/Read/Delete Test');
            $testKey = '_diagnose_test_' . time() . '.txt';
            $testContent = 'storage:diagnose write test at ' . now()->toIso8601String();

            try {
                // Write
                Storage::disk($disk)->put($testKey, $testContent);
                $this->line("   Write ✅");

                // Read back
                $read = Storage::disk($disk)->get($testKey);
                if ($read === $testContent) {
                    $this->line("   Read  ✅ (content matches)");
                } else {
                    $this->line("   Read  ⚠️  (content mismatch)");
                }

                // Delete
                Storage::disk($disk)->delete($testKey);
                $this->line("   Delete ✅");

                $this->info("   ✅ Write/read/delete cycle PASSED on disk '{$disk}'");
            } catch (\Throwable $e) {
                $this->error("   ❌ Write/read/delete cycle FAILED on disk '{$disk}'");
                $this->line("   Exception class:   " . get_class($e));
                $this->line("   Exception message: " . $e->getMessage());
            }

            $this->newLine();
        }

        // ── Summary ─────────────────────────────────────────────────────
        $this->line('═══════════════════════════════════════════════════════');
        if ($disk === 's3') {
            $this->info("  ✅ Disk configured as S3 (persistent across deployments)");
        } elseif ($disk === 'public' || $disk === 'local') {
            $this->warn("  ⚠️  Disk is LOCAL — files will be lost on container rebuild");
            $this->warn("  ⚠️  Set FILESYSTEM_DISK=s3 + S3 credentials for persistent production storage");
        }
        $this->line('═══════════════════════════════════════════════════════');
        $this->newLine();

        return self::SUCCESS;
    }
}
