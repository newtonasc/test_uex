import Vue from 'vue';
import App from './App';
import router from './router';
import Bootstrap from 'bootstrap-vue';
import { BootstrapVueIcons } from 'bootstrap-vue';
import Snotify from 'vue-snotify';
import 'vue-snotify/styles/material.css';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import VueTheMask from 'vue-the-mask';
import VueGoogleMap from 'vuejs-google-maps';
import 'vuejs-google-maps/dist/vuejs-google-maps.css';
import dotenv from 'dotenv';
dotenv.config();
Vue.config.productionTip = false;
Vue.use(Bootstrap);
Vue.use(BootstrapVueIcons);
Vue.use(Snotify);
Vue.use(VueTheMask);
Vue.use(VueGoogleMap, {
    load: {
        apiKey: 'AIzaSyDkRfQvApdiHD2NGc49Agpa8WflYjwgMCQ',
        libraries: ['places', 'visualization ']
    }
});
const EventBus = new Vue();
Object.defineProperties(Vue.prototype, {
	$bus: {
		get: function() {
			return EventBus
		}
	}
});
new Vue({
  el: '#app',
  router,
  EventBus,
  components: { App },
  template: '<App/>'
})
