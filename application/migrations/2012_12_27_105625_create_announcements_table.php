<?php

class Create_Announcements_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('announcements', function($table) {
			$table->increments('id');
			$table->text('message');
			$table->integer('subject_id')->nullable();
			$table->integer('semester_id')->nullable();
			$table->integer('user_id');
			$table->integer('attachment_id')->nullable();
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
		Schema::drop('announcements');
	}

}