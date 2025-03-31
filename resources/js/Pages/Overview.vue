<template>

    <Header></Header>

    <div class="overview-header">Album list</div>

    <div class="overview-album-btn">

        <div class="overview-btn" @click="openModal">
            <i class="fa-solid fa-compact-disc"></i>
            Add Album
        </div>

        <div class="overview-btn" @click="openAlbumSongModal">
            <i class="fa-solid fa-music"></i>
            Add Song
        </div>

    </div>

    <div class="overview-album-list-container">
        <div v-for="items in album.getAlbum" class="overview-album-list">
            <div class="overview-album-list-content">
                <div class="overview-album-list-content-image">
                    <!-- <img :src="`http://localhost${items.cover_image}`" width=200/> -->
                    <img :src="items.cover_image" width=200/>
                </div>

                <div class="overview-album-list-content-datails">
                    <div>
                        <i class="fa-solid fa-compact-disc"></i>
                        Title:
                        {{ items.title }}
                    </div>

                    <div>
                        <i class="fa-solid fa-microphone"></i>
                        Artist:
                        {{ items.artist }}
                    </div>
                </div>

                <div class="overview-album-list-btn">
                    <div @click="deleteAlbum(items.id)"> <i class="fa-solid fa-trash" style="color: red;"></i> Delete</div>
                </div>
            </div>

        </div>
    </div>

    <div class="overview-paginate">
        <div class="overview-paginate-left" @click="fetchAlbum(pagination.prev_page_url)" :disabled="!pagination.prev_page_url">
            <
        </div>

        <span>Page {{ pagination.current_page }} of {{ pagination.last_page }}</span>
            
        <div class="overview-paginate-right" @click="fetchAlbum(pagination.next_page_url)" :disabled="!pagination.next_page_url">
            >
        </div>
    </div>

    <AddAlbumModal ref="modalRef"/>
    <AddAlbumSongModal ref="albumSongModalRef"/>

</template>

<script setup lang="ts">
    import { onMounted, ref, reactive } from 'vue';
    import axios from "axios";
    import { useAlbum } from '../stores/album-info';
    import AddAlbumModal from '@/layout/AddAlbumModal.vue';
    import AddAlbumSongModal from '@/layout/AddAlbumSongModal.vue';
    import { useToast } from 'vue-toastification';
    import { useLoading } from 'vue-loading-overlay';
    import Header from '../components/Header.vue';
    const album = useAlbum();
    const modalRef = ref();
    const albumSongModalRef = ref();
    const toast = useToast();
    const loading = useLoading({ loader: 'dots' });

    interface Pagination {
        current_page: number;
        last_page: number;
        next_page_url: string | null;
        prev_page_url: string | null;
    }

    const pagination = reactive<Pagination>({
        current_page: 1,
        last_page: 1,
        next_page_url: null,
        prev_page_url: null
    });

    onMounted(() => {
        fetchAlbum()
    });

    const fetchAlbum = (url = "/api/album/list") => {
        axios.get(url).then((res) => {
            album.setAlbum(res.data.data.data);
            console.log(res.data.data.data)
            Object.assign(pagination, res.data.data);
        })
        .catch((res) => {
            toast.error('Something went wrong! While collecting data');
        });
    }

    const deleteAlbum = (id) => {
        const loader = loading.show();

        // `http://localhost/api/album/destroy/${id}`
        axios.delete(`/api/album/destroy/${id}`).then((res) => {
            album.removeAlbum(id);
            loader.hide();
            toast.success('Album Deleted');
        })
        .catch((res) => {
            loader.hide();
            toast.error('Something went wrong! Please try again');
        });
    }

    const openModal = () => {
        modalRef.value.openModal()
    }

    const openAlbumSongModal = () => {
        albumSongModalRef.value.openModal();
    }

</script>