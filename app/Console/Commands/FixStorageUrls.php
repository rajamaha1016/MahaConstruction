<?php
// Fix broken storage URLs in settings table

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;

class FixStorageUrls extends Command
{
    protected $signature = 'fix:storage-urls';
    protected $description = 'Fix broken /storage/uploads/ URLs in settings table';

    public function handle()
    {
        $keys = ['intro_video_url', 'guidebook_pdf_url'];
        foreach ($keys as $key) {
            $setting = Setting::where('key', $key)->first();
            if ($setting) {
                $old = $setting->value;
                // Replace http://host/storage/uploads/ or /storage/uploads/ with /uploads/
                $new = preg_replace('#https?://[^/]+/storage/uploads/#', '/uploads/', $old);
                $new = str_replace('/storage/uploads/', '/uploads/', $new);
                if ($new !== $old) {
                    $setting->update(['value' => $new]);
                    $this->info("Fixed $key: $old -> $new");
                } else {
                    $this->info("$key OK: $old");
                }
            } else {
                $this->info("$key: not set");
            }
        }
        return 0;
    }
}
