<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSheetMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sheet_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_sheet');
            $table->string('details')->nullable();
            $table->dateTime('date');
            $table->string('type');
            $table->float('amount');
            $table->float('balance')->nullable();
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
        Schema::dropIfExists('sheet_movements');
    }
}
