<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MailDiagnose extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'mail:diagnose
                            {--send-test : Attempt to send a test email (no OTP/sensitive data)}';

    /**
     * The console command description.
     */
    protected $description = 'Safely diagnose mail configuration (never exposes passwords or secrets)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->newLine();
        $this->line('═══════════════════════════════════════════════════════');
        $this->info('  Maha Construction — Safe Mail Diagnostics');
        $this->line('═══════════════════════════════════════════════════════');
        $this->newLine();

        // ── 1. Application Environment ──────────────────────────────────
        $this->info('① Application Environment');
        $appEnv   = config('app.env', app()->environment());
        $appUrl   = config('app.url', '(not set)');
        $appDebug = config('app.debug', false) ? 'true' : 'false';

        $envOk = $appEnv === 'production';
        $this->line("   APP_ENV   = {$appEnv} " . ($envOk ? '✅' : '⚠️  (expected: production)'));
        $this->line("   APP_URL   = {$appUrl}");
        $this->line("   APP_DEBUG = {$appDebug}");
        $this->newLine();

        // ── 2. Mail Driver ──────────────────────────────────────────────
        $this->info('② Mail Driver');
        $mailDefault = config('mail.default', '(not set)');
        $driverOk    = $mailDefault === 'smtp';
        $this->line("   MAIL_MAILER (config default) = {$mailDefault} " . ($driverOk ? '✅' : '❌ (expected: smtp)'));
        $this->newLine();

        // ── 3. SMTP Settings ────────────────────────────────────────────
        $this->info('③ SMTP Settings');
        $host       = config('mail.mailers.smtp.host', '(not set)');
        $port       = config('mail.mailers.smtp.port', '(not set)');
        $encryption = config('mail.mailers.smtp.encryption', '(not set)');
        $username   = config('mail.mailers.smtp.username', null);
        $password   = config('mail.mailers.smtp.password', null);

        $hostOk     = $host === 'smtp.gmail.com';
        $portOk     = (string)$port === '587';
        $encOk      = in_array(strtolower((string)$encryption), ['tls', 'starttls'], true);
        $userSet    = !empty($username);
        $passSet    = !empty($password);

        $this->line("   MAIL_HOST       = {$host} " . ($hostOk ? '✅' : '❌ (expected: smtp.gmail.com)'));
        $this->line("   MAIL_PORT       = {$port} " . ($portOk ? '✅' : '❌ (expected: 587)'));
        $this->line("   MAIL_ENCRYPTION = {$encryption} " . ($encOk ? '✅' : '❌ (expected: tls)'));
        $this->line("   MAIL_USERNAME   = " . ($userSet ? $username . ' ✅' : '(empty) ❌'));
        $this->line("   MAIL_PASSWORD   = " . ($passSet ? '[SET — ' . strlen((string)$password) . ' chars] ✅' : '[NOT SET] ❌'));
        $this->newLine();

        // ── 4. From Address ─────────────────────────────────────────────
        $this->info('④ From Address');
        $fromAddr = config('mail.from.address', '(not set)');
        $fromName = config('mail.from.name', '(not set)');
        $this->line("   MAIL_FROM_ADDRESS = {$fromAddr}");
        $this->line("   MAIL_FROM_NAME    = {$fromName}");
        $this->newLine();

        // ── 5. Config Cache Status ──────────────────────────────────────
        $this->info('⑤ Config Cache Status');
        $cacheFile   = base_path('bootstrap/cache/config.php');
        $cacheExists = file_exists($cacheFile);
        $cacheAge    = $cacheExists ? round((time() - filemtime($cacheFile)) / 60) . ' minutes ago' : 'N/A';
        $this->line("   Config cached = " . ($cacheExists ? "YES (built {$cacheAge}) ✅" : 'NO (reading live .env)'));
        $this->newLine();

        // ── 6. OS Environment Check (what Railway actually injected) ────
        $this->info('⑥ OS Environment (Railway-injected vars)');
        $this->line("   MAIL_MAILER     from OS = " . (getenv('MAIL_MAILER')     !== false ? getenv('MAIL_MAILER')         : '(not set in OS env)'));
        $this->line("   MAIL_HOST       from OS = " . (getenv('MAIL_HOST')       !== false ? getenv('MAIL_HOST')           : '(not set in OS env)'));
        $this->line("   MAIL_PORT       from OS = " . (getenv('MAIL_PORT')       !== false ? getenv('MAIL_PORT')           : '(not set in OS env)'));
        $this->line("   MAIL_ENCRYPTION from OS = " . (getenv('MAIL_ENCRYPTION') !== false ? getenv('MAIL_ENCRYPTION')    : '(not set in OS env)'));
        $this->line("   MAIL_USERNAME   from OS = " . (getenv('MAIL_USERNAME')   !== false ? getenv('MAIL_USERNAME')       : '(not set in OS env)'));
        $this->line("   MAIL_PASSWORD   from OS = " . (getenv('MAIL_PASSWORD')   !== false ? '[SET — ' . strlen(getenv('MAIL_PASSWORD')) . ' chars]' : '(not set in OS env) ❌'));
        $this->line("   APP_ENV         from OS = " . (getenv('APP_ENV')         !== false ? getenv('APP_ENV')             : '(not set in OS env)'));
        $this->newLine();

        // ── 7. .env File Check ──────────────────────────────────────────
        $this->info('⑦ .env File on Disk');
        $envFile = base_path('.env');
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (str_starts_with(trim($line), '#')) {
                    continue;
                }
                // Show key names but mask credential values
                foreach (['MAIL_PASSWORD', 'MAIL_USERNAME', 'APP_KEY', 'ADMIN_PASSWORD'] as $secret) {
                    if (str_starts_with(trim($line), $secret . '=')) {
                        $rawVal = substr(trim($line), strlen($secret) + 1);
                        $rawVal = trim($rawVal, '"\'');
                        $line   = $secret . '=[SET — ' . strlen($rawVal) . ' chars]';
                        break;
                    }
                }
                // Only show MAIL_* and APP_* lines
                if (preg_match('/^(MAIL_|APP_ENV|APP_URL|APP_DEBUG)/', trim($line))) {
                    $this->line("   " . trim($line));
                }
            }
        } else {
            $this->error('   .env file NOT FOUND at ' . $envFile);
        }
        $this->newLine();

        // ── 8. Queue Config ─────────────────────────────────────────────
        $this->info('⑧ Queue Configuration');
        $queue = config('queue.default', '(not set)');
        $this->line("   QUEUE_CONNECTION = {$queue} " . ($queue === 'sync' ? '(synchronous — no worker needed) ✅' : '⚠️  queue worker must be running'));
        $this->newLine();

        // ── 9. Connectivity Test ────────────────────────────────────────
        $this->info('⑨ SMTP Connectivity Test (smtp.gmail.com:587)');
        $this->line('   Attempting TCP connection (no credentials sent)...');
        $connected = false;
        $tcpError  = '';
        try {
            $socket = @fsockopen('tcp://smtp.gmail.com', 587, $errno, $errstr, 10);
            if ($socket) {
                $connected = true;
                fclose($socket);
                $this->line('   TCP connection to smtp.gmail.com:587 ✅ SUCCESS');
            } else {
                $tcpError = "errno={$errno} errstr={$errstr}";
                $this->error("   TCP connection FAILED: {$tcpError}");
            }
        } catch (\Throwable $ex) {
            $tcpError = $ex->getMessage();
            $this->error("   TCP connection FAILED: {$tcpError}");
        }
        $this->newLine();

        // ── 10. Optional Test Send ──────────────────────────────────────
        if ($this->option('send-test')) {
            $this->info('⑩ Test Send Attempt');
            $recipient = config('auth.admin_email', 'mahaconstructions2013@gmail.com');
            $this->line("   Sending diagnostic test email to: {$recipient}");
            try {
                Mail::mailer('smtp')->raw(
                    "This is a safe SMTP connectivity test from Maha Construction production server.\n"
                    . "Time: " . now()->toIso8601String() . "\n"
                    . "Server: " . gethostname() . "\n"
                    . "No sensitive data in this message.",
                    function ($message) use ($recipient) {
                        $message->to($recipient)->subject('[TEST] Maha Construction Mail Diagnose');
                    }
                );
                $this->info("   ✅ Test email sent successfully to {$recipient}");
                Log::info('[mail:diagnose] Test email sent successfully', ['recipient' => $recipient]);
            } catch (\Throwable $e) {
                $this->error("   ❌ Test send FAILED");
                $this->line("   Exception class:   " . get_class($e));
                $this->line("   Exception message: " . $e->getMessage());
                Log::error('[mail:diagnose] Test send failed', [
                    'exception_class'   => get_class($e),
                    'exception_message' => $e->getMessage(),
                    'mail_host'         => config('mail.mailers.smtp.host', '(not set)'),
                    'mail_port'         => config('mail.mailers.smtp.port', '(not set)'),
                    'mail_encryption'   => config('mail.mailers.smtp.encryption', '(not set)'),
                    'mail_username_set' => !empty(config('mail.mailers.smtp.username')),
                    'mail_password_set' => !empty(config('mail.mailers.smtp.password')),
                    'mail_password_len' => strlen((string)config('mail.mailers.smtp.password')),
                ]);
            }
            $this->newLine();
        }

        // ── Summary ─────────────────────────────────────────────────────
        $this->line('═══════════════════════════════════════════════════════');
        $allOk = $envOk && $driverOk && $hostOk && $portOk && $encOk && $userSet && $passSet && $connected;
        if ($allOk) {
            $this->info('  ✅ ALL CHECKS PASSED — Mail config looks correct');
        } else {
            $this->error('  ❌ SOME CHECKS FAILED — Review items marked ❌ above');
            if (!$passSet) {
                $this->warn('  ⚠️  MAIL_PASSWORD is not set — set it in Railway Variables panel');
            }
            if (!$userSet) {
                $this->warn('  ⚠️  MAIL_USERNAME is not set — set it in Railway Variables panel');
            }
            if (!$driverOk) {
                $this->warn('  ⚠️  MAIL_MAILER is not smtp — set MAIL_MAILER=smtp in Railway Variables');
            }
            if (!$connected) {
                $this->warn('  ⚠️  Cannot reach smtp.gmail.com:587 — Railway may block outbound SMTP (port 587)');
                $this->warn('  ⚠️  Try switching to port 465 with ssl encryption, or use an SMTP relay');
            }
        }
        $this->line('═══════════════════════════════════════════════════════');
        $this->newLine();

        return $allOk ? self::SUCCESS : self::FAILURE;
    }
}
