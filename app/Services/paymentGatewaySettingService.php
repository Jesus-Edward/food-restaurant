<?php
namespace App\Services;

use App\Models\PaymentGatewaySettings;
use Cache;

class paymentGatewaySettingService
{
    public function getSettings(){
        return Cache::rememberForever('pathwaySettings', function(){
            return PaymentGatewaySettings::pluck('value', 'key')->toArray();
        });
    }

    public function setGlobalSettings(): void{
        $paymentPathwaySettings = $this->getSettings();
        config()->set('pathwaySettings', $paymentPathwaySettings);
    }

    public function clearCachedSettings(): void{
        Cache::forget('pathwaySettings');
    }
}

