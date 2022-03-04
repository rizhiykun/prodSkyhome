<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repairs', function (Blueprint $table) {

            $table->string('objectType')->nullable();
            $table->string('estimate')->nullable();
            $table->string('person')->nullable();
            $table->bigInteger('disignCoast')->nullable();
            $table->boolean('checkPresent')->nullable();
            $table->Integer('discount')->nullable();
            $table->date('termContract')->nullable();
            $table->Integer('objectSquare')->nullable();
            $table->bigInteger('totalAmount')->nullable();
            $table->string('paySchedule')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('repairs', function (Blueprint $table) {
            $table->dropColumn('termContract');
        });
    }
}
