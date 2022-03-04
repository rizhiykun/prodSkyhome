<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->string('type')->nullable();
            //$table->id();
            //$table->string('name');
            //$table->string('lastname');
            //$table->string('surname');
            //$table->string('BirthDate');
            //$table->string('passportInfo');
            //$table->string('address');
            //$table->string('addressReal');
            //$table->string('phone');
            //$table->string('email');
            //$table->string('password');
            //$table->string('checkIfSame');
            //$table->string('data')->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
