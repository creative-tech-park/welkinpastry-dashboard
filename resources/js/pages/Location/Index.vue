  <script setup>
import {onMounted, ref} from 'vue';
import useAxios from "@/composables/useAxios"
import LoadingButton from "@/components/LoadingButton.vue";
import DeleteButton from "@/components/DeleteButton.vue";

const {sendRequest, loading, error} = useAxios();
const locations = ref([])
const getLocations = async (search = null) => {
  const response = await sendRequest({
    url: "/v1/location",
    params: {
      search: search
    },
    method: 'GET'
  })
  locations.value = response.data
}
onMounted(async () => await getLocations())


</script>
<template>
  <AppLayout>

    <section class="px-4">
      <div class="bg-white p-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <Icon name="tabler:category" class="text-3xl text-primary"/>
            <h3 class="text-primary text-3xl font-semibold">Locations</h3>
          </div>
          <div>
            <RouterLink :to="{name:'CreateLocations'}" class="bg-primary text-white px-5 py-2 flex items-center gap-2">
              <Icon name="material-symbols:add-box-outline"/>
              Add Record
            </RouterLink>
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
                     placeholder="Search for Categories">
            </div>
          </div>

          <div class="flex items-center gap-3">
            Rows: <Select
              class="w-20"
              placeholder="25"
              :options="[5, 10, 15, 20, 25]"
          ></Select>
          </div>
        </div>
      </div>
    </section>
    <div v-if="loading">
        <LoadingButton :isLoading="loading"/>
    </div>
    <div class="mx-5 bg-white" v-else>
      <div class="relative overflow-x-auto">
        <LoadingButton class="w-full items-center justify-center" v-if="loading" :isLoading="loading">Loading</LoadingButton>

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-white  uppercase bg-primary dark:bg-gray-700 dark:text-gray-400">
          <tr>

            <th scope="col" class="px-6 py-3">
              Name
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
          <tr v-for="location in locations" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

            <th class=" px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
              <div>
                <div class="text-base font-medium">{{ location?.name }}</div>
              </div>
            </th>

            <th class=" px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
              <div>
                <div class="text-base font-medium">{{ location?.full_address }}</div>
              </div>
            </th>

            <td class="px-6 py-4">
              <div class="flex items-center gap-2">
                <RouterLink :to="{name:'EditLocations', params:{id:location?.id}}"
                            class="w-8 h-8 rounded-md flex items-center justify-center bg-yellow-400/10 border border-yellow-900">
                  <Icon name="material-symbols:edit-square-outline" class="text-lg text-yellow-900"/>
                </RouterLink>
                <DeleteButton :path="`/v1/location/${location.id}`" @deleted="getLocations()"/>
              </div>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>

 </AppLayout>
</template>
