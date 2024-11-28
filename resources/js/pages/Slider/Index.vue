<script setup>
import { onMounted, ref } from 'vue';
import useAxios from "@/composables/useAxios"
import { useAuthStore } from '@/stores/useAuthStore.js';
import {useToast} from "vue-toastification";
import DeleteButton from "@/components/DeleteButton.vue";
import LoadingButton from "@/components/LoadingButton.vue";
const toast = useToast();;
const authStore = useAuthStore();
const { loading, error, sendRequest } = useAxios();

const sliders= ref(null);

const getSliders = async() => {
    const response = await sendRequest({
        method: 'get',
        url: '/v1/slider',
    });

    sliders.value = response.data
}




const onDelete = async(id) => {
    const response = await sendRequest({
        method:'delete',
        url:`/v1/slider/${id}`,
        headers: {
            authorization: `Bearer ${authStore.user.token}`
        }
    })


    if(response)
    {
        toast.success('Slider Deleted Successfully', {autoClose:1000});
        getSliders();
    }
}
onMounted(() => {
    getSliders();
})
</script>
<template>
    <AppLayout>
        <section class="px-4">
            <div class="bg-white p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <Icon name="solar:slider-minimalistic-horizontal-bold" class="text-3xl text-primary" />
                        <h3 class="text-primary text-3xl font-semibold">Slider</h3>
                    </div>
                    <div>
                        <RouterLink to="/create-slider" class="flex items-center gap-2 bg-primary px-4 py-2 text-white">
                            <Icon name="material-symbols:add-box-outline" />
                            Add Record
                        </RouterLink>
                    </div>
                </div>
            </div>
        </section>
        <div class="mx-5 bg-white">
            <div class="relative overflow-x-auto">
              <LoadingButton class="w-full" v-if="loading" :isLoading="loading">Loading</LoadingButton>

              <table v-else class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-white  uppercase bg-primary dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Banner
                        </th>
                        <th scope="col" class="px-6 py-3">
                           URL
                        </th>
                        <th scope="col" class="px-6 py-3">
                           Order Number
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                    </thead>
                    
                    <tbody>
                    <tr v-for="slider in sliders" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">
                            <img :src="slider?.image_url" class="w-16 md:w-32 max-w-full max-h-full" alt="">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                              <p class="capitalize">{{ slider?.title }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            {{ slider?.order_number }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <RouterLink :to="`/edit-slider/${slider?.id}`" class="w-8 h-8 rounded-md flex items-center justify-center bg-green-400/10 border border-green-900">
                                    <Icon name="material-symbols:edit-square-outline" class="text-lg text-green-900" />
                                </RouterLink>
                              <DeleteButton :path="`/v1/slider/${slider?.id}`" @deleted="getSliders"/>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
