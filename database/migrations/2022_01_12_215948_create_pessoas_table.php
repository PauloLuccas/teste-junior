<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePessoasTable.
 */
class CreatePessoasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pessoas', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('sobrenome');
            $table->string('cpf');
            $table->string('celular');
            $table->longText('logradouro');
            $table->string('cep');

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
		Schema::drop('pessoas');
	}
}
