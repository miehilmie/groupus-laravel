<?php

class Add_Faculty_Id_To_Users_Table {    

	public function up()
    {
		Schema::table('users', function($table) {
			$table->integer('faculty_id')->unsigned();
			$table->foreign('faculty_id')->references('id')->on('faculties');

	});

    }    

	public function down()
    {
		Schema::table('users', function($table) {
			$table->drop_foreign('users_faculty_id_foreign');
			$table->drop_column('faculty_id');
	});

    }

}