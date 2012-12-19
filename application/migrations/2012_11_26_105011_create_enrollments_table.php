<?php

class Create_Enrollments_Table {    

	public function up()
    {
		Schema::create('enrollments', function($table) {
			$table->increments('id');
			$table->integer('student_id')->unsigned();
			$table->integer('subject_id')->unsigned();
			$table->integer('semester_id')->unsigned();
			$table->foreign('student_id')->references('id')->on('students');
			$table->foreign('subject_id')->references('id')->on('subjects');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('enrollments');

    }

}