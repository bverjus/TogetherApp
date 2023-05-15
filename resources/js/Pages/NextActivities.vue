<script setup>
import { useActivitiesStore } from '../ActivitiesStore';
import { computed,onMounted, ref  } from "@vue/runtime-core";

let activitiesByDate = ref(null);
let rayon = ref(100);

defineProps({
    title: String,
    activities: Array
});

// Formatage de la date pour avoir le jour et le mois 
const formatDate = (dateString) => {
  const options = { day: 'numeric', month: 'long' };
  const date = new Date(dateString);
  return date.toLocaleDateString(undefined, options);
};

onMounted(async () => {
    const activitiesStore = useActivitiesStore();
    await activitiesStore.fetchActivities();
    
    // Activités triées par date 
    activitiesByDate.value = activitiesStore.getActivitiesSortedByDate;
});
</script>
<template>
    
    <section class="ml-2 mt-4 text-slate-50 max-w-full overflow-x-scroll flex ">
        <div v-for="activitiy in activitiesByDate" class=" w-1/2 h-72 ml-2 relative">
            <article class="bg-myblue-searchbar w-full h-full rounded-2xl shadow-md shrink-0" v-if="activitiy.distance <= rayon">
                <div class="w-full relative">
                    <span class="absolute top-2 left-2 z-20 bg-white text-myblue-dark font-bold px-2 rounded-md">{{ activitiy.category.nom }}</span>
                    <img  class="w-full h-32 rounded-t-2xl z-0" :src="activitiy.image">
                    <div class="absolute bottom-0 right-0 w-[40%] bg-black opacity-50 z-10 h-[30%] rounded"></div>
                    <span class="absolute bottom-2 right-2 z-10 font-bold">{{ formatDate(activitiy.date) }}</span>
                </div>
                <div class="mx-2 mt-4 flex flex-col">
                    <h3 class="font-semibold whitespace-nowrap overflow-ellipsis overflow-hidden max-w-full">{{ activitiy.title }}</h3>
                    <p class="text-green-400 text-sm font-light">{{  activitiy.city  }} , {{ Math.round(activitiy.distance) }} Km</p>
                    <p class="text-sm font-light">{{ activitiy.user.name }} <span>
                        <i class="fa-solid fa-star" style="color: #f5e324;"></i>
                        <i class="fa-solid fa-star" style="color: #f5e324;"></i>
                        <i class="fa-solid fa-star" style="color: #f5e324;"></i>
                        <i class="fa-solid fa-star" style="color: #f5e324;"></i>
                        <i class="fa-regular fa-star"></i>
                        </span>
                    </p>
                    <p class=" mb-2 text-sm font-light">{{ activitiy.participants_count}}/{{ activitiy.nb_attendees }} participants</p>
                    <a class="text-center bg-green-500  px-8 no-underline text-white rounded-full max-w-fit" :href="'activities/'+activitiy.id">Infos</a>
                </div>
            </article>
        </div>
        </section>
</template>