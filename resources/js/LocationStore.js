import { defineStore } from 'pinia';

export const useLocationStore = defineStore({
    id: 'location',
  
    state: () => ({
      latitude: null,
      longitude: null,
    }),
  
    getters: {
      getLatitude: (state) => state.latitude,
      getLongitude: (state) => state.longitude,
    },
  
    actions: {
      async fetch() {
        return new Promise((resolve, reject) => {
          navigator.geolocation.getCurrentPosition(
            (position) => {
              const { latitude, longitude } = position.coords;
              this.setData({ latitude, longitude });
              resolve();
            },
            (error) => reject(error)
          );
        });
      },
  
      setData({ latitude, longitude }) {
        this.latitude = latitude;
        this.longitude = longitude;
      },
    },
  });