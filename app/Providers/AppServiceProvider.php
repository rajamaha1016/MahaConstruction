<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use App\Services\YouTubeSyncService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            $settingsList = [];
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                    $settingsList = \App\Models\Setting::pluck('value', 'key')->toArray();
                }
            } catch (\Throwable $e) {
                $settingsList = [];
            }

            $defaults = [
                'company_phone'           => '+91 94888 88758',
                'company_phone_secondary' => '+91 90959 29543',
                'company_whatsapp'        => '+91 94888 88758',
                'company_email'           => 'Mahaconstructions2013@gmail.com',
                'company_address'         => 'Tamilnomi complex, 1st floor, ICICI Bank Upstar, Near kottar police station, Nagercoil',
                'company_hours'           => 'Monday - Saturday: 10:00 AM - 6:00 PM',
                'company_branches'        => 'KANYAKUMARI, TIRUNELVELI, AND CHENNAI',
            ];

            $mergedSettings = array_merge($defaults, $settingsList);

            $rawPhone = preg_replace('/[^0-9]/', '', $mergedSettings['company_phone']);
            $rawWhatsapp = preg_replace('/[^0-9]/', '', $mergedSettings['company_whatsapp']);

            $view->with([
                'site_settings'     => $mergedSettings,
                'company_phone'     => $mergedSettings['company_phone'],
                'company_phone_sec' => $mergedSettings['company_phone_secondary'],
                'company_whatsapp'  => $mergedSettings['company_whatsapp'],
                'company_email'     => $mergedSettings['company_email'],
                'company_address'   => $mergedSettings['company_address'],
                'company_hours'     => $mergedSettings['company_hours'],
                'company_branches'  => $mergedSettings['company_branches'],
                'raw_phone'         => $rawPhone ?: '919488888758',
                'raw_whatsapp'      => $rawWhatsapp ?: '919488888758',
                'yt_channel_url'    => YouTubeSyncService::getActiveChannelUrl(),
                'yt_channel_meta'   => YouTubeSyncService::getChannelMeta(),
                'yt_channel_handle' => YouTubeSyncService::getChannelHandle(),
            ]);
        });
    }
}
