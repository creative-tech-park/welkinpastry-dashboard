if (!import.meta.env.VITE_APP_PREFIX) {
    console.error("Environment variable VITE_APP_NAME is not defined!");
    alert("Critical Error: Environment variable VITE_APP_NAME is not defined! The application cannot start.");
    throw new Error("Critical Error: Environment variable VITE_APP_NAME is missing.");
}
import "vue-select/dist/vue-select.css";
import '@/assets/css/app.css'
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import AppLayout from '@/components/Layouts/AppLayout.vue';
import  Icon  from '@/components/Icon.vue';
import Button from '@/components/Button.vue';
import  VSelect  from "vue-select";

import Toast, {useToast} from "vue-toastification";
import "vue-toastification/dist/index.css";

import 'flowbite';
import 'summernote/dist/summernote-lite.css';
import 'summernote/dist/summernote-lite.min.js';
import {useAuthStore} from "@/stores/useAuthStore.js";

const toast = useToast();

import $ from 'jquery';
window.$ = window.jQuery = $;
import App from './App.vue'
import router from './router/index.js'

const app = createApp(App)
// app.use(createPinia())
//     .use(router)
//     .component('AppLayout', AppLayout)
//     .component('Icon', Icon)
//     .component('Button', Button)
//     .component("Select", VSelect)
//     .mount('#app')


app.use(createPinia())

    .use(router)
    .component('AppLayout', AppLayout)
    .component("Select", VSelect)
    .component('Button', Button)
    .component('Icon', Icon)
    .use(Toast, {
        position: "bottom-right",
        timeout: 2254,
        closeOnClick: true,
        pauseOnFocusLoss: true,
        pauseOnHover: true,
        draggable: true,
        draggablePercent: 0.32,
        showCloseButtonOnHover: true,
        hideProgressBar: false,
        closeButton: "button",
        icon: true,
        rtl: false
    })
    .mount('#app')


app.config.errorHandler = async (err, instance, info) => {
    const authStore = useAuthStore()

    switch (err?.response?.status) {
        case 200:
            toast('Hello World.!')
            break;
        case 500:
            toast(err.message)
            break;
        case 422:
            toast.error(err.message)
            break;
        case 401:
            toast.error(err.message)
            await authStore.clearLocalStoreage();
            await router.push({name: "Home"})
            break;
        default:
        // toast.error(err.message)
    }
}
