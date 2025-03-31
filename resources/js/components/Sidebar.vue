<template>
    Album list
    <div v-for="items in album.getAlbum" style="margin-bottom: 3px; border: 1px solid white">
        {{ items.title }}
        {{ items.artist }}
        <img :src="items.cover_image" width=100/>
    </div>
</template>

<script setup lang="ts">
    import { useAlbum } from '../stores/album-info';
    const album = useAlbum();


</script>