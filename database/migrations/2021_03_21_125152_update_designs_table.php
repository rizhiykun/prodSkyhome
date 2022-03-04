<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDesignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->string('person')->nullable();
            $table->string('ourCompany')->nullable();
            $table->string('objectAddress')->nullable();
            $table->string('objectSquare')->nullable();
            $table->string('objectTariff')->nullable();
            $table->string('objectData')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->dropColumn('person');
            $table->dropColumn('ourCompany');
            $table->dropColumn('objectAddress');
            $table->dropColumn('objectSquare');
            $table->dropColumn('objectTariff');
            $table->dropColumn('objectData')();
        });
    }
}
