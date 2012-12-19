<?php

class Create_Student_Group_Table {    

	public function up()
    {
		Schema::create('student_group', function($table) {
			$table->increments('id');
			$table->integer('group_id')->unsigned();
			$table->integer('student_id')->unsigned();
			$table->foreign('group_id')->references('id')->on('groups');
			$table->foreign('student_id')->references('id')->on('students');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('student_group');

    }

}