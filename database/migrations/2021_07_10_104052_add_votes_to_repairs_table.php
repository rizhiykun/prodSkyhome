<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVotesToRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repairs', function (Blueprint $table) {
            $table->integer('deposit')->default(0);
            $table->string('manager')->nullable();
            $table->string('foreman')->nullable();
            $table->string('supplier')->nullable();
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
            $table->dropColumn('deposit');
            $table->dropColumn('manager');
            $table->dropColumn('foreman');
            $table->dropColumn('supplier');
        });
    }
}
