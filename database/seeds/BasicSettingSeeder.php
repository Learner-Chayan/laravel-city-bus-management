<?php

namespace Database\Seeders;

use App\BasicSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BasicSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BasicSetting::create([
            'title' => 'Website Title',
            'phone' => '01704211894',
            'email' => 'your@gmail.com',
        ]);
    }
}
