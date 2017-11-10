<template>
    <td
        class="c-calendar__day js-calendar-day"
        v-bind:class="
            getDayClass(
                date,
                month,
                year
            )"
        :data-day="getProperDay(date, month, year)"
        :data-month="getProperMonth(date, month, year)"
        :data-year="getProperYear(date, month, year)"
        @click="dateClicked"
        >
        <span class="c-calendar__day__label">
            {{
                getProperDay(date, month, year)
            }}
        </span>
        <div class="c-calendar__day__component">
            <component
                :is="day_component_type"
                :date="getProperDay(date, month, year)"
                :month="getProperMonth(date, month, year)"
                :year="getProperYear(date, month, year)"
                ></component>
        </div>
    </td>
</template>

<script>
    export default {
        props: [
            'date',
            'month',
            'year',
            'day_component_type'
        ],
        methods: {
            getProperYear: function (date, month, year) {

                var ret_year = year;

                if ( date < 1 && month == 0 ) {
                    ret_year = year - 1;
                } else if ( date > this.numDaysInMonth(month, year) && month == 11) {
                    ret_year = year + 1;
                }

                return ret_year;

            },
            getProperMonth: function (date, month, year) {
                var ret_month = month;

                if ( date < 1 ) {
                    ret_month = (((month - 1) % 12) + 12) % 12;
                } else if ( date > this.numDaysInMonth(month, year)) {
                    ret_month = (((month + 1) % 12) + 12) % 12;
                }

                return ret_month;

            },
            getProperDay: function (date, month, year) {

                var ret_day = date;

                if ( ret_day < 1 ) {

                    var month = this.getProperMonth(date, month, year);
                    var year  = this.getProperYear(date, month, year);
                    ret_day  = this.numDaysInMonth(month, year) + date;

                } else if ( ret_day > this.numDaysInMonth(month, year)) {

                    ret_day -= this.numDaysInMonth(month, year);

                }

                return ret_day;

            },
            getDayClass: function(date, month, year) {
                return {
                    'c-calendar__day--prev-month':
                        ( date <= 0 ),
                    'c-calendar__day--next-month':
                        ( date > this.numDaysInMonth(month, year) )
                }
            },
            numDaysInMonth: function (month, year) {
                return 32 - new Date(year, month, 32).getDate();
            },
            dateClicked: function(e) {
                this.$emit('date-clicked', e);
            }
        }
    }
</script>