<script setup>
import {onMounted, ref} from 'vue';
import useAxios from "@/composables/useAxios"
import Pagination from '@/components/Pagination.vue';
import DeleteButton from "@/components/DeleteButton.vue";
import LoadingButton from "@/components/LoadingButton.vue";

const {loading, error, sendRequest} = useAxios();

//  get All brands and categories first
const categories = ref(null);
const brands = ref(null);


const getPrice = (product) =>{
  if(product?.variant){
    const variants = JSON.parse(product?.variant)
    return variants[0]?.price +' to '+ variants[variants.length - 1]?.price;
  }else{
    return product.price;
  }
}

const products = ref(null);

const getProducts = async (link) => {
  const res = await sendRequest({
    method: 'get',
    url: link ?? '/v1/product',
  });
  products.value = res?.data
}


onMounted(async () => await getProducts())
</script>
<template>
  <AppLayout>
    <section class="px-4">
      <div class="bg-white p-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <Icon name="carbon:ibm-data-product-exchange" class="text-lg text-primary"/>
            <h3 class="text-primary text-lg font-semibold">Products</h3>
          </div>
          <div>
            <RouterLink to="/create-product" class="bg-primary px-4 py-2 text-white flex items-center gap-2">
              <Icon name="material-symbols:add-box-outline"/>
              Add Record
            </RouterLink>
          </div>
        </div>
      </div>
    </section>

    <section class="">
      <div class="px-4 ">
        <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
          <div class="overflow-x-auto">
            <LoadingButton class="w-full items-center justify-center" v-if="loading" :isLoading="loading">Loading</LoadingButton>

            <table v-else class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr>
                <th scope="col" class="px-4 py-3">Product</th>
                <th scope="col" class="px-4 py-3">Category</th>
                <th scope="col" class="px-4 py-3">Stock</th>
                <th scope="col" class="px-4 py-3">Price</th>
                <th scope="col" class="px-4 py-3">Sales</th>
                <th scope="col" class="px-4 py-3">Action</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="product in products?.data"
                  class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                <th scope="row"
                    class="flex items-center px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  <img :src="product?.thumbnail" alt="iMac Front Image" class="w-auto h-8 mr-3">
                  {{ product?.title }}
                </th>
                <td class="px-4 py-2">
                  <span
                      class="bg-primary-100 text-primary-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-primary-900 dark:text-primary-300">{{
                      product?.category?.name
                    }}</span>
                </td>
                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  <div v-if="product?.stock <= 10" class="flex items-center">
                    <div class="inline-block w-4 h-4 mr-2 bg-red-700 rounded-full"></div>
                    {{ product?.stock }}
                  </div>
                  <div v-else-if="product?.stock >= 10 && product?.stock <= 30" class="flex items-center">
                    <div class="inline-block w-4 h-4 mr-2 bg-yellow-300 rounded-full"></div>
                    {{ product?.stock }}
                  </div>
                  <div v-else class="flex items-center w-full">
                    <div class="inline-block w-4 h-4 mr-2 bg-green-700 rounded-full"></div>
                    {{ product?.stock  }}
                  </div>
                </td>
                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  <p>Tk. {{ getPrice(product) }}</p>
                </td>
                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ product?.visited }}</td>

                <td class="px-6 py-4">
                  <div class="flex items-center gap-2">
<!--                    <RouterLink :to="`/product-detail/${product?.id}`"
                                class="w-8 h-8 rounded-md flex items-center justify-center bg-green-400/10 border border-green-900">
                      <Icon name="material-symbols:visibility-outline-rounded" class="text-xl text-green-900"/>
                    </RouterLink>-->
                    <RouterLink :to="`/edit-product/${product?.id}`"
                                class="w-8 h-8 rounded-md flex items-center justify-center bg-yellow-400/10 border border-yellow-900">
                      <Icon name="material-symbols:edit-square-outline" class="text-lg text-yellow-900"/>
                    </RouterLink>
                    <DeleteButton :path="`/v1/product/${product?.id}`" @deleted="getProducts()"/>
                  </div>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
          <Pagination @someEvent="getProducts" :to="products?.to" :from="products?.from" :total="products?.total"
                      :links="products?.links"/>
        </div>
      </div>
    </section>
  </AppLayout>
</template>
