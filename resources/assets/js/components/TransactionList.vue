<template>

    <ul class="c-transaction-list">
        <li
            v-for="transaction in transactions"
            class="c-transaction"
            v-bind:class="{
                'c-transaction--expense': (transaction.amount < 0),
                'c-transaction--income': (transaction.amount >= 0)
            }"
            >
            <div class="c-transaction__name">
                {{ transaction.name }}
            </div>
            <div class="c-transaction__amount">
                {{ transaction.amount }}
            </div>
        </li>
    </ul>

</template>

<script>
    export default {
        props: [
            'transactions'
        ],
        methods: {
        },
        components: {
        }
    }
</script>
