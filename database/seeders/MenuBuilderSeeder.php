<?php

namespace Database\Seeders;
use DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuBuilderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $admin_menus = array(

            array(
                'id' => 1,
                'name' => 'main_menu',
                'created_at' => '2024-06-06 07:47:33',
                'updated_at' => '2024-06-06 07:47:33'
            ),

            array(
                'id' => 2,
                'name' => 'footer_menu_one',
                'created_at' => '2024-06-06 07:02:15',
                'updated_at' => '2024-06-06 07:03:27'
            ),

            array(
                'id' => 3,
                'name' => 'footer_menu_two',
                'created_at' => '2024-06-06 07:03:55',
                'updated_at' => '2024-06-06 07:03:55'
            ),

            array(
                'id' => 4,
                'name' => 'footer_menu_three',
                'created_at' => '2024-06-06 07:04:43',
                'updated_at' => '2024-06-06 07:04:43'
            ),
        );

        $admin_menu_items = array(
            array('id' => '1','label' => 'Home','link' => '/','parent_id' => '0','sort' => '0','class' => NULL,'menu_id' => '2','depth' => '0','created_at' => '2024-06-06 07:19:09','updated_at' => '2024-06-06 07:24:02'),
            array('id' => '2','label' => 'About','link' => '/about-page','parent_id' => '0','sort' => '1','class' => NULL,'menu_id' => '2','depth' => '0','created_at' => '2024-06-06 07:22:48','updated_at' => '2024-06-06 07:27:01'),
            array('id' => '3','label' => 'Contact','link' => '/contact','parent_id' => '0','sort' => '2','class' => NULL,'menu_id' => '2','depth' => '0','created_at' => '2024-06-06 07:24:47','updated_at' => '2024-06-06 07:24:47'),
            array('id' => '4','label' => 'Our Services','link' => '#','parent_id' => '0','sort' => '3','class' => NULL,'menu_id' => '2','depth' => '0','created_at' => '2024-06-06 07:26:58','updated_at' => '2024-06-06 07:26:58'),
            array('id' => '5','label' => 'Gallery','link' => '#','parent_id' => '0','sort' => '4','class' => NULL,'menu_id' => '2','depth' => '0','created_at' => '2024-06-06 07:27:58','updated_at' => '2024-06-06 07:27:58'),
            array('id' => '6','label' => 'Terms And Conditions','link' => '/terms&cons','parent_id' => '0','sort' => '0','class' => NULL,'menu_id' => '3','depth' => '0','created_at' => '2024-06-06 07:29:33','updated_at' => '2024-06-06 07:30:26'),
            array('id' => '7','label' => 'Privacy Policy','link' => '/privacy-policy','parent_id' => '0','sort' => '1','class' => NULL,'menu_id' => '3','depth' => '0','created_at' => '2024-06-06 07:30:21','updated_at' => '2024-06-06 09:15:44'),
            array('id' => '8','label' => 'Blogs','link' => '/blogs','parent_id' => '0','sort' => '2','class' => NULL,'menu_id' => '3','depth' => '0','created_at' => '2024-06-06 09:15:42','updated_at' => '2024-06-06 09:35:20'),
            array('id' => '9','label' => 'FAQ','link' => '#','parent_id' => '0','sort' => '3','class' => NULL,'menu_id' => '3','depth' => '0','created_at' => '2024-06-06 09:16:07','updated_at' => '2024-06-06 09:16:44'),
            array('id' => '10','label' => 'Contact','link' => '/contact','parent_id' => '0','sort' => '4','class' => NULL,'menu_id' => '3','depth' => '0','created_at' => '2024-06-06 09:16:42','updated_at' => '2024-06-06 09:35:13'),
            array('id' => '11','label' => 'FAQ','link' => '/blogs','parent_id' => '0','sort' => '0','class' => NULL,'menu_id' => '4','depth' => '0','created_at' => '2024-06-06 09:23:14','updated_at' => '2024-06-06 09:34:23'),
            array('id' => '12','label' => 'Payment','link' => '/checkout/payment/index','parent_id' => '0','sort' => '1','class' => NULL,'menu_id' => '4','depth' => '0','created_at' => '2024-06-06 09:26:18','updated_at' => '2024-06-06 09:27:18'),
            array('id' => '13','label' => 'Settings','link' => '#','parent_id' => '0','sort' => '2','class' => NULL,'menu_id' => '4','depth' => '0','created_at' => '2024-06-06 09:27:16','updated_at' => '2024-06-06 09:28:04'),
            array('id' => '14','label' => 'Privacy Policy','link' => '/privacy-policy','parent_id' => '0','sort' => '3','class' => NULL,'menu_id' => '4','depth' => '0','created_at' => '2024-06-06 09:28:03','updated_at' => '2024-06-06 09:33:33'),
            array('id' => '15','label' => 'Home','link' => '/','parent_id' => '0','sort' => '0','class' => NULL,'menu_id' => '1','depth' => '0','created_at' => '2024-06-06 11:02:16','updated_at' => '2024-06-06 11:02:40'),
            array('id' => '17','label' => 'About','link' => '/about-page','parent_id' => '0','sort' => '1','class' => NULL,'menu_id' => '1','depth' => '0','created_at' => '2024-06-06 11:04:11','updated_at' => '2024-06-06 11:04:11'),
            array('id' => '18','label' => 'Chefs','link' => '/chef','parent_id' => '25','sort' => '4','class' => NULL,'menu_id' => '1','depth' => '1','created_at' => '2024-06-06 11:05:14','updated_at' => '2024-06-06 12:25:10'),
            array('id' => '19','label' => 'Blogs','link' => '/blogs','parent_id' => '0','sort' => '7','class' => NULL,'menu_id' => '1','depth' => '0','created_at' => '2024-06-06 11:06:01','updated_at' => '2024-06-06 12:23:11'),
            array('id' => '20','label' => 'Contact','link' => '/contact','parent_id' => '0','sort' => '8','class' => NULL,'menu_id' => '1','depth' => '0','created_at' => '2024-06-06 11:06:40','updated_at' => '2024-06-06 12:23:11'),
            array('id' => '21','label' => 'Testimonial','link' => '/testimonials','parent_id' => '25','sort' => '3','class' => NULL,'menu_id' => '1','depth' => '1','created_at' => '2024-06-06 11:13:00','updated_at' => '2024-06-06 12:24:58'),
            array('id' => '22','label' => 'Privacy Policy','link' => '/privacy-policy','parent_id' => '25','sort' => '6','class' => NULL,'menu_id' => '1','depth' => '1','created_at' => '2024-06-06 11:15:09','updated_at' => '2024-06-06 12:23:22'),
            array('id' => '24','label' => 'Terms And Conditions','link' => '/terms&cons','parent_id' => '25','sort' => '5','class' => NULL,'menu_id' => '1','depth' => '1','created_at' => '2024-06-06 11:37:33','updated_at' => '2024-06-06 12:23:22'),
            array('id' => '25','label' => 'Pages','link' => '#','parent_id' => '0','sort' => '2','class' => NULL,'menu_id' => '1','depth' => '0','created_at' => '2024-06-06 11:39:00','updated_at' => '2024-06-06 12:24:58'),
            array('id' => '26','label' => 'Products','link' => '/products/','parent_id' => '0','sort' => '10','class' => NULL,'menu_id' => '1','depth' => '0','created_at' => '2024-06-06 11:39:00','updated_at' => '2024-06-06 12:24:58')
        );

        DB::table('admin_menus')->insert($admin_menus);

        DB::table('admin_menu_items')->insert($admin_menu_items);
    }
}
