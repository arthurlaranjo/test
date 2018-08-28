<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('size');
            $table->string('description');
            $table->integer('quantity')->unsigned();
            $table->string('code')->nullable();
            $table->integer('value')->unsigned();
            $table->integer('forward_value')->unsigned()->nullable();
            $table->integer('installments')->unsigned()->nullable();
            $table->double('interest')->unsigned()->nullable();
            $table->enum('interest_unity', ['ANO', 'MES', 'DIA'])->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
