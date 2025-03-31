<template>
    <div>

        <div class="input-text-register">
            <div>Name</div>
            <input placeholder="Name" :value="values.name" @input="setFieldValue('name', ($event.target as HTMLInputElement).value)"/>
            <div style="color: red;">{{ errors.name }}</div>
        </div>

        <div class="input-text-register">
            <div>Email</div>
            <input type="email" placeholder="email" :value="values.email" @input="setFieldValue('email', ($event.target as HTMLInputElement).value)"/>
            <div style="color: red;">{{ errors.email }}</div>
        </div>

        <div class="input-text-register">
            <div>Password</div>
            <input type="password" placeholder="password" :value="values.password" @input="setFieldValue('password', ($event.target as HTMLInputElement).value)"/>
            <div style="color: red;">{{ errors.password }}</div>
        </div>

        <div class="select-role-register">
            <div>Select Role</div>
            <select @change="selectRole">
                <option value="admin">Admin</option>
                <option selected value="">None</option>
            </select>
        </div>

        <div class="btn-register">
            <button type="submit" @click="submitData">submit</button>
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
    import * as yup from 'yup';
    import { useRouter } from "vue-router";
    const router = useRouter();
    
    const validationSchema = yup.object({
        name: yup.string().matches(/^[A-Za-z\s]+$/, 'Name cannot contain numbers').required('Title is required'),
        email: yup.string().email('Invalid email format').required('Artist is required'),
        password: yup.string().min(8, 'Password must be at least 8 characters').required('Password is required'),
        role: yup.string().nullable()
    });


    const { values, setFieldValue, handleSubmit, errors, resetForm } = useForm({
        initialValues: {
            id: '',
            name: '',
            email: '',
            password: '',
            role: null
        },
        validationSchema
    })

    Object.keys(values).forEach(field => useField(field, {}))

    const submitData = handleSubmit(() => {
        const loader = loading.show();

        // http://localhost/api/saveData
        axios.post("/api/saveData", values).then((res) => {
            console.log("user saved")
            resetForm();
            loader.hide();
            toast.success('Registered successfully!');
            redirectToLogin()
        })
        .catch((res) => {
            loader.hide();

            if (res.request) {
                toast.error("Email already exist!");
            }
        })

    });

    const selectRole = (event: Event) => {
        setFieldValue("role", (event.target as HTMLSelectElement).value)
    }

    const redirectToLogin = () => {
        router.push("/login");
    };

</script>