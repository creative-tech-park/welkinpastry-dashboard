<script setup>
import {useAuthStore} from '@/stores/useAuthStore.js';
import useAxios from '@/composables/useAxios';

import {useRoute} from 'vue-router';
import {ref, onMounted, watch} from 'vue';
import {useToast} from "vue-toastification";
import moment from "moment";
import LoadingButton from "@/components/LoadingButton.vue";

const toast = useToast();
const {loading, error, sendRequest} = useAxios();
const authStore = useAuthStore();
const route = useRoute();

const changeOrderStatus = async (status, type = 'order') => {
  const response = await sendRequest({
    method: 'POST',
    url: `/v1/order-status/${route.params.id}`,
    data: {
      type: type,
      status: status,
    }
  });

  toast.success('Status Updated Successfully', {autoClose: 500});

  await getOrder()

}

const order = ref({})
const getOrder = async () => {
  const response = await sendRequest({
    url: `/v1/order/${route.params.id}`,
    method: "GET"
  })
  order.value = response.data
}


const printInvoice = (areaID) => {
  const printContent = document.getElementById(areaID).cloneNode(true);
  const printContainer = document.createElement('div');
  printContainer.style.position = 'absolute';
  printContainer.style.top = '-9999px';
  printContainer.appendChild(printContent);
  document.body.appendChild(printContainer);
  window.print();
  document.body.removeChild(printContainer);
}

