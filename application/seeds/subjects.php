<?php // file: /application/seeds/subjects.php

class Seed_Subjects extends \S2\Seed {

    public function grow()
    {
        $subject = new Subject(array(
            'code' => 'TCP1231',
            'name' => 'Computer Programming 1',
            'faculty_id' => $this->getReference('faculty-fci')->id
        ));
        $subject->save();
        $this->addReference('subject-1', $subject);

        $subject = new Subject(array(
            'code' => 'TCP1232',
            'name' => 'Computer Programming 2',
            'faculty_id' => $this->getReference('faculty-fci')->id
        ));
        $subject->save();
        $this->addReference('subject-2', $subject);
    }

    // This is optional. It lets you specify the order each seed is grown.
    // Seeds with a lower number are grown first.
    public function order()
    {
        return 5;
    }

}