<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import Categories from './Categories.vue';
import NearbyActivities from './NearbyActivities.vue';
import NextActivites from './NextActivities.vue';
import Footer from './Footer.vue';

defineProps({activities :Array});
</script>

<template>
    <AppLayout title="Dashboard">
    <main class="bg-gradient-to-b from-myblue-light to-myblue-dark h-screen pb-24 overflow-y-scroll">
        <h1 class="text-4xl text-slate-50 font-black pt-10 pl-4">Together</h1>
        <div>
            <input type="search" name="" id="" placeholder="Chercher des activités" class=" mt-12 rounded-xl bg-myblue-searchbar ml-4 placeholder-slate-100 w-3/5">
            <i class="fa-solid fa-filter fa-xl ml-6" style="color: #ffffff;"></i>
            <i class="fa-solid fa-map fa-xl ml-4" style="color: #ffffff;"></i>
        </div>

        <!--categories-->
        <Categories/>
        

        <!-- Activities Near  -->
        
        <NearbyActivities :activities="activities"/>

        <h2 class="text-xl text-slate-50 font-semibold pl-4 mt-8">Prochaines activités</h2>

        <!-- Prochaines activités -->
        <NextActivites/>
        
    </main>

    <!-- Footer -->
    <Footer/>
    
</AppLayout>
    
</template>
