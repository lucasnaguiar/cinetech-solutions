<template>
    <div class="border p-2 rounded-3 shadow pb-4 mx-2">
        <div class="border p-2 rounded-3 shadow pb-4 mx-2">
      <h2 class="text-base/7 font-semibold text-gray-900">
        {{ isEditing ? 'Editar Filme' : 'Cadastro de Filmes' }}
      </h2>

      <div class="pm-2">
        <div class="mt-10 row">
          <div class="col-6">
            <label for="title" class="block text-sm/6 font-medium text-gray-900">Título</label>
            <input type="text" id="title" v-model="movieFormStore.formData.title" class="form-control" />
          </div>

          <div class="col-6">
            <label class="block text-sm/6 font-medium text-gray-900">Gênero</label>
            <div class="mt-2">
              <div v-for="genre in movieFormStore.genreList" :key="genre.id" class="form-check">
                <input type="checkbox" :id="'genre-' + genre.id" :value="genre.id" v-model="movieFormStore.formData.genres"
                  class="form-check-input">
                <label :for="'genre-' + genre.id" class="form-check-label">{{ genre.name }}</label>
              </div>
            </div>
          </div>

          <div class="col-6 mt-2">
            <label for="trailer" class="block text-sm/6 font-medium text-gray-900">Link do Trailer (YouTube)</label>
            <input type="text" id="trailer" v-model="movieFormStore.formData.trailer_link" class="form-control" />
          </div>

          <div class="col-6 mt-2">
            <label for="release_date" class="block text-sm/6 font-medium text-gray-900">Data de Lançamento</label>
            <input type="date" id="release_date" v-model="movieFormStore.formData.release_date" class="form-control" />
          </div>

          <div class="col-6 mt-2">
            <label for="duration" class="block text-sm/6 font-medium text-gray-900">Duração (Minutos)</label>
            <input type="number" id="duration" v-model="movieFormStore.formData.duration" class="form-control" />
          </div>

          <div class="col-6 mt-2">
            <label for="cover" class="block text-sm/6 font-medium text-gray-900">Capa do Filme</label>
            <input type="file" id="cover" @change="handleCoverUpload" accept="image/*" class="form-control" />
          </div>
        </div>
      </div>

      <div class="col-span-full">
        <label for="description" class="block text-sm/6 font-medium text-gray-900">Descrição</label>
        <textarea id="description" rows="3" v-model="movieFormStore.formData.description" class="form-control"></textarea>
      </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6 mx-4">
      <RouterLink to="/filmes">
        <button type="button" class="text-sm/6 font-semibold text-gray-900">Voltar</button>
      </RouterLink>
      <button type="button" @click="movieFormStore.submitForm" class="btn btn-primary">
        {{ isEditing ? 'Atualizar' : 'Cadastrar' }}
      </button>
    </div>
    </div>
</template>
<script setup lang="ts">
import type Genre from '@/types/genre';
import { onMounted, ref } from 'vue';
import { api } from '@/axios.ts';

import { useMovieFormStore } from '@/stores/movieForm.ts'
import { storeToRefs } from 'pinia';
const movieFormStore = useMovieFormStore();

const genreList = ref<Genre[]>([])

const isEditing = ref(false)
const coverFile = ref<File>()

onMounted(() => {
    getGenres()
})

const handleCoverUpload = (event: Event) => {
    const input = event.target as HTMLInputElement;
    if (input.files && input.files.length > 0) {
        movieFormStore.formData.cover = input.files[0];
    }
};

const getGenres = async () => {
    api.get('/genres',
    )
        .then(function (response) {
            if (response.status === 200) {
                movieFormStore.genreList = response.data
            }
        })
        .catch(function (error) {
            console.error(error);
        })
};
</script>