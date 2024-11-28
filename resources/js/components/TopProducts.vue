<template>
<div class="relative overflow-x-auto">
          <h3 class="text-base font-medium p-2  text-black">Top Products</h3>
          <table class="w-full text-sm text-left rtl:text-right text-black">

            <thead class="text-xs text-white uppercase bg-secondary border-b bg-primary">
            <tr>
              <th scope="col" class="px-16 py-3">
                <span class="sr-only">Image</span>
              </th>
              <th scope="col" class="px-6 py-3">
                Product
              </th>
              <th scope="col" class="px-6 py-3 ">
                Price
              </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="p in 5" class="border-b border-gray-300">
              <td class="py-1 px-6">
                <img  src="https://www.apple.com/v/watch/bm/images/overview/select/product_se__frx4hb13romm_large_2x.png" class="w-10 max-w-full max-h-full" alt="Apple Watch">
              </td>
              <td class="px-6 py-1 font-semibold text-xs">
                Apple Watch
              </td>
              <td class="px-6 py-1 font-semibold text-xs">
                $599
              </td>
            </tr>
            
            </tbody>
          </table>
        </div>
</template>