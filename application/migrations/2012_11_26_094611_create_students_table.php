<?php

class Create_Students_Table {    

	public function up()
    {
		Schema::create('students', function($table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->float('cgpa');
			$table->integer('distance_f_c')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
	});

    }    

	public function down()
    {
		Schema::drop('students');

    }

}