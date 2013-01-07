<?php

class Create_Sentitems_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sentitems', function($table) {
			$table->increments('id');
			$table->integer('sender_id')->unsigned();
			$table->integer('receiver_id')->unsigned();
			$table->text('message');
			$table->integer('attachment_id')->unsigned()->nullable();
			$table->string('subject');
			$table->foreign('sender_id')->references('id')->on('users');
			$table->foreign('receiver_id')->references('id')->on('users');
			$table->timestamps();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sentitems');
	}

}