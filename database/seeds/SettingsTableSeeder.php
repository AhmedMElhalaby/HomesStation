<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            ['key' => 'app_lang', 'value' => ''],
            ['key' => 'mobile', 'value' => ''],
            ['key' => 'email', 'value' => ''],
            ['key' => 'facebook_url', 'value' => ''],
            ['key' => 'twitter_url', 'value' => ''],
            ['key' => 'youtube_url', 'value' => ''],
            ['key' => 'instagram_url', 'value' => ''],
            ['key' => 'whatsapp_phone', 'value' => ''],
            ['key' => 'about_ar', 'value' => ''],
            ['key' => 'about_en', 'value' => ''],
            ['key' => 'policy_terms_ar', 'value' => ''],
            ['key' => 'policy_terms_en', 'value' => ''],
            ['key' => 'num_of_search_km_for_provider', 'value' => '500'],
            ['key' => 'app_precentage_from_provider', 'value' => '10'],
            ['key' => 'delivery_price', 'value' => '10'],
            ['key' => 'number_of_ads', 'value' => '10'],
            ['key' => 'price_of_delegate_subscription', 'value' => '100'],
            ['key' => 'price_of_publishing_an_ad', 'value' => '15'],
        ]);
    }
}
