import { createApp } from 'vue';
import { createPinia } from 'pinia';
import Admin from '@/Pages/admin.vue';
import routerAdmin from './router/admin';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';

const pinia = createPinia();
const app = createApp(Admin);
app.use(Loading);
app.use(Toast);
app.use(pinia)
app.use(routerAdmin);
app.mount('#app-admin');