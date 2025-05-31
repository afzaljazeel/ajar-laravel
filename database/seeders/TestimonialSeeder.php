<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        Testimonial::insert([
            [
                'name' => 'Ayesha Malik',
                'location' => 'Colombo',
                'message' => 'Absolutely love the quality and service. Will order again!',
                'avatar' => 'images/avatars/ayesha.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dinuka Perera',
                'location' => 'Kandy',
                'message' => 'Great customer care and premium packaging. 10/10!',
                'avatar' => 'images/avatars/dinuka.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
                        [
                'name' => 'Sarangi Siva',
                'location' => 'Matale',
                'message' => 'Perfumes are authentic and the price is way better!',
                'avatar' => 'images/avatars/Sarangi.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
                        [
                'name' => 'Abdul Malik',
                'location' => 'Colombo',
                'message' => 'I didnt expect this quality shoes and service. stunned!',
                'avatar' => 'images/avatars/abdul.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
