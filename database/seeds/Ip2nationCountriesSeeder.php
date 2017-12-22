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
        
        $handle = fopen(storage_path().'/ip2nationCountries.sql', "r");
        $contents = '';
        if ($handle) {
            while (!feof($handle)) {
                $sql = fgets($handle);
                $sql = utf8_encode($sql);
                $sql = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S','',$sql);
                $sql = preg_replace('/[^\x00-\x7F]+/S','',$sql);
                echo "run: $sql\n";
                DB::statement($sql);
            }
            fclose($handle);
        }
    }
}
