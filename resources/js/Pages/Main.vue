<template>

    <Header></Header>

    <div class="main-tab-container">

        <router-link class="main-tab" to="/album/list">
            Albums
        </router-link>

        <router-link class="main-tab" to="/voted/album">
            My Votes
        </router-link>

    </div>

    <router-view/>

</template>


<script setup lang="ts">
    import Header from '../components/Header.vue';
</script>