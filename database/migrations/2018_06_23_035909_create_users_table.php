<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('cpf')->unique();
            $table->string('rg');
            $table->string('password');
            $table->enum('role', ['ADMINISTRADOR', 'PROPRIETÁRIO', 'GERENTE', 'VENDEDOR']);
            $table->integer('store_id')->unsigned();
            $table->string('address');
            $table->integer('number');
            $table->string('cep', 8);
            $table->string('district');
            $table->string('city');
            $table->string('state', 2);
            $table->string('observation')->nullable();
            $table->string('phone', 20);
            $table->string('mobile_phone', 20);
            $table->string('email')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
