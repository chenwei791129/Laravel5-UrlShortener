<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIp2nationCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip2nationCountries', function (Blueprint $table) {
            $table->string('code');
            $table->string('iso_code_2');
            $table->string('iso_code_3');
            $table->string('iso_country');
            $table->string('country');
            $table->float('lat');
            $table->float('lon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ip2nationCountries');
    }
}
