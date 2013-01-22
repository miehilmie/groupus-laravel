<?php

class Create_Table_Groupposts {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('groupposts', function($table) {
			$table->increments('id');
			$table->integer('poster_id')->unsigned();
			$table->integer('group_id')->unsigned();
			$table->integer('attachment_id')->unsigned()->nullable();
			$table->text('message');
			$table->boolean('has_attachment')->default(false);
			$table->timestamps();
			$table->foreign('poster_id')->references('id')->on('users');
			$table->foreign('group_id')->references('id')->on('groups');
			$table->foreign('attachment_id')->references('id')->on('attachments')->on_delete('cascade');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('groupposts');
	}

}