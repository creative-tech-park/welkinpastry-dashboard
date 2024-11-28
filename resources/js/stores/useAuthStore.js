import { defineStore } from 'pinia'
import {ref, computed, onMounted} from "vue"
import useAxios from "@/composables/useAxios";
import { useRouter } from 'vue-router';
import {useToast} from "vue-toastification";
const {loading,error,sendRequest,} = useAxios();
const toast = useToast();
export const useAuthStore = defineStore('auth', ()=>{
    const NAMESPACE = import.meta.env.VITE_APP_PREFIX;
    const router = useRouter();
    const user = ref(JSON.parse(localStorage.getItem(`${NAMESPACE}_user`)) ?? null)
    const isLoggedIn = computed(() => !! user.value)

    async function fetchUser(){
        const user = JSON.parse(await getLocalStoreage());
        if(user){
            const data = await sendRequest({
                method: 'get',
                url: "/v1/user",
                headers:{
                    "Authorization": `Bearer ${user?.token}`
                }
            })
            if(data?.data){
                user.value = data?.data
            }else{
                await clearLocalStoreage();
            }
        }else{
            await clearLocalStoreage();
        }


    }

    async function login(credential){
        await sendRequest({
            method: 'get',
            url: "/sanctum/csrf-cookie",
        })

        const login = await sendRequest({
            method:"POST",
            url:"/v1/login",
            data:credential
        })

        if(login.data?.message) toast.success(login.data?.message)

        await setLocalStoreage(login.data?.data)
        user.value = login.data?.data
        console.log("login response", login)

        return login;
    }

    async function signup(signupData){
        const singup = await sendRequest("/register")
        console.log(singup)
        return singup;
    }

    async function logout(){
        const res = await sendRequest({
            url:"/v1/logout",
            method:"GET"
        })
        console.log('log out res', res)
        if(res.data?.message) toast.success(res.data?.message)
        user.value = null;
        await clearLocalStoreage();
        await router.push({name: "Home"})
    }

    async function setLocalStoreage(user) {
        localStorage.setItem(`${NAMESPACE}_user`, JSON.stringify(user));
    }

    async function clearLocalStoreage() {
        user.value = null;
        localStorage.removeItem(`${NAMESPACE}_user`);
    }

    async function getLocalStoreage() {
        return localStorage.getItem(`${NAMESPACE}_user`);
    }

    function getToken() {
        return JSON.parse(localStorage.getItem(`${NAMESPACE}_user`))?.token;
    }
    return {user, login, signup, isLoggedIn, fetchUser, logout, loading, error, getLocalStoreage,clearLocalStoreage, getToken}

})
