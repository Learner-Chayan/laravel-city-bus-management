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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('start_time');
            $table->string('end_time')->nullable;
            $table->integer('route');
            $table->string('driver'); // change it integer later
            $table->string('helper'); // change it integer later
            $table->string('contacter'); // change it integer later
            $table->integer('bus'); 
            $table->integer('total_seat'); 
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
        Schema::dropIfExists('trips');
    }
};
