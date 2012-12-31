<?php

class Create_Table_Votes {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('votes', function($table) {
			$table->increments('id');
			$table->integer('value');
			$table->integer('voter_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('type');
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('voter_id')->references('id')->on('users');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('votes');
	}

}