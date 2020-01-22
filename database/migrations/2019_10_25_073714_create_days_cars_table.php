<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDaysCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('days_cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('driver');
            $table->string('day');
            $table->text('description');
            $table->double('price', 8, 2);
            $table->double('paid', 8, 2);
            $table->double('remain', 8, 2);
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
        Schema::dropIfExists('days_cars');
    }
}
