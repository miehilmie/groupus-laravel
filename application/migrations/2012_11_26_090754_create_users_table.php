<?php

class Create_Users_Table {    

	public function up()
    {
		Schema::create('users', function($table) {
			$table->increments('id');
			$table->string('username');
			$table->string('password');
			$table->string('name');
			$table->integer('gender_id')->unsigned();
			$table->integer('university_id')->unsigned();
			$table->timestamps();
			$table->foreign('gender_id')->references('id')
				->on('genders');
			$table->foreign('university_id')->references('id')
				->on('universities');
	});

    }    

	public function down()
    {
		Schema::drop('users');

    }

}