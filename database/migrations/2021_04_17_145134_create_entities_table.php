<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('organizationNameFull');
            $table->string('organizationNameShort');
            $table->string('inn');
            $table->string('kpp');
            $table->string('ogrn');
            $table->string('legalAddress');
            $table->string('addressReal');
            $table->string('checkIfSame');
            $table->string('requisites');
            $table->string('bankDetails');
            $table->string('subscriber');
            $table->string('phone');
            $table->string('email');
            $table->string('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entities');
    }
}
