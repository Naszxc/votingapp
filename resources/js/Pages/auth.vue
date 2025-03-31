<template>

    <div class="container-login">
        <div class="card-login">
            
            <!-- <div class="tab-login"> -->
                <router-link class="tab-login" to="/register">
                    Register
                </router-link>
            <!-- </div> -->

            <!-- <div class="tab-login"> -->
                <router-link class="tab-login" to="/login">Login</router-link>
            <!-- </div> -->

            <RouterView />

        </div>
    </div>

</template>


<script setup lang="ts">
    
</script>