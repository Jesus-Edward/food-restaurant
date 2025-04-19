<?php

namespace Database\Seeders;

use App\Models\WhyChooseUs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WhyChooseUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WhyChooseUs::insert([
            'icon' => 'fa-light fa-percent',
            'title' => 'Discount Voucher',
            'short_message' => 'Lorem ipsum dolor sit amet consectetur
            adipisicing elit. Est, debitis expedita .'
        ]);
        WhyChooseUs::insert([
            'icon' => 'fa-solid fa-burger-soda',
            'title' => 'Fresh Healthy Foods',
            'short_message' => 'Lorem ipsum dolor sit amet consectetur
            adipisicing elit. Est, debitis expedita .'
        ]);
        WhyChooseUs::insert([
            'icon' => 'fa-sharp fa-regular fa-hat-chef',
            'title' => 'Fast Serve On Table',
            'short_message' => 'Lorem ipsum dolor sit amet consectetur
            adipisicing elit. Est, debitis expedita .'
        ]);
    }
}
