<script setup>
import { ref } from "vue";

const props = defineProps({
  text: {
    type: Boolean,
    default: true,
  },
});

const isDashboardLinks = ref(false);
const isProductsLinks = ref(false);
const isCmsLinks = ref(false);
const isOrderLinks = ref(false);
const isUserLinks = ref(false);
const isCustomCakeLinks = ref(false);
const isSettingLinks = ref(false);
</script>

<template>
  <div class="relative">
    <div class="rounded-lg m-3 mb-5 shadow-2xl flex items-center w-full px-4">
      <img
        src="@/assets/images/logo.png"
        class="w-16 flex items-center h-auto"
      />
    </div>
    <ul class="flex flex-col gap-5 pl-5">
      <!-- Dashboard  -->
      <!--
      <li>
        <div
            class="group flex items-center gap-3  rounded-lg transition-all ease-in-out duration-300 cursor-pointer relative"
            @click="isDashboardLinks = !isDashboardLinks">
          <div class=" w-7 h-7 bg-slate-400/50 border border-gray-100/50 rounded-full flex items-center justify-center">
            <Icon name="material-symbols:background-grid-small" class="text-sm text-white"/>
          </div>
          <span class="text-white text-sm font-normal transition-all ease-in-out duration-300">Dashboard</span>
          <div class="absolute top-1/2 -translate-y-1/2 right-2 transition-all  ease-in-out duration-300"
               :class="{'rotate-90 ' : isDashboardLinks}">
            <Icon name="ic:twotone-keyboard-arrow-right" class="text-white transition-all ease-in-out duration-300"/>
          </div>
        </div>
        <div class="overflow-hidden">
          <ul class="shop-links flex flex-col gap-4 pl-4 py-4" :class="{'shop-links&#45;&#45;active' : isDashboardLinks}">
            <li>
              <RouterLink to="/dashboard" class="flex items-center gap-3 ">
                <Icon name="material-symbols-light:circles-outline" class="text-white"/>
                <span class="text-sm text-white">Dashboard</span>
              </RouterLink>
            </li>
&lt;!&ndash;            <li>
              <RouterLink to="/analytics" class="flex items-center gap-3 ">
                <Icon name="material-symbols-light:circles-outline" class="text-white"/>
                <span class="text-sm text-white">Analytics</span>
              </RouterLink>
            </li>&ndash;&gt;
          </ul>
        </div>
      </li>
