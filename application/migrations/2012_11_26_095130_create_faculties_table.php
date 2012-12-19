<?php

class Create_Faculties_Table {    

	public function up()
    {
		Schema::create('faculties', function($table) {
			$table->increments('id');
			$table->string('name');
			$table->string('abbrevation');
			$table->integer('university_id')->unsigned();
			$table->foreign('university_id')->references('id')->on('universities');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('faculties');

    }

}