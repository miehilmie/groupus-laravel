<?php // file: /application/seeds/users.php

class Seed_Genders extends \S2\Seed {

    public function grow()
    {
		$gender = new Gender(array(
				'gender' => 'Male'
			));
		$gender->save();
		$this->addReference('gender-m', $gender);

		$gender = new Gender(array(
				'gender' => 'Female'
			));
		$gender->save();
		$this->addReference('gender-m', $gender);
    }

    // This is optional. It lets you specify the order each seed is grown.
    // Seeds with a lower number are grown first.
    public function order()
    {
        return 1;
    }

}