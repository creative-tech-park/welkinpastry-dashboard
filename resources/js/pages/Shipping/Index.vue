<script setup>
import AppLayout from "@/components/Layouts/AppLayout.vue";
import {useAuthStore} from '@/stores/useAuthStore.js';
import useAxios from '@/composables/useAxios';
import {ref, onMounted} from 'vue';
import {useToast} from "vue-toastification";
import DeleteButton from "@/components/DeleteButton.vue";
import LoadingButton from "@/components/LoadingButton.vue";

const toast = useToast();
const {loading, error, sendRequest} = useAxios();
const authStore = useAuthStore();

const areas = ref(null);
const getAreas = async () => {
  const response = await sendRequest({
    method: 'get',
    url: '/v1/shipping-area',
  })
  areas.value = response.data
}

onMounted(async () => {
  await getAreas();
})
</script>
<template>
  <AppLayout>
    <section class="px-4">
      <div class="bg-white p-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <Icon name="streamline:shipping-transfer-cart-package-box-fulfillment-cart-warehouse-shipping-delivery"
                  class="text-3xl text-primary"/>
            <h3 class="text-primary text-3xl font-semibold">Shipping</h3>
          </div>
          <div>
            <RouterLink to="/create-shipping" class="flex items-center gap-2 bg-primary text-white px-4 py-2 text-base">
              <Icon name="material-symbols:add-box-outline"/>
              Add New Shipping
            </RouterLink>
          </div>
        </div>
      </div>
    </section>
    <div class="mx-5 bg-white">
      <div class="relative overflow-x-auto">
        <LoadingButton v-if="loading" :isLoading="loading">Loading</LoadingButton>
        <table v-else class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-white  uppercase bg-primary dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">
              Area Name
            </th>
            <th scope="col" class="px-6 py-3">
              Area Code
            </th>
            <th scope="col" class="px-6 py-3">
              Delivery Charge
            </th>

            <th scope="col" class="px-6 py-3">
              Action
            </th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="area in areas?.data" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="px-6 py-4">
              {{ area?.area_name }}
            </td>
            <th class="px-6 py-4">
              {{ area?.area_code }}
            </th>
            <th class="px-6 py-4">
              Tk. {{ area?.delevery_charge }}
            </th>

            <td class="px-6 py-4">
              <div class="flex items-center gap-2">
                <RouterLink :to="`/edit-shipping/${area.id}`"
                            class="w-8 h-8 rounded-md flex items-center justify-center bg-yellow-400/10 border border-yellow-900">
                  <Icon name="material-symbols:edit-square-outline" class="text-lg text-yellow-900"/>
                </RouterLink>
                <DeleteButton :path="`/v1/shipping-area/${area.id}`" @deleted="getAreas()"/>
              </div>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>
