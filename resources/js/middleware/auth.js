import { useAuthStore } from '@/stores/useAuthStore.js'
import {useToast} from "vue-toastification";

export default (to, from, next) => {
    const auth = useAuthStore()
    const toast = useToast();
    const loginRoute = 'Login'
    const isLoginRoute = to.name === loginRoute

    if (!auth.isLoggedIn && !isLoginRoute) {
        // toast.error('Unauthorized Access. Please Login First...')
        next({ name: 'Login' })
    }else if(auth.isLoggedIn && isLoginRoute){
        toast.warning(`Can't access login page. Already Login...`)
        next({ name: 'Dashboard' })
    } else {
        next()
    }
}