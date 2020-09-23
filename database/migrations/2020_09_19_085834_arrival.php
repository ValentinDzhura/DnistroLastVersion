<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Arrival extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrival', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longtext('description');
            $table->date('begin');
            $table->date('end');
            $table->string('tour_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('arrival');
    }
}
