<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('name');
            $table->bigInteger('imageable_id');
            $table->string('imageable_type');
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('images');
    }
};
