<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaderosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maderos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_courier');
            $table->float('amount_madero');
            $table->float('amount_repartos');
            $table->float('amount_urbo');
            $table->float('amount_repartidor');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maderos');
    }
}
