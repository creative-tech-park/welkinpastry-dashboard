<script setup>
import {ref, onMounted} from 'vue'
import useAxios from '@/composables/useAxios';
import {useAuthStore} from "@/stores/useAuthStore";
import {useRoute, useRouter} from 'vue-router';
import {useToast} from "vue-toastification";
import Input from "@/components/Input.vue"
import LoadingButton from "@/components/LoadingButton.vue";

const toast = useToast();
const {loading, error, sendRequest} = useAxios();
const authStore = useAuthStore();
const router = useRouter();
const route = useRoute();
const allCategories = ref([]);
const categoryLoading = ref(false)
const getAllCategories = async () => {
  const response = await sendRequest({
    method: 'GET',
    url: '/v1/category?recursive'
  });
  allCategories.value = response?.data;
}

const allLocations = ref([])
const locationLoading = ref(false)


const locations = ref([
  {
    id: 1, name: 'Gulshan 1, Dhaka'
  },

  {
    id: 2, name: 'Gulshan 2, Dhaka'
  },
  {
    id: 3, name: 'Savar, Dhaka'
  },

  {
    id: 4, name: 'Badda, Dhaka'
  }
])

//handle cover image
const coverImg = ref(null);
const coverImage = (image) => {
  const file = image.target.files[0];
  form.value.cover_image = file;
  coverImg.value = URL.createObjectURL(file);
}

// handle hover image
const hoverImg = ref(null);

// handle multiple image upload
const handleFileChange = (event) => {
  for (let i = 0; i < event.target.files.length; i++) {
    form.value.images.push({
      url: URL.createObjectURL(event.target.files[i]),
      file: event.target.files[i],
    });
  }
};

const removeMedia = (index) => {
  let removedImage = form.value.images[index];
  if (removedImage.url.startsWith('blob:')) {
    URL.revokeObjectURL(removedImage.url);
  }
  form.value.images.splice(index, 1);
};

const form = ref({
  title: '',
  // price: '',
  category_id: '',
  sku: '',
  // discount_price: '',
  stock: 2,
  cover_image: '',
  about: '',
  details: '',
  images: [],
  location_id: '',

  variants: [
    {
      weight: null,
      price: null
    }
  ]
});
const getProduct = async () => {
  const response = await sendRequest({
    method: 'GET',
    url: '/v1/product/'+route.params.id
  });
  console.log("called", response)
  console.log("route", route.params)
  form.value = response.data
  form.value.variants = JSON.parse(response.data.variant)
  coverImg.value = response.data.thumbnail
  form.value.images = []
}
const isVarient = ref(false)
const addRow = () => {
  form.value.variants.push(
      {
        weight: null,
        price: null
      }
  )
}
const remoteItem = (index) => form.value.variants.splice(index, 1);
const changeVariant = () => {
  if (confirm('Are you sure?, Want to reset price null')) {
    if (isVarient.value) {
      form.value.price = null
    } else {
      //
    }
    isVarient.value = true;
  }
}
// Save Product
const onSubmit = async () => {
  const response = await sendRequest({
    method: 'post',
    url: '/v1/update-product',
    data: form.value,
    headers: {
      authorization: `Bearer ${authStore.user.token}`,
      'Content-Type': 'multipart/form-data'
    }
  });
  if (response?.data) {
    toast.success(response.data?.message, {autoclose: 1000});
    await router.push('/products');
  }
}

onMounted(async () => {
  await getAllCategories();
  await getProduct();
});
</script>
<template>
  <AppLayout>
    <div class="p-4 bg-white shadow-md me-4">
      <h3 class="text-sm mb-5">Add New Product</h3>
      <div class="flex flex-wrap">
        <div class="w-1/2 flex flex-col gap-3 px-2">
          <div class="w-full px-2">
            <Input label-name="Product Title"
                   v-model="form.title"
                   label="Product Title"
                   :error="error?.response?.data?.errors?.title"
                   :loading="loading" required
            />
          </div>
          <div class="w-full flex flex-wrap gap-y-5">
            <div class="w-full">
              <!--
                            <div class="flex cursor-pointer justify-between items-center bg-primary py-1 px-4 rounded-lg text-white" @click="changeVariant">
                              <p class="text-xs">Click Me If Want to make varient products</p>
                            </div>
                            <div class="w-full" v-if="!isVarient">
                              <Input label-name="Price"
                                     v-model="form.price"
                                     label="Price"
                                     :error="error?.response?.data?.errors?.price"
                                     :loading="loading"
                                     type="number"
                                     required
                              />
                            </div>
              -->
              <p class="my-4">Product Variants</p>
              <div class="w-full">
                <div class="flex justify-between px-4 items-center" v-for="(item, index) in form.variants">
                  <Input label-name="Weight"
                         v-model="form.variants[index].weight"
                         label="Weight"
                         :error="error?.response?.data?.errors?.stock"
                         :loading="loading"
                         type="text"
                         required
                  />
                  <Input label-name="Price"
                         v-model="form.variants[index].price"
                         label="Price"
                         :error="error?.response?.data?.errors[index]?.price"
                         :loading="loading"
                         type="number"
                         required
                  />

                  <button class="p-1 rounded-lg bg-primary text-white" v-if="index === 0" @click="addRow">
                    <Icon name="material-symbols:add"/>
                  </button>
                  <button class="p-1 rounded-lg bg-red-800 text-white" v-else @click="remoteItem(index)">
                    <Icon name="material-symbols:cancel-outline-rounded"/>
                  </button>

                </div>
              </div>
            </div>

