<template>
  <div class="mt-5">
    <div class="border border-1 p-2 rounded-3 shadow pb-4 mx-2">
      <h2 class="text-base/7 font-semibold text-gray-900">
        {{ isEditing ? 'Editar Filme' : 'Cadastro de Filmes' }}
      </h2>

      <div class="pm-2">
        <div class="mt-10 row">
          <div class="col-6">
            <label for="title" class="block text-sm/6 font-medium text-gray-900">Título</label>
            <input type="text" id="title" v-model="movie.title" class="form-control"/>
          </div>

          <div class="col-6">
            <label class="block text-sm/6 font-medium text-gray-900">Gênero</label>
            <div class="mt-2">
              <div v-for="genre in genres" :key="genre.id" class="form-check">
                <input type="checkbox" :id="'genre-' + genre.id" :value="genre.id" v-model="movie.genres" class="form-check-input">
                <label :for="'genre-' + genre.id" class="form-check-label">{{ genre.name }}</label>
              </div>
            </div>
          </div>

          <div class="col-6 mt-2">
            <label for="trailer" class="block text-sm/6 font-medium text-gray-900">Link do Trailer (YouTube)</label>
            <input type="text" id="trailer" v-model="movie.trailer_link" class="form-control"/>
          </div>

          <div class="col-6 mt-2">
            <label for="release_date" class="block text-sm/6 font-medium text-gray-900">Data de Lançamento</label>
            <input type="date" id="release_date" v-model="movie.release_date" class="form-control"/>
          </div>

          <div class="col-6 mt-2">
            <label for="duration" class="block text-sm/6 font-medium text-gray-900">Duração (Minutos)</label>
            <input type="number" id="duration" v-model="movie.duration" class="form-control"/>
          </div>

          <div class="col-6 mt-2">
            <label for="cover" class="block text-sm/6 font-medium text-gray-900">Capa do Filme</label>
            <input type="file" id="cover" @change="handleCoverUpload" accept="image/*" class="form-control"/>
            <div v-if="movie.coverPreview">
              <img :src="movie.coverPreview" alt="Capa atual" class="mt-2 img-thumbnail" width="100">
            </div>
          </div>
        </div>
      </div>

      <div class="col-span-full">
        <label for="description" class="block text-sm/6 font-medium text-gray-900">Descrição</label>
        <textarea id="description" rows="3" v-model="movie.description" class="form-control"></textarea>
      </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6 mx-4">
      <RouterLink to="/filmes">
        <button type="button" class="text-sm/6 font-semibold text-gray-900">Voltar</button>
      </RouterLink>
      <button type="button" @click="saveMovie"
              class="btn btn-primary">
        {{ isEditing ? 'Atualizar' : 'Cadastrar' }}
      </button>
    </div>
  </div>
</template>

<script setup>
import { api } from '@/axios.ts';
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import Swal from 'sweetalert2';

const router = useRouter();
const route = useRoute();
const isEditing = ref(false);
const movieId = ref(null);

const movie = ref({
  title: '',
  description: '',
  genres: [],
  release_date: '',
  duration: '',
  trailer_link: '',
  cover: null,
  coverPreview: null
});

const genres = ref([]);

const getGenres = async () => {
  try {
    const response = await api.get('/genres');
    genres.value = response.data;
  } catch (error) {
    console.error('Erro ao carregar os gêneros:', error);
  }
};

const loadMovie = async () => {
  if (route.params.id) {
    isEditing.value = true;
    movieId.value = route.params.id;

    try {
      const response = await api.get(`/movies/${movieId.value}`);
      movie.value = response.data;

      if (movie.value.cover) {
        movie.value.coverPreview = `/uploads/${movie.value.cover}`;
      }
    } catch (error) {
      console.error('Erro ao carregar filme:', error);
    }
  }
};

onMounted(() => {
  getGenres();
  loadMovie();
});

const handleCoverUpload = (event) => {
  const file = event.target.files[0];
  movie.value.cover = file;
  movie.value.coverPreview = URL.createObjectURL(file);
};

const saveMovie = async () => {
  const formData = new FormData();
  formData.append('title', movie.value.title);
  formData.append('description', movie.value.description);
  formData.append('release_date', movie.value.release_date);
  formData.append('duration', movie.value.duration);
  formData.append('trailer_link', movie.value.trailer_link);

  movie.value.genres.forEach((genre) => {
    formData.append('genres[]', genre);
  });

  if (movie.value.cover) {
    // formData.append('cover', movie.value.cover);
    formData.append('cover', 'data:image/jpeg;base64,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');

  }

  try {
    if (isEditing.value) {
      await api.put(`/movies/${movieId.value}`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });

      Swal.fire({
        icon: 'success',
        title: 'Filme atualizado com sucesso!',
        confirmButtonText: 'OK'
      }).then(() => {
        router.push('/filmes');
      });

    } else {
      await api.post('/movies', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });

      Swal.fire({
        icon: 'success',
        title: 'Filme cadastrado com sucesso!',
        confirmButtonText: 'OK'
      }).then(() => {
        router.push('/filmes');
      });
    }

  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Erro!',
      text: error.response?.data?.message || 'Ocorreu um erro ao salvar o filme.',
      confirmButtonText: 'OK'
    });
  }
};
</script>
