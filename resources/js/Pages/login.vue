<template>

    <div>
        
        <div class="input-text-login">
            <div>Email</div>
            <input placeholder="email" :value="values.email" @input="setFieldValue('email', ($event.target as HTMLInputElement).value)"/>
        </div>

        <div class="input-text-login">
            <div>Password</div>
            <input type="password" placeholder="password" :value="values.password" @input="setFieldValue('password', ($event.target as HTMLInputElement).value)"/>
        </div>

        <div class="btn-login">
            <button type="submit" @click="submit">Login</button>
        </div>

    </div>

</template>

<script setup lang="ts">
import axios from "axios";
import { useForm, useField } from 'vee-validate';
import { useToast } from 'vue-toastification';
import { useLoading } from 'vue-loading-overlay';
const toast = useToast();
const loading = useLoading({ loader: 'dots' });


const { values, handleSubmit, setFieldValue } = useForm({
    initialValues: {
        email: '',
        password: ''
    }
})

const submit = handleSubmit(() => {
    const loader = loading.show();

    // "http://localhost/api/login"
    axios.post("/api/login", values).then((res) => {
        loader.hide();
        toast.success('You are now Logged in!');
        location.href = res.data;
    })
    .catch((res) => {
        loader.hide();

        if (res.response) {
            toast.error(res.response.data.message);
        } else if (res.request) {
            toast.error("Something went wrong! Please try again later");
        }
    });

})

</script>
