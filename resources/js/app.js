require('./bootstrap');

window.Vue = require('vue');

/*****************************************************************************************************/



/*****
/
/ import and use VueRouter
/
**/
import VueRouter from 'vue-router';
import {routes} from './routes';
Vue.use(VueRouter);

/*****************************************************************************************************/

const app = new Vue({

    el: '#app',

    router: new VueRouter(routes)

});
