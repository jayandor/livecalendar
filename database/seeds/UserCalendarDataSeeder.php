<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\UserCalendar;
use App\User;

class UserCalendarDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Create User Calendars
        $user_cal1 = new UserCalendar;
        $user_cal1->name = "My Calendar";
        $user_cal1->user_calendar_id = 1;

        $user1 = User::where('email','jordanwilliamson70@gmail.com')->first();

        $user_cal1->user()->associate($user1);
        $user_cal1->save();

        $user_cal2 = new UserCalendar;
        $user_cal2->name = "My Calendar";
        $user_cal2->user_calendar_id = 1;

        $user2 = User::where('email','john@test.com')->first();

        $user_cal2->user()->associate($user2);
        $user_cal2->save();

    }
}
