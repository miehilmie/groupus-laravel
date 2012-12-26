<?php

class Create_Lecturers_Table {    

	public function up()
    {
		Schema::create('lecturers', function($table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('room_no')->nullable();
			$table->foreign('user_id')->references('id')->on('users');
	});

    }    

	public function down()
    {
		Schema::drop('lecturers');

    }

}