<script setup lang="ts">

</script>

<template>
    <nav class="flex items-center justify-between px-10 py-5">
        <div>
            <img src="https://creativetechpark.com/wp-content/uploads/2021/09/Creative-Tech-Park-Website-Design-Company-in-Bangladesh-Logo.png" alt="">
        </div>
        <ul class="flex items-center  gap-10">
           <li>
               <RouterLink to="/">Home</RouterLink>
           </li>
            <li>
                <RouterLink to="/">Documentation</RouterLink>
            </li>
            <li>
                <a href="#support">Support</a>
            </li>
        </ul>
        <div>
            <RouterLink to="/login" class="bg-primary px-10 py-4 text-white">Access Dashboard</RouterLink>
        </div>
    </nav>


    <main class="px-10">
        <section class="">
            <h3 class="text-5xl text-center max-w-4xl mx-auto pt-32 font-semibold"><span class="text-primary">Create</span> An Ecommerce Products In Minutes… Start Selling In A Few Clicks.</h3>

            <div class="bg-white shadow-2xl p-8 mt-10">
                <img src="../public/ctp-dashboard.png" alt="">
            </div>
        </section>

        <section class="pt-32 pb-16">
            <h3 class="text-center text-5xl max-w-6xl mx-auto font-bold">BUILD AND MANAGE AN ECOMMERCE PRODUCTS IN A FEW CLICKS… Unlock a New Level Of Growth!</h3>

            <div class="flex py-10 flex-wrap">
                <div class="w-1/3 p-5">
                    <div class="p-5 border border-primary rounded-2xl h-full">
                        <h4 class="text-3xl font-bold mb-5">Built-in Analytics</h4>
                        <p>Trac visits, sales, and find top-perfoming products</p>
                    </div>
                </div>
                <div class="w-1/3 p-5">
                    <div class="p-5 border border-primary rounded-2xl h-full">
                        <h4 class="text-3xl font-bold mb-5">Product Manager</h4>
                        <p>Add and edit new products. Upload images and customize product specifications.</p>
                    </div>
                </div>
                <div class="w-1/3 p-5">
                    <div class="p-5 border border-primary rounded-2xl h-full">
                        <h4 class="text-3xl font-bold mb-5">Custom Pages</h4>
                        <p>Easily create legal, contact, or any other pages you need. </p>
                    </div>
                </div>
                <div class="w-1/3 p-5">
                    <div class="p-5 border border-primary rounded-2xl h-full">
                        <h4 class="text-3xl font-bold mb-5">Custom Pages</h4>
                        <p>Easily create legal, contact, or any other pages you need. </p>
                    </div>
                </div>
                <div class="w-1/3 p-5">
                    <div class="p-5 border border-primary rounded-2xl h-full">
                        <h4 class="text-3xl font-bold mb-5">Custom Pages</h4>
                        <p>Easily create legal, contact, or any other pages you need. </p>
                    </div>
                </div>
                <div class="w-1/3 p-5">
                    <div class="p-5 border border-primary rounded-2xl h-full">
                        <h4 class="text-3xl font-bold mb-5">Custom Pages</h4>
                        <p>Easily create legal, contact, or any other pages you need. </p>
                    </div>
                </div>
            </div>
        </section>

        <section id="support" class="pb-28">
            <p class="text-center mb-2 font-bold">About Creative Tech Park</p>
            <h1 class="text-7xl font-bold max-w-6xl text-center mx-auto"><a href="https://creativetechpark.com/" class="text-primary">Creative Tech Park</a> is the best web design company in Bangladesh and it is based in Dhaka.</h1>
        </section>
    </main>
</template>
