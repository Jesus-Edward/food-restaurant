<?php

namespace App\Providers;

use App\Models\GeneralSettings;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        $keys = ['pusher_app_id', 'pusher_app_key', 'pusher_app_secret_key', 'pusher_cluster'];
        $pusherConf = GeneralSettings::whereIn('key', $keys)->pluck('value', 'key');
        config(['broadcasting.connections.pusher.key' => $pusherConf['pusher_app_key']]);
        config(['broadcasting.connections.pusher.secret' => $pusherConf['pusher_app_secret_key']]);
        config(['broadcasting.connections.pusher.app_id' => $pusherConf['pusher_app_id']]);
        config(['broadcasting.connections.pusher.options.cluster' => $pusherConf['pusher_cluster']]);
    }
}
