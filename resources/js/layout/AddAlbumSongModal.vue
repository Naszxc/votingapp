<template>

    <ModalLayout v-if="isOpen">
        <template #default>
            <AddSong @close="closeModal"/>
        </template>
    </ModalLayout>

</template>

<script setup lang="ts">
    import ModalLayout from '@/layout/ModalLayout.vue';
    import AddSong from '@/modals/AddSong.vue';
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