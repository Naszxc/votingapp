import { createApp } from 'vue';
import { createPinia } from 'pinia';
import MainPage from '@/Pages/Main.vue';
import router from './router/index';

const pinia = createPinia();
const app = createApp(MainPage);
app.use(pinia)
app.use(router);
app.mount('#app-main');