import { defineStore } from 'pinia'
import {ref, computed,reactive} from 'vue'
export const useLoadingStore = defineStore('loading', () => {
    

    const loading = ref(false)
   
   return {loading}

  })