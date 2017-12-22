<?php

use Illuminate\Database\Seeder;
use DB as DB;

class Ip2nationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ip2nation')->truncate();

        $handle = fopen(storage_path().'/ip2nation.sql', "r");
        $contents = '';
        if ($handle) {
            while (!feof($handle)) {
                $sql = fgets($handle);
                echo "run: $sql\n";
                DB::statement($sql);
            }
            fclose($handle);
        }
    }
}
