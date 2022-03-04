<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * - фио  (обязательное поле)
    - дата рождения
    - паспортные данные (обязательное поле)
    - адрес регистрации  (обязательное поле)
    - адрес фактического проживания (галочка совпадает)
    - номер телефона  (обязательное поле)
    - электронная почта  (обязательное поле)
    -  возможность подгрузить фото паспорта.

     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->string('surname');
            $table->string('BirthDate');
            $table->string('passportInfo');
            $table->string('address');
            $table->string('addressReal');
            $table->string('phone');
            $table->string('email');
            $table->string('password');
            $table->string('checkIfSame');
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
        Schema::dropIfExists('persons');
    }
}
