<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('clientID')->default('')->nullable();
            $table->string('objectAddress')->default('')->nullable();
            $table->string('objectArea')->default('')->nullable();
            $table->string('priceMcv')->default('')->nullable();
            $table->string('summaryPrice')->default('')->nullable();
            $table->string('objectType')->default('')->nullable();
            $table->string('executive')->default('')->nullable();
            $table->string('Coordinator')->default('')->nullable();
            $table->string('objectStatus')->default('')->nullable();
            $table->string('Rationale')->default('')->nullable();
            $table->string('overhead')->default('')->nullable();
            $table->string('director')->default('')->nullable();
            $table->string('floorArea')->default('')->nullable();
            $table->string('ceilingHeight')->default('')->nullable();
            $table->string('wallArea')->default('')->nullable();
            $table->json('works')->nullable();
            $table->string('discounts')->default('')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estimates');
    }
}
