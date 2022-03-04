<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserExtendTable extends Migration
{
    /**
     * Run the migrations.
    - дата рождения
    - паспортные данные
    - адрес регистрации
    - адрес фактического проживания (галочка совпадает)
    - номер телефона
    - возможность подгрузить фото паспорта и фотографию пользователя.
    - Договора
     * @return void
     */
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->jsonb('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['data']);
        });
    }
}
