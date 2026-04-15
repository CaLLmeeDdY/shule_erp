<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemSetting;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        // Define the default settings for the system
        $settings = [
            'school_name' => 'Shule ERP',
            'school_slogan' => 'Excellence in Management',
            'school_motto'  => 'Empowering Education through Technology',
            'school_logo'   => null,          // Defaults to the icon if null
            'school_color'  => 'slate-900',   // Default theme color
        ];

        // Loop through and create them. 
        // updateOrCreate ensures we don't create duplicates if you run this twice.
        foreach ($settings as $key => $value) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}