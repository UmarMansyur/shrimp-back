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
        Schema::create('kimias', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pond_id')->unsigned();
            $table->foreign('pond_id')->references('id')->on('ponds')->onDelete('cascade');
            $table->double('amoniak')->nullable();
            $table->double('nitrit')->nullable();
            $table->double('nitrat')->nullable();
            $table->double('alkalinitas')->nullable();
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
        Schema::dropIfExists('kimias');
    }
};
