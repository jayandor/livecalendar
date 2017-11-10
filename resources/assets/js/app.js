/*------------------------------------*\
  #BOOTSTRAP
\*------------------------------------*/

require('./bootstrap');

window.Vue = require('vue');





/*------------------------------------*\
  #HELPER_FUNCTIONS
\*------------------------------------*/

Date.prototype.sameDateAs = function ( date, month, year ) {

    if (date instanceof Date) {
        year  = date.getFullYear();
        month = date.getMonth();
        date  = date.getDate();
    }

    return (
        this.getDate() == date
        && this.getMonth() == month
        && this.getFullYear() == year
    );
}

Date.monthNames = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];

Date.prototype.getMonthName = function () {
    return this.monthNames[this.getMonth()];
}





/*------------------------------------*\
  #FILTERS
\*------------------------------------*/

Vue.filter('currency', function (value) {
    return '$' + parseFloat(value).toFixed(2);
});

Vue.filter('date', function (value) {
    var monthNames = ["January", "February", "March", "April", "May", "June",
                      "July", "August", "September", "October", "November", "December"
                    ];
    return monthNames[value.getMonth()] + " " + value.getDate() + ", " + value.getFullYear();
});





/*------------------------------------*\
  #COMPONENTS
\*------------------------------------*/

// Transaction Components

Vue.component('transaction-list', require('./components/TransactionList.vue'));

// Global Bus to allow components to plug into Transaction events
transactionEventBus = new Vue();


// Calendar Components
Vue.component('calendar', require('./components/Calendar.vue'));
Vue.component('calendar-transaction-list', require('./components/CalendarTransactionList.vue'));





/*------------------------------------*\
  #MAIN_APP_VIEW
\*------------------------------------*/

// Initialize vue_data, then override any explicitly given data
vue_data_default = {

    user_id: 0,

    transactions: [],

    selected_date: new Date(),
    selected_date_balance: 0,

    viewing_month: new Date().getMonth(),
    viewing_year: new Date().getFullYear(),

    is_loaded: false,
};

vue_data = $.extend(vue_data_default, client_vue_data);


my_vue = new Vue({
    el: '#app',

    data: vue_data,

    mounted: function() {

        // Uncomment to show app immediately, otherwise will not show until
        // transactions have loaded
        //this.is_loaded = true;

        this.fetchTransactions();

        this.highlightDateElement(
            this.getCalendarDayElement( this.selected_date )
        );

    },

    watch: {
        viewing_month: function () {
            var self = this;
            this.$nextTick( function () {

                self.highlightDateElement(
                    self.getCalendarDayElement( self.selected_date )
                );

            });
        },
        viewing_year: function () {
            var self = this;
            this.$nextTick( function () {

                self.highlightDateElement(
                    self.getCalendarDayElement( self.selected_date )
                );

            });
        },
    },

    methods: {
        fetchTransactions: function() {


            var user_id = this.user_id;
            var url = '/api/users/' + user_id + '/transactions';

            var self = this;
            axios.get(url)
                .then( function(transactions) {

                    if (!self.is_loaded)
                        self.is_loaded = true;

                    self.transactions = transactions.data;
                    transactionEventBus.$emit(
                        'updatedTransactions',
                        self.transactions
                    );

                })
                .catch(function (error) {
                    console.log(error);
                });

        },
        getCalendarDayElement: function (date) {

            var y = this.selected_date.getFullYear();
            var m = this.selected_date.getMonth();
            var d = this.selected_date.getDate();

            var s = "[data-year='"  + y + "']";
            s    += "[data-month='" + m + "']";
            s    += "[data-day='"   + d + "']";

            var el = $(".js-calendar-day" + s).get(0);

            return el;

        },
        getDateFromCalendarElement: function (el) {

            var el_year  = +$(el).attr('data-year');
            var el_month = +$(el).attr('data-month');
            var el_day   = +$(el).attr('data-day');

            var date = new Date(el_year, el_month, el_day);

            return date;

        },
        dateClicked: function (e) {

            var target = e.currentTarget;

            var target_date = this.getDateFromCalendarElement( target );

            this.highlightDateElement(target);

            this.selected_date = target_date;

        },
        highlightDateElement: function(el) {

            if ( ! $(el).hasClass('js-selected-day') ) {

                $(".js-calendar-day.js-selected-day").removeClass('is-selected js-selected-day');
                $(el).addClass('is-selected js-selected-day');
                
            }

        },
        updatedCalendarViewingDate: function(month, year) {
            this.setViewingDate(month, year);
        },
        setViewingDate: function(month, year) {

            this.viewing_month = month;
            this.viewing_year = year;

            var self = this;
            this.$nextTick( function () {

                transactionEventBus.$emit(
                    'updatedTransactions',
                    self.transactions
                );

            });

        },
        previousMonth: function() {

            var newDate = new Date(this.viewing_year, this.viewing_month, 1);
            newDate.setMonth( newDate.getMonth() - 1 );

            this.setViewingDate( newDate.getMonth(), newDate.getFullYear() );

        },
        nextMonth: function() {

            var newDate = new Date(this.viewing_year, this.viewing_month, 1);
            newDate.setMonth( newDate.getMonth() + 1 );

            this.setViewingDate( newDate.getMonth(), newDate.getFullYear() );

        },
        viewToday: function() {

            var newDate = new Date();
            this.setViewingDate( newDate.getMonth(), newDate.getFullYear() );

        },
    }
});

// $(document).ready(function() {

//     $(".js-calendar-day").click(function() {

//         if ( ! $(this).hasClass('js-selected-day') ) {

//             $(".js-calendar-day.js-selected-day").removeClass('is-selected js-selected-day');
//             $(this).addClass('is-selected js-selected-day');
            
//         }

//     })

// });