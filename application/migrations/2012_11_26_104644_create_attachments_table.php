<?php

class Create_Attachments_Table {    

	public function up()
    {
		Schema::create('attachments', function($table) {
			$table->increments('id');
			$table->string('url');
			$table->string('path');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('attachments');

    }

}