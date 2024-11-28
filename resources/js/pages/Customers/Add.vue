<script setup>
    import {ref, onMounted} from 'vue';
    import { useAuthStore } from '@/stores/useAuthStore.js';
    import useAxios from '@/composables/useAxios';

    const {loading, error, sendRequest} = useAxios();
    const authStore = useAuthStore();
    
    const form = ref({
        name:null,
        phone:null,
        email:null,
    })
    
</script>
<template>
    <AppLayout>
        <div>
            
        </div>
    </AppLayout>
</template>