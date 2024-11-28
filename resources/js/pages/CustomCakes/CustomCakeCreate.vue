<script setup>
import { ref, computed } from "vue";
import useAxios from "@/composables/useAxios";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";

const toast = useToast();
const router = useRouter();

const form = ref({
  name: null,
  price: null,
  image: null,
  imageUrl: "",
});

const handleImageUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    form.value.image = file; // Set the uploaded file to the form object
    form.value.imageUrl = URL.createObjectURL(file); // Create a local URL for the uploaded image
  }
};

const { loading, error, sendRequest } = useAxios();

const submitForm = async () => {
  const formData = new FormData();
  formData.append("name", form.value.name);
  formData.append("price", form.value.price);
  formData.append("image", form.value.image);

  const response = await sendRequest({
    method: "post",
    url: "/v1/custom-cakes",
    data: formData,
  });

  if (response?.data) {
    toast.success(response?.data?.message);

    // Reset the form values
    form.value = {
      name: null,
      price: null,
      image: null,
      imageUrl: "",
    };

    await router.push("/custom-cakes");
  }
};

// Computed property to check if the form is valid
const isFormValid = computed(() => {
  return form.value.name && form.value.price && form.value.image;
});
</script>

<template>
  <AppLayout>
    <div class="max-w-4xl mx-auto p-8 bg-gray-50 rounded-lg shadow-lg my-10">
      <h2 class="text-3xl font-bold text-gray-800 mb-8">Add Custom Cake</h2>
      <form @submit.prevent="submitForm">
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="name"
            >Name</label
          >
          <input
            v-model="form.name"
            type="text"
            id="name"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            required
          />
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="name"
            >Price</label
          >
          <input
            v-model="form.price"
            type="text"
            id="name"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            required
          />
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="image"
            >Upload Image</label
          >
          <div
            class="border-dashed border-2 border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:bg-gray-100"
            @click="$refs.fileInput.click()"
          >
            <svg
              class="w-12 h-12 mx-auto mb-2 text-gray-500"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 4v16m8-8H4"
              ></path>
            </svg>
            <p class="text-gray-600">Click to upload an image</p>
          </div>
          <input
            type="file"
            ref="fileInput"
            @change="handleImageUpload"
            accept="image/*"
            class="hidden"
            required
          />
        </div>

        <!-- Show uploaded image -->
        <div class="mb-4" v-if="form.imageUrl">
          <img
            :src="form.imageUrl"
            alt="Uploaded Image"
            class="w-32 h-32 object-cover rounded border mt-2"
          />
        </div>

        <div class="flex items-center justify-between">
          <button
            type="submit"
            :disabled="loading || !isFormValid"
            :class="[
              'bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline',
              { 'bg-gray-400 cursor-not-allowed': loading || !isFormValid }, // Disabled styles
            ]"
          >
            Submit
          </button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
