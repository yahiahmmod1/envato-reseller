<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sites')->insert([
            [
                'site_name'=>'Envato Element',
                'slug'=>'envato',
                'logo'=>'envato.png',
                'site_link'=>'https://elements.envato.com/',
                'status'=>'active'
            ],
            [
                'site_name'=>'Freepik',
                'slug'=>'freepik',
                'logo'=>'freepik.png',
                'site_link'=>'https://elements.envato.com/',
                'status'=>'active'
            ]
        ]);
    }
}
