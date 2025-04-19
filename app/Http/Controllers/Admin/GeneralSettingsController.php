<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use App\Models\PusherSettings;
use App\Services\PusherSettingsService;
use App\Services\SettingsService;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class GeneralSettingsController extends Controller
{
    use FileUploadTrait;

    public function index(): View
    {
        return view('admin.settings.index');
    }

    public function updateGeneralSettings(Request $request)
    {
        $validatedData = $request->validate([
            'site_name' => ['required', 'max:255'],
            'site_email' => ['nullable', 'email', 'max:255'],
            'site_phone' => ['nullable', 'max:50'],
            'site_default_currency' => ['required', 'max:5'],
            'site_currency_symbol' => ['required', 'max:5'],
            'site_currency_symbol_position' => ['required', 'max:255']
        ]);

        foreach ($validatedData as $key => $value) {
            GeneralSettings::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

        toastr()->success('Done');
        return redirect()->back();
    }

    function updatePusherSettings(Request $request)
    {
        $validatedData = $request->validate([
            'pusher_app_id' => ['required', 'max:255'],
            'pusher_app_key' => ['required', 'max:255'],
            'pusher_app_secret_key' => ['required', 'max:255'],
            'pusher_cluster' => ['required', 'max:255']
        ]);

        foreach ($validatedData as $key => $value) {
            GeneralSettings::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

        toastr()->success('Done');
        return redirect()->back();
    }

    function updateMailSettings(Request $request)
    {
        $validatedData = $request->validate([
            'mail_driver' => ['required', 'max:255'],
            'mail_port' => ['required', 'max:255'],
            'mail_encryption' => ['required', 'max:255'],
            'mail_host' => ['required', 'max:255'],
            'mail_username' => ['required', 'max:255'],
            'mail_password' => ['required', 'max:255'],
            'mail_from_address' => ['required', 'max:255'],
            'received_mail_address' => ['required', 'max:255']
        ]);

        foreach ($validatedData as $key => $value) {
            GeneralSettings::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

        Cache::forget('mail_settings');

        toastr()->success('Done');
        return redirect()->back();
    }

    function updateLogoSettings(Request $request)
    {
        $validatedData = $request->validate([
            'logo' => ['nullable', 'image', 'max:5048'],
            'footer_logo' => ['nullable', 'image', 'max:5048'],
            'favicon' => ['nullable', 'image', 'max:5048'],
            'breadcrumb' => ['nullable', 'image', 'max:5048']
        ]);

        foreach ($validatedData as $key => $value) {
            $imagePath = $this->uploadImage($request, $key);
            if (!empty($imagePath)) {
                $oldPath = config('settings.' . $key);
                $this->removeImage($oldPath);

                GeneralSettings::updateOrCreate(
                    ['key' => $key],
                    ['value' => $imagePath]
                );
            }
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

        toastr()->success('Done');
        return redirect()->back();
    }

    function updateAppearanceSettings(Request $request)
    {
        $validatedData = $request->validate([
            'site_color' => ['required']
        ]);

        foreach ($validatedData as $key => $value) {
            GeneralSettings::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

        toastr()->success('Done');
        return redirect()->back();
    }

    function updateSeoSettings(Request $request)
    {
        $validatedData = $request->validate([
            'seo_title' => ['required', 'max:255'],
            'seo_description' => ['nullable', 'max:500'],
            'seo_keywords' => ['nullable']
        ]);

        foreach ($validatedData as $key => $value) {
            GeneralSettings::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

        toastr()->success('Done');
        return redirect()->back();
    }
}
