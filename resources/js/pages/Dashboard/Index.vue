<script setup>
    import BarChart from '@/components/Chart/BarChart.vue';
    import TopProducts from '@/components/TopProducts.vue';
    import RecentOrder from '@/components/RecentOrder.vue';
    import AppLayout from "@/components/Layouts/AppLayout.vue";
    import {useAuthStore} from "@/stores/useAuthStore.js";

    const {user} = useAuthStore()

</script>
<template>
    <AppLayout>
      <div class="py-4 px-6 flex flex-col gap-4 bg-teal-100 text-teal-900">
        <h1 class="font-bold text-4xl">Hello {{ user?.name }}</h1>
        <h1 class="font-semibold text-lg">WELCOME TO DASHBOARD</h1>
      </div>

<!--      <div class="flex flex-wrap -mx-1">
        <div class="w-1/5 p-1">
          <div
              class="
              h-full
              p-4
              overlay
              shadow
              bg-[url('https://img.freepik.com/free-photo/shopping-cart-with-presents_658428-64.jpg?t=st=1717409303~exp=1717412903~hmac=ef1e57a02078b8fd2419ceb6514a406d53a22fc5221264e8849fce08970214db&w=1060')]
                w-full bg-cover bg-no-repeat bg-center"
          >
            <div class="relative z-10 flex flex-col justify-between h-full">
              <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-slate-400/50 border border-gray-100 flex items-center justify-center">
                  <Icon name="hugeicons:money-receive-circle"  class="text-gray-100 text-3xl" />
                </div>
                <h3 class="text-end text-3xl font-medium text-white">$5000</h3>
              </div>
              <div>
                <p class=" text-gray-200 text-base text-end">Total Earning</p>
                <p class="text-end font-light text-sm text-gray-200">Compared Last Year</p>
              </div>
            </div>
          </div>
        </div>
        <div class="w-1/5 p-1">
          <div
              class="
              h-full
              p-4
                overlay
                shadow
                bg-[url('https://img.freepik.com/free-photo/shopping-cart-with-presents_658428-64.jpg?t=st=1717409303~exp=1717412903~hmac=ef1e57a02078b8fd2419ceb6514a406d53a22fc5221264e8849fce08970214db&w=1060')]
                  w-full bg-cover bg-no-repeat bg-center"
          >
            <div class="relative z-10 flex flex-col justify-between h-full">
              <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-slate-400/50 border border-gray-100 flex items-center justify-center">
                  <Icon name="ic:sharp-attach-money" class="text-gray-100 text-3xl" />
                </div>
                <h3 class="text-end text-3xl font-medium text-white">$89</h3>
              </div>
              <p class="text-gray-200 text-base text-end">Sale Today</p>
            </div>
          </div>
        </div>
        <div class="w-1/5 p-1">
          <div
              class="
              h-full
              p-4
                overlay
                shadow
                bg-[url('https://img.freepik.com/free-photo/shopping-cart-with-presents_658428-64.jpg?t=st=1717409303~exp=1717412903~hmac=ef1e57a02078b8fd2419ceb6514a406d53a22fc5221264e8849fce08970214db&w=1060')]
                  w-full bg-cover bg-no-repeat bg-center"
          >
            <div class="relative z-10 flex flex-col justify-between h-full">
              <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-slate-400/50 border border-gray-100 flex items-center justify-center">
                  <Icon name="ic:outline-shopping-cart-checkout" class="text-gray-100 text-2xl" />
                </div>
                <h3 class="text-end text-3xl font-medium text-white">15</h3>
              </div>
              <div>
                <p class="text-white text-base text-end">New Order</p>
                <p class="text-end font-light text-sm text-white">Compared Last Week</p>
              </div>
            </div>
          </div>
        </div>
        <div class="w-1/5 p-1">
          <div
              class="
              h-full
              p-4
                overlay
                shadow
                bg-[url('https://img.freepik.com/free-photo/shopping-cart-with-presents_658428-64.jpg?t=st=1717409303~exp=1717412903~hmac=ef1e57a02078b8fd2419ceb6514a406d53a22fc5221264e8849fce08970214db&w=1060')]
                  w-full bg-cover bg-no-repeat bg-center"
          >
            <div class="relative z-10 flex flex-col justify-between h-full">
              <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-slate-400/50 border border-gray-100 flex items-center justify-center">
                  <Icon name="tabler:shopping-cart-up" class="text-gray-100 text-2xl" />
                </div>
                <h3 class="text-end text-3xl font-medium text-white">25</h3>
              </div>
              <p class="text-white text-base text-end">Pending Order</p>
            </div>
          </div>
        </div>
        <div class="w-1/5 p-1">
          <div
              class="
              h-full
              p-4
                overlay
                shadow
                bg-[url('https://img.freepik.com/free-photo/shopping-cart-with-presents_658428-64.jpg?t=st=1717409303~exp=1717412903~hmac=ef1e57a02078b8fd2419ceb6514a406d53a22fc5221264e8849fce08970214db&w=1060')]
                  w-full bg-cover bg-no-repeat bg-center"
          >
            <div class="relative z-10 flex flex-col justify-between h-full">
              <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-slate-400/50 border border-gray-100 flex items-center justify-center">
                  <Icon name="hugeicons:shopping-basket-check-out-03" class="text-gray-100 text-3xl" />
                </div>
                <h3 class="text-end text-3xl font-medium text-white">128</h3>
              </div>
              <p class="text-white text-base text-end">Total Products</p>
            </div>
          </div>
        </div>
        <div class="w-3/5 p-1">
          <div class="bg-primary h-full p-3">
            <h3 class="text-white text-sm font-normal">Good Afternoon,</h3>
            <div class="flex items-center py-2 gap-2">
              <img class="w-8 h-8 rounded-full" src="https://img.freepik.com/free-vector/businessman-character-avatar-isolated_24877-60111.jpg?uid=R102446229&ga=GA1.1.1386564851.1716744340&semt=sph" alt="">
              <div>
                <h3 class="text-white font-medium text-sm">Tushar Imran</h3>
                <p class="text-xs font-normal text-white">Admin</p>
              </div>
            </div>
            <div class="flex items-center">
              <p class="text-xs font-normal text-white w-1/2">Have a nice day! Did you know that you can quickly add your favorite product or category?</p>
            </div>
          </div>
        </div>
        <div class="w-1/5 p-1">
          <div
              class="
              h-full
              p-4
                overlay
                shadow
                bg-[url('https://img.freepik.com/free-photo/shopping-cart-with-presents_658428-64.jpg?t=st=1717409303~exp=1717412903~hmac=ef1e57a02078b8fd2419ceb6514a406d53a22fc5221264e8849fce08970214db&w=1060')]
                  w-full bg-cover bg-no-repeat bg-center"
          >
            <div class="relative z-10 flex flex-col justify-between h-full gap-4">
              <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-slate-400/50 border border-gray-100 flex items-center justify-center">
                  <Icon name="hugeicons:shopping-basket-check-out-03" class="text-gray-100 text-3xl" />
                </div>
                <h3 class="text-end text-3xl font-medium text-white">128</h3>
              </div>
              <p class="text-white text-base text-end">Total Customer</p>
            </div>
          </div>
        </div>
        <div class="w-1/5 p-1">
          <div
              class="
              h-full
              p-4
                overlay
                shadow
                bg-[url('https://img.freepik.com/free-photo/shopping-cart-with-presents_658428-64.jpg?t=st=1717409303~exp=1717412903~hmac=ef1e57a02078b8fd2419ceb6514a406d53a22fc5221264e8849fce08970214db&w=1060')]
                  w-full bg-cover bg-no-repeat bg-center"
          >
            <div class="relative z-10 flex flex-col justify-between gap-4 h-full">
              <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-slate-400/50 border border-gray-100 flex items-center justify-center">
                  <Icon name="hugeicons:shopping-basket-check-out-03" class="text-gray-100 text-3xl" />
                </div>
                <h3 class="text-end text-3xl font-medium text-white">128</h3>
              </div>
              <p class="text-white text-base text-end">Total Cancel Orders</p>
            </div>
          </div>
        </div>
      </div>  

      <div class="flex mt-4 mx-2" >
          <div class="w-2/3 px-2">
              <div class="p-4 shadow bg-white">
                  <BarChart />
              </div>
          </div>
          <div class="w-1/3 px-2">
              <div class="shadow bg-white">
                  <TopProducts />
              </div>
          </div>
      </div>

      <div class="mt-5 mx-4 bg-white">
        <RecentOrder />
    </div>-->
    </AppLayout>
</template>
