<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('nameslug');
            $table->string('type');
            $table->string('delivery');
            $table->string('deliveryprice');
            $table->string('deliverytype');
            $table->string('email');
            $table->text('about');
            $table->string('flor');
            $table->integer('florprice');
            $table->string('address');
            $table->string('phone');
            $table->text('comment');
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
        Schema::dropIfExists('posts');
    }
}
