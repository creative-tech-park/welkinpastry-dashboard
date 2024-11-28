<script setup>

import {ref} from 'vue';
import {useAuthStore} from '@/stores/useAuthStore.js';
import {useRouter} from 'vue-router'
import LoadingButton from "@/components/LoadingButton.vue";
import Input from "@/components/Input.vue";

const authStore = useAuthStore();
const router = useRouter()


//Login
const loginCredential = ref({
  email: null,
  password: null,
});

const handleLogin = async () => {
  const loginResponse = await authStore.login(loginCredential.value);
  if (loginResponse) {
    await router.push({name: "Dashboard"});
  }
}

</script>

<template>
  <div class="w-full h-screen bg-white">
    <div class="flex">
      <div class="w-3/4 h-screen">
        <img
            src="https://img.freepik.com/free-vector/ecommerce-checkout-laptop-concept-illustration_114360-8233.jpg?t=st=1719227470~exp=1719231070~hmac=bf22bb02896a562b13892ad72d1ab1aeb86606efd9d3468c2924af202ee4475c&w=1800"
            class="w-full h-full" alt="">
      </div>
      <div class="w-1/4">
        <div class="w-full h-screen flex items-center justify-center bg-white shadow-lg">
          <div class="w-full px-4">
            <h3 class="text-center font-medium text-3xl uppercase mb-3">Sign in To <span
                class="text-primary">Dashboard</span></h3>
            <div class="flex flex-col items-center gap-5">
              <Input
                  class="w-full"
                  label="Email"
                  labelName="Email"
                  :error="authStore.error?.response?.data?.errors?.email"
                  v-model="loginCredential.email"
                  :loading="authStore.loading"
                  type="email"
                  required
                  placeholder="Enter your Email"
              />

              <Input
                  class="w-full"
                  label="Password"
                  labelName="Password"
                  v-model="loginCredential.password"
                  :error="authStore.error?.response?.data?.errors?.password"
                  :loading="authStore.loading"
                  type="password"
                  required
                  placeholder="Enter your Password"
              />
              <div class="w-full">
                <LoadingButton @click="handleLogin" :isLoading="authStore.loading">
                  Loading
                </LoadingButton>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>