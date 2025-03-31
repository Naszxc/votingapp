import { createRouter, createWebHistory } from 'vue-router';
import Overview from '@/Pages/Overview.vue';

const routes = [
    { path: '/admin', component: Overview},
]

const routerAdmin = createRouter({
    history: createWebHistory(),
    routes,
});

export default routerAdmin;