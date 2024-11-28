<script setup>
import { onMounted, ref } from "vue";
import useAxios from "@/composables/useAxios";
import { useToast } from "vue-toastification"; // For toast notifications

const testimonials = ref([]);
const toast = useToast(); // Initialize toast for notifications

const { loading, error, sendRequest } = useAxios();

const getData = async () => {
  const response = await sendRequest({
    url: "/v1/testimonials",
    method: "GET",
  });
  testimonials.value = response.data;
};

const deleteTestimonial = async (id) => {
  const confirmDelete = confirm(
    "Are you sure you want to delete this testimonial?"
  );
  if (confirmDelete) {
    const response = await sendRequest({
      url: `/v1/testimonials/${id}`,
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
    <div class="max-w-4xl mx-auto p-8 bg-gray-50 rounded-lg shadow-lg my-10">
      <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Testimonials</h2>
        <router-link to="/testimonials/create">
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

      <table class="min-w-full bg-white border border-gray-300 rounded-lg">
        <thead>
          <tr class="bg-gray-200 text-gray-600">
            <th class="py-3 px-4 text-left">Name</th>
            <th class="py-3 px-4 text-left">Message</th>
            <th class="py-3 px-4 text-left">Image</th>
            <th class="py-3 px-4 text-left">Actions</th>
            <!-- New Actions Column -->
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(testimonial, index) in testimonials"
            :key="index"
            class="border-b hover:bg-gray-100"
          >
            <td class="py-3 px-4">{{ testimonial.name }}</td>
            <td class="py-3 px-4">{{ testimonial.message }}</td>
            <td class="py-3 px-4">
              <img
                :src="testimonial.image_url"
                alt="Customer Image"
                class="w-16 h-16 object-cover rounded-full"
              />
            </td>
            <td class="py-3 px-4 text-center">
              <button
                @click="deleteTestimonial(testimonial.id)"
                class="text-red-500 hover:text-red-700"
              >
                <i class="fa fa-trash" aria-hidden="true"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>
