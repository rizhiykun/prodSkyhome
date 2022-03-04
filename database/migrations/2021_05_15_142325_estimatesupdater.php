<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Estimatesupdater extends Migration
{
    public function up()
    {
        Schema::table('estimates', function (Blueprint $table) {
            $table->boolean('approval')->default(false);
        });
    }

    public function down()
    {
        Schema::table('estimates', function (Blueprint $table) {
            $table->dropColumn('approval');
        });
    }
}
