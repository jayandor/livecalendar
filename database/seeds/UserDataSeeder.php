<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;

class UserDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Create Users
        $user1 = new User;
        $user1->id = \Webpatser\Uuid\Uuid::generate(4);
        $user1->email = 'jordanwilliamson70@gmail.com';
        $user1->first_name = 'Jordan';
        $user1->last_name = 'Williamson';
        $user1->password = bcrypt("test12");
        $user1->save();

        $user2 = new User;
        $user2->id = \Webpatser\Uuid\Uuid::generate(4);
        $user2->email = 'john@test.com';
        $user2->first_name = 'John';
        $user2->last_name = 'Doe';
        $user2->password = bcrypt("test12");
        $user2->save();

    }
}
