<?php

class Create_Groups_Table {    

	public function up()
    {
		Schema::create('groups', function($table) {
			$table->increments('id');
			$table->integer('subject_id')->unsigned();
			$table->integer('semester_id')->unsigned();
			$table->string('name');
			$table->foreign('subject_id')->references('id')->on('subjects');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('groups');

    }

}