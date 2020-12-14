<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_movements', function (Blueprint $table) {
            $table->id();
            $table->string('concept');
            $table->string('details');
            $table->unsignedInteger('id_account');
            $table->date('date');
            $table->string('type');
            $table->float('amount');
            $table->float('balance')->nullable();
            $table->unsignedInteger('id_courier')->nullable();
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
        Schema::dropIfExists('account_movements');
    }
}
