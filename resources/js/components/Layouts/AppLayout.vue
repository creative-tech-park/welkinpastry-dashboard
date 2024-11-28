<script setup>
import SideBar from '@/components/Layouts/SideBar.vue';
import AdminHeader from "@/components/Layouts/AdminHeader.vue";
</script>
<template>
    <div class="w-full flex">
        <aside class="w-48 mx-auto overflow-y-scroll scrollbar-hide fixed top-0 left-0 bottom-0 h-screen bg-primary">
            <SideBar />
        </aside>
        <main class="ml-48 w-full p-4 mb-8">
          <AdminHeader/>
            <div class="mt-16">
                <slot />
            </div>
        </main>
    </div>
</template> 
