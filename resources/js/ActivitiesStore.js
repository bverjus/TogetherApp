import axios from 'axios';
import { defineStore } from 'pinia';
import {useLocationStore} from './LocationStore';

export const useActivitiesStore = defineStore({
  id: 'activities',
  state: () => ({
    activities: [],
  }),
  getters: {
    getActivityById: (state) => (id) => {
      // Récupération d'une activité par son id
      console.log(JSON.parse(JSON.stringify(state.activities)));
      return JSON.parse(JSON.stringify(state.activities)).find((activity) => activity.id == id);
    },

    getActivitiesSortedByDistance: (state) => {
      // Tri des activités par distance
      return JSON.parse(JSON.stringify(state.activities)).slice().sort((a, b) => a.distance - b.distance);
    },
    getActivitiesSortedByDate: (state) => {
      // Tri des activités par date
      const sortedActivities = [...state.activities].sort((a, b) => {
        const dateA = new Date(a.date);
        const dateB = new Date(b.date);
        return dateA.getTime() - dateB.getTime();
      });
      return sortedActivities;
    },
  },
  actions: {
    async fetchActivities() {
        const LocationStore = useLocationStore();
        await LocationStore.fetch();
        console.log(LocationStore.getLatitude, LocationStore.getLongitude);
      try {
        // Récupération des activités depuis le serveur
        const response = await axios.get(`/api/getActivitiesWithDistances?lat=${LocationStore.getLatitude}&lon=${LocationStore.getLongitude}`)
        .then(response => {
            // Gérer la réponse
            console.log('sjns');
            console.log(response.data);
            this.activities = response.data;
        })
        .catch(error => {
          
        });
      } catch (error) {
        console.error('Error fetching activities:', error);
      }
    },
  },
});
