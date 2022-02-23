require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('flash', require('./components/Flash.vue').default);

const app = new Vue({
    el: '#app',
});

