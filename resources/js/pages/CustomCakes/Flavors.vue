<script setup>
import { onMounted, ref } from "vue";
import useAxios from "@/composables/useAxios";
import { useToast } from "vue-toastification"; // For toast notifications

const data = ref([]);
const toast = useToast(); // Initialize toast for notifications

const { loading, error, sendRequest } = useAxios();

const getData = async () => {
  const response = await sendRequest({
    url: "/v1/custom-cake-flavors",
    method: "GET",
  });
  data.value = response.data;
};

const deleteData = async (id) => {
  const confirmDelete = confirm("Are you sure you want to delete this data?");
  if (confirmDelete) {
    const response = await sendRequest({
      url: `/v1/custom-cake-flavors/${id}`,
      method: "DELETE",
    });
    if (response?.data) {
      toast.success(response.data.message);
      await getData(); // Refresh the testimonials list
    }
  }
};

onMounted(async () => await getData());
</script>

<template>
  <AppLayout>
    <div class="max-w-5xl mx-auto p-8 bg-gray-50 rounded-lg shadow-lg my-10">
      <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Custom Cake Flavors</h2>
        <router-link to="/custom-cake-flavors/create">
          <button
            class="flex items-center bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded"
          >
            <svg
              class="w-5 h-5 mr-2"
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
            Add Record
          </button>
        </router-link>
      </div>

      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <template v-if="loading">
          <div class="animate-pulse">
            <div class="h-8 bg-gray-200 mb-4"></div>
            <div class="h-8 bg-gray-200 mb-4"></div>
            <div class="h-8 bg-gray-200 mb-4"></div>
            <div class="h-8 bg-gray-200 mb-4"></div>
            <div class="h-8 bg-gray-200 mb-4"></div>
            <div class="h-8 bg-gray-200 mb-4"></div>
            <div class="h-8 bg-gray-200 mb-4"></div>
          </div>
        </template>

        <template v-else>
          <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
          >
            <thead
              class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
              <tr>
                <th scope="col" class="px-6 py-3">Custom Cake Flavor Name</th>
                <th scope="col" class="px-6 py-3">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(item, index) in data"
                :key="index"
                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
              >
                <th
                  scope="row"
                  class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                >
                  {{ item.name }}
                </th>
                <td class="px-6 py-4">
                  <button
                    @click="deleteData(item.id)"
                    class="text-red-500 hover:text-red-700"
                  >
                    <i class="fa fa-trash" aria-hidden="true"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </template>
      </div>
    </div>
  </AppLayout>
</template>
