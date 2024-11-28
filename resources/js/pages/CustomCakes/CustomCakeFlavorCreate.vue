<script setup>
import { ref, computed } from "vue";
import useAxios from "@/composables/useAxios";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";

const toast = useToast();
const router = useRouter();

const form = ref({
  name: null,
});

const { loading, error, sendRequest } = useAxios();

const submitForm = async () => {
  const formData = new FormData();
  formData.append("name", form.value.name);

  const response = await sendRequest({
    method: "post",
    url: "/v1/custom-cake-flavors",
    data: formData,
  });

  if (response?.data) {
    toast.success(response?.data?.message);

    // Reset the form values
    form.value = {
      name: null,
    };

    await router.push("/custom-cake-flavors");
  }
};

// Computed property to check if the form is valid
const isFormValid = computed(() => {
  return form.value.name;
});
</script>

<template>
  <AppLayout>
    <div class="max-w-4xl mx-auto p-8 bg-gray-50 rounded-lg shadow-lg my-10">
      <h2 class="text-3xl font-bold text-gray-800 mb-8">
        Add Custom Cake Flavor
      </h2>
      <form @submit.prevent="submitForm">
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="name"
            >Flavor Name</label
          >
          <input
            v-model="form.name"
            type="text"
            id="name"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            required
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
