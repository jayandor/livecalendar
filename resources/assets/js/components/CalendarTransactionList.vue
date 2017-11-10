<template>

    <div>
        <transaction-list
            class="c-transaction-list--small"
            :transactions="transactions"
            ></transaction-list>
    </div>

</template>

<script>
    export default {
        props: [
            'date',
            'month',
            'year'
        ],
        data: function () {
            return {
                transactions: []
            }
        },
        mounted: function () {
            transactionEventBus.$on('updatedTransactions', (transactions) => {

                this.transactions = this.getTransactionsByDate(
                    transactions,
                    this.date,
                    this.month,
                    this.year
                );

            });
        },
        methods: {
            getTransactionsByDate: function (transactions, date, month, year) {

                return transactions.filter( function (trans) {

                    return (new Date(trans.date + ' 0:0:0').sameDateAs(date, month, year));

                });

            }
        },
        components: {
        }
    }
</script>
