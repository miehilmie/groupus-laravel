<?php

class Create_Universities_Table {    

	public function up()
    {
		Schema::create('universities', function($table) {
			$table->increments('id');
			$table->string('name');
			$table->string('abbrevation');
			$table->integer('semester_id');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('universities');

    }

}