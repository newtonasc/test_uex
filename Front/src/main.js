import Vue from 'vue';
import App from './App';
import router from './router';
import Bootstrap from 'bootstrap-vue';
import { BootstrapVueIcons } from 'bootstrap-vue';
import Snotify from 'vue-snotify';
import 'vue-snotify/styles/material.css';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

Vue.config.productionTip = false;
Vue.use(Bootstrap);
Vue.use(BootstrapVueIcons);
Vue.use(Snotify);

new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})
