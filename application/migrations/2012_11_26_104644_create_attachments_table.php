<?php

class Create_Attachments_Table {    

	public function up()
    {
		Schema::create('attachments', function($table) {
			$table->increments('id');
			$table->string('filename');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('attachments');

    }

}