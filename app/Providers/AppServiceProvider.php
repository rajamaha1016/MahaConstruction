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
                'company_phone'           => '+91 90959 29543',
                'company_phone_secondary' => '',
                'company_whatsapp'        => '+91 90959 29543',
                'company_email'           => 'Mahaconstructions2013@gmail.com',
                'company_address'         => 'Tamilnomi complex, 1st floor, ICICI Bank Upstar, Near kottar police station, Nagercoil',
                'company_hours'           => 'Monday - Saturday: 10:00 AM - 6:00 PM',
                'company_branches'        => 'KANYAKUMARI, TIRUNELVELI AND CHENNAI EST-2013',
                'hero_title'              => 'BUILDING LUXURY ARCHITECTURAL MASTERPIECES WITH UNCOMPROMISING EXCELLENCE',
                'hero_subtitle'           => "Tamil Nadu's premier government-registered engineering firm delivering custom luxury villas, residential residences, and architectural homes with itemized material transparency and 15-year structural warranties.",
                'hero_check1'             => 'Premium Materials',
                'hero_check2'             => 'Transparent Pricing',
                'hero_check3'             => 'On-Time Delivery',
                'hero_check4'             => 'Expert Engineers',
                'hero_check5'             => 'Lifetime Support',
                'hero_cta_primary'        => 'BOOK FREE CONSULTATION',
            ];

            $mergedSettings = array_merge($defaults, $settingsList);

            $rawPhone    = preg_replace('/[^0-9]/', '', $mergedSettings['company_phone']);
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
                'raw_phone'         => $rawPhone    ?: '919095929543',
                'raw_whatsapp'      => $rawWhatsapp ?: '919095929543',
                'hero_title'        => $mergedSettings['hero_title'],
                'hero_subtitle'     => $mergedSettings['hero_subtitle'],
                'hero_check1'       => $mergedSettings['hero_check1'],
                'hero_check2'       => $mergedSettings['hero_check2'],
                'hero_check3'       => $mergedSettings['hero_check3'],
                'hero_check4'       => $mergedSettings['hero_check4'],
                'hero_check5'       => $mergedSettings['hero_check5'],
                'hero_cta_primary'  => $mergedSettings['hero_cta_primary'],
                'yt_channel_url'    => YouTubeSyncService::getActiveChannelUrl(),
                'yt_channel_meta'   => YouTubeSyncService::getChannelMeta(),
                'yt_channel_handle' => YouTubeSyncService::getChannelHandle(),
            ]);
        });
    }
}
