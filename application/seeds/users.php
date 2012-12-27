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
        $this->addReference('user-1', $user);
        $user->save();
        $student = new Student(array(
            'cgpa' => 3.66,
            'distance_f_c' => 1,
        ));
        $user->student()->insert($student);
        $this->addReference('student-1', $student);

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
        $this->addReference('user-2', $user);

        $lecturer = new Lecturer(array(
        ));
        $user->lecturer()->insert($lecturer);
        $this->addReference('lecturer-1', $lecturer);
    }

    // This is optional. It lets you specify the order each seed is grown.
    // Seeds with a lower number are grown first.
    public function order()
    {
        return 6;
    }

}