<template>
    <div>

    </div>
</template>

<script>
    import Vue from 'vue';
    import VueAlertify from 'vue-alertify';
    Vue.use(VueAlertify);

    export default {
        props:[
            'alert_message',
            'alert_type',
        ],

        data() {
            return {

            };
        },

        mounted: function () {

            if (this.alert_message) {
                this.show(this.alert_message, this.alert_type);
            }

            this.$root.$on('flash', (data) => {
                this.show(data[0], data[1]);
            })
        },

        created() {

        },

        methods: {
            show: function(message, type) {
                if (type == 'success') {
                    this.$alertify.success(message);
                } else if (type == 'warning') {
                    this.$alertify.warning(message);
                } else if (type == 'error') {
                    this.$alertify.error(message);
                }
            }
        }
    }
</script>
