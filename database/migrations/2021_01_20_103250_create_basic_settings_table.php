<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasicSettingsTable extends Migration
{

    public function up()
    {
        Schema::create('basic_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('phone','20');
            $table->string('email','100');
            $table->string('address','255')->nullable();
            $table->text('meta_tag')->nullable();
            $table->text('description')->nullable();
            $table->string('footer')->nullable();
            $table->string('copy')->nullable();
            $table->string('faq')->nullable();
            $table->string('about')->nullable();
            $table->string('privacy')->nullable();
            $table->string('terms')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('basic_settings');
    }
}
