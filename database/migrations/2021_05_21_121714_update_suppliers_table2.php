<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSuppliersTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('addressj')->nullable();
            $table->bigInteger('inn')->nullable();
            $table->bigInteger('kpp')->nullable();
            $table->bigInteger('ogrn')->nullable();
            $table->bigInteger('okved')->nullable();
           //$table->Integer('additional')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn('addressj')->nullable();
            $table->dropColumn('inn')->nullable();
            $table->dropColumn('kpp')->nullable();
            $table->dropColumn('ogrn')->nullable();
            $table->dropColumn('okved')->nullable();
            //$table->dropColumn('additional')->nullable();
        });
    }
}
