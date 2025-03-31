<template>

    <ModalLayout v-if="isOpen">
        <template #default>
            <AddAlbum @close="closeModal"/>
        </template>
    </ModalLayout>

</template>

<script setup lang="ts">
    import ModalLayout from '@/layout/ModalLayout.vue';
    import AddAlbum from '@/modals/AddAlbum.vue';
    import { ref } from 'vue';
    const isOpen = ref(false);

    const openModal = () => {
        isOpen.value = true;
    };

    const closeModal = () => {
        isOpen.value = false;
    };

    defineExpose({
        openModal,
        closeModal,
    });
</script>