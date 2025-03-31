<template>

    <div class="voted-album-list-container">
        <div class="voted-album-list" v-for="items in mainStore.getVotedAlbum" >

            <div class="voted-album-list-content">
                <div class="voted-album-list-content-image">
                    <img :src="items.album.cover_image" width=200/>
                </div>

                <div class="voted-album-list-content-details">
                    <div>
                        <i class="fa-solid fa-compact-disc"></i>
                            Title:
                            {{ items.album.title }}
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="album-paginate">
        <button @click="fetchData(pagination.prev_page_url)" :disabled="!pagination.prev_page_url">
            Previous
        </button>

        <span>Page {{ pagination.current_page }} of {{ pagination.last_page }}</span>
            
        <button @click="fetchData(pagination.next_page_url)" :disabled="!pagination.next_page_url">
            Next
        </button>
    </div>

</template>


<script setup lang="ts">
    import axios from "axios";
    import { onMounted, ref, toRaw, reactive } from 'vue';
    import { useMain } from '../stores/main';
    const songs = ref<any>();
    const mainStore = useMain();

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
        console.log("on hello world")
        fetchData();
    });

    const fetchData = (url = "/api/vote/list") => {
        axios.get(url).then((res) => {
            mainStore.setVotedAlbum(res.data.data.data)
            Object.assign(pagination, res.data.data);
        })
        .catch((res) => {
            console.log(res, "something went wrong")
        });
    }

</script>