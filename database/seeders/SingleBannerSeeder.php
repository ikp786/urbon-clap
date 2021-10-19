<?php

namespace Database\Seeders;

use App\Models\BannerSingle;
use Illuminate\Database\Seeder;

class SingleBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BannerSingle::create([
            'title' => 'Demo Banner',
            'banner' => 'plumber.jpeg',
            'status' => 'Active',
        ]);
    }
}
