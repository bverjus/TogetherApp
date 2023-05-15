<script setup>
import { useActivitiesStore } from '../ActivitiesStore';
import { ref, onMounted } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import Footer from './Footer.vue';

const activity = ref(null);

const props = defineProps({activityId : {type: Number}});

// Formattage de la date pour récupérer le jour et le mois
const formatDate = (dateString) => {
  const options = { day: 'numeric', month: 'long' };
  const date = new Date(dateString);
  return date.toLocaleDateString(undefined, options);
};

// Formattage de la date pour récupérer l'heure
const formatTime = (dateString) => {
  const options = { hour: 'numeric', minute: 'numeric', hour12: false };
  const date = new Date(dateString);
  return date.toLocaleTimeString(undefined, options);
};

// Récupération de l'activité par son id et affichage de la map
onMounted(async () => {
    const activitiesStore = useActivitiesStore();
    await activitiesStore.fetchActivities();

    activity.value = activitiesStore.getActivityById(props.activityId);
    console.log(activity.value.lat);

    const map = L.map('map').setView([activity.value.lat, activity.value.lon], 13);
    const marker = L.marker([activity.value.lat, activity.value.lon]).addTo(map);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

});



</script>
<template>  
    <div class="w-full relative" >
        <img :src="activity && activity.image" alt="" class="w-full h-full object-cover object-center">
        <div class="absolute bottom-0 left-0 w-full h-[20%] bg-black opacity-40 z-10"></div>
        <h2 class="absolute left-2 bottom-10 text-white text-bold text-xl z-20 overflow-ellipsis">{{activity && activity.title }}</h2>
        <div class="absolute bottom-2 left-2 bg-white px-4 h-6 z-20 rounded-xl ">
            <p class="text-green-500 text-semibold pl-2">{{ activity && activity.city  }} , {{ Math.round(activity && activity.distance) }} Km</p>
        </div>
    </div>
    <div class="bg-myblue-dark flex justify-between w-full h-12 pt-2 px-4">
        <p class="text-white font-semibold text-lg">{{ formatDate(activity && activity.date) }}</p>
        <div class="bg-white rounded-xl h-fit">
            <p class="px-2 py-1 text-myblue-dark">{{ activity && activity.category.nom }}</p>
        </div>
    </div>
    <main class="bg-gradient-to-b from-myblue-light to-myblue-dark pt-8 px-6 pb-10">
        <h1 class="text-white text-2xl font-bold mb-4">{{ activity && activity.title }}</h1>
        <p class="text-white">le {{ activity && formatDate(activity.date) }} à {{ activity && formatTime(activity.date) }}</p>
        <p class="text-white mt-4 text-lg">{{ activity && activity.description }}</p>

        <div class="mt-6 text-white ">
            <p>{{ activity && activity.street }}, {{ activity && activity.house_number }}</p>
            <p>{{ activity && activity.zip_code }} {{activity && activity.city }}</p>
            <div class="w-[80%] h-40 mt-4">
                <div class="w-full h-full" id="map"></div>
            </div>
        </div>
        <div class="mt-6 text-white">
            <p>Organisé par : </p>
            <img :src="activity && activity.user.profile_photo_path" alt="profile photo" class="w-16  rounded-full">
            <p class="font-bold mb-4">{{ activity && activity.user.name }}</p>
            <p class="mb-4">{{ activity && activity.participants_count }}/{{ activity && activity.nb_attendees }} participants </p>
            <a class="bg-green-500 rounded-xl px-4 py-1 text-white ">S'inscrire</a>
        </div>
        
   </main>
   <Footer/>
</template>