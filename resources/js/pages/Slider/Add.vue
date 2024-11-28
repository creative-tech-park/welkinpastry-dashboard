<script setup>
import {onMounted, ref} from 'vue';
import {useAuthStore} from '@/stores/useAuthStore.js';
import useAxios from '@/composables/useAxios';
import {useToast} from "vue-toastification";

const toast = useToast();
;
import {useRoute, useRouter} from 'vue-router';
import LoadingButton from "@/components/LoadingButton.vue";

const router = useRouter();
const authStore = useAuthStore();
const {loading, error, sendRequest} = useAxios();


const sliderImg = ref(null);
const image = (image) => {
  const file = image.target.files[0];
  form.value.image = file;
  sliderImg.value = URL.createObjectURL(file);
}

const form = ref({
  title:null,
  slogan:null,
  btn1_name:null,
  url: null,
  image: null,
  order_number: 0
})

const onSubmit = async () => {
  const response = await sendRequest({
    url: '/v1/slider',
    method: 'post',
    data: form.value,
  })

  toast.success('Slider Action Successfully');
  await router.push('/slider')
}

onMounted(async () => {
  const route = useRoute();
  const response = await sendRequest({
    url: `/v1/slider/${route?.params?.id}`,
    method: 'get',
  })
  sliderImg.value = response?.data?.image_url
  form.value = response.data
})

</script>
<template>
  <AppLayout>
    <div class="bg-white p-4 shadow max-w-3xl mx-auto">
      <h3 class="text-xl mb-5">{{ $route?.params?.id ? 'Edit' : 'Add New' }} Home Slider</h3>
      <div class="flex flex-col gap-5">

        <div class="w-full">
          <label class="text-sm block mb-1">Title</label>
          <input type="text" class="p-2 rounded-md border w-full" v-model="form.title">
        </div>
        <div class="w-full">
          <label class="text-sm block mb-1">slogan</label>
          <input type="text" class="p-2 rounded-md border w-full" v-model="form.slogan">
        </div>
        <div class="w-full">
          <label class="text-sm block mb-1">URL</label>
          <input type="text" class="p-2 rounded-md border w-full" v-model="form.url">
        </div>
        <div class="w-full">
          <label class="text-sm block mb-1">Button Name</label>
          <input type="text" class="p-2 rounded-md border w-full" v-model="form.btn1_name">
        </div>
        <div class="w-full">
          <label class="text-sm block mb-1">Order Number</label>
          <input type="text" class="p-2 rounded-md border w-full" v-model="form.order_number">
        </div>

        <div class="w-full">
          <label for="slider-image" class="text-sm block mb-2">Slider Image</label>
          <label for="slider-image"
                 class="border border-primary border-dashed p-4 rounded-2xl flex items-center justify-center w-full h-52 cursor-pointer">
            <img v-if="sliderImg" :src="sliderImg" class="w-full h-full rounded-md">
            <div v-if="!sliderImg" class="flex flex-col items-center justify-center gap-2">
              <Icon name="tabler:cloud-upload" class="text-primary text-5xl opacity-85"/>
              <span class="text-primary font-semibold opacity-85">Upload Slider Image</span>
            </div>
            <input id="slider-image" @change="image" type="file" hidden>
          </label>
          <small class="text-red-500" v-if="error?.response?.data?.errors?.image">{{ error?.response?.data?.errors?.image[0] }}</small>
        </div>
        <div>
          <LoadingButton :isLoading="loading" @click="onSubmit" class="bg-primary text-center text-white w-full py-2 rounded">
            {{  $route?.params?.id ? 'Update' : 'Save' }} Slider
          </LoadingButton>
        </div>
      </div>
    </div>
  </AppLayout>
</template>