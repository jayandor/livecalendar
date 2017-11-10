<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_calendars', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('user_id');                // foreign

            // Each calendar has an additional unique id relative to user,
            // so a combination of `user_id` and `user_calendar_id` can uniquely
            // identify a calendar, but not just `user_calendar_id`. `id` can
            // still uniquely identify a calendar, as well.
            $table->integer('user_calendar_id');
            $table->unique( ['user_id', 'user_calendar_id'] );

            $table->string('name')->default('');
            $table->timestamps();
        });

        Schema::table('user_calendars', function(Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_calendars');
    }
}
