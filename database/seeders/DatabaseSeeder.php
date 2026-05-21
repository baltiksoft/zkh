<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       // $this->call(CountrySeeder::class);
        //$this->call(LanguageSeeder::class);
        //User::factory(50)->create();

        User::create([
            'id' => 1,
            'name' => 'admin',
            'email' => 'baltiksoft@mail.ru',
            'root' => true,
            'active' => true,
            'password' => '11111111',
        ]);

        User::create([
            'id' => 2,
            'name' => 'Напирелли И.',
            'email' => 'napirelli@mail.ru',
            'root' => false,
            'active' => false,
            'password' => '11111111',
        ]);

        User::create([
            'id' => 3,
            'name' => 'Пуганц Е.',
            'email' => 'puganz@mail.ru',
            'root' => false,
            'active' => true,
            'password' => '11111111',
        ]);

        $this->call(UserDetailSeeder::class);
        $this->call(MeterSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(TariffSeeder::class);
        $this->call(InvoiceSeeder::class);
        $this->call(PaymentSeeder::class);
    }
}