const settings = ref([])
const getSettings = async () => {
  const response = await sendRequest({
    url: "/v1/get-settings?name=profile,social,hero,counter",
    method: "GET"
  })
  settings.value = response.data
}
onMounted(async () => {
  await getSettings()
  await getOrder();
})
</script>
<template>
  <AppLayout>
    <div class="mx-auto grid grid-cols-12 items-start gap-5">
      <div class="col-span-8 p-6 bg-white rounded shadow-sm my-6" id="printable-area">
        <div class="grid grid-cols-2 items-center">
          <div>
            <img class="w-32 h-auto p-2"  src="@/assets/images/logo.png" alt="">
          </div>
          <div class="text-right">
            <p>
              {{ settings?.profile?.name }}
            </p>
            <p class="text-gray-500 text-sm">
              {{ settings?.profile?.email }}
            </p>
            <p class="text-gray-500 text-sm mt-1">
              {{ settings?.profile?.phone }}
            </p>
          </div>
        </div>

        <!-- Client info -->
        <div class="grid grid-cols-2 items-center mt-8">
          <div>
            <p class="font-bold text-gray-800">
              Bill to :
            </p>
            <p class="text-gray-500">
              Name: {{ order?.customer?.name }}
              <br/>
              Address: {{ order?.address?.address }}
            </p>
            <p class="text-gray-500">
              Phone: {{ order?.customer?.phone }}
            </p>
            <p class="text-gray-500">
              Phone: {{ order?.address?.phone }}
            </p>
          </div>

          <div class="text-right">
            <span>#INV-{{ order.id + moment(order.created_at)?.format('DDMMYYYY') }}</span>

            <p>
              Order date: <span class="text-gray-500">{{ moment(order?.created_at).format('DD/MM/YYYY') }}</span>
              <br/>
              Invoice date:<span class="text-gray-500">{{ moment().format('DD/MM/YYYY') }}</span>
            </p>
            <p class="mt-3">Order Status: <span
                class="px-3 py-1 bg-primary/90 text-white font-semibold text-sm rounded-lg capitalize print:bg-yellow-400 print:text-red-500">{{
                order?.order_status
              }}</span></p>
            <p class="mt-3">Payment Status: <span
                class="status-btn px-3 py-1 bg-orange-400 text-white font-semibold text-sm rounded-lg capitalize">{{
                order?.payment_status
              }}</span></p>
          </div>
        </div>
        <!-- Invoice Items -->
        <div class="-mx-4 mt-8 flow-root sm:mx-0">
          <table class="min-w-full">
            <colgroup>
              <col class="w-full sm:w-1/2">
              <col class="sm:w-1/6">
              <col class="sm:w-1/6">
              <col class="sm:w-1/6">
            </colgroup>
            <thead class="border-b border-gray-300 text-gray-900">
            <tr>
              <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Items</th>
              <th scope="col" class="hidden px-3 py-3.5 text-right text-sm font-semibold text-gray-900 sm:table-cell">
                Quantity
              </th>
              <th scope="col" class="hidden px-3 py-3.5 text-right text-sm font-semibold text-gray-900 sm:table-cell">
                Price
              </th>
              <th scope="col" class="py-3.5 pl-3 pr-4 text-right text-sm font-semibold text-gray-900 sm:pr-0">Amount
              </th>
            </tr>
            </thead>
            <tbody>
            <tr class="border-b border-gray-200" v-for="details in order?.order_details">
              <td class="max-w-0 py-5 pl-4 pr-3 text-sm sm:pl-0">
                <div class="font-medium text-gray-900">{{ details?.product?.title }}</div>
                <div class="mt-1 truncate text-gray-500" v-if="JSON.parse(details?.product_variant)?.weight">
                  Variant: {{ JSON.parse(details?.product_variant)?.weight }}
                </div>
                <div class="mt-2" v-if="JSON.parse(details?.product_variant)?.message">
                  Message: {{ JSON.parse(details?.product_variant)?.message }}
                </div>
              </td>
              <td class="hidden px-3 py-5 text-right text-sm text-gray-500 sm:table-cell">{{ details?.quantity }}</td>
              <td class="hidden px-3 py-5 text-right text-sm text-gray-500 sm:table-cell">Tk. {{ details?.product_price }}</td>
              <td class="py-5 pl-3 pr-4 text-right text-sm text-gray-500 sm:pr-0">Tk. {{ parseInt(details?.quantity) * parseInt(details?.product_price) }}</td>
            </tr>

            </tbody>
            <tfoot>
            <tr>
              <th scope="row" colspan="3"
                  class="hidden pl-4 pr-3 pt-6 text-right text-sm font-normal text-gray-500 sm:table-cell sm:pl-0">
                Subtotal
              </th>
              <th scope="row" class="pl-6 pr-3 pt-6 text-left text-sm font-normal text-gray-500 sm:hidden">Subtotal</th>
              <td class="pl-3 pr-6 pt-6 text-right text-sm text-gray-500 sm:pr-0">Tk. {{ order?.sub_total }}</td>
            </tr>
            <tr>
              <th scope="row" colspan="3"
                  class="hidden pl-4 pr-3 pt-4 text-right text-sm font-normal text-gray-500 sm:table-cell sm:pl-0">
                Delivery Charge
              </th>
              <th scope="row" class="pl-6 pr-3 pt-4 text-left text-sm font-normal text-gray-500 sm:hidden">Delivery
                Charge
              </th>
              <td class="pl-3 pr-6 pt-4 text-right text-sm text-gray-500 sm:pr-0">Tk.
                {{ order?.address?.order_area?.delevery_charge }}
              </td>
            </tr>

            <tr>
              <th scope="row" colspan="3"
                  class="hidden pl-4 pr-3 pt-4 text-right text-sm font-semibold text-gray-900 sm:table-cell sm:pl-0">
                Total
              </th>
              <th scope="row" class="pl-6 pr-3 pt-4 text-left text-sm font-semibold text-gray-900 sm:hidden">Total</th>
              <td class="pl-3 pr-4 pt-4 text-right text-sm font-semibold text-gray-900 sm:pr-0">Tk.
                {{ parseInt(order?.address?.order_area?.delevery_charge) + parseInt(order?.sub_total) }}
              </td>
            </tr>
            </tfoot>
          </table>
        </div>

        <!--  Footer  -->
        <div class="border-t-2 pt-4 text-xs text-gray-500 text-center mt-16">
          This is computer generated invoice no signature required
        </div>

      </div>

      <div v-if="loading" class="col-span-4 p-6 bg-white rounded shadow-sm my-6">
        <LoadingButton :isLoading="loading">Loading</LoadingButton>
      </div>
      <div v-else class="col-span-4 p-6 bg-white rounded shadow-sm my-6">
        <div class="flex justify-between items-center">
          <p class="font-semibold text-lg">Invoice Action</p>
          <RouterLink to="/order"
                      class="flex gap-1 items-center border bg-gray-50 px-3 py-1 rounded-lg active:bg-gray-200 transition-all ease-in-out duration-100">
            <Icon name="material-symbols:arrow-left-alt" class="text-gray-700" size="50"/>
            <span class="text-sm">Back</span>
          </RouterLink>
        </div>
        <div class="mt-7">
          <button @click="printInvoice('printable-area')"
                  class="flex gap-3 w-full items-center justify-center font-semibold px-3 py-2 bg-primary rounded-lg text-white">
            <Icon name="solar:download-minimalistic-bold-duotone" class="text-lg text-white"/>
            <span>Download Invoice</span>
          </button>
          <div class="mt-7">
            <h1 class="text-lg font-semibold capitalize">order Status</h1>
            <ul class="flex gap-2 flex-wrap mt-2">
              <li class="cursor-pointer capitalize font-semibold px-4 py-1 rounded-lg border"
                  @click="changeOrderStatus('pending')"
                  :class="order?.order_status === 'pending' ? 'bg-purple-500 text-white' :'bg-purple-50 border-gray-100 '">
                pending
              </li>
              <li class="cursor-pointer capitalize font-semibold px-4 py-1 rounded-lg border"
                  @click="changeOrderStatus('received')"
                  :class="order?.order_status === 'received' ? 'bg-yellow-500 text-white' :'bg-yellow-50 border-yellow-100 '">
                received
              </li>
              <li class="cursor-pointer capitalize font-semibold px-4 py-1 rounded-lg border"
                  @click="changeOrderStatus('process')"
                  :class="order?.order_status === 'process' ? 'bg-orange-500 text-white' :'bg-orange-50 border-orange-100 '">
                process
              </li>
              <li class="cursor-pointer capitalize font-semibold px-4 py-1 rounded-lg border"
                  @click="changeOrderStatus('shipped')"
                  :class="order?.order_status === 'shipped' ? 'bg-pink-500 text-white' :'bg-pink-50 border-pink-100 '">
                shipped
              </li>
              <li class="cursor-pointer capitalize font-semibold px-4 py-1 rounded-lg border"
                  @click="changeOrderStatus('delivered')"
                  :class="order?.order_status === 'delivered' ? 'bg-green-500 text-white' :'bg-green-50 border-green-100 '">
                delivered
              </li>
              <li class="cursor-pointer capitalize font-semibold px-4 py-1 rounded-lg border"
                  @click="changeOrderStatus('cancel')"
                  :class="order?.order_status === 'cancel' ? 'bg-red-500 text-white' :'bg-red-50 border-red-100 '">
                cancel
              </li>
            </ul>
          </div>
          <div class="mt-7">
            <h1 class="text-lg font-semibold capitalize">payment Status</h1>
            <ul class="flex gap-2 flex-wrap mt-2">
              <li class="cursor-pointer capitalize font-semibold px-4 py-1 rounded-lg border"
                  @click="changeOrderStatus('paid', 'payment')"
                  :class="order?.payment_status === 'paid' ? 'bg-purple-500 text-white' :'bg-purple-50 border-gray-100 '">
                paid
              </li>
              <li class="cursor-pointer capitalize font-semibold px-4 py-1 rounded-lg border"
                  @click="changeOrderStatus('pending', 'payment')"
                  :class="order?.payment_status === 'pending' ? 'bg-yellow-500 text-white' :'bg-yellow-50 border-yellow-100 '">
                pending
              </li>
              <li class="cursor-pointer capitalize font-semibold px-4 py-1 rounded-lg border"
                  @click="changeOrderStatus('cancelled', 'payment')"
                  :class="order?.payment_status === 'cancelled' ? 'bg-orange-500 text-white' :'bg-orange-50 border-orange-100 '">
                canclled
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

  </AppLayout>
</template>

