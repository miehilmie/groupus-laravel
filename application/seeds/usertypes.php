<?php // file: /application/seeds/users.php

class Seed_Usertypes extends \S2\Seed {

    public function grow()
    {
		$usertype = new Usertype(array(
				'type' => 'Student'
			));
		$usertype->save();
		$this->addReference('usertype-s', $usertype);

		$usertype = new Usertype(array(
				'type' => 'Lecturer'
			));
		$usertype->save();
		$this->addReference('usertype-l', $usertype);

		$usertype = new Usertype(array(
				'type' => 'Admin'
			));
		$usertype->save();
		$this->addReference('usertype-a', $usertype);
    }

    // This is optional. It lets you specify the order each seed is grown.
    // Seeds with a lower number are grown first.
    public function order()
    {
        return 3;
    }

}
