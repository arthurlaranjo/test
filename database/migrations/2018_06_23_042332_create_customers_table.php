<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->date('birthday')->nullable();
            $table->string('cpf', 11);
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->integer('number')->nullable();
            $table->string('cep', 8)->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('state', 2)->nullable();
            $table->string('observation')->nullable();

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
        Schema::dropIfExists('customers');
    }
}
