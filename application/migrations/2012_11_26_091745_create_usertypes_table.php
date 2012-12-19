<?php

class Create_Usertypes_Table {    

	public function up()
    {
		Schema::create('usertypes', function($table) {
			$table->increments('id');
			$table->string('type');
	});

    }    

	public function down()
    {
		Schema::drop('usertypes');

    }

}