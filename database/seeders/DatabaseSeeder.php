<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        DB::table('guilds')->insert([
            'id' => 1,
            'guild_id' => '2E365437-6552-EA11-81B1-D0069C08C942',
            'leader_id' => '6D117E57-9FAD-254B-AF45-AC730739CB1499375B0C-EF88-44B8-BECD-1EFCA71FB703',
            'slug' => 'warband-of-wolves'
        ]);
    }
}
