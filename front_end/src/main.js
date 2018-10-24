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
router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    const uid = window.localStorage.getItem('uid')
    if (!uid) {
      next({name: 'signin'})
    } else {
      next()
    }
  } else {
    next()
  }
})