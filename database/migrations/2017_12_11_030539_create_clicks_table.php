<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clicks', function (Blueprint $table) {
            $table->string('short_code');
            $table->boolean('isRobot');
            $table->boolean('isDesktop');
            $table->string('platform');
            $table->string('platform_version');
            $table->string('browser');
            $table->string('browser_version');
            $table->json('client_ip_addrs');
            $table->string('country_from')->nullable();
            $table->string('geo_latitude')->nullable();
            $table->string('geo_longitude')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clicks');
    }
}
