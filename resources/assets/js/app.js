
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'
import Vuetify from 'vuetify'
import VueSimplemde from 'vue-simplemde'
import md from 'marked'; // Kèm theo khi install 'vue-simplemde'
import 'simplemde/dist/simplemde.min.css'

Vue.use(Vuetify);
Vue.use(VueSimplemde);

import User from './helpers/User';
window.User = User;
window.EventBus = new Vue(); // Tạo 1 vue instance chỉ để phục vụ cho việc EventBus
window.md = md;
console.log(User.id());

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('app-home', require('./components/AppHome.vue'));
import router from './router/router';
const app = new Vue({
    el: '#app',
    router
});
