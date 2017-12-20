<?php

use Illuminate\Database\Seeder;

class Ip2nationCountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ip2nationCountries')->truncate();
        
        $handle = fopen(storage_path('app').'/ip2nationCountries.sql', "r");
        $contents = '';
        if ($handle) {
            while (!feof($handle)) {
                $sql = fgets($handle);
                DB::statement($sql);
            }
            fclose($handle);
        }
    }
}
