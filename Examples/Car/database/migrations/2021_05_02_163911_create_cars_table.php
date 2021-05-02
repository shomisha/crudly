<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->bigInteger('manufacturer_id')->unsigned();
            $table->integer('production_year')->nullable()->unsigned();
            $table->date('first_registration_date')->nullable();
            $table->integer('horse_power')->nullable()->unsigned();
            $table->timestamps();
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cars');
    }
}