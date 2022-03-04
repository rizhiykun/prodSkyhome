<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
//Общее:

//Документы(файлы)
//e-mail email
//телефон phone
//Адрес регистрации(Адрес) address
//Адрес фактического проживания(Фактический адрес) real_address

//Физик:
//ФИО* name surname patronymic
//Дата рождения birthdate
//Паспорт* passport
//Юрик:
//наименование организации полное* name
//наименование организации сокращенное* surname
//инн * inn
//кпп kpp
//огрн ogrn
//в лице: должность ____ фио _____на основании чего действует ______ req
//банковские реквизиты bank
//подписант signer
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('real_address')->nullable();
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('patronymic')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('passport')->nullable();
            $table->string('inn')->nullable();
            $table->string('kpp')->nullable();
            $table->string('ogrn')->nullable();
            $table->string('req')->nullable();
            $table->string('bank')->nullable();
            $table->string('signer')->nullable();
            $table->json('additional')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
