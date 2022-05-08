import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';

//bootstrap vue
import { BootstrapVue } from 'bootstrap-vue';
import 'bootstrap-vue/dist/bootstrap-vue.css';
Vue.use(BootstrapVue);

//perfect scrollbar
import PerfectScrollbar from 'vue2-perfect-scrollbar';
Vue.use(PerfectScrollbar);

//vue-scrollactive
import VueScrollactive from 'vue-scrollactive';
Vue.use(VueScrollactive);

//vue-meta
import VueMeta from 'vue-meta';
Vue.use(VueMeta, {
    refreshOnceOnNavigation: true
});

//Sweetalert
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
const options = {
    confirmButtonColor: '#4361ee',
    cancelButtonColor: '#e7515a'
};
Vue.use(VueSweetalert2, options);

//portal vue
import PortalVue from 'portal-vue';
Vue.use(PortalVue);

//vue-i18n
import i18n from './i18n';

Vue.config.productionTip = false;

// set default settings
import appSetting from './app-setting';
Vue.prototype.$appSetting = appSetting;
appSetting.init();


/*Added Configurations for Laravel*/ 

import Toaster from 'v-toaster'
 
// You need a specific loader for CSS files like https://github.com/webpack/css-loader
import 'v-toaster/dist/v-toaster.css'
 
// optional set default imeout, the default is 10000 (10 seconds).
Vue.use(Toaster, {timeout: 5000})

// Progress Bar
import VueProgressBar from 'vue-progressbar'

const optionss = {
  color: 'rgb(143, 255, 199)',
  failedColor: '#F76B61',
  thickness: '5px',
  location: 'top',
}

Vue.use(VueProgressBar, optionss)


import axios from 'axios'

Vue.prototype.$http=axios
axios.defaults.baseURL = 'http://127.0.0.1:8000' //change this base URL when deployed to server


import VueMask from 'v-mask';
Vue.use(VueMask);

// meta field
function loggedIn(){
    return localStorage.getItem('token')
}
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
      // this route requires auth, check if logged in
      // if not, redirect to login page.
      if (!loggedIn()) {
        next({
          path: '/login',
          query: { redirect: to.fullPath }
        })
      } else {
        
        let user = localStorage.getItem('role')
        if (to.matched.some(record => record.meta.is_admin)) {
          if (user == 'admin') {
            next()
          } else {
            next({
              name: 'error404'
            })
          }
        } else if (to.matched.some(record => record.meta.is_instructor)) {
          if (user == 'instructor') {
            next()
          } else {
            next({
              name: 'error404'
            })
          }
        }
        
        else {
          next()
        }
      }
    } else if(to.matched.some(record => record.meta.guest)) {
        if (loggedIn()) {
            next({
              path: '/',
              query: { redirect: to.fullPath }
            })
          } else {
            next()
          }
    }else{
        next() // make sure to always call next()!
    }
})


// Validation Error
export default class Errors{
    constructor(){
        this.errors = {}
    }
    get(field){
        if(this.errors[field]){
            return this.errors[field][0];
        }
    }
    record(errors){
        this.errors = errors;
    }
    clear(field){
        delete this.errors[field];
    }
}

/*End*/ 



new Vue({
    router,
    store,
    i18n,
    render: h => h(App)
}).$mount('#app');
