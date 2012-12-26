<?php // file: /application/seeds/users.php

class Seed_Faculties extends \S2\Seed {

    public function grow()
    {
		$faculty = new Faculty(array(
				'name' => 'Faculty of Computing and Informatics',
				'abbrevation' => 'FCI',
				'university_id' => $this->getReference('university-mmu')->id
			));
		$faculty->save();
		$this->addReference('faculty-fci', $faculty);
		
		$faculty = new Faculty(array(
				'name' => 'Faculty of Engineering',
				'abbrevation' => 'FOE',
				'university_id' => $this->getReference('university-mmu')->id
			));
		$faculty->save();
		$this->addReference('faculty-foe', $faculty);
		
		$faculty = new Faculty(array(
				'name' => 'Faculty of Management',
				'abbrevation' => 'FOM',
				'university_id' => $this->getReference('university-mmu')->id
			));
		$faculty->save();
		$this->addReference('faculty-fom', $faculty);
		
		$faculty = new Faculty(array(
				'name' => 'Faculty of Creative and Multimedia',
				'abbrevation' => 'FCM',
				'university_id' => $this->getReference('university-mmu')->id
			));
		$faculty->save();
		$this->addReference('faculty-fcm', $faculty);

    }

    // This is optional. It lets you specify the order each seed is grown.
    // Seeds with a lower number are grown first.
    public function order()
    {
        return 4;
    }

}