<template>
    <div>

        <input placeholder="title" :value="values.title" @input="setFieldValue('title', ($event.target as HTMLInputElement).value)"/>
        <input placeholder="artist" :value="values.artist" @input="setFieldValue('artist', ($event.target as HTMLInputElement).value)"/>
        <input type="date" value="values.release_date" @input="setFieldValue('release_date', ($event.target as HTMLInputElement).value)"/>
        <input type="file" @change="hadleFileChange"/>
        <button type="submit" @click="submitData">submit</button>

        <AddSong/>

    </div>
</template>

<script setup lang="ts">
    import { onMounted, ref } from 'vue';
    import { useRouter } from 'vue-router';
    import axios from "axios";
    import { useForm, useField } from 'vee-validate';
    import Login from '@/modals/login.vue';
    import { useAlbum } from '../stores/album-info';
    import AddSong from '@/Pages/AddSong.vue';
    const songs = ref<any>();
    const album = useAlbum();

    
    const { values, setFieldValue } = useForm({
        initialValues: {
            id: '',
            title: '',
            artist: '',
            release_date: '',
            image: null as File | null
        }
    })

    const submitData = () => {
        const formData = new FormData();
        formData.append("title", values.title)
        formData.append("artist", values.artist)
        formData.append("release_date", values.release_date)

        if(values.image instanceof File){
            formData.append("image", values.image)
            console.log("image apppeofaposef")
        }

        formData.forEach((value, key) => {
            console.log(value)
        })

        // http://localhost/api/album
        axios.post("/api/album", formData).then((res) => {

        })
        .catch((res) => {
            console.log('something went wrong')
        })

    }


    const hadleFileChange = (event: Event) => {
        const target = event.target as HTMLInputElement;
        if(target.files && target.files[0]){
            setFieldValue("image", target.files[0] as File)
        }
    }


    onMounted(() => {
        fetchAlbum()
    });

    const fetchAlbum = () => {
        // http://localhost/api/album/list
        axios.get("/api/album/list").then((res) => {

            album.setAlbum(res.data.data);
        })
        .catch((res) => {
            console.log("something went wrong")
        });
    }


</script>