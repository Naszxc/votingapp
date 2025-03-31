import { createRouter, createWebHistory } from 'vue-router';
import Login from '@/Pages/login.vue';
import Register from '@/Pages/register.vue';

const routes = [
    { path: '/login', component: Login},
    { path: '/register', component: Register},

    { path: '/:pathMatch(.*)*', component: Login },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;