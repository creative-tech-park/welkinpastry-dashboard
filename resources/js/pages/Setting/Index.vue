<script setup>
import useAxios from "@/composables/useAxios.js";
import {onMounted, ref} from "vue";
import {useToast} from "vue-toastification";
import LoadingButton from "@/components/LoadingButton.vue";

const toast = useToast();
const {sendRequest, loading, error} = useAxios();
const gallerys = ref([])

const section = ref('profile')

const settings = ref({
  profile: {
    name: null,
    email: null,
    phone: null,
    whatsapp: null,
    address: null,
    footer_cntent: null,
  },
  social: {
    facebook: null,
    instagram: null,
    twitter: null,
    linkedin: null,
    youtube: null,
  },
  counter: {
    project_complate: null,
    customer_satisfied: null,
    expart_team: null,
    award: null,

    house: null,
    condo: null,
    landed: null,
    corporate: null,
  },
  header: {
    pages:[],
  },
  footer: {
    col1:{
      column:null,
      pages:[]
    },
    col2:{
      column:null,
      pages:[]
    }
  }
})

const updateSetting = async () => {
  const response = await sendRequest({
    url: "/v1/settings",
    method: 'POST',
    data: settings.value
  })
  toast.success(response?.data?.message)
}
const getSettings = async () => {
  const response = await sendRequest({
    url: "/v1/settings",
    method: 'GET'
  })
  setupSettings(response.data)
}
const setupSettings = (data) => {
  settings.value.hero = data?.bSettings.hero ?? {}
  settings.value.profile = data?.bSettings.profile ?? {}
  settings.value.social = data?.bSettings.social ?? {}
  settings.value.counter = data?.bSettings.counter ?? {}
  settings.value.footer = data?.bSettings.footer ?? {}
  settings.value.header = data?.bSettings.header ?? {}
}
const pages = ref([])
const getPages = async () => {
  const response = await sendRequest({
    url: "/v1/page?onlyData",
    method: 'GET'
  })
  pages.value = response.data
}
onMounted(async () => await getSettings())
onMounted(async () => await getPages())


