<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\TransactionCategory;

class TransactionCategoryDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Create Transaction Categories
        $trans_cat1 = new TransactionCategory;
        $trans_cat1->name = "Bills";
        $trans_cat1->public = true;
        $trans_cat1->save();

    }
}