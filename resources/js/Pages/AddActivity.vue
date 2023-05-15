<script setup>
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'
import { ref } from 'vue';
import Footer from './Footer.vue';

const data = reactive({
    title: null,
    description: null,
    street: null,
    house_number: null,
    city: null,
    zip_code: null,
    country: null,
    category_id: null,
    image: null,
    date: null,
    duration: null,
    nb_attendees: null,
    user_id: null,
});

const successMessage = ref('');
const image = ref(null);

//Envoie du formulaire 
const submitForm = async () => {
    console.log(data);
    await router.post('/activities/store', data);
    successMessage.value = 'Activité ajoutée avec succès';
      successMessage.value = 'Activité ajoutée avec succès';
      setTimeout(() => {
        router.get('/dashboard');
      }, 2000);
}



// Gestion de l'image 
const handleImageUpload = (event) => {
  const file = event.target.files[0];
  image.value = file;
  data.image = image.value;
};

const props = defineProps({
    categories: Array
});
</script>

<template>

<div class="max-w-md mx-auto p-4 bg-form">
    <h1 class="text-2xl font-bold mb-6">Ajouter une nouvelle activité</h1>
    <form @submit.prevent="submitForm" class="space-y-6">
      <div>
        <label for="title" class="block">Titre</label>
        <input type="text" id="title" v-model="data.title" required class="w-full border border-gray-300 rounded-md p-2 bg-myblue-input">
      </div>

      <div>
        <label for="description" class="block">Description</label>
        <textarea id="description" v-model="data.description" required class="w-full border border-gray-300 rounded-md p-2 bg-myblue-input"></textarea>
      </div>

      <div>
        <label for="street" class="block">Rue</label>
        <input type="text" id="street" v-model="data.street" required class="w-full border border-gray-300 rounded-md p-2 bg-myblue-input">
      </div>

      <div>
        <label for="house_number" class="block">Numéro</label>
        <input type="text" id="house_number" v-model="data.house_number"  class="w-full border border-gray-300 rounded-md p-2  bg-myblue-input">
      </div>

      <div>
        <label for="zip_code" class="block">Code postal</label>
        <input type="text" id="zip_code" v-model="data.zip_code" required class="w-full border border-gray-300 rounded-md p-2 bg-myblue-input">
      </div>

      <div>
        <label for="city" class="block">Ville</label>
        <input type="text" id="city" v-model="data.city" required class="w-full border border-gray-300 rounded-md p-2 bg-myblue-input">
      </div>

      <div>
        <label for="country" class="block">Pays</label>
        <input type="text" id="country" v-model="data.country" required class="w-full border border-gray-300 rounded-md p-2 bg-myblue-input">
      </div>

      <div>
        <label for="category" class="block">Catégorie</label>
        <select id="category" required v-model="data.category_id" class="w-full border border-gray-300 rounded-md p-2 bg-myblue-input">
          <option value="">Sélectionnez une catégorie</option>
          <option v-for="category in props.categories" :value="category.id" :key="category.id">{{ category.nom }}</option>
        </select>
      </div>

      <div>
        <label for="image" class="block">Image</label>
        <input type="file" id="image" accept="image/*" @change="handleImageUpload" required class="w-full">
      </div>

      <div>
        <label for="date" class="block">Date de l'activité</label>
        <input type="datetime-local" id="date" v-model="data.date" required class="w-full border border-gray-300 rounded-md p-2 bg-myblue-input">
      </div>

      <div>
        <label for="duration" class="block">Durée (en heures)</label>
        <input type="number" id="duration" v-model="data.duration" required class="w-full border border-gray-300 rounded-md p-2 bg-myblue-input">
      </div>
      <div>
        <label for="maxParticipants" class="block">Nombre de participants max</label>
        <input type="number" id="maxParticipants" v-model="data.nb_attendees" required class="w-full border border-gray-300 rounded-md p-2 bg-myblue-input">
      </div>

      <div class="flex justify-center space-x-4">
        <button type="submit" class=" bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md">Ajouter</button>
        
      </div>
    </form>
    <div v-if="successMessage" class="text-green-500 mt-4">
      {{ successMessage }}
    </div>
  </div>
  <Footer/>
</template>