</script>
<template>
  <AppLayout>
    <div class="flex items-center justify-between p-5">
      <div>
        <div class="flex items-center">
          <Icon name="ic:baseline-medical-services"
                class="text-primary text-4xl rounded-full border-2 shadow-lg border-primary p-1"/>
          <h2 class="font-bold text-3xl py-5 px-3 uppercase text-primary tracking-wider ">Settings</h2>
        </div>
      </div>
    </div>
    <!--Gallary  table -->
    <div class="relative">
      <div class="grid grid-cols-4 gap-5 min-h-[60vh]">
        <div class="col-span-1 h-full bg-white">
          <ul>
            <li class="w-full border-b hover:bg-teal-100 group transition-all ease-linear duration-300"
                :class="{'bg-teal-100' : section === 'profile'}">
              <a href="javascript:void(0)" @click="section = 'profile'"
                 :class="section === 'profile' ? 'text-teal-800 font-bold' : ' font-semibold'"
                 class="py-4 flex items-center justify-center w-full h-full group-hover:text-teal-800 group-hover:font-bold">Setup
                Profile</a>
            </li>

            <li class="w-full border-b hover:bg-teal-100 group transition-all ease-linear duration-300"
                :class="{'bg-teal-100' : section === 'social'}">
              <a href="javascript:void(0)" @click="section = 'social'"
                 :class="section === 'social' ? 'text-teal-800 font-bold' : ' font-semibold'"
                 class="py-4 flex items-center justify-center w-full h-full group-hover:text-teal-800 group-hover:font-bold">Social
                Setup</a>
            </li>
            <li class="w-full border-b hover:bg-teal-100 group transition-all ease-linear duration-300"
                :class="{'bg-teal-100' : section === 'header-page'}">
              <a href="javascript:void(0)" @click="section = 'header-page'"
                 :class="section === 'header-page' ? 'text-teal-800 font-bold' : ' font-semibold'"
                 class="py-4 flex items-center justify-center w-full h-full group-hover:text-teal-800 group-hover:font-bold">Header
                Setup</a>
            </li>
            <li class="w-full border-b hover:bg-teal-100 group transition-all ease-linear duration-300"
                :class="{'bg-teal-100' : section === 'footer'}">
              <a href="javascript:void(0)" @click="section = 'footer'"
                 :class="section === 'footer' ? 'text-teal-800 font-bold' : ' font-semibold'"
                 class="py-4 flex items-center justify-center w-full h-full group-hover:text-teal-800 group-hover:font-bold">Footer
                Setup</a>
            </li>
            <li class="w-full border-b hover:bg-teal-100 group transition-all ease-linear duration-300">
              <RouterLink  to="/shipping"
                 class="py-4 flex font-semibold items-center justify-center w-full h-full group-hover:text-teal-800 group-hover:font-bold">Shipping Area</RouterLink>
            </li>
          </ul>
        </div>


        <div class="col-span-3 h-full bg-white overflow-hidden p-5">
          <TransitionGroup name="page" mode="out-in">
            <div v-if="section === 'profile'">
              <p class="text-3xl font-semibold">Profile Setup</p>
              <form @submit.prevent="updateSetting" class="mt-3 flex flex-col gap-3">
                <div class="w-full">
                  <label for="name" class="text-sm block mb-2">Site Name<span
                      class="text-red-500">*</span></label>
                  <input type="text" :disabled="loading" v-model="settings.profile.name"
                         class="border border-primary rounded-md font-normal text-sm disabled:bg-teal-50 w-full  focus:ring-primary focus:border-primary">
                  <span class="text-red-500" v-if="error?.response?.data?.errors?.name">{{
                      error?.response?.data?.errors?.name[0]
                    }}</span>
                </div>


                <div class="w-full">
                  <label for="name" class="text-sm block mb-2">Email <span
                      class="text-red-500">*</span></label>
                  <input type="text" :disabled="loading" v-model="settings.profile.email"
                         class="border border-primary rounded-md font-normal text-sm disabled:bg-teal-50 w-full  focus:ring-primary focus:border-primary">
                  <span class="text-red-500" v-if="error?.response?.data?.errors?.email">{{
                      error?.response?.data?.errors?.email[0]
                    }}</span>
                </div>

                <div class="w-full">
                  <label for="name" class="text-sm block mb-2">Phone <span
                      class="text-red-500">*</span></label>
                  <input type="text" :disabled="loading" v-model="settings.profile.phone"
                         class="border border-primary rounded-md font-normal text-sm disabled:bg-teal-50 w-full  focus:ring-primary focus:border-primary">
                  <span class="text-red-500" v-if="error?.response?.data?.errors?.phone">{{
                      error?.response?.data?.errors?.phone[0]
                    }}</span>
                </div>
                <div class="w-full">
                  <label for="name" class="text-sm block mb-2">Whatsapp <span
                      class="text-red-500">*</span></label>
                  <input type="text" :disabled="loading" v-model="settings.profile.whatsapp"
                         class="border border-primary rounded-md font-normal text-sm disabled:bg-teal-50 w-full  focus:ring-primary focus:border-primary">
                  <span class="text-red-500" v-if="error?.response?.data?.errors?.whatsapp">{{
                      error?.response?.data?.errors?.whatsapp[0]
                    }}</span>
                </div>
                <div class="w-full">
                  <label for="name" class="text-sm block mb-2">Address <span
                      class="text-red-500">*</span></label>
                  <input type="text" :disabled="loading" v-model="settings.profile.address"
                         class="border border-primary rounded-md font-normal text-sm disabled:bg-teal-50 w-full  focus:ring-primary focus:border-primary">
                  <span class="text-red-500" v-if="error?.response?.data?.errors?.address">{{
                      error?.response?.data?.errors?.address[0]
                    }}</span>
                </div>

                <div class="w-full">
                  <label for="name" class="text-sm block mb-2">Footer Content <span
                      class="text-red-500">*</span></label>
                  <textarea type="text" :disabled="loading" v-model="settings.profile.footer_cntent"
                            rows="5"
                            class="border border-primary rounded-md font-normal text-sm disabled:bg-teal-50 w-full  focus:ring-primary focus:border-primary"></textarea>
                  <span class="text-red-500" v-if="error?.response?.data?.errors?.footer_cntent">{{
                      error?.response?.data?.errors?.footer_cntent[0]
                    }}</span>
                </div>

                <div class="flex items-center justify-end">
                  <LoadingButton :isLoading="loading">Update Settings</LoadingButton>
                </div>

              </form>
            </div>
            <div v-if="section === 'social'">
              <p class="text-3xl font-semibold">Social Setup</p>
              <form @submit.prevent="updateSetting" class="mt-3 flex flex-col gap-3">
                <div class="w-full">
                  <label for="name" class="text-sm block mb-2">Facebook<span
                      class="text-red-500">*</span></label>
                  <input type="text" :disabled="loading" v-model="settings.social.facebook"
                         class="border border-primary rounded-md font-normal text-sm disabled:bg-teal-50 w-full  focus:ring-primary focus:border-primary">
                  <span class="text-red-500" v-if="error?.response?.data?.errors?.facebook">{{
                      error?.response?.data?.errors?.facebook[0]
                    }}</span>
                </div>


                <div class="w-full">
                  <label for="name" class="text-sm block mb-2">Instagram <span
                      class="text-red-500">*</span></label>
                  <input type="text" :disabled="loading" v-model="settings.social.instagram"
                         class="border border-primary rounded-md font-normal text-sm disabled:bg-teal-50 w-full  focus:ring-primary focus:border-primary">
                  <span class="text-red-500" v-if="error?.response?.data?.errors?.instagram">{{
                      error?.response?.data?.errors?.instagram[0]
                    }}</span>
                </div>

                <!--                  <div class="w-full">
                                    <label for="name" class="text-sm block mb-2">Twitter <span
                                        class="text-red-500">*</span></label>
                                    <input type="text" :disabled="loading" v-model="settings.social.twitter"
                                           class="border border-primary rounded-md font-normal text-sm disabled:bg-teal-50 w-full  focus:ring-primary focus:border-primary">
                                    <span class="text-red-500" v-if="error?.response?.data?.errors?.twitter">{{
                                        error?.response?.data?.errors?.twitter[0]
                                      }}</span>
                                  </div>

                                  <div class="w-full">
                                    <label for="name" class="text-sm block mb-2">Linkedin <span
                                        class="text-red-500">*</span></label>
                                    <input type="text" :disabled="loading" v-model="settings.social.linkedin"
                                           class="border border-primary rounded-md font-normal text-sm disabled:bg-teal-50 w-full  focus:ring-primary focus:border-primary">
                                    <span class="text-red-500" v-if="error?.response?.data?.errors?.linkedin">{{
                                        error?.response?.data?.errors?.linkedin[0]
                                      }}</span>
                                  </div>-->
                <div class="w-full">
                  <label for="name" class="text-sm block mb-2">Youtube <span
                      class="text-red-500">*</span></label>
                  <input type="text" :disabled="loading" v-model="settings.social.youtube"
                         class="border border-primary rounded-md font-normal text-sm disabled:bg-teal-50 w-full  focus:ring-primary focus:border-primary">
                  <span class="text-red-500" v-if="error?.response?.data?.errors?.youtube">{{
                      error?.response?.data?.errors?.youtube[0]
                    }}</span>
                </div>

                <div class="flex items-center justify-end">
                  <LoadingButton :isLoading="loading">Update Settings</LoadingButton>
                </div>
              </form>
            </div>


            <div v-if="section === 'header-page'">
              <p class="text-3xl font-semibold">Header Page Setup</p>
              <form @submit.prevent="updateSetting" class="mt-3 flex flex-col gap-3">

                <div class="w-full mt-5">
                      <label class="text-sm block mb-2">Select Page</label>
                      <Select
                          class="disabled:bg-gray-200"
                          :disabled="loading"
                          multiple
                          label="title"
                          :options="pages"
                          v-model="settings.header.pages"
                      >
                      </Select>
                    </div>

                <div class="flex items-center justify-end">
                  <LoadingButton :isLoading="loading">Update Settings</LoadingButton>
                </div>
              </form>
            </div>


            <div v-if="section === 'footer'">
              <p class="text-3xl font-semibold">Footer Setup</p>
              <form @submit.prevent="updateSetting" class="mt-3 flex flex-col gap-3">

                <div class="grid grid-cols-2 gap-5">
                  <div class="col-span-1">
                    <div class="w-full">
                      <label for="name" class="text-sm block mb-2">Column Name<span
                          class="text-red-500">*</span></label>
                      <input type="text" :disabled="loading" v-model="settings.footer.col1.column"
                             class="border border-primary rounded-md font-normal text-sm disabled:bg-teal-50 w-full  focus:ring-primary focus:border-primary">
                      <span class="text-red-500" v-if="error?.response?.data?.errors?.column">{{
                          error?.response?.data?.errors?.column[0]
                        }}</span>
                    </div>
                    <div class="w-full mt-5">
                      <label class="text-sm block mb-2">Select Page</label>
                      <Select
                          class="disabled:bg-gray-200"
                          :disabled="loading"
                          multiple
                          label="title"
                          :options="pages"
                          v-model="settings.footer.col1.pages"
                      >
                      </Select>
                    </div>
                  </div>
                  <div class="col-span-1">
                    <div class="w-full">
                      <label for="name" class="text-sm block mb-2">Column Name<span
                          class="text-red-500">*</span></label>
                      <input type="text" :disabled="loading" v-model="settings.footer.col2.column"
                             class="border border-primary rounded-md font-normal text-sm disabled:bg-teal-50 w-full  focus:ring-primary focus:border-primary">
                      <span class="text-red-500" v-if="error?.response?.data?.errors?.column">{{
                          error?.response?.data?.errors?.column[0]
                        }}</span>
                    </div>
                    <div class="w-full mt-5">
                      <label class="text-sm block mb-2">Select Page</label>
                      <Select
                          class="disabled:bg-gray-200"
                          :disabled="loading"
                          multiple
                          label="title"
                          :options="pages"
                          v-model="settings.footer.col2.pages"
                      >
                      </Select>
                    </div>
                  </div>
                </div>


                <div class="flex items-center justify-end">
                  <LoadingButton :isLoading="loading">Update Settings</LoadingButton>
                </div>
              </form>
            </div>
          </TransitionGroup>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.page-enter-from,
.page-leave-to {
  opacity: 0;
  transform: translateY(20px)
}

.page-enter-to,
.page-leave-from {
  opacity: 1;
}

.page-enter-active,
.page-leave-active {
  transition: all 0.5s ease;
}
</style>