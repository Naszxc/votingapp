import { createApp } from 'vue';
import Auth from '@/Pages/auth.vue';
import router from './router/auth';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';

const app = createApp(Auth);
app.use(Loading);
app.use(Toast);
app.use(router);
app.mount('#app-login');