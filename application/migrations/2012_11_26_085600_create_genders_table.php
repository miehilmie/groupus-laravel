<?php

class Create_Genders_Table {    

	public function up()
    {
		Schema::create('genders', function($table) {
			$table->increments('id');
			$table->string('gender');
	});

    }    

	public function down()
    {
		Schema::drop('genders');

    }

}