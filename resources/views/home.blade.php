@extends('layouts.base')

@section('title', 'Home')

@section('content')

    <div class="c-loading" v-if='!is_loaded'>
        <img class="c-loading--graphic" src="{{ asset('images/circles.svg') }}">
        <p>Loading...</p>
    </div>

    <div class="vue-content" :hidden="!is_loaded" v-cloak>

        <div class="panel panel-default">

            <div class="panel-body">


                <h2 class="c-calendar__month-title js-calendar-month-title text-center">
                    <button class="btn btn-sm btn-default" @click="previousMonth">Previous</button>
                    <span
                        class="o-fixed-block col-xs-5 col-md-4 col-lg-3 text-center"
                        >
                        @{{ Date.monthNames[ this.viewing_month ] }}
                        @{{ this.viewing_year }}
                    </span>
                    <button class="btn btn-sm btn-default" @click="nextMonth">Next</button>
                </h2>
                <div class="text-center">
                    <button class="btn btn-xs btn-default" @click="viewToday">Today</button>
                </div>

                <calendar-table
                    :viewing_month='this.viewing_month'
                    :viewing_year='this.viewing_year'
                    :start_on_monday="false"
                    day_component_type="calendar-transaction-list"
                    @date-clicked="dateClicked"
                    >
                </calendar-table>

            </div>

        </div>

        <div class="panel panel-default">


            <div class="panel-heading">
                <h2 class="panel-title text-center js-day-summary-title">
                    <strong>@{{ selected_date_balance | currency }}</strong> as of
                    <span class="js-current-date">@{{ selected_date | date }}</span>
                </h2>
            </div>

            <div class="c-day-summary-box panel-body">


                <transaction-list
                    :transactions="
                        this.transactions.filter( function (trans) {
                            return (new Date(trans.date + ' 0:0:0').sameDateAs(selected_date));

                        })"
                    ></transaction-list>

                <div class="c-day-summary-box__add-transaction container-fluid">
                    <form class="form-inline row">


                        <div class="form-group col-sm-5 col-md-4 col-lg-3">
                            <label for="new-transaction-name">Name</label>
                            <input type='text' name='new-transaction-name' class="form-control">
                        </div>

                        <div class="form-group col-sm-7 col-md-8 col-lg-9">
                            <label for="new-transaction-amount">Amount</label>

                            <div class="input-group">
                                <div class="input-group-addon">$</div>
                                <input type='text' name='new-transaction-amount' class="form-control">
                                <div class="input-group-addon">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </div>

                        </div>



                    </form>
                </div>


            </div>


        </div>

    </div>

@endsection

@section('pre-vue-script')
client_vue_data = {
    user_id: "{{ request()->user_id }}"
};
@endsection