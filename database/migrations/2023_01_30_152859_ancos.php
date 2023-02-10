<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ancos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pond_id')->unsigned();
            $table->foreign('pond_id')->references('id')->on('ponds')->onDelete('cascade');
            $table->bigInteger('anco_type_id')->unsigned();
            $table->foreign('anco_type_id')->references('id')->on('anco_types')->onDelete('cascade');
            $table->time('started_time')->nullable();
            $table->time('finished_time')->nullable();
            $table->double('duration')->nullable();
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
        Schema::dropIfExists('ancos');
    }
};