<!--            <div class="w-1/2 px-2">
              <Input label-name="Sku"
                     v-model="form.sku"
                     label="Sku"
                     :error="error?.response?.data?.errors?.sku"
                     :loading="loading"
              />
            </div>
            <div class="w-1/2 px-2">

              <Input label-name="Stock"
                     v-model="form.stock"
                     label="Stock"
                     :error="error?.response?.data?.errors?.stock"
                     :loading="loading"
                     type="number"
                     required
              />
            </div>-->
          </div>
          <div class="w-full flex items-center space-x-5 px-2 mt-2">
            <div class="w-full">
              <label class="text-sm block mb-2">Category</label>
              <Select
                  class="disabled:bg-gray-200"
                  :disabled="categoryLoading"
                  label="name"
                  :options="allCategories"
                  :reduce="item => item.id"
                  v-model="form.category_id"
              >
              </Select>
              <small class="text-red-500" v-if="error?.response?.data?.errors?.category_id">
                {{ error?.response?.data?.errors?.category_id[0] }}
              </small>
            </div>

            <!--            <div class="w-1/2">
                          <label class="text-sm block mb-2">Locations</label>
                          <Select
                              class="disabled:bg-gray-200"
                              :disabled="locationLoading"
                              label="name"
                              :options="allLocations"
                              :reduce="item => item.id"
                              v-model="form.location_id"
                          >
                          </Select>
                          <small class="text-red-500" v-if="error?.response?.data?.errors?.location_id">
                            {{error?.response?.data?.errors?.location_id[0] }}
                          </small>
                        </div>-->
          </div>
          <div class="w-full px-2">
            <label for="title" class="text-xs mb-1">About Product</label>
            <textarea type="text" v-model="form.about" :disabled="loading"
                      class="p-1 border disabled:bg-gray-200 border-primary w-full rounded focus:ring-0 focus:border-primary"></textarea>

            <small class="text-red-500" v-if="error?.response?.data?.errors?.about">
              {{ error?.response?.data?.errors?.about[0] }}
            </small>
          </div>
        </div>
        <div class="w-1/2 flex flex-col gap-4 px-2">
          <div class="flex">
            <div class="pr-2">
              <label for="image" class="text-xs block mb-1">Cover Image</label>
              <label for="cover_image" class="w-52 h-36 flex items-center
                            justify-center gap-3 p-2 border border-dashed border-primary rounded-md text-primary cursor-pointer">
                <input type="file" id="cover_image" hidden @change="coverImage">
                <img v-if="coverImg" :src="coverImg" class="w-full h-full object-cover">
                <div v-else>
                  <p class="text-xs">Upload Product Cover Image</p>
                </div>

              </label>
              <small class="text-red-500" v-if="error?.response?.data?.errors?.cover_image">
                {{ error?.response?.data?.errors?.cover_image[0] }}
              </small>
            </div>
          </div>
          <div class="w-full">
            <div class="p-2 bg-white border rounded-lg">
              <h4 class="mb-3 text-sm">Product Images</h4>
              <ul class="mb-2">
                <li class="text-xs">999 KB limit.</li>
                <li class="text-xs">Allowed types: <span class="text-primary"> JPG</span>, <span class="text-primary">JPEG</span>,
                  <span class="text-primary">PNG</span>.
                </li>
              </ul>
              <div class="file-upload-container">
                <div class="file-upload-container-wrapper">
                  <!--IMAGES PREVIEW-->
                  <div v-for="(image, index) in form.images" class="file-upload-container-wrapper__preview"
                       :key="image.index">
                    <img :src="image.url" class="file-upload-container-wrapper__preview-item">
                    <button @click="removeMedia(index)" class="file-upload-container-wrapper__preview-cancel"
                            type="button">
                      <Icon name="material-symbols:close" class="text-white"/>
                    </button>
                  </div>
                  <!--UPLOAD BUTTON-->
                  <div class="file-upload-container-wrapper__add">
                    <label for="mu-file-input" class="file-upload-container__add-btn">
                      <span>
                          <Icon name="tabler:cloud-upload"/>
                      </span>
                    </label>
                    <input @change="handleFileChange" id="mu-file-input" type="file" accept="image/*" multiple hidden>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="w-1/2 px-2 mb-5">
          <label for="title" class="text-sm mb-1">Product Details</label>
          <div class="editor_data">
            <textarea type="text" rows="5" v-model="form.details" :disabled="loading"
                      class="p-1 border disabled:bg-gray-200 border-primary w-full rounded focus:ring-0 focus:border-primary"></textarea>

            <small class="text-red-500" v-if="error?.response?.data?.errors?.details">
              {{ error?.response?.data?.errors?.details[0] }}
            </small>
          </div>
        </div>
      </div>

    </div>
    <div class="text-center pt-10">
      <LoadingButton @click="onSubmit" :isLoading="loading" class="!w-1/2">Save Product</LoadingButton>
    </div>
  </AppLayout>
</template>