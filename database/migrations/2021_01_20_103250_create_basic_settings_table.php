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
            $table->string('address','255');
            $table->Text('meta_tag');
            $table->Text('description');
            $table->string('footer');
            $table->string('copy');
            $table->string('faq');
            $table->string('about');
            $table->string('privacy');
            $table->string('terms');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('basic_settings');
    }
}
