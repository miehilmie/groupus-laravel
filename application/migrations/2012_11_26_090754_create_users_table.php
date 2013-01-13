<?php

class Create_Users_Table {    

	public function up()
    {
		Schema::create('users', function($table) {
			$table->increments('id');
			$table->string('username');
			$table->string('password');
			$table->string('name');
			$table->string('phone');
			$table->integer('age');
			$table->string('address');
			$table->string('img_url')->default('default.png');
			$table->integer('gender_id')->unsigned();
			$table->integer('university_id')->unsigned();
			$table->timestamps();
			$table->timestamp('last_activity');
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