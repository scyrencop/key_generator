/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

import FaqsIndex from './components/faqs/FaqsIndex.vue';
import FaqsCreate from './components/faqs/FaqsCreate.vue';
import FaqsEdit from './components/faqs/FaqsEdit.vue';

const routes = [
    {
        path: '/',
        components: {
            faqsIndex: FaqsIndex
        }
    },
    {path: '/admin/faqs/create', component: FaqsCreate, name: 'createfaq'},
    {path: '/admin/faqs/edit/:id', component: FaqsEdit, name: 'editfaq'},
]

const router = new VueRouter({ routes })

const app = new Vue({ router }).$mount('#app')