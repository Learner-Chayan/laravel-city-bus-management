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
            $table->string('end_time')->nullable();
            $table->integer('route');
            $table->integer('owner_id');
            $table->integer('driver_id'); // change it integer later
            $table->integer('helper_id'); // change it integer later
            $table->integer('checker_id'); // change it integer later
            $table->integer('bus_id');
            $table->integer('total_seat');
            $table->string('type')->nullable();
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
