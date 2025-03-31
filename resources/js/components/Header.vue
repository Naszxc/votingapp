<template>
    <div class="header">
        <a href="#" @click="logout()">Log out</a>
    </div>
</template>

<script setup lang="ts">
    import axios from 'axios';

    const logout = () => {
        axios.post('/api/logout', {}).then((res) => {
            window.location.href = '/'
        })
        .catch((res) => {
            console.log("Something went wrong")
        });
    }

</script>