<?php

class Add_Unique_Username_To_Users_Table {    

	public function up()
    {
		Schema::table('users', function($table) 
		{
			$table->unique('username');
		});

    }    

	public function down()
    {
		Schema::table('users', function($table) {
			$table->drop_unique('users_username_unique');
		});
	}


}