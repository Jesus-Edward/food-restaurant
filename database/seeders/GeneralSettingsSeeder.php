<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $general_settings = array(
            array('id' => '1','key' => 'site_name','value' => 'Food Park','created_at' => '2024-04-25 06:45:12','updated_at' => '2024-04-25 09:32:33'),
            array('id' => '2','key' => 'site_default_currency','value' => 'USD','created_at' => '2024-04-25 06:45:12','updated_at' => '2024-04-25 10:14:36'),
            array('id' => '3','key' => 'site_currency_symbol','value' => '$','created_at' => '2024-04-25 06:45:12','updated_at' => '2024-04-25 10:47:48'),
            array('id' => '4','key' => 'site_currency_symbol_position','value' => 'left','created_at' => '2024-04-25 06:45:13','updated_at' => '2024-04-25 10:47:48'),
            array('id' => '5','key' => 'pusher_app_id','value' => '1805095','created_at' => '2024-05-19 07:10:05','updated_at' => '2024-05-19 07:10:05'),
            array('id' => '6','key' => 'pusher_app_key','value' => '262c9d1ee762b13a320c','created_at' => '2024-05-19 07:10:05','updated_at' => '2024-05-19 07:10:05'),
            array('id' => '7','key' => 'pusher_app_secret_key','value' => 'd50a18f6f5da416d7a45','created_at' => '2024-05-19 07:10:05','updated_at' => '2024-05-19 07:10:05'),
            array('id' => '8','key' => 'pusher_cluster','value' => 'mt1','created_at' => '2024-05-19 07:10:05','updated_at' => '2024-05-19 07:10:05'),
            array('id' => '9','key' => 'mail_driver','value' => 'smtp','created_at' => '2024-06-02 18:52:19','updated_at' => '2024-06-02 19:10:38'),
            array('id' => '10','key' => 'mail_port','value' => '2525','created_at' => '2024-06-02 18:52:19','updated_at' => '2024-06-02 19:10:38'),
            array('id' => '11','key' => 'mail_encryption','value' => 'tls','created_at' => '2024-06-02 18:52:19','updated_at' => '2024-06-02 19:10:38'),
            array('id' => '12','key' => 'mail_host','value' => 'sandbox.smtp.mailtrap.io','created_at' => '2024-06-02 18:52:19','updated_at' => '2024-06-02 19:10:38'),
            array('id' => '13','key' => 'mail_username','value' => 'ad7ba89fb05025','created_at' => '2024-06-02 18:52:20','updated_at' => '2024-06-02 19:10:38'),
            array('id' => '14','key' => 'mail_password','value' => '5ee36a14eba2a0','created_at' => '2024-06-02 18:52:20','updated_at' => '2024-06-02 19:10:38'),
            array('id' => '15','key' => 'mail_from_address','value' => 'food-Park@example.com','created_at' => '2024-06-02 18:52:20','updated_at' => '2024-06-02 19:10:38'),
            array('id' => '16','key' => 'received_mail_address','value' => 'food-Park@example.com','created_at' => '2024-06-02 18:52:20','updated_at' => '2024-06-02 19:10:38'),
            array('id' => '17','key' => 'logo','value' => '/uploads/media666caea047afb.png','created_at' => '2024-06-13 18:41:10','updated_at' => '2024-06-14 20:57:04'),
            array('id' => '18','key' => 'footer_logo','value' => '/uploads/media666b3e9f5e825.png','created_at' => '2024-06-13 18:41:10','updated_at' => '2024-06-13 18:46:55'),
            array('id' => '19','key' => 'favicon','value' => '/uploads/media666caefb5d4eb.png','created_at' => '2024-06-13 18:41:10','updated_at' => '2024-06-14 20:58:35'),
            array('id' => '20','key' => 'breadcrumb','value' => '/uploads/media666b3e9f86dad.jpg','created_at' => '2024-06-13 18:41:10','updated_at' => '2024-06-13 18:46:55'),
            array('id' => '21','key' => 'site_email','value' => 'foodpark@gmail.com','created_at' => '2024-06-16 12:01:21','updated_at' => '2024-06-16 12:01:21'),
            array('id' => '22','key' => 'site_phone','value' => '+96487452145214','created_at' => '2024-06-16 12:01:21','updated_at' => '2024-06-16 12:01:21'),
            array('id' => '23','key' => 'site_color','value' => '#f86f03','created_at' => '2024-06-16 14:21:37','updated_at' => '2024-06-16 14:38:10'),
            array('id' => '24','key' => 'seo_title','value' => 'Food Park','created_at' => '2024-06-16 15:28:11','updated_at' => '2024-06-16 15:28:11'),
            array('id' => '25','key' => 'seo_description','value' => 'This is a test seo description','created_at' => '2024-06-16 15:28:11','updated_at' => '2024-06-16 15:28:11'),
            array('id' => '26','key' => 'seo_keyword','value' => 'food,restaurant','created_at' => '2024-06-16 15:28:12','updated_at' => '2024-06-16 15:28:12')
          );          
        \DB::table('general_settings')->insert($general_settings);
    }
}
