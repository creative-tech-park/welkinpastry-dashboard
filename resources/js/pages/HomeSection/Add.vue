<script setup>
import {onMounted, ref} from 'vue';
import { useAuthStore } from '@/stores/useAuthStore.js';
import useAxios from '@/composables/useAxios';
import {useToast} from "vue-toastification";
const toast = useToast();;
import { useRouter } from 'vue-router';

const router = useRouter();
const authStore = useAuthStore(); 
const {loadin, error, sendRequest} = useAxios();


const products = ref(null);
const getProducts = async() => {
    const response = await sendRequest({
        method: 'get',
        url:'/v1/get-all-product-list',
        headers: {
            authorization: `Bearer ${authStore.user.token}`,
        }
    });

    products.value = response.data;
}

const categories = ref(null);
const getCategory = async() => {
    const response = await sendRequest({
        method: 'get',
        url: '/v1/get-all-category-list',
        headers: {
            authorization: `Bearer ${authStore.user.token}`,
        }
    })

    categories.value = response.data
}


const bannerImg = ref(null);
const image = (image) => {
    const file = image.target.files[0];
    form.value.banner = file;
    bannerImg.value = URL.createObjectURL(file);
}

const form = ref({
    title:null,
    sub_title:null,
    banner:null,
    categories: [],
    products: [],
    order_number:null
})

const onSubmit = async() => {
    const response = await sendRequest({
        url:'/v1/home-section',
        method: 'post',
        data:form.value,
        headers: {
            authorization: `Bearer ${authStore.user.token}`,
            'Content-Type': 'multipart/form-data'
        }
    })

    if(response){
        toast.success('Home Section Created Successfully');
        router.push('/home-sections')
    }
}

onMounted(() => {
    getProducts();
    getCategory();
})
</script>

<template>
    <AppLayout>
        <div class="bg-white p-4 shadow flex flex-col gap-5 w-full max-w-3xl mx-auto">
            <h3>Create Home Section</h3>
            <div class="w-full">
                <label for="title" class="text-xs mb-1 block">Title</label>
                <input v-model="form.title" type="text" class="rounded-md border p-2 w-full">
            </div>
            <div class="w-full">
                <label for="sub_title" class="text-xs mb-1 block">Sub Title</label>
                <textarea v-model="form.sub_title" class="rounded-md border p-2 w-full text-xs"></textarea>
            </div>

            <div class="w-full">
                <label for="order_number" class="text-xs mb-1 block">Order Number</label>
                <input v-model="form.order_number" type="text" class="rounded-md border p-2 w-full">
            </div>
            <div class="w-full">
                    <label for="slider-image" class="text-xs block mb-2">Banner Image</label>
                    <label for="slider-image" class="border border-primary border-dashed p-4 rounded-2xl flex items-center justify-center w-full h-52 cursor-pointer">
                        <img v-if="bannerImg" :src="bannerImg" class="w-full h-full rounded-md">
                        <div v-if="!bannerImg" class="flex flex-col items-center justify-center gap-2">
                            <Icon name="tabler:cloud-upload" class="text-primary text-5xl opacity-85" />
                            <span class="text-primary text-sm font-semibold opacity-85">Upload Banner Image</span>
                        </div>
                        <input id="slider-image" @change="image" type="file" hidden>
                    </label>
                </div>
            <div class="w-full">
                <label for="title" class="text-xs mb-1 block">Categories</label>
                <Select
                    label="name"
                    v-if="categories"
                    :options="categories"
                    :reduce="item => item.id"
                    :searchable="true"
                    v-model="form.categories"
                    placeholder="Select Categories..."
                    multiple
                >
                <template v-slot:option="option">
                    <li class="flex items-start py-1">
                        <div class="flex items-center justify-between w-full">
                            <div class="me-1 flex items-center gap-2">
                                <img :src="option?.icon" class="w-12 h-12">
                                <h6 class="mb-25">{{ option?.name }}</h6>
                            </div>
                        </div>
                    </li>
                </template>
                </Select>
            </div>
            <div class="w-full">
                <label for="title" class="text-xs mb-1 block">Products</label>
                <Select
                    label="title"
                    v-if="products"
                    :options="products"
                    :reduce="item => item.id"
                    :searchable="true"
                    v-model="form.products"
                    placeholder="Select Products..."
                    multiple
                >
                <template v-slot:option="option">
                    <li class="flex items-start py-1">
                        <div class="flex items-center justify-between w-full">
                            <div class="me-1 flex items-center gap-2">
                                <img :src="option?.cover_image" class="w-16 h-16 object-cover">
                                <h6 class="mb-25">{{ option?.title }}</h6>
                            </div>
                        </div>
                    </li>
                </template>
                </Select>
            </div>
            <div class="w-full">
                <Button class="w-full rounded-md" @click="onSubmit">Save Section</Button>
            </div>
        </div>
    </AppLayout>
</template>