<?php

class Create_Discussions_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('discussions', function($table) {
			$table->increments('id');
			$table->integer('poster_id')->unsigned();
			$table->integer('subject_id')->unsigned();
			$table->integer('semester_id')->unsigned();
			$table->integer('attachment_id')->unsigned()->nullable();
			$table->text('message');
			$table->boolean('has_attachment')->default(false);
			$table->timestamps();
			$table->foreign('poster_id')->references('id')->on('users');
			$table->foreign('subject_id')->references('id')->on('subjects');
			$table->foreign('attachment_id')->references('id')->on('attachments');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('discussions');
	}

}