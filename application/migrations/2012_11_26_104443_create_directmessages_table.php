<?php

class Create_Directmessages_Table {    

	public function up()
    {
		Schema::create('directmessages', function($table) {
			$table->increments('id');
			$table->integer('sender_id')->unsigned();
			$table->integer('receiver_id')->unsigned();
			$table->text('message');
			$table->integer('attachment_id')->unsigned()->nullable();

			$table->foreign('sender_id')->references('id')->on('users');
			$table->foreign('receiver_id')->references('id')->on('users');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('directmessages');

    }

}