
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/*

import wysiwyg from 'vue-wysiwyg';
import Vuelidate from 'vuelidate';

Vue.use(Vuelidate);
Vue.use(wysiwyg, {hideModules: { "code": true }});
Vue.component('new-page', require('./components/NewPageForm.vue'));

const app = new Vue({
    el: '#app',
    data: {
      guild_id: document.head.querySelector("[name='guild_id']").content
    },
    methods: {
        fetch(request) {
            return "/api/" + request + "?key=" + this.guild_id;
        }
    }
});

*/
