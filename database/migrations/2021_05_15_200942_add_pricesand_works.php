<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPricesandWorks extends Migration
{
    public function up()
    {
        Schema::table('estimates', function (Blueprint $table) {
            $table->json('additionalWorks');
        });
    }

    public function down()
    {
        Schema::table('estimates', function (Blueprint $table) {
            $table->dropColumn('additionalWorks');
        });
    }
}
