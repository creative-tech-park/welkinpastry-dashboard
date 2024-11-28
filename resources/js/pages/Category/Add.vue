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
const getParentCategory = async () => {
  const response = await sendRequest({
    method: 'get',
    url: '/v1/category?recursive',
  });
  parentCategories.value = response?.data;
}

const iconImg = ref(null);
const bannerImg = ref(null);

const form = ref({
  name: null,
  parent_id: null,
  icon: null,
  banner: null,
  order_number: 0,
  short_description: null,
  description: null,
});


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

const onSubmit = async () => {
  console.log(form.value);
  const response = await sendRequest({
    method: 'post',
    url: '/v1/category',
    data: form.value
  });
  if (response?.data) {
    toast.success(response?.data?.message);
    await router.push('/category');
  }
}


onMounted(() => {
  getParentCategory()
})
</script>
<template>
  <AppLayout>
    <div class="bg-white shadow-md p-6 max-w-5xl mx-auto">
      <h3 class="mb-10">Create a New Category</h3>
      <div>
        <div class="flex items-start flex-wrap">
          <div class="w-1/2 pr-2">
            <Input label-name="Name"
                   v-model="form.name"
                   label="Name"
                   :error="error?.response?.data?.errors?.name"
                   :loading="loading"
            />
          </div>
          <div class="w-1/2 pr-2">
            <label class="text-sm block mb-2">Parent Category</label>
            <Select
                class="disabled:bg-gray-200"
                :disabled="loading"
                label="name"
                :options="parentCategories"
                :reduce="item => item.id"
                v-model="form.parent_id"
            >
            </Select>
          </div>

          <div class="w-1/2 pr-2 pt-2">
            <div class="w-full">
              <Input label-name="Order Number"
                     v-model="form.order_number"
                     label="Order number"
                     :error="error?.response?.data?.errors?.order_number"
                     :loading="loading"
                     type="number"
              />
            </div>
          </div>
        </div>
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
          <div class="w-2/3 pl-2">
            <div class="w-full">
              <label for="category-banner" class="text-sm block mb-2">Category Banner</label>
              <label for="category-banner"
                     :class="{'bg-gray-200' : loading}"
                     class="border border-primary border-dashed p-4 rounded-2xl flex items-center justify-center w-full h-52 cursor-pointer">
                <img v-if="bannerImg" :src="bannerImg" class="w-full h-full rounded-md object-cover">
                <div v-if="!bannerImg" class="flex flex-col items-center justify-center gap-2">
                  <Icon name="tabler:cloud-upload" class="text-primary text-5xl opacity-85"/>
                  <span class="text-primary font-semibold opacity-85">Upload Category Banner</span>
                </div>
                <input :disabled="loading" id="category-banner" @change="banner" type="file" hidden>
              </label>
            </div>
          </div>
        </div>
        <div class="w-full mb-4">
          <label for="short-description" class="text-sm block mb-2">Short Description</label>
          <textarea class="w-full h-20 rounded border p-2 disabled:bg-gray-200"
                    :disabled="loading"
                    v-model="form.short_description"></textarea>
        </div>
        <div class="w-full">
          <label for="description" class="text-sm block mb-2">Description</label>
          <div class="editor_data">
            <SummernoteEditor v-model="form.description"/>
          </div>
        </div>
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