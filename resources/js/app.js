import Vue from "vue";
import router from "./router";
import vuetify from "./plugins/vuetify";

import App from "./App";

require('./bootstrap');

new Vue({
    router,
    vuetify,
    render: h => h(App)
}).$mount('#app');
