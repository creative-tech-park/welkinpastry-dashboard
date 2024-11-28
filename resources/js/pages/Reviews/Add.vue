<script setup>
import SummernoteEditor from 'vue3-summernote-editor';
import useAxios from "@/composables/useAxios"
import {useAuthStore} from "@/stores/useAuthStore";
import {ref, onMounted} from "vue";
import {useRouter} from 'vue-router'
import Input from "@/components/Input.vue";
import LoadingButton from "@/components/LoadingButton.vue";
import {useToast} from "vue-toastification";

const toast = useToast();

const {loading, error, sendRequest} = useAxios();
const authStore = useAuthStore();
const router = useRouter();
const parentCategories = ref([]);

const iconImg = ref(null);

const form = ref({
  name: null,
  message: null,
  image: null,
  position: null,
});

const image = (image) => {
  const file = image.target.files[0];
  form.value.image = file;
  iconImg.value = URL.createObjectURL(file);
}

const onSubmit = async () => {
  const response = await sendRequest({
    method: 'post',
    url: '/v1/reviews',
    data: form.value
  });
  if (response?.data) {
    toast.success(response?.data?.message);
    await router.push('/all-review');
  }
}


onMounted(async () => {
  await getParentCategory()
})
</script>
<template>
  <AppLayout>
    <div class="bg-white shadow-md p-6 max-w-5xl mx-auto">
      <h3 class="mb-10">Create a New Category</h3>
      <div class="flex items-center my-10">
        <div class="w-1/3 pr-2">
          <div class="w-full">
            <label for="category-icon" class="text-sm block mb-2">Category Image</label>
            <label
                :class="{'bg-gray-200' : loading}"
                class="border border-primary border-dashed p-4 rounded-2xl flex items-center justify-center w-full h-52 cursor-pointer">
              <img v-if="iconImg" :src="iconImg" class="w-full h-full object-cover">
              <div v-if="!iconImg" class="flex flex-col items-center justify-center gap-2">
                <Icon name="tabler:cloud-upload" class="text-primary text-5xl opacity-85"/>
                <span class="text-primary font-semibold opacity-85">Upload Category Icon</span>
              </div>
              <input :disabled="loading" id="category-icon" @change="image" type="file" hidden>
            </label>
          </div>
        </div>
      </div>

      <div class="flex gap-4 items-center">
        <div class="w-full mb-4">
          <label for="short-description" class="text-sm block mb-2">Name</label>
          <input type="text" class="w-full rounded border p-2 disabled:bg-gray-200"
                 :disabled="loading"
                 v-model="form.name"></input>
        </div>
      </div>
      <div class="w-full mb-4">
        <label for="short-description" class="text-sm block mb-2">Message</label>
        <textarea class="w-full h-20 rounded border p-2 disabled:bg-gray-200"
                  :disabled="loading"
                  v-model="form.message"></textarea>
      </div>
      <div class="mt-5">
        <LoadingButton class="w-max" @click="onSubmit" :isLoading="loading">
          Save
        </LoadingButton>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>

</style>