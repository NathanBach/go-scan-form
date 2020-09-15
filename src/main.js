import Vue from 'vue'
import App from './App.vue'
import store from './store'
import i18n from './plugins/i18n'
import './static/css/style.scss'
import VueResource from 'vue-resource'

import fieldAwesome from './components/fieldAwesome.vue'
Vue.component('fieldAwesome', fieldAwesome)

Vue.use(VueResource)
Vue.config.productionTip = false

new Vue({
  i18n,
  store,
  render: h => h(App)
}).$mount('#app')
