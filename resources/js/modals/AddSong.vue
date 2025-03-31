<template>

    <div style="padding: 50px;">

        <div style="text-align: center; font-size: 30px; font-weight: bold; margin-bottom: 15px;">
            Add Song
        </div>

        <div style="margin-bottom: 60px;">
            
            <div style="margin-bottom: 10px;">
                <div style="font-weight: bold; font-family: Arial, sans-serif; margin-bottom: 5px;">Title</div>
                <input placeholder="title" style="height: 30px; width: 100%;" :value="values.title" @input="setFieldValue('title', ($event.target as HTMLInputElement).value)"/>
            </div>

            <div style="margin-bottom: 10px;">
                <div style="font-weight: bold; font-family: Arial, sans-serif; margin-bottom: 5px;">Release Date</div>
                <input style="height: 30px; width: 100%;" :value="values.title" type="date" @input="setFieldValue('release_date', ($event.target as HTMLInputElement).value)"/>
            </div>

            <div style="margin-bottom: 10px;">
                <div style="font-weight: bold; font-family: Arial, sans-serif; margin-bottom: 5px;">Select Album</div>
                <select style="height: 30px; width: 40%;" @change="selectAlbum">
                    <option v-for="items in album.getAlbum" :value="items.id">{{ items.title }}</option>
                </select>
            </div>

        </div>

        <div style="height: 40px; display: flex; justify-content: center;">
            <div style="display: inline-block; margin-right: 10px; width: 30%;">
                <button type="submit" style="height: 40px; width: 100%;" @click="submitData">Submit</button>
            </div>
            <div style="display: inline-block; width: 30%;">
                <button type="submit" style="height: 40px; width: 100%;" @click="close">Cancel</button>
            </div>
        </div>

    </div>

</template>

<script setup lang="ts">

    import { useForm, useField } from 'vee-validate';
    import { onMounted, ref, defineEmits } from 'vue';
    import axios from "axios";
    import { useAlbum } from '../stores/album-info';
    import { useToast } from 'vue-toastification';
    import { useLoading } from 'vue-loading-overlay';
    const album = useAlbum();
    const emit = defineEmits(['close']);
    const toast = useToast();
    const loading = useLoading({ loader: 'dots' });

    const { values, setFieldValue } = useForm({
        initialValues: {
            album_id: '',
            title: '',
            release_date: '',
        }
    })

    const submitData = () => {
        const loader = loading.show();

        // "http://localhost/api/create/song"
        axios.post("/api/create/song", values).then((res) => {
            loader.hide();
            toast.success('Song added successfully!');
            close()
        })
        .catch((res) => {
            console.log('something went wrong')
        })
    }

    const selectAlbum = (event: Event) => {
        setFieldValue("album_id", (event.target as HTMLSelectElement).value)
    }

    const close = () => {
        emit('close');
    };

</script>