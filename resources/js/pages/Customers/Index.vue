<script setup>
    import { onMounted, ref } from 'vue';
    import useAxios from "@/composables/useAxios"
    import { useAuthStore } from '@/stores/useAuthStore.js';
    import {useToast} from "vue-toastification";
    const toast = useToast();
    import Pagination from '@/components/Pagination.vue'
    import DeleteButton from "@/components/DeleteButton.vue";
    import LoadingButton from "@/components/LoadingButton.vue";
    const authStore = useAuthStore();
    const { loading, error, sendRequest } = useAxios();

    const customers= ref(null);

    const getCustomers = async() => {
        const response = await sendRequest({
            method: 'get',
            url: '/v1/customer',
        });
        customers.value = response.data
    }

    onMounted(async () => {
      await getCustomers();
    })
</script>
<template>
    <AppLayout>
        <section class="px-4">
            <div class="bg-white p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1">
                        <Icon name="gis:globe-users" class="text-lg text-primary" />
                        <h3 class="text-primary text-lg font-semibold">Customers</h3>
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
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Phone
                </th>
                <th scope="col" class="px-6 py-3">
                    Email
                </th>
                <th scope="col" class="px-6 py-3">
                    Address
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="customer in customers?.data" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                    <div class="w-10 h-10 bg-purple-700 rounded-full flex items-center justify-center">
                    <span class="text-white text-xl">{{customer?.name?.substring(0,1)  }}</span>
                    </div>
                    <div class="ps-2">
                        <div class="text-sm font-semibold">{{customer?.name  }}</div>
                    </div>
                </th>
                <td class="px-6 py-4">
                    {{ customer?.phone }}
                </td>
                <td class="px-6 py-4">
                    {{ customer?.email }}
                </td>
                <td class="px-6 py-4">
                    {{ customer?.orders_count }}
                </td>
                <td class="px-6 py-4">
                <div class="flex items-center gap-2">
<!--                    <button class="w-8 h-8 rounded-md flex items-center justify-center bg-green-400/10 border border-green-900">
                        <Icon  name="material-symbols:visibility-outline-rounded" class="text-xl text-green-900" />
                    </button>
                    <button class="w-8 h-8 rounded-md flex items-center justify-center bg-yellow-400/10 border border-yellow-900">
                        <Icon name="material-symbols:edit-square-outline" class="text-lg text-yellow-900" />
                    </button>-->
                  <DeleteButton :path="`/v1/customer/${customer?.id}`" @deleted="getCustomers"/>
                </div>
                </td>
                </tr>
                </tbody>
            </table>
            <Pagination v-if="customers?.data?.length > 0" :links="customers?.meta?.links" :from="customers?.meta?.from" :to="customers?.meta?.to"
                :total="customers?.meta?.total"/>
        </div>
    </div>
    </AppLayout>
</template>
