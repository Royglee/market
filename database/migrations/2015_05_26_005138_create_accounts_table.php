<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accounts', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->boolean('countq');
            $table->integer('count')->nullable();
            $table->boolean('first_owner');
            $table->boolean('has_email');
            $table->integer('duration');
            $table->float('delivery');
            $table->string('title');
            $table->string('server');
            $table->string('league');
            $table->integer('division')->unsigned()->nullable();
            $table->integer('champions');
            $table->integer('skins');
            $table->float('price');
            $table->text('body');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
		Schema::table('accounts', function(Blueprint $table)
		{
            Schema::drop('accounts');
		});
	}

}
