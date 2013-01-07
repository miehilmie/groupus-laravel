<?php

class Create_Grouprules_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('grouprules', function($table) {
			$table->increments('id');
			$table->integer('subject_id')->unsigned();
			$table->integer('semester_id')->unsigned();
			$table->integer('maxgroups')->default(0);
			$table->integer('maxstudents')->default(0);
			$table->integer('mode')->default(1); // auto or manual
			$table->boolean('enable')->default(false);
			$table->foreign('subject_id')->references('id')->on('subjects');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('grouprules');
	}

}