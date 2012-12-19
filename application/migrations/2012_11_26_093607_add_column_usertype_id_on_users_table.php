<?php

class Add_Column_Usertype_Id_On_Users_Table {    

	public function up()
    {
		Schema::table('users', function($table) {
			$table->integer('usertype_id')->unsigned();
			$table->foreign('usertype_id')->references('id')->on('usertypes');
	});

    }    

	public function down()
    {
		Schema::table('users', function($table) {
			$table->drop_foreign('users_usertype_id_foreign');
			$table->drop_column('usertype_id');
	});

    }

}