<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\UserCalendar;
use App\TransactionCategory;
use App\Transaction;

class TransactionDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user1 = User::where('email','jordanwilliamson70@gmail.com')->first();
        $user2 = User::where('email','john@test.com')->first();

        $cat1 = TransactionCategory::all()->first();

        $cal1 = $user1->calendars()->first();
        $cal2 = $user2->calendars()->first();
        
        $trans1 = new Transaction;
        $trans1->id = \Webpatser\Uuid\Uuid::generate(4);
        $trans1->name = 'Transaction #1';
        $trans1->calendar()->associate($cal1);
        $trans1->category()->associate($cat1);
        $trans1->description = "My first transaction";
        $trans1->amount = 40.00;
        $trans1->date = '2017-11-10';
        $trans1->recurring = 'disabled';
        $trans1->save();

        $trans2 = new Transaction;
        $trans2->id = \Webpatser\Uuid\Uuid::generate(4);
        $trans2->name = 'Transaction #2';
        $trans2->calendar()->associate($cal1);
        $trans2->category()->associate($cat1);
        $trans2->description = "My second transaction";
        $trans2->amount = -20.00;
        $trans2->date = '2017-11-10';
        $trans2->recurring = 'disabled';
        $trans2->save();

        $trans3 = new Transaction;
        $trans3->id = \Webpatser\Uuid\Uuid::generate(4);
        $trans3->name = 'Transaction #1';
        $trans3->calendar()->associate($cal2);
        $trans3->category()->associate($cat1);
        $trans3->description = "My first transaction";
        $trans3->amount = 40.00;
        $trans3->date = '2017-11-10';
        $trans3->recurring = 'disabled';
        $trans3->save();

    }
}
