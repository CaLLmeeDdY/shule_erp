<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL; // This is needed for the SSL fix
use App\Models\SystemSetting;

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
        // 1. SSL FIX: Force HTTP in local development
        // This stops the "Unsupported SSL request" error in your terminal
        if (app()->isLocal()) {
            URL::forceScheme('http');
        }

        // 2. BRANDING: Share settings with ALL views (Login, Sidebar, etc.)
        try {
            // Fetch all settings as a simple array: ['school_name' => 'Nairobi Academy', ...]
            $settings = SystemSetting::pluck('value', 'key')->toArray();
            
            // If the array is empty (first run), set defaults
            if (empty($settings)) {
                $settings = [
                    'school_name' => 'Shule ERP',
                    'school_logo' => null,
                ];
            }

            // Share the variable $school_settings globally
            View::share('school_settings', $settings);

        } catch (\Exception $e) {
            // If the database is broken or missing, use safe defaults
            // This prevents the app from crashing during migrations
            View::share('school_settings', [
                'school_name' => 'Shule ERP',
                'school_logo' => null,
            ]);
        }
    }
}