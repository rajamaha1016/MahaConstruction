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
            $view->with([
                'yt_channel_url' => YouTubeSyncService::getActiveChannelUrl(),
                'yt_channel_meta' => YouTubeSyncService::getChannelMeta(),
                'yt_channel_handle' => YouTubeSyncService::getChannelHandle(),
            ]);
        });
    }
}
