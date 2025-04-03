<template>
  <div class="mt-5">
      <MovieForm></MovieForm>
  </div>
</template>

<script setup lang="ts">
import { api } from '@/axios.ts';
import { ref, onMounted } from 'vue';
import type Movie from '@/types/movie';
import MovieForm from '@/components/Movies/MovieForm.vue';
import { useRouter, useRoute } from 'vue-router';
const route = useRoute();
import { useMovieFormStore } from '@/stores/movieForm.ts'
const movieFormStore = useMovieFormStore();
onMounted(() => {
  loadMovie()
})
const movie = ref<Movie>()
const movieId = ref()

const loadMovie = async () => {
  if (route.params.id) {
    movieId.value = route.params.id;
    try {
      const response = await api.get(`/movies/${movieId.value}`);
      movie.value = response.data;
      const genreIds = response.data.genres.map(item => item.id);
      movie.value.genres = genreIds
      
      movieFormStore.loadMovie(movie.value)
    } catch (error) {
      console.error('Erro ao carregar genero:', error);
    }
  }
};

</script>
