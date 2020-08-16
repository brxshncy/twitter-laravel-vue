/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';

Vue.component('main-component',require('./components/MainComponent.vue').default);
Vue.use(VueRouter);

let routes = 
[
    {path:'/tweet-content/:tweet_id',component:require('./components/TweetSection.vue').default},
    {path:'/home',component:require('./components/TweetComponent.vue').default},
    {path:'/profile/:user_id',component:require('./components/ProfileComponent.vue').default},
];

const router = new VueRouter({
    routes,
    mode:'history',
});


const app = new Vue({
    el: '#app',
    router
});
