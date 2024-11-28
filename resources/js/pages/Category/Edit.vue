
<script setup>
import  SummernoteEditor  from 'vue3-summernote-editor';
import {ref, onMounted} from 'vue';
import { useAuthStore } from '@/stores/useAuthStore.js';
import useAxios from '@/composables/useAxios';
import {useToast} from "vue-toastification";
const toast = useToast();
import { useRouter } from 'vue-router';
import { useRoute } from 'vue-router';
import Editor from '@/components/Editor.vue';


const {error, loading, sendRequest} = useAxios();
const route = useRoute();
const router = useRouter();
const authStore = useAuthStore();

const parentCategories = ref(null);
const getParentCategory = async() => {
    const response = await sendRequest({
        method:'get',
        url: '/v1/category?recursive',
        headers: {
            authorization: `Bearer ${authStore.user.token}`,
        }
    });
    parentCategories.value = response?.data;
}

const getCategory = async() => {
    const response = await sendRequest({
        method:'get',
        url:`/v1/category/${route?.params?.id}`,
        headers: {
            authorization: `Bearer ${authStore.user.token}`
        }
    })
    if(response){
        form.value.id = response.data.id;
        form.value.name = response.data.name;
        form.value.parent_id = response.data.parent_id;
        form.value.order_number = response.data.order_number;
        form.value.short_description = response.data.short_description;
        form.value.description = response.data.description;
        iconImg.value = response.data.icon;
        bannerImg.value = response.data.banner;
    }
}

const iconImg = ref(null);
const bannerImg = ref(null);

const form = ref({
    id:null,
    name: null,
    parent_id: 0,
    icon: null,
    banner: null,
    order_number: null,
    short_description: null,
    description: null,
})

const banner = (banner) => {
    const file = banner.target.files[0];
    form.value.banner = file;
    bannerImg.value = URL.createObjectURL(file);
}
const image = (image) => {
    const file = image.target.files[0];
    form.value.icon = file;
    iconImg.value = URL.createObjectURL(file);
}

const onUpdate = async(id) => {
    const response = await sendRequest({
        method:'post',
        url:`/v1/category/${id}`,
        data:form.value,
        params: {
            _method:'PUT'
        },
        headers: {
            authorization: `Bearer ${authStore.user.token}`,
            'Content-Type': 'multipart/form-data'
        }
    })

    if(response){
        toast.success('Category Upddated Succesfully');
        router.push('/category')
    }
}

onMounted(() => {
    getParentCategory();
    getCategory();
})
</script>
<template>
    <AppLayout>
        <div class="bg-white shadow-md p-6 max-w-5xl mx-auto">
            <h3 class="mb-10">Create a New Category</h3>
            <div>
                <div class="flex items-center flex-wrap">
                    <div class="w-1/2 pr-2">
                        <div class="w-full">
                            <label for="name" class="text-sm block mb-2">Category Name</label>
                            <input v-model="form.name" type="text" class="border border-primary rounded-md font-normal text-sm w-full">
                        </div>
                    </div>
                    
                    <div class="w-1/2 pl-2">
                        <div class="w-full">
                            <label for="name" class="text-sm block mb-2">Parent Category</label>
                            <Select
                                v-if="parentCategories"
                                label="name"
                                :options="parentCategories"
                                :reduce="item => item.id"
                                v-model="form.parent_id"
                                :searchable="true"
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
                            <p v-else class="text-primary">Failed To load Parent Category...</p>
                        </div>
                    </div>
                    <div class="w-1/2 pr-2 pt-2">
                        <div class="w-full">
                            <label for="name" class="text-sm block mb-2">Order Number</label>
                            <input v-model="form.order_number" type="number" class="border border-primary rounded-md font-normal text-sm w-full">
                        </div>
                    </div>
                </div>
                <div class="flex items-center my-10">
                    <div class="w-1/3 pr-2">
                        <div class="w-full">
                            <label for="category-icon" class="text-sm block mb-2">Category Image</label>
                            <label class="border border-primary border-dashed p-4 rounded-2xl flex items-center justify-center w-full h-52 cursor-pointer">
                                <img v-if="iconImg" :src="iconImg" class="w-full h-full">
                                <div v-if="!iconImg" class="flex flex-col items-center justify-center gap-2">
                                    <Icon name="tabler:cloud-upload" class="text-primary text-5xl opacity-85" />
                                    <span class="text-primary font-semibold opacity-85">Upload Category Icon</span>
                                </div>
                                <input id="category-icon" @change="image" type="file" hidden>
                            </label>
                        </div>
                    </div>
                    <div class="w-2/3 pl-2">
                        <div class="w-full">
                            <label for="category-banner" class="text-sm block mb-2">Category Banner</label>
                            <label for="category-banner" class="border border-primary border-dashed p-4 rounded-2xl flex items-center justify-center w-full h-52 cursor-pointer">
                                <img v-if="bannerImg" :src="bannerImg" class="w-full h-full rounded-md">
                                <div v-if="!bannerImg" class="flex flex-col items-center justify-center gap-2">
                                    <Icon name="tabler:cloud-upload" class="text-primary text-5xl opacity-85" />
                                    <span class="text-primary font-semibold opacity-85">Upload Category Banner</span>
                                </div>
                                <input id="category-banner" @change="banner" type="file" hidden>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="w-full mb-4">
                    <label for="short-description" class="text-sm block mb-2">Short Description</label>
                    <textarea class="w-full h-20 rounded border p-2" v-model="form.short_description"></textarea>
                </div>
                <div class="w-full">
                    <label for="description" class="text-sm block mb-2">Description</label>
                    <div class="editor_data">
                        <SummernoteEditor v-model="form.description" />
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <Button @click="onUpdate(form.id)">Save Change</Button>
            </div>
        </div>
    </AppLayout>
</template>