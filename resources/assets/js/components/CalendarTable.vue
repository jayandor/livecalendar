<template>

    <div>
        <table class="c-calendar__table table">
            <thead>
                <tr>
                    <th v-for="day in getDaysOfWeek()" class="c-calendar__header-day">
                        {{ day }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="week in 6">
                    <calendar-day v-for="day in 7"
                        :month="viewing_month"
                        :date="getMonthDay(
                                day + (
                                    (monthStartDay(
                                        viewing_month,
                                        viewing_year
                                    ) == 0) ?
                                        -6 * start_on_monday
                                        : 1 * start_on_monday
                                ),
                                week,
                                viewing_month,
                                viewing_year
                            )"
                        :year="viewing_year"
                        :day_component_type="day_component_type"
                        :key="'calendar-day-' + viewing_year + '_' + viewing_month + '_' + day"
                        @date-clicked="dateClicked"
                        >
                    </calendar-day>
                </tr>
            </tbody>
        </table>
    </div>

</template>

<script>
    export default {
        props: {
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
        methods: {
            monthStartDay: function (month, year) {
                // returns day of the week the first of month starts on
                return new Date(year, month, 1).getDay();
            },
            getMonthDay: function (day, week, month, year) {
                // returns "date" of month given a day (1-7) and a week (1-5) of
                // a given month (0-11) and year. "date" may be negative (previous
                // month) or greater than the actual number of days in the month
                // (next month), depending on the monthStartDay value
                return ((day) + ((week - 1) * 7)) - this.monthStartDay( month, year );
            },
            getDaysOfWeek: function () {
                var days = [
                    'Sun',
                    'Mon',
                    'Tue',
                    'Wed',
                    'Thu',
                    'Fri',
                    'Sat'
                ];
                if (this.start_on_monday)
                    days.push(days.shift());
                return days
            },
            dateClicked: function(e) {
                this.$emit('date-clicked', e);
            }
        },
        components: {
            'calendar-day':
                Vue.component(
                    'calendar-day',
                    require('./CalendarDay.vue')
                )
        }
    }
</script>