-->

      <!-- Dashboard End -->

      <li>
        <RouterLink to="/dashboard" class="flex items-center gap-2">
          <div
            class="w-8 h-8 bg-slate-400/50 border border-gray-100/50 rounded-full flex items-center justify-center"
          >
            <Icon name="mdi:point-of-sale" size="20" class="text-white" />
          </div>
          <p v-if="text" class="text-white text-sm">Dashboard</p>
        </RouterLink>
      </li>

      <!-- Products  -->
      <li>
        <div
          class="group flex items-center gap-3 rounded-lg transition-all ease-in-out duration-300 cursor-pointer relative"
          @click="isProductsLinks = !isProductsLinks"
        >
          <div
            class="w-7 h-7 bg-slate-400/50 border border-gray-100/50 rounded-full flex items-center justify-center"
          >
            <Icon
              name="carbon:ibm-data-product-exchange"
              class="text-sm text-white"
            />
          </div>
          <span
            class="text-white text-sm font-normal transition-all ease-in-out duration-300"
            >Products</span
          >
          <div
            class="absolute top-1/2 -translate-y-1/2 right-2 transition-all ease-in-out duration-300"
            :class="{ 'rotate-90 ': isProductsLinks }"
          >
            <Icon
              name="ic:twotone-keyboard-arrow-right"
              size="20"
              class="text-white transition-all ease-in-out duration-300"
            />
          </div>
        </div>
        <div class="overflow-hidden">
          <ul
            class="shop-links flex flex-col gap-4 pl-4 py-4"
            :class="{ 'shop-links--active': isProductsLinks }"
          >
            <li>
              <RouterLink to="/products" class="flex items-center gap-3">
                <Icon
                  name="material-symbols-light:circles-outline"
                  class="text-white"
                />
                <span class="text-sm text-white">Products</span>
              </RouterLink>
            </li>
            <li>
              <RouterLink to="/category" class="flex items-center gap-3">
                <Icon
                  name="material-symbols-light:circles-outline"
                  class="text-white"
                />
                <span class="text-sm text-white">Category</span>
              </RouterLink>
            </li>
            <!--            <li>
              <RouterLink to="/locations" class="flex items-center gap-3 ">
                <Icon name="material-symbols-light:circles-outline" class="text-white"/>
                <span class="text-sm text-white">Location</span>
              </RouterLink>
            </li>-->
            <!-- <li>
                <RouterLink to="/brand" class="flex items-center gap-3 ">
                    <Icon name="material-symbols-light:circles-outline" class="text-white" />
                    <span class="text-sm text-white">Brand</span>
                </RouterLink>
            </li>
            <li>
              <RouterLink to="/product/variations" class="flex items-center gap-3 ">
                <Icon name="material-symbols-light:circles-outline" class="text-white"/>
                <span class="text-sm text-white">Variations</span>
              </RouterLink>
            </li>
            <li>
              <RouterLink to="/stock" class="flex items-center gap-3 ">
                <Icon name="material-symbols-light:circles-outline" class="text-white"/>
                <span class="text-sm text-white">Stock</span>
              </RouterLink>
            </li> -->
          </ul>
        </div>
      </li>
      <!-- Products End -->

      <!-- Order  -->
      <!--      <li>
        <div
            class="group flex items-center gap-3  rounded-lg transition-all ease-in-out duration-300 cursor-pointer relative"
            @click="isOrderLinks = !isOrderLinks">
          <div class=" w-7 h-7 bg-slate-400/50 border border-gray-100/50 rounded-full flex items-center justify-center">
            <Icon name="carbon:ibm-data-product-exchange" size="20" class="text-white"/>
          </div>
          <span class="text-white text-sm font-normal transition-all ease-in-out duration-300">Order</span>
          <div class="absolute top-1/2 -translate-y-1/2 right-2 transition-all  ease-in-out duration-300"
               :class="{'rotate-90 ' : isOrderLinks}">
            <Icon name="ic:twotone-keyboard-arrow-right" size="20"
                  class="text-white transition-all ease-in-out duration-300"/>
          </div>
        </div>
        <div class="overflow-hidden">
          <ul class="shop-links flex flex-col gap-4 pl-4 py-4" :class="{'shop-links&#45;&#45;active' : isOrderLinks}">
            <li>
              <RouterLink to="/order" class="flex items-center gap-3 ">
                <Icon name="material-symbols-light:circles-outline" class="text-white"/>
                <span class="text-sm text-white">Orders</span>
              </RouterLink>
            </li>
            &lt;!&ndash; <li>
                <RouterLink to="/order/refund-request" class="flex items-center gap-3 ">
                    <Icon name="material-symbols-light:circles-outline" class="text-white" />
                    <span class="text-sm text-white">Refund Request</span>
                </RouterLink>
            </li> &ndash;&gt;
            <li>
              <RouterLink to="/shipping" class="flex items-center gap-3 ">
                <Icon name="material-symbols-light:circles-outline" class="text-white"/>
                <span class="text-sm text-white">Shipping Area</span>
              </RouterLink>
            </li>
          </ul>
        </div>
      </li>-->
      <!-- Order End -->

      <!-- Users  -->
      <li>
        <div
          class="group flex items-center gap-3 rounded-lg transition-all ease-in-out duration-300 cursor-pointer relative"
          @click="isUserLinks = !isUserLinks"
        >
          <div
            class="w-7 h-7 bg-slate-400/50 border border-gray-100/50 rounded-full flex items-center justify-center"
          >
            <Icon
              name="carbon:ibm-data-product-exchange"
              size="20"
              class="text-white"
            />
          </div>
          <span
            class="text-white text-sm font-normal transition-all ease-in-out duration-300"
            >Users</span
          >
          <div
            class="absolute top-1/2 -translate-y-1/2 right-2 transition-all ease-in-out duration-300"
            :class="{ 'rotate-90 ': isUserLinks }"
          >
            <Icon
              name="ic:twotone-keyboard-arrow-right"
              size="20"
              class="text-white transition-all ease-in-out duration-300"
            />
          </div>
        </div>
        <div class="overflow-hidden">
          <ul
            class="shop-links flex flex-col gap-4 pl-4 py-4"
            :class="{ 'shop-links--active': isUserLinks }"
          >
            <!--
            <li>
              <RouterLink to="/admin" class="flex items-center gap-3 ">
                <Icon name="material-symbols-light:circles-outline" class="text-white"/>
                <span class="text-sm text-white">Admin</span>
              </RouterLink>
            </li><li>
                <RouterLink to="/manager" class="flex items-center gap-3 ">
                    <Icon name="material-symbols-light:circles-outline" class="text-white" />
                    <span class="text-sm text-white">Manager</span>
                </RouterLink>
            </li> -->
            <li>
              <RouterLink to="/customers" class="flex items-center gap-3">
                <Icon
                  name="material-symbols-light:circles-outline"
                  class="text-white"
                />
                <span class="text-sm text-white">Customer</span>
              </RouterLink>
            </li>
          </ul>
        </div>
      </li>
      <!-- Users End -->

      <li>
        <RouterLink to="/order" class="flex items-center gap-2">
          <div
            class="w-8 h-8 bg-slate-400/50 border border-gray-100/50 rounded-full flex items-center justify-center"
          >
            <Icon name="mdi:point-of-sale" size="20" class="text-white" />
          </div>
          <p v-if="text" class="text-white text-sm">Orders</p>
        </RouterLink>
      </li>

      <!-- customized cakes -->

      <li>
        <div
          class="group flex items-center gap-3 rounded-lg transition-all ease-in-out duration-300 cursor-pointer relative"
          @click="isCustomCakeLinks = !isCustomCakeLinks"
        >
          <div
            class="w-7 h-7 bg-slate-400/50 border border-gray-100/50 rounded-full flex items-center justify-center"
          >
            <Icon
              name="carbon:ibm-data-product-exchange"
              size="20"
              class="text-white"
            />
          </div>
          <span
            class="text-white text-sm font-normal transition-all ease-in-out duration-300"
            >Customized Cake</span
          >
          <div
            class="absolute top-1/2 -translate-y-1/2 right-2 transition-all ease-in-out duration-300"
            :class="{ 'rotate-90 ': isCustomCakeLinks }"
          >
            <Icon
              name="ic:twotone-keyboard-arrow-right"
              size="20"
              class="text-white transition-all ease-in-out duration-300"
            />
          </div>
        </div>
        <div class="overflow-hidden">
          <ul
            class="shop-links flex flex-col gap-4 pl-4 py-4"
            :class="{ 'shop-links--active': isCustomCakeLinks }"
          >
            <li>
              <RouterLink to="/custom-cakes" class="flex items-center gap-3">
                <Icon
                  name="material-symbols-light:circles-outline"
                  class="text-white"
                />
                <span class="text-sm text-white">Custom Cakes</span>
              </RouterLink>
            </li>
            <li>
              <RouterLink
                to="/custom-cake-flavors"
                class="flex items-center gap-3"
              >
                <Icon
                  name="material-symbols-light:circles-outline"
                  class="text-white"
                />
                <span class="text-sm text-white">Flavors</span>
              </RouterLink>
            </li>
            <li>
              <RouterLink
                to="/custom-cake-orders"
                class="flex items-center gap-3"
              >
                <Icon
                  name="material-symbols-light:circles-outline"
                  class="text-white"
                />
                <span class="text-sm text-white">Orders</span>
              </RouterLink>
            </li>
          </ul>
        </div>
      </li>

      <!-- CMS  -->
      <li>
        <div
          class="group flex items-center gap-3 rounded-lg transition-all ease-in-out duration-300 cursor-pointer relative"
          @click="isCmsLinks = !isCmsLinks"
        >
          <div
            class="w-7 h-7 bg-slate-400/50 border border-gray-100/50 rounded-full flex items-center justify-center"
          >
            <Icon
              name="carbon:ibm-data-product-exchange"
              size="20"
              class="text-white"
            />
          </div>
          <span
            class="text-white text-sm font-normal transition-all ease-in-out duration-300"
            >CMS</span
          >
          <div
            class="absolute top-1/2 -translate-y-1/2 right-2 transition-all ease-in-out duration-300"
            :class="{ 'rotate-90 ': isCmsLinks }"
          >
            <Icon
              name="ic:twotone-keyboard-arrow-right"
              size="20"
              class="text-white transition-all ease-in-out duration-300"
            />
          </div>
        </div>
        <div class="overflow-hidden">
          <ul
            class="shop-links flex flex-col gap-4 pl-4 py-4"
            :class="{ 'shop-links--active': isCmsLinks }"
          >
            <li>
              <RouterLink to="/slider" class="flex items-center gap-3">
                <Icon
                  name="material-symbols-light:circles-outline"
                  class="text-white"
                />
                <span class="text-sm text-white">Home Slider</span>
              </RouterLink>
            </li>

            <li>
              <RouterLink to="/custom-pages" class="flex items-center gap-3">
                <Icon
                  name="material-symbols-light:circles-outline"
                  class="text-white"
                />
                <span class="text-sm text-white">Pages</span>
              </RouterLink>
            </li>
            <!--
            <li>
              <RouterLink to="/home-sections" class="flex items-center gap-3 ">
                <Icon name="material-symbols-light:circles-outline" class="text-white"/>
                <span class="text-sm text-white">Home Sections</span>
              </RouterLink>
            </li>
            <li>
                <RouterLink to="/advertise" class="flex items-center gap-3 ">
                    <Icon name="material-symbols-light:circles-outline" class="text-white" />
                    <span class="text-sm text-white">Advertise</span>
                </RouterLink>
            </li>
            <li>
              <RouterLink to="/blog" class="flex items-center gap-3 ">
                <Icon name="material-symbols-light:circles-outline" class="text-white"/>
                <span class="text-sm text-white">Blog</span>
              </RouterLink>
            </li> -->
          </ul>
        </div>
      </li>
      <!-- CMS End -->

      <!--      reviews start-->
      <!--      <li>
        <RouterLink to="/all-review" class="flex items-center gap-3 ">
          <div class=" w-7 h-7 bg-slate-400/50 border border-gray-100/50 rounded-full flex items-center justify-center">
            <Icon name="material-symbols-light:circles-outline" class="text-white"/>
          </div>
          <span class="text-sm text-white">Reviews</span>
        </RouterLink>
      </li>-->
      <!--      reviews start-->

      <li>
        <RouterLink to="/messages" class="flex items-center gap-2">
          <div
            class="w-8 h-8 bg-slate-400/50 border border-gray-100/50 rounded-full flex items-center justify-center"
          >
            <Icon name="mdi:point-of-sale" size="20" class="text-white" />
          </div>
          <p v-if="text" class="text-white text-sm">Messages</p>
        </RouterLink>
      </li>
      <!-- Testimonials -->
      <li>
        <RouterLink to="/testimonials" class="flex items-center gap-3">
          <div
            class="w-7 h-7 bg-slate-400/50 border border-gray-100/50 rounded-full flex items-center justify-center"
          >
            <Icon
              name="material-symbols-light:circles-outline"
              class="text-white"
            />
          </div>
          <span class="text-sm text-white">Testimonials</span>
        </RouterLink>
      </li>
      <!-- Services -->
      <li>
        <RouterLink to="/services" class="flex items-center gap-3">
          <div
            class="w-7 h-7 bg-slate-400/50 border border-gray-100/50 rounded-full flex items-center justify-center"
          >
            <Icon
              name="material-symbols-light:circles-outline"
              class="text-white"
            />
          </div>
          <span class="text-sm text-white">Services</span>
        </RouterLink>
      </li>
      <!-- Setting -->
      <li>
        <RouterLink to="/setting" class="flex items-center gap-3">
          <div
            class="w-7 h-7 bg-slate-400/50 border border-gray-100/50 rounded-full flex items-center justify-center"
          >
            <Icon
              name="material-symbols-light:circles-outline"
              class="text-white"
            />
          </div>
          <span class="text-sm text-white">Settings</span>
        </RouterLink>
      </li>
      <!-- <li>
          <div class="group flex items-center gap-3  rounded-lg transition-all ease-in-out duration-300 cursor-pointer relative" @click="isSettingLinks = !isSettingLinks">
              <div class=" w-7 h-7 bg-slate-400/50 border border-gray-100/50 rounded-full flex items-center justify-center">
                  <Icon   name="carbon:ibm-data-product-exchange" size="20" class="text-white" />
              </div>
              <span class="text-white text-sm font-normal transition-all ease-in-out duration-300">Settings</span>
              <div class="absolute top-1/2 -translate-y-1/2 right-2 transition-all  ease-in-out duration-300" :class="{'rotate-90 ' : isSettingLinks}">
              <Icon name="ic:twotone-keyboard-arrow-right" size="20" class="text-white transition-all ease-in-out duration-300"  />
              </div>
          </div>
          <div class="overflow-hidden">
              <ul class="shop-links flex flex-col gap-4 pl-4 py-4" :class="{'shop-links--active' : isSettingLinks}">
                  <li>
                      <RouterLink to="/app-setting" class="flex items-center gap-3 ">
                          <Icon name="material-symbols-light:circles-outline" class="text-white" />
                          <span class="text-sm text-white">App</span>
                      </RouterLink>
                  </li>
                  <li>
                      <RouterLink to="/home-setting" class="flex items-center gap-3 ">
                          <Icon name="material-symbols-light:circles-outline" class="text-white" />
                          <span class="text-sm text-white">Home</span>
                      </RouterLink>
                  </li>
                  <li>
                      <RouterLink to="/header-setting" class="flex items-center gap-3 ">
                          <Icon name="material-symbols-light:circles-outline" class="text-white" />
                          <span class="text-sm text-white">Header</span>
                      </RouterLink>
                  </li>
                  <li>
                      <RouterLink to="/footer-setting" class="flex items-center gap-3 ">
                          <Icon name="material-symbols-light:circles-outline" class="text-white" />
                          <span class="text-sm text-white">Footer</span>
                      </RouterLink>
                  </li>
              </ul>
          </div>
      </li> -->
      <!-- Setting End-->
    </ul>
  </div>
</template>
