<?php // file: /application/seeds/users.php

class Seed_Users extends \S2\Seed {

    public function grow()
    {
        $user = new User(array(
            'username' => 'miebaik',
            'password' => Hash::make('testing'),
            'name' => 'Muhammad Hilmi',
            'university_id' => $this->getReference('university-mmu')->id,
            'faculty_id' => $this->getReference('faculty-fci')->id,
            'usertype_id' => $this->getReference('usertype-s')->id,
            'gender_id' => $this->getReference('gender-m')->id,
        ));
        $user->save();
        $student = new Student(array(
            'cgpa' => 3.66,
            'distance_f_c' => 1,
        ));
        $user->student()->insert($student);

        $user = new User(array(
            'username' => 'miehilmie',
            'password' => Hash::make('testing'),
            'name' => 'Muhammad Hilmie',
            'university_id' => $this->getReference('university-mmu')->id,
            'faculty_id' => $this->getReference('faculty-fci')->id,
            'usertype_id' => $this->getReference('usertype-l')->id,
            'gender_id' => $this->getReference('gender-m')->id,
        ));
        $user->save();
        $lecturer = new Lecturer(array(
        ));
        $user->lecturer()->insert($lecturer);
    }

    // This is optional. It lets you specify the order each seed is grown.
    // Seeds with a lower number are grown first.
    public function order()
    {
        return 6;
    }

}