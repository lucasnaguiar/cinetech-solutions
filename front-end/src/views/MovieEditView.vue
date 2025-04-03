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
const router = useRouter();
const route = useRoute();
const handleFormSubmit = async (data: FormData) => {
  console.log(data)

  await api.post('/movies', data, {
        headers: { 'Content-Type': 'multipart/form-data' }
      }).then((response) => {
    console.log(response.data)
  }).catch(function (error) {
    console.log(error.response.data)
  })
};
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
      console.log(movie.value)
    } catch (error) {
      console.error('Erro ao carregar genero:', error);
    }
  }
};

</script>
