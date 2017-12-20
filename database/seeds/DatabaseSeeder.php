<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Ip2nationSeeder::class);
        $this->call(Ip2nationCountriesSeeder::class);
        $this->call(UserSeeder::class);
    }
}
