<?php

class Create_Subjects_Table {    

	public function up()
    {
		Schema::create('subjects', function($table) {
			$table->increments('id');
			$table->string('code');
			$table->string('name');
			$table->integer('faculty_id')->unsigned();
			$table->foreign('faculty_id')->references('id')->on('faculties');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('subjects');

    }

}