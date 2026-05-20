<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        Room::create([
            'id' => 1,
            'userdetail_id' => 1,
            'name' => '3-х комнатная квартира',
            'area' => 75,
            'address' => 'Московская область, г.о.Люберцы, ул. 3 почтовое отделение, д.22 кв.44',
            'number' => '50:24:4567890',
        ]);

        $this->call(LeaseSeader::class);
    }
}
