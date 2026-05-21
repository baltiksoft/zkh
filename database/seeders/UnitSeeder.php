<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        Unit::create([
            'id' => 1,
            'name' => 'КилоВатт',
            'shortname' => 'КВт',
        ]);

        Unit::create([
            'id' => 2,
            'name' => 'Куб.метр',
            'shortname' => 'м³',
        ]);
    }
}
