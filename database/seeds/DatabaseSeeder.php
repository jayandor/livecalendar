<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transactions')->delete();
        DB::table('transaction_categories')->delete();
        DB::table('user_calendars')->delete();
        DB::table('users')->delete();

        $this->call(UserDataSeeder::class);
        $this->call(TransactionCategoryDataSeeder::class);
        $this->call(UserCalendarDataSeeder::class);
        $this->call(TransactionDataSeeder::class);
    }
}
