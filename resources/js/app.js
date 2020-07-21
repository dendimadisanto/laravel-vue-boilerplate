require('./bootstrap');

window.Vue = require('vue');


import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import Axios from 'axios';
import config from './config';

import swal from 'sweetalert2';
window.Swal = swal;
window.App = config;


Vue.use(VueRouter,VueAxios,Axios);


import 'bootstrap/dist/css/bootstrap.min.css';
import App from './components/App.vue';
import routes from './routes';
import store from './store'
import { Icon } from 'leaflet';
import 'leaflet/dist/leaflet.css';
import 'ag-grid-community/dist/styles/ag-grid.css'
import 'ag-grid-community/dist/styles/ag-theme-alpine.css';
import 'vue-loading-overlay/dist/vue-loading.css';
import 'es6-promise/auto'

delete Icon.Default.prototype._getIconUrl;

Icon.Default.mergeOptions({
  iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
  iconUrl: require('leaflet/dist/images/marker-icon.png'),
  shadowUrl: require('leaflet/dist/images/marker-shadow.png')
});

let user = localStorage.getItem('user');



const router = new VueRouter({ mode: 'history', routes: routes });
router.beforeEach((to, from, next) => {
  // mengecek ada tidak meta auth di dalam meta
  if (to.matched.some(record => record.meta.auth)) {
      
  } else {
    next();
  }
});

new Vue({
  router,
  el:'#app',
  store: store,
  render: h => h(App)
})
