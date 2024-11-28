<script setup>
import { onMounted, ref } from 'vue';
import useAxios from "@/composables/useAxios"
import { useAuthStore } from '@/stores/useAuthStore.js';
import {useToast} from "vue-toastification";
const toast = useToast();
import Pagination from '@/components/Pagination.vue'
import DeleteButton from "@/components/DeleteButton.vue";
import LoadingButton from "@/components/LoadingButton.vue";
import moment from 'moment';
const authStore = useAuthStore();
const { loading, error, sendRequest } = useAxios();
const messages= ref(null);

const getMessages = async() => {
  const response = await sendRequest({
    method: 'get',
    url: '/v1/get-in-touch',
  });
  messages.value = response.data
}

onMounted(async () => {
  await getMessages();
})
</script>
<template>
  <AppLayout>
    <section class="px-4">
      <div class="bg-white p-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-1">
            <Icon name="solar:chat-dots-bold-duotone" class="text-lg text-primary" />
            <h3 class="text-primary text-lg font-semibold">Messages</h3>
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
              Message
            </th>
            <th scope="col" class="px-6 py-3">
              Phone
            </th>
            <th scope="col" class="px-6 py-3">
              Email
            </th>
            <th scope="col" class="px-6 py-3">
              Date
            </th>
            <th scope="col" class="px-6 py-3">
              Action
            </th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="message in messages?.data" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
              <div class="w-10 h-10 bg-purple-700 rounded-full flex items-center justify-center">
                <span class="text-white text-xl">{{message?.name?.substring(0,1)  }}</span>
              </div>
              <div class="ps-2">
                <div class="text-sm font-semibold">{{message?.name  }}</div>
              </div>
            </th>
            <td class="px-6 py-4">
              {{ message?.message }}
            </td>
            <td class="px-6 py-4">
              {{ message?.phone }}
            </td>
            <td class="px-6 py-4">
              {{ message?.email }}
            </td>
            <td class="px-6 py-4">
              {{ moment(message?.created_at).format('MMMM Do YYYY, h:mm:ss a')}}
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-2">
                <DeleteButton :path="`/v1/delete-get-in-touch/${message?.id}`" @deleted="getMessages"/>
              </div>
            </td>
          </tr>
          </tbody>
        </table>
        <Pagination v-if="messages?.data?.length > 0" :links="messages?.meta?.links" :from="messages?.meta?.from" :to="messages?.meta?.to"
                    :total="messages?.meta?.total"/>
      </div>
    </div>
  </AppLayout>
</template>
