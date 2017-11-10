<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('user_calendar_id')->unsigned();        // foreign
            $table->integer('transaction_category_id')
                ->unsigned()->nullable();                           // foreign
            $table->string('name')->default('');
            $table->string('description')->default('');
            $table->decimal('amount', 8, 2)->default(0);
            $table->date('date')->useCurrent();
            $table->enum('recurring', ['disabled', 'daily', 'weekly', 'biweekly', 'monthly', 'yearly'])->default('disabled');

            $table->timestamps();
            $table->primary('id');
        });

        Schema::table('transactions', function(Blueprint $table) {
            $table->foreign('user_calendar_id')
                ->references('id')
                ->on('user_calendars');
            $table->foreign('transaction_category_id')
                ->references('id')
                ->on('transaction_categories')
                ->onDelete('set null');
        });

        DB::unprepared('
            CREATE TRIGGER before_insert_transactions
                BEFORE INSERT ON transactions
                FOR EACH ROW
                SET new.id = IF (new.id != "", new.id, uuid());
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
        DB::unprepared('DROP TRIGGER IF EXISTS `before_insert_transactions`');
    }
}
