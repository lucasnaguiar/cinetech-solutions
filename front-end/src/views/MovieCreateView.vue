<template>
  <div class="mt-5">
      <MovieForm @submit-form="handleFormSubmit"></MovieForm>
  </div>
</template>

<script setup lang="ts">
import { api } from '@/axios.ts';
import { ref } from 'vue';
import type Movie from '@/types/movie';
import MovieForm from '@/components/Movies/MovieForm.vue';

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

const isEditing = ref(false);
const movieId = ref(null);


</script>
