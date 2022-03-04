<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('norms_list', function (Blueprint $table) {
            $table->string('workID');
            $table->json('supply')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('norms_list', function (Blueprint $table) {
            $table->dropColumn('workID');
            $table->dropColumn('supply');
        });
    }
}
