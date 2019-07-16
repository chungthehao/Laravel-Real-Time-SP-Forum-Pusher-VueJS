import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import Parallax from '../components/Parallax';
import Login from '../components/login/Login';
import Logout from '../components/login/Logout';
import SignUp from '../components/login/SignUp';
import Forum from '../components/forum/Forum';
import Read from '../components/forum/Read';
import Create from '../components/forum/Create';
import CreateCategory from '../components/category/CreateCategory';
const routes = [
    { path: '/', component: Parallax},
    { path: '/login', component: Login },
    { path: '/logout', component: Logout },
    { path: '/signup', component: SignUp },
    { path: '/categories', component: CreateCategory },
    { path: '/forum', component: Forum, name: 'forum' },
    { path: '/ask', component: Create },
    { path: '/questions/:slug', component: Read, name: 'read' },
];

const router = new VueRouter({
    routes, // short for `routes: routes`
    hashbang: false,
    mode: 'history'
});

export default router;