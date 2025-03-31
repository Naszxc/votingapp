<template>
    <div class="add-album-card" style="padding: 50px;">
        <div style="text-align: center; font-size: 30px; font-weight: bold; margin-bottom: 10px;">
            Add Album
        </div>

        <div style="margin-bottom: 60px;">
            <div style="margin-bottom: 10px;">
                <div style="font-weight: bold; font-family: Arial, sans-serif; margin-bottom: 5px;">Title</div>
                <input placeholder="title" style="height: 30px; width: 100%;" :value="values.title" @input="setFieldValue('title', ($event.target as HTMLInputElement).value)"/>
                <div style="color: red;">{{ errors.title }}</div>
            </div>
            
            <div style="margin-bottom: 10px;">
                <div style="font-weight: bold; font-family: Arial, sans-serif; margin-bottom: 5px;">Artist</div>
                <input placeholder="artist" style="height: 30px; width: 100%;" :value="values.artist" @input="setFieldValue('artist', ($event.target as HTMLInputElement).value)"/>
                <div style="color: red;">{{ errors.artist }}</div>
            </div>

            <div style="margin-bottom: 10px;">
                <div style="font-weight: bold; font-family: Arial, sans-serif; margin-bottom: 5px;">Date</div>
                <input type="date" style="width: 40%;" value="values.release_date" @input="setFieldValue('release_date', ($event.target as HTMLInputElement).value)"/>
                <div style="color: red;">{{ errors.release_date }}</div>
            </div>

            <div>
                <div style="font-weight: bold; font-family: Arial, sans-serif; margin-bottom: 5px;">Image</div>
                <input type="file" style="width: 40%;" @change="hadleFileChange" accept="image/png, image/jpeg"/>
                <div style="color: red;">{{ errors.image }}</div>
            </div>

            <img v-if="filePreview" :src="filePreview" alt="File Preview" width="200" />
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
    import { onMounted, ref, defineEmits } from 'vue';
    import axios from "axios";
    import { useForm, useField, defineRule  } from 'vee-validate';
    import { useAlbum } from '../stores/album-info';
    import { useToast } from 'vue-toastification';
    import { useLoading } from 'vue-loading-overlay';
    import * as yup from 'yup';
    const emit = defineEmits(['close']);
    const album = useAlbum();
    const toast = useToast();
    const loading = useLoading({ loader: 'dots' });
    const filePreview = ref<string | null>(null);


    const validationSchema = yup.object({
        title: yup.string().required('Title is required'),
        artist: yup.string().required('Artist is required'),
        release_date: yup.string().required('Release Date is required'),
        image: yup.mixed().test("fileType", "Please upload images", (value) => {
            if (!value) return false;
            const allowedTypes = ["image/png", "image/jpeg"];
            return allowedTypes.includes((value as File).type);
        }).required('Image is required')
    });

    const { values, setFieldValue, handleSubmit, errors } = useForm({
        initialValues: {
            id: '',
            title: '',
            artist: '',
            release_date: '',
            image: null as File | null
        },
        validationSchema
    })

    Object.keys(values).forEach(field => useField(field, {}))

    onMounted(() => {
        fetchAlbum()
    });
    

    const submitData = handleSubmit((formValues) => {
        const loader = loading.show();

        const formData = new FormData();
        formData.append("title", formValues.title)
        formData.append("artist", formValues.artist)
        formData.append("release_date", formValues.release_date)

        if(formValues.image instanceof File){
            formData.append("image", formValues.image)
        }

        // "http://localhost/api/album"
        axios.post("/api/album", formData).then((res) => {
            loader.hide();
            toast.success('Album added successfully!');
            close()
        })
        .catch((res) => {
            console.log(res)
        })

    });


    const hadleFileChange = (event: Event) => {
        const target = event.target as HTMLInputElement;
        if(target.files && target.files[0]){
            setFieldValue("image", target.files[0] as File)
            filePreview.value = URL.createObjectURL(target.files[0]);
        }

    }

    const fetchAlbum = () => {
        // "http://localhost/api/album/list"
        axios.get("/api/album/list").then((res) => {
            album.setAlbum(res.data.data);
        })
        .catch((res) => {
            console.log("something went wrong")
        });
    }

    const close = () => {
        emit('close');
    };

</script>