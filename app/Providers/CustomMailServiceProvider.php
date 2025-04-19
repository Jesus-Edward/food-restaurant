<?php

namespace App\Providers;

use App\Models\GeneralSettings;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class CustomMailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $mailConfig = Cache::rememberForever('mail_settings', function () {
            $key = [
                'mail_driver',
                'mail_port',
                'mail_encryption',
                'mail_host',
                'mail_username',
                'mail_password',
                'mail_from_address',
                'received_mail_address'
            ];

            return GeneralSettings::whereIn('key', $key)->pluck('value', 'key')->toArray();
        });

        if ($mailConfig) {
            Config::set('mail.mailers.smtp.host', $mailConfig['mail_host']);
            Config::set('mail.mailers.smtp.port', $mailConfig['mail_port']);
            Config::set('mail.mailers.smtp.encryption', $mailConfig['mail_encryption']);
            Config::set('mail.mailers.smtp.username', $mailConfig['mail_username']);
            Config::set('mail.mailers.smtp.password', $mailConfig['mail_password']);
            Config::set('mail.from.address', $mailConfig['mail_from_address']);
        }
    }
}
