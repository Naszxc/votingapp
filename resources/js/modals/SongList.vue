<template>
    <div v-if="isOpen" class="song-list-modal">
        <div class="song-list-container">
            <div class="song-list-card">

                <div class="song-list-card-header">
                    <div @click="closeModal" style="cursor: pointer;">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                </div>

                <div class="song-list-image">
                    <!-- <img :src="`http://localhost${mainStore.getAlbumDetails.cover_image}`" width=200/> -->
                    <img :src="mainStore.getAlbumDetails.cover_image" width=200/>
                </div>

                <div class="song-list-btn">
                    <button @click="submitVote()">
                        <i :class="isVoted ? 'fa-solid fa-thumbs-down' : 'fa-solid fa-thumbs-up'"></i>
                        {{ isVoted ? 'Unvote' : 'Vote' }}
                    </button>
                </div>

                <div v-if="mainStore.getAlbumDetails.song.length > 0" v-for="items in mainStore.getAlbumDetails.song">
                    <div style="font-weight: bold; margin-bottom: 15px;">Song Lists</div>
                    <div>{{ items.title }}</div>
                </div>

                <div v-else>
                    <div style="font-weight: bold; margin-bottom: 15px;">Song Lists</div>
                    <div>No Song list available</div>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
    import { onMounted, ref, watch, toRaw, computed } from 'vue';
    import axios from "axios";
    import { useMain } from '../stores/main';
    const mainStore = useMain();

    const isOpen = ref(false);
    const albumId = ref<number | null>(null);
    const songDetails = ref<any>([]);

    const openModal = (id: number) => {
        albumId.value = id;
        isOpen.value = true;
    };

    const closeModal = () => {
        isOpen.value = false;
        albumId.value = null;
    };

    defineExpose({
        openModal,
        closeModal,
    });

    watch(isOpen, (newVal) => {
        if (newVal && albumId.value) {
            fetchAlbumData(albumId.value);
        }
    });

    const fetchAlbumData = (albumId) => {
        // `http://localhost/api/album/song/${albumId.id}`
        axios.get(`/api/album/song/${albumId.id}`).then((res) => {
            mainStore.setAlbumDetails(res.data.data.data[0])
            console.log(res.data.data.data[0])
        }).catch((res) => {
            console.log("something went wrong")
        })
    }

    const submitVote = () => {
        let albumDetails = mainStore.getAlbumDetails;

        if (albumDetails.user_votes.length > 0) {
            let userVoteId = albumDetails.user_votes[0].id
            removeVote(userVoteId)
            console.log('already casts vote')
        }else{
            createVote(albumDetails.id)
        }
    }

    const isVoted = computed(() => {
        let album = mainStore.getAlbumDetails;
        return album.user_votes != undefined ? album.user_votes.length > 0 : false
    })

    const createVote = (id) => {
        // 'http://localhost/api/vote'
        axios.post('/api/vote', { id: id }).then((res) => {
            mainStore.setAppendUserVote(res.data.data)
            mainStore.appendVoteOnAlbumList(mainStore.getAlbumDetails.id)
        })
        .catch((res) => {
            console.log('something went wrong')
        })
    }

    const removeVote = (id) => {
        // `http://localhost/api/vote/destroy/${id}`
        axios.delete(`/api/vote/destroy/${id}`).then((res) => {
            mainStore.removeVote()
            mainStore.removeVoteOnAlbumList(mainStore.getAlbumDetails.id)
        })
        .catch((res) => {
            console.log('something went wrong')
        })
    }
</script>