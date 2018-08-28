<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cnpj', 14);
            $table->string('name');
            $table->string('trade_name');
            $table->string('ie', 20)->nullable();
            $table->string('address');
            $table->integer('number');
            $table->string('cep', 8);
            $table->string('district');
            $table->string('city');
            $table->string('state', 2);
            $table->string('observation')->nullable();
            $table->string('phone', 20);
            $table->string('mobile_phone', 20);
            $table->double('interest')->default(0);
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
        Schema::dropIfExists('stores');
    }
}
