<template>
  <div class="mt-5">
      <MovieForm></MovieForm>
  </div>
</template>

<script setup lang="ts">

import MovieForm from '@/components/Movies/MovieForm.vue';
import { onMounted } from 'vue';
import { useMovieFormStore } from '@/stores/movieForm.ts'
const movieFormStore = useMovieFormStore();
onMounted(() => {
  movieFormStore.resetForm()
})
</script>
