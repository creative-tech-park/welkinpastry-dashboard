<script setup>
    import  SummernoteEditor  from 'vue3-summernote-editor';
    import {ref, onMounted} from 'vue';
    import { useAuthStore } from '@/stores/useAuthStore.js';
    import useAxios from '@/composables/useAxios.js';
    import {useRouter} from 'vue-router';
    import { useRoute } from 'vue-router';
    import {useToast} from "vue-toastification";
    const toast = useToast();
    const {error, loading, sendRequest} = useAxios();
    const authStore = useAuthStore();
    const router = useRouter();
    const route = useRoute();


    const form = ref({
      id:null,
      title:null,
      content:'',
    })


    const getPage = async() => {
        const response = await sendRequest({
            method:'get',
            url:`/v1/page/${route?.params?.id}`,
        });
        form.value = response.data
    }
    const onUpdate = async(id) => {
        const response = await sendRequest({
            method:'post',
            url:`/v1/page`,
            data:form.value
        })

        if(response) {
            toast.success('Page Update Successfully', {autoClose:1000})
            await router.push('/pages')
        }
    }

    onMounted(async () => {
      await getPage();
    })
</script>
<template>
    <AppLayout>
        <div class="flex justify-center">
            <div class="w-full pr-1">
                <div class=" bg-white p-4 shadow-lg">
                    <h3>Create New Page</h3>
                    <div class="mb-5">
                        <label for="title" class="mb-1 block text-sm text-gray-600">Page Title</label>
                        <input id="title" type="text" class="p-2 rounded-md border w-full" v-model="form.title">
                        <small class="text-red-500" v-if="error?.response?.data?.errors?.title">{{ error?.response?.data?.errors?.title[0] }} </small>

                    </div>
                    <div>
                        <label for="summery" class="mb-1 block text-sm text-gray-600">Page Content</label>
                        <div class="editor_data">
                        <SummernoteEditor v-model="form.content" />
                    </div>
                    </div>
                    <div class="mt-5">
                        <Button @click="onUpdate(form.id)">Update Page</Button>
                    </div>
                </div>
            </div>
            <!-- <div class="w-1/5 pl-1">
                <div class=" bg-white p-4 shadow-lg">
                    <h3 class="mb-2">Page Seo Detail</h3>
                    <div class="mb-5">
                        <label for="title" class="mb-1 block text-sm text-gray-600">Seo Title</label>
                        <input id="title" type="text" class="text-sm p-2 rounded-md border w-full" v-model="form.seo_title">
                    </div>
                    <div class="mb-5">
                        <label for="title" class="mb-1 block text-sm text-gray-600">Seo Description</label>
                        <textarea class="p-1 w-full h-32 rounded-md text-sm" v-model="form.seo_description"></textarea>
                    </div>
                    <div>
                        <label for="title" class="mb-1 block text-sm text-gray-600">Seo Image</label>
                        <div class="w-full">
                            <label class="border border-primary border-dashed p-4 rounded-xl flex items-center justify-center w-full h-32 cursor-pointer" for="seo-image">
                                <img v-if="img" :src="img" class="w-full h-full object-cover">
                                <div v-if="!img" class="flex flex-col items-center justify-center gap-2">
                                    <Icon name="tabler:cloud-upload" class="text-primary text-4xl opacity-85" />
                                    <span class="text-primary font-normal text-base opacity-85">Upload Seo Image</span>
                                </div>
                                <input id="seo-image" @change="image" type="file" hidden>
                            </label>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </AppLayout>
</template>