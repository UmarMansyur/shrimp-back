<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function PHPSTORM_META\map;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('water_qualities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pond_id')->unsigned();
            $table->foreign('pond_id')->references('id')->on('ponds')->onDelete('cascade');
            $table->double('pH')->nullable();
            $table->double('temperature')->nullable();
            $table->double('salinity')->nullable();
            $table->double('DO')->nullable();
            $table->double('brightness')->nullable();
            $table->enum('water_color', [
                'Kuning',
                'Kuning Kehijauan',
                'Coklat',
                'Coklat Kehijauan',
                'Cokal Gelap',
                'Coklat Muda',
                'Coklat Kemerahan',
                'Hijau',
                'Hijau Kecoklatan',
                'Hijau Kebiruan',
                'Hijau Gelap Kecoklatan',
                'Hijau Gelap',
                'Hitam'
            ])->nullable();
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
        Schema::dropIfExists('water_qualities');
    }
};
