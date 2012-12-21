<?php

class Add_Contact_To_Users_Table {    

	public function up()
    {
		Schema::table('users', function($table) {
			$table->string('contact');
	});

    }    

	public function down()
    {
		Schema::table('users', function($table) {
			$table->drop_column('contact');
		});

    }

}