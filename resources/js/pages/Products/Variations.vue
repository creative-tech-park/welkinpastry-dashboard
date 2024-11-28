<script setup>
    import { onMounted, ref , watch} from 'vue';
    import useAxios from "@/composables/useAxios"
    import { useAuthStore } from '@/stores/useAuthStore.js';
    import Modal from '@/components/Modal.vue';
    import {useToast} from "vue-toastification";
const toast = useToast();;

    const authStore = useAuthStore();
    const { loading, error, sendRequest } = useAxios();

    const variations= ref(null);

    const query = ref({
        search:null,
        parPage:20,
    });

    const getVariation = async () => {
        console.log(query?.value);
        const response = await sendRequest({
            method: 'get',
            url: '/v1/variation',
            headers: {
                authorization: `Bearer ${authStore.user.token}`
            },
            data:query.value
        });
        variations.value = response?.data
    }

    const iconImg = ref(null);
    const image = (image) => {
        const file = image.target.files[0];
        form.value.image = file;
        newItem.value.image = file;
        iconImg.value = URL.createObjectURL(file);
    }
    // Add new Varaton
    const form = ref({
        name:null,
        image:null,
    });

    const onSubmit = async() => {
        const response = await sendRequest({
            method: 'post',
            url:'/v1/variation',
            data: form.value,
            headers: {
                authorization: `Bearer ${authStore.user.token}`,
                'Content-type' : 'multipart/form-data'
            }
        });
        if(response?.data){
            toast.success( `${response?.data?.name} Variation Addded Succesfully`, {autoclose:1000});
            getVariation();
            isModalOpened.value = false;
        }
    }

    // edit product
    const newItem = ref({
        id:null,
        name:null,
        image:null,
    })

    const editVariation = (item) => {
        isEditModalOpened.value = true;
        newItem.value.id = item.id
        newItem.value.name = item.name
        iconImg.value = item.image
    }

    const onUpdate = async(id) => {
        const response = await sendRequest({
            method: 'post',
            url: `/v1/variation/${id}`,
            params: {
                _method: 'PUT'
            },
            data: newItem.value,
            headers: {
                authorization: `Bearer ${authStore.user.token}`,
                'Content-type' : 'multipart/form-data'
            }
        });

        if(response?.data){
            toast.success( `Variatioin Updated Succesfully`, {autoclose:1000});
            getVariation();
            isEditModalOpened.value = false;
        }
    }


    // delete Variation
    const deleteVariation = async(variation) => {
        await sendRequest({
            method: 'delete',
            url: `/v1/variation/${variation}`,
            headers: {
                authorization: `Bearer ${authStore.user.token}`,
                'Content-type' : 'multipart/form-data'
            }
        });

        getVariation();
        toast.success('Variation Deleted Succesfully', {autoClose:1000})
    }


    onMounted(() => {
        getVariation();
    })

    // model
    const isModalOpened = ref(false);
    const isEditModalOpened = ref(false);

    const openModal = () => {
    isModalOpened.value = true;
    };
    const closeModal = () => {
        isModalOpened.value = false;
        isEditModalOpened.value = false;
        form.value.name = null;
        iconImg.value = null;
    };


watch(query, getVariation, {deep: true});
</script>

<template>
    <AppLayout>
        <section class="px-4">
            <div class="bg-white p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <Icon name="simple-icons:nginxproxymanager" class="text-lg text-primary" />
                        <h3 class="text-primary text-lg font-semibold">Prodcut Variations</h3>
                    </div>
                    <div>
                        <Button class="flex items-center gap-2" @click="openModal">
                            <Icon name="material-symbols:add-box-outline" />
                            Add Record
                        </Button>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4 bg-white dark:bg-gray-900">
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-primary dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input v-model="query.serach" type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-primary rounded-lg w-96 bg-gray-50 focus:ring-primary focus:border-primary" placeholder="Search for Product Variaton...">
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        Rows: <Select
                        class="w-20"
                        placeholder="25"
                        :options="[5, 10, 15, 20, 25]"
                    ></Select>
                    </div>
                </div>
            </div>
        </section>
        <div class="mx-5 bg-white">
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-white  uppercase bg-primary dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Slug
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Image
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Created At
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                    </thead>
                    
                    <tbody>               
                    <tr  v-for="item in variations?.data" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 text-black">
                            {{ item?.name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ item?.slug }}
                        </td>
                        <td class="px-6 py-4">
                            <img class="w-20 h-auto object-cover" :src="item?.image">
                        </td>
                        <td class="px-6 py-4">
                            {{ item?.created_at }}
                        </td>
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                
                                <button @click="editVariation(item)" class="w-8 h-8 rounded-md flex items-center justify-center bg-yellow-400/10 border border-yellow-900">
                                    <Icon name="material-symbols:edit-square-outline" class="text-lg text-yellow-900" />
                                </button>
                                <div>

                                </div>
                                <button @click="deleteVariation(item?.id)" class="w-8 h-8 rounded-md flex items-center justify-center bg-red-400/10 border border-red-900">
                                    <Icon name="material-symbols:delete-outline" class="text-lg text-red-900" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
    <Modal title="Add New Attribute" :isOpen="isModalOpened" @modal-close="closeModal">
        <div class="flex flex-col gap-5 pt-5">
            <div class="w-full">
                <label for="name" class="block text-sm mb-1">Variation Name</label>
                <input v-model="form.name" type="text" class="p-2 border border-primary rounded-md w-full">
            </div>
            <div class="w-full">
                <label for="variation-img" class="text-sm block mb-2">Variation Image</label>
                <label class="border border-primary border-dashed p-4 rounded-2xl flex items-center justify-center  w-32 h-32 cursor-pointer">
                    <img v-if="iconImg" :src="iconImg" class="w-full h-full object-cover">
                    <div v-if="!iconImg" class="flex flex-col items-center justify-center gap-2">
                        <Icon name="tabler:cloud-upload" class="text-primary text-2xl opacity-85" />
                        <span class="text-primary text-xs font-semibold opacity-85">Upload Image</span>
                    </div>
                    <input id="category-icon" @change="image" type="file" hidden>
                </label>
            </div>
            <div class="w-full">
                <Button @click="onSubmit">Save Variations</Button>
            </div>
        </div>
    </Modal>

    <Modal title="Edit Attribute" :isOpen="isEditModalOpened" @modal-close="closeModal">
        <div class="flex flex-col gap-5 pt-5">
            <div class="w-full">
                <label for="name" class="block text-sm mb-1">Variation Name</label>
                <input v-model="newItem.name" type="text" class="p-2 border border-primary rounded-md w-full">
            </div>

            <div class="w-full">
                <label for="update-variation-img" class="text-sm block mb-2">Variation Image</label>
                <label class="border border-primary border-dashed p-4 rounded-2xl flex items-center justify-center  w-32 h-32 cursor-pointer">
                    <img v-if="iconImg" :src="iconImg" class="w-full h-full object-cover">
                    <div v-if="!iconImg" class="flex flex-col items-center justify-center gap-2">
                        <Icon name="tabler:cloud-upload" class="text-primary text-2xl opacity-85" />
                        <span class="text-primary text-xs font-semibold opacity-85">Upload Image</span>
                    </div>
                    <input id="update-banner-image" @change="image" type="file" hidden>
                </label>
            </div>
            
            <div class="w-full">
                <Button @click="onUpdate(newItem.id)">Update Variation</Button>
            </div>
        </div>
    </Modal>
</template>