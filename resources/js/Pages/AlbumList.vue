<template>
    <div>

        <div class="main-album-search">
            <div>
                <input id="search-input" v-model="searchQuery" type="input" placeholder="Search"/>
                <button type="submit" :disabled="isSearchDisabled" @click="search">Search</button>
                <button type="submit" :disabled="isSearchDisabled" @click="clearSearch">Clear</button>
            </div>
        </div>

        <div class="main-album-list-container">
            <div v-for="items in albumList" class="main-album-list" @click="showModal(items)" >

                <div class="main-album-list-content">
                    <div class="main-album-list-content-image">
                        <!-- <img :src="`http://localhost${items.cover_image}`" width=200/> -->
                        <img :src="items.cover_image" width=200/>
                    </div>

                    <div class="main-album-list-content-details">
                        <div>
                            <i class="fa-solid fa-compact-disc"></i>
                            Artist:
                            {{ items.artist }}
                        </div>

                        <div>
                            <i class="fa-solid fa-compact-disc"></i>
                            Title:
                            {{ items.title }}
                        </div>

                        <div>
                            <i class="fa-solid fa-thumbs-up"></i>
                            Votes:
                            {{ items.votes_count }}
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="album-paginate">
            <button @click="fetchData(pagination.prev_page_url)" :disabled="!pagination.prev_page_url">
                <
            </button>

            <span>Page {{ pagination.current_page }} of {{ pagination.last_page }}</span>
            
            <button @click="fetchData(pagination.next_page_url)" :disabled="!pagination.next_page_url">
                >
            </button>
        </div>

    </div>

    <SongList ref="modalRef"/>
</template>

<script setup lang="ts">
    import { onMounted, ref, computed, reactive } from 'vue';
    import axios from "axios";
    import SongList from '@/modals/SongList.vue';
    import { useMain } from '../stores/main';
    const modalRef = ref<InstanceType<typeof SongList> | null>(null);
    const mainStore = useMain();
    const searchQuery = ref('');
    const albums = ref([]);

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

    const isSearchDisabled = computed(() => searchQuery.value.trim() === '');

    const albumList = computed(() => 
        mainStore.getSearchResult.length > 0 ? mainStore.getSearchResult : mainStore.getAlbumList
    );

    const showModal = (id: number) => {
        modalRef.value?.openModal(id);
    };

    onMounted(() => {
        fetchData();
    });

    // http://localhost/api/getSaved'
    const fetchData = (url = '/api/getSaved') => {
        axios.get(url).then((res) => {
            mainStore.setAlbumList(res.data.data.data);
            Object.assign(pagination, res.data.data);
        })
        .catch((res) => {
            console.log(res, "something went wrong")
        });
    }

    const search = () => {
        let searchValue = searchQuery.value;

        searchInput(searchValue)
    }

    const searchInput = (search) => {
        // http://localhost/api/search/album
        axios.get("/api/search/album" , { params: { search } })
        .then((res) => {
            console.log(res.data.data)
            mainStore.setSearchResult(res.data.data);
        }).catch((res) => {

        });
    }

    const clearSearch = () => {
        searchQuery.value = ''
        mainStore.setSearchResult([]);
    }

</script>