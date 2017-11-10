<template>

    <div class="c-calendar">

        <h2 class="c-calendar__month-title js-calendar-month-title">{{ Date.monthNames[internal_viewing_month] }} {{ internal_viewing_year }}</h2>

        <button
            v-if="show_nav_buttons"
            class="btn btn-default"
            @click="previousMonth"
            >
            Previous
        </button>
        <button
            v-if="show_nav_buttons"
            class="btn btn-default"
            @click="nextMonth"
            >
            Next
        </button>
        <button
            v-if="show_nav_buttons"
            class="btn btn-default"
            @click="viewToday"
            >
            Today
        </button>

        <calendar-table
            :viewing_month='internal_viewing_month'
            :viewing_year='internal_viewing_year'
            :start_on_monday="start_on_monday"
            @date-clicked="dateClicked"
            :day_component_type="day_component_type"
            >
        </calendar-table>

    </div>

</template>

<script>
    export default {
        props: {
            'show_nav_buttons': {
                default: true,
                type: Boolean
            },
            'start_on_monday': {
                default: false,
                type: Boolean
            },
            'viewing_month': {
                default: new Date().getMonth()
            },
            'viewing_year': {
                default: new Date().getFullYear()
            },
            'day_component_type': {},
        },
        data: function() {
            return {
                internal_viewing_month: this.viewing_month,
                internal_viewing_year: this.viewing_year,
            };
        },
        watch: {
            viewing_month: function () {
                this.internal_viewing_month = this.viewing_month;
            },
            viewing_year: function () {
                this.internal_viewing_year = this.viewing_year;
            },
        },
        methods: {
            getMonthName: function (month) {
                var monthNames = ["January", "February", "March", "April", "May", "June",
                      "July", "August", "September", "October", "November", "December"
                    ];
                return monthNames[month];
            },
            dateClicked: function(e) {
                this.$emit('date-clicked', e);
            },
            setViewingDate: function(month, year) {

                this.internal_viewing_month = month;
                this.internal_viewing_year = year;

                this.$emit(
                    'updated-viewing-date',
                    this.internal_viewing_month,
                    this.internal_viewing_year
                );

            },
            previousMonth: function () {

                var newDate = new Date(this.internal_viewing_year, this.internal_viewing_month, 1);
                newDate.setMonth( newDate.getMonth() - 1 );

                this.setViewingDate( newDate.getMonth(), newDate.getFullYear() );

            },
            nextMonth: function () {

                var newDate = new Date(this.internal_viewing_year, this.internal_viewing_month, 1);
                newDate.setMonth( newDate.getMonth() + 1 );

                this.setViewingDate( newDate.getMonth(), newDate.getFullYear() );

            },
            viewToday: function () {

                var newDate = new Date();
                this.setViewingDate( newDate.getMonth(), newDate.getFullYear() );

            },
        },
        components: {
            'calendar-table':
                Vue.component(
                    'calendar-table',
                    require('./CalendarTable.vue')
                )
        }
    }
</script>
