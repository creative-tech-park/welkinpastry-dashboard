<script setup>
import AppLayout from "@/components/Layouts/AppLayout.vue";
import {ref, onMounted} from 'vue';
import {useAuthStore} from '@/stores/useAuthStore.js';
import useAxios from '@/composables/useAxios';
import LoadingButton from "@/components/LoadingButton.vue";
import moment from "moment";

const {loading, error, sendRequest} = useAxios();
const authStore = useAuthStore();

const orders = ref(null);
const getOrder = async () => {
  const response = await sendRequest({
    method: 'get',
    url: '/v1/order',
    headers: {
      authorization: `Bearer ${authStore.user.token}`,
    }
  })

  orders.value = response.data;
}

onMounted(() => {
  getOrder();
})
</script>
<template>
  <AppLayout>
    <section class="px-4">
      <div class="bg-white p-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-1">
            <Icon name="material-symbols:shopping-cart-outline-sharp" class="text-lg text-primary"/>
            <h3 class="text-primary text-lg font-semibold">Order</h3>
          </div>
        </div>
        <div class="flex items-center justify-between">
          <div
              class="flex items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4 bg-white dark:bg-gray-900">
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
              <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-primary dark:text-gray-400" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
              </div>
              <input type="text" id="table-search-users"
                     class="block p-2 ps-10 text-sm text-gray-900 border border-primary rounded-lg w-96 bg-gray-50 focus:ring-primary focus:border-primary"
                     placeholder="Search for Order">
            </div>
          </div>

          <div class="flex items-center gap-3">
            Rows: <select name="" id="" class="p-1 rounded-md border border-gray-300">
            <option value="">5</option>
            <option value="">10</option>
            <option value="">15</option>
            <option value="">20</option>
          </select>
          </div>
        </div>
      </div>
    </section>
    <div class="mx-5 bg-white">
      <div class="overflow-x-auto">
        <LoadingButton class="w-full" v-if="loading" :isLoading="loading">Loading</LoadingButton>

        <table v-else class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-white  uppercase bg-primary">
          <tr>
            <th scope="col" class="p-3">
              Id
            </th>
            <th scope="col" class="p-3">
              Customer
            </th>
            <th scope="col" class="p-3">
              Total
            </th>
            <th scope="col" class="p-3">
              Order Status
            </th>
            <th scope="col" class="p-3">
              Payment Status
            </th>
            <th scope="col" class="p-3">
              Payment Method
            </th>
            <th scope="col" class="p-3">
              Order date
            </th>
            <th scope="col" class="p-3">
              Action
            </th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="order in orders?.data?.data" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <th class="p-3">
              <span class="text-red-600">{{ order?.id }}</span>
            </th>
            <th scope="row" class="p-3 text-gray-900 whitespace-nowrap dark:text-white">
              <div class="flex items-center gap-2">
                <div class="w-10 h-10 flex items-center justify-center bg-blue-500 rounded-full text-white text-lg">
                  {{ order?.customer?.name[0] }}
                </div>
                <div class="text-base font-semibold">{{ order?.customer?.name }}</div>
              </div>
            </th>
            <td class="p-3">
              <div class="flex items-center">
                Tk. <p>{{ order?.grand_total }}</p>
              </div>
            </td>
            <td class="p-3">
              <div class="flex justify-center">
                <p class="rounded  text-yellow-500 text-xs font-medium px-3 py-1 text-center">{{
                    order?.order_status
                  }}</p>
              </div>
            </td>
            <td class="p-3">
              <div class="flex justify-center">
                <p class="rounded  text-green-400 text-xs font-semibold px-3 py-1 text-center">{{
                    order?.payment_status
                  }}</p>
              </div>
            </td>
            <td class="p-3">
              <div class="flex items-center">
                <p>{{ order?.payment_method }}</p>
              </div>
            </td>
            <td class="p-3">
              <div class="flex items-center">
                <p>{{ moment(order.created_at)?.format('MM-DD-YYYY') }}</p>
              </div>
            </td>

            <td class="p-3">
              <div class="flex items-center gap-2">
                <RouterLink :to="`/order-detail/${order?.id}`" class="">
                  <Icon name="material-symbols:arrow-forward-ios-rounded" class="text-xl text-green-900"/>
                </RouterLink>
              </div>
            </td>
          </tr>
          </tbody>
        </table>
        <Pagination/>
      </div>
    </div>
  </AppLayout>
</template>
