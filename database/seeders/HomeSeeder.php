<?php

namespace Database\Seeders;

use App\Models\Home;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if Home record already exists
        if (Home::count() === 0) {
            Home::create([
                'whatsapp_link' => 'https://wa.me/966500000000',
                'x_link' => 'https://x.com/morphicarts',
                'youtube_link' => 'https://youtube.com/@morphicarts',
                'instagram_link' => 'https://instagram.com/morphicarts',
                'phone_number' => '+966 50 000 0000',
                'email' => 'info@morphicarts.sa',
                'location' => 'Riyadh, Saudi Arabia',
            ]);
        }
    }
}
