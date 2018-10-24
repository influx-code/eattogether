import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
// Webpack CSS import
import 'onsenui/css/onsenui.css';
import 'onsenui/css/onsen-css-components.css';
import VueOnsen from 'vue-onsenui';
Vue.use(VueOnsen); 
Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
