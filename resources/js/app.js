import Vue from "vue";
import App from "./App";

require('./bootstrap');

new Vue({
    render: h => h(App)
}).$mount('#app');
