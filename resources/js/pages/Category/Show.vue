
<script setup>
import { useAuthStore } from '@/stores/useAuthStore.js';
import useAxios from '@/composables/useAxios';
import { useRoute } from 'vue-router';
import {ref, onMounted} from 'vue';

const {loading, error, sendRequest} = useAxios();
const route = useRoute();
const authStore = useAuthStore();
const category = ref(null);
const getCategory = async() => {
    const response = await sendRequest({
        method:'get',
        url:`/v1/category/${route?.params?.id}`,
        headers: {
            authorization: `Bearer ${authStore.user.token}`,
        }
    })

    category.value = response.data;
}

onMounted(() => {
    getCategory();
})
</script>  
<template>
    <AppLayout>
        <div class="p-4 bg-white">
            <div class="mb-5">
                <img :src="category?.banner" class="w-full h-80">
            </div>
            <div class="flex items-end gap-5 mb-5">
                <img :src="category?.icon" class="w-64 h-auto object-cover">
                <div>
                    <h3 class="text-lg font-medium">{{ category?.name }}</h3>
                    <p>{{ category?.short_description }}</p>
                </div>
            </div>
            <div v-html="category?.description">

            </div>
        </div>
    </AppLayout>
</template>