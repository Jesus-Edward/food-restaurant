<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $section_titles = array(
            array('id' => '1','key' => 'why_choose_top_title','value' => 'Why Choose Us','created_at' => NULL,'updated_at' => NULL),
            array('id' => '2','key' => 'why_choose_main_title','value' => 'Why Choose Us','created_at' => NULL,'updated_at' => NULL),
            array('id' => '3','key' => 'why_choose_sub_title','value' => 'Objectively pontificate quality models before intuitive information. Dramatically recapitalize multifunctional materials.','created_at' => NULL,'updated_at' => NULL),
            array('id' => '4','key' => 'daily_offer_top_title','value' => 'daily offer','created_at' => '2024-05-26 19:33:58','updated_at' => '2024-05-26 19:33:58'),
            array('id' => '5','key' => 'daily_offer_main_title','value' => 'up to 75% off for this day','created_at' => '2024-05-26 19:33:58','updated_at' => '2024-05-26 19:33:58'),
            array('id' => '6','key' => 'daily_offer_sub_title','value' => 'Objectively pontificate quality models before intuitive information. Dramatically recaptiualize multifunctional materials.','created_at' => '2024-05-26 19:33:58','updated_at' => '2024-05-26 19:33:58'),
            array('id' => '7','key' => 'chef_team_top_title','value' => 'our team','created_at' => '2024-05-28 16:58:35','updated_at' => '2024-05-28 16:58:35'),
            array('id' => '8','key' => 'chef_team_main_title','value' => 'meet our expert chefs','created_at' => '2024-05-28 16:58:35','updated_at' => '2024-05-28 16:58:35'),
            array('id' => '9','key' => 'chef_team_sub_title','value' => 'Objectively pontificate quality models before intuitive information. Dramatically recaptiualize multifunctional materials.','created_at' => '2024-05-28 16:58:35','updated_at' => '2024-05-28 16:58:35'),
            array('id' => '10','key' => 'testimonial_top_title','value' => 'testimonial','created_at' => '2024-05-29 00:45:17','updated_at' => '2024-05-29 00:45:17'),
            array('id' => '11','key' => 'testimonial_main_title','value' => 'our customar feedbacks','created_at' => '2024-05-29 00:45:17','updated_at' => '2024-05-29 00:45:17'),
            array('id' => '12','key' => 'testimonial_sub_title','value' => 'Objectively pontificate quality models before intuitive information. Dramatically recaptiualize multifunctional materials.','created_at' => '2024-05-29 00:45:17','updated_at' => '2024-05-29 00:45:17'),
            array('id' => '13','key' => 'menu_item_top_title','value' => 'food Menu','created_at' => '2024-06-11 16:17:47','updated_at' => '2024-06-11 16:17:47'),
            array('id' => '14','key' => 'menu_item_main_title','value' => 'Our Popular Delicious Foods','created_at' => '2024-06-11 16:17:47','updated_at' => '2024-06-11 16:17:47'),
            array('id' => '15','key' => 'menu_item_sub_title','value' => 'Objectively pontificate quality models before intuitive information. Dramatically recaptiualize multifunctional materials.','created_at' => '2024-06-11 16:17:47','updated_at' => '2024-06-11 16:17:47')
          );
          
        \DB::table('section_titles')->insert($section_titles);
    }
}
