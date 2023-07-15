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
        Schema::create('ticket_sales', function (Blueprint $table) {
            $table->id();
            $table->integer('issued_by');
            $table->integer('trip_id');
            $table->integer('from');
            $table->integer('to');
            $table->integer('fare_amount');
            $table->integer('total_seat');
            $table->string('transaction_id')->nullable();
            $table->string('serial')->unique();
            $table->string('status');
            $table->string('payment_by');
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
        Schema::dropIfExists('ticket_sales');
    }
};
