<?php

namespace App\Services;

use App\Models\GeneralSettings;
use Cache;

class SettingsService
{
    public function getSettings()
    {
        return Cache::rememberForever('settings', function () {
            return GeneralSettings::pluck('value', 'key')->toArray();
        });
    }

    public function setGlobalSettings(): void
    {
        $settings = $this->getSettings();
        config()->set('settings', $settings);
    }

    public function clearCachedSettings(): void
    {
        Cache::forget('settings');
    }
}
