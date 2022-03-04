<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriseListRepairTable extends Migration
{
    /**
     * Run the migrations.
    Прайс-лист Ремонт параметр скидка - в процентах
    Группа работ - 	название, выбор из списка групп работ
    Блок работ 	название, редактируемое поле
    Вид работ	название, редактируемое поле
    Опции - массив операций
    Дополнительные обязательные работы - работы которые необходимо выполнить вместе с этой работой по умолчанию
    Отображать в смете по умолчанию - чекбокс, работа является базовой(отображается в смете на работы)
    ед. изм.	единицы измерения со справочника единиц измерений*, редактируемое поле выбора.
    Базовая цена	цена мастера * наценка ( поле которое можем редактировать только администратор)
    Базовая цена со скидкой	нередактируемое поле
    Цена Мастера	( выставояем) цена за которую мастер выполняет данный вид работ
    Цена Прораба 	цена мастера * наценка на прораба
     * @return void
     */
    public function up()
    {
        Schema::create('prise_list_repair', function (Blueprint $table) {
            $table->id();
            $table->string('workGroup')->default('No Group');
            $table->string('workBlock')->default('No block');
            $table->string('workName')->default('without Name');
            $table->json('options')->nullable();
            $table->string('additionalWorks')->default('');
            $table->boolean('plVisible')->default(false);
            $table->string('measurement')->default('Без е.и.');
            $table->float('basePrice')->default(0);
            $table->float('discount')->default(0);
            $table->float('discountPrice')->default(0);
            $table->float('masterPrice')->default(0);
            $table->float('foremanPrice')->default(0);
            $table->jsonb('data')->nullable();
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
        Schema::dropIfExists('prise_list_repair');
    }
}
