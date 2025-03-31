import { createRouter, createWebHistory } from 'vue-router';
import AlbumList from '@/Pages/AlbumList.vue';
import VotedAlbum from '@/Pages/VotedAlbum.vue';

const routes = [
    { path: '/album/list', component: AlbumList},
    { path: '/voted/album', component: VotedAlbum},

    { path: '/:pathMatch(.*)*', component: AlbumList },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;