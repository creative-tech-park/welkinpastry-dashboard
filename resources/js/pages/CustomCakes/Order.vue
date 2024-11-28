<script setup>
import { onMounted, ref } from "vue";
import useAxios from "@/composables/useAxios";
import { useToast } from "vue-toastification"; // For toast notifications

const isModalOpen = ref(false);
const modalItem = ref({});

const showModal = (item) => {
  modalItem.value = item; // Set the selected item to display in the modal
  isModalOpen.value = true; // Open the modal
};

const closeModal = () => {
  isModalOpen.value = false; // Close the modal
  modalItem.value = {}; // Clear the item when closing
};

const data = ref([]);
const isLoading = ref(true); // Track loading state
const toast = useToast(); // Initialize toast for notifications

const { loading, error, sendRequest } = useAxios();

const getData = async () => {
  try {
    const response = await sendRequest({
      url: "/v1/custom-cake-orders",
      method: "GET",
    });
    data.value = response.data;
  } catch (err) {
    toast.error("Failed to load custom cake orders");
  } finally {
    isLoading.value = false; // Set loading to false once data is fetched
  }
};

// Function to download file
const downloadFile = async (fileName) => {
  try {
    const response = await sendRequest({
      method: "get",
      url: `/download/${fileName}`, // URL of the backend download route
      responseType: "blob", // Ensure the response is treated as a file
    });

    // Create a link element to trigger download
    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement("a");
    link.href = url;
    link.setAttribute("download", fileName); // Filename for download
    document.body.appendChild(link);
    link.click();

    // Cleanup the link element
    link.remove();
    toast.success("File downloaded successfully!");
  } catch (error) {
    toast.error("Failed to download the file.");
    console.error("Error downloading file:", error.response?.data);
  }
};

onMounted(async () => await getData());
</script>

<template>
  <AppLayout>
    <div class=" p-4 bg-gray-50 rounded-lg shadow-lg my-10">
      <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Custom Cake Orders</h2>
      </div>

      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table
          class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
          <thead
            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
          >
            <tr>
              <th scope="col" class="px-6 py-3">Cake Name</th>
              <th scope="col" class="px-6 py-3">Customer</th>
               <th scope="col" class="px-6 py-3">Flavor</th>
               <th scope="col" class="px-6 py-3">Message On Cake</th>
               <th scope="col" class="px-6 py-3">Weight</th>
              <th scope="col" class="px-6 py-3">Delivery Location</th>
              <th scope="col" class="px-6 py-3">Delivery Date</th>
              <th scope="col" class="px-6 py-3">Action</th>
            </tr>
          </thead>
          <tbody>
            <template v-if="isLoading">
              <tr v-for="n in 5" :key="n" class="animate-pulse">
                <td colspan="9" class="px-6 py-4">
                  <div class="h-8 bg-gray-300 rounded w-full"></div>
                </td>
              </tr>
            </template>

            <template v-else>
              <tr
                v-for="(item, index) in data"
                :key="index"
                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
              >
                <th
                  scope="row"
                  class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                >
                  {{ item.custom_cake.name }}
                </th>
                <td class="px-6 py-4">
                  <p>{{ item.custom_cake_customer.full_name }}</p>
                  <p>{{ item.custom_cake_customer.phone_number }}</p>
                </td>
                 <td class="px-6 py-4">{{ item.custom_cake_flavor.name }}</td>
                 <td class="px-6 py-4">{{ item.message_on_cake }}</td>
                 <td class="px-6 py-4">{{ item.weight }}kg</td>
                <td class="px-6 py-4 capitalize">
                  {{ item.custom_cake_customer?.address }}
                </td>
                <td class="px-6 py-4">
                  {{
                    new Date(item.delivery_date).toLocaleDateString("en-GB", {
                      day: "numeric",
                      month: "short",
                      year: "numeric",
                    })
                  }}
                </td>
                <td class="px-6 py-4">
                  <button
                    v-if="item?.photo_on_cake"
                    class="text-green-500 hover:text-green-700"
                    @click="downloadFile(item?.photo_on_cake)"
                  >
                    <i class="fa fa-download" aria-hidden="true"></i> Download
                  </button>
                  <button
                    @click="showModal(item)"
                    class="text-green-500 hover:text-green-700"
                  >
                    <i class="fa fa-eye" aria-hidden="true"></i> View
                  </button>
                </td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>

      <!-- Modal -->
      <div
        v-if="isModalOpen"
        class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75"
      >
        <div class="bg-white p-4 rounded-lg shadow-lg max-w-lg w-full">
          <button class="text-red-500" @click="closeModal">Close</button>
          <h2 class="text-xl font-bold mb-2">
            {{ modalItem.custom_cake_name }}
          </h2>
          <p class="mb-2">
            <strong>Customer Name:</strong>
            {{ modalItem.custom_cake_customer.full_name }}
          </p>
          <p class="mb-2">
            <strong>Mobile:</strong>
            {{ modalItem.custom_cake_customer.phone_number }}
          </p>
          <p class="mb-2">
            <strong>Flavor:</strong> {{ modalItem.custom_cake_flavor.name }}
          </p>
          <p class="mb-2">
            <strong>Message:</strong> {{ modalItem.message_on_cake }}
          </p>
          <p class="mb-2"><strong>Weight:</strong> {{ modalItem.weight }}kg</p>
          <p class="mb-2">
            <strong>Delivery Location:</strong>
            {{ modalItem.delivery_location }} Dhaka
          </p>
          <p class="mb-2">
            <strong>Delivery Date:</strong>
            {{
              new Date(modalItem.delivery_date).toLocaleDateString("en-GB", {
                day: "numeric",
                month: "short",
                year: "numeric",
              })
            }}
          </p>

          <h3 class="text-lg font-bold mt-4">Images:</h3>
          <div
            v-if="modalItem.custom_cake_order_images.length"
            class="grid grid-cols-1 md:grid-cols-3 gap-4"
          >
            <img
              v-for="(image, index) in modalItem.custom_cake_order_images"
              :key="index"
              :src="image.image_url"
              alt="Cake Image"
              class="w-full h-auto rounded-lg"
            />
          </div>
          <p v-else>No images available</p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
