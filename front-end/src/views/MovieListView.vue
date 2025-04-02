<template>
  <div class="d-flex justify-content-end mb-3">
    <RouterLink :to="{ name: 'movie-create' }">
      <button class="btn btn-primary">
        <i class="fa fa-plus me-2"></i>Novo Filme
      </button>
    </RouterLink>
  </div>

  <div class="mt-5 rounded-3">
    <table class="table table-responsive border border-1 shadow rounded-3 p-2">
      <thead>
        <tr>
          <th scope="col" class="text-center">ID</th>
          <th scope="col" class="text-center">Título</th>
          <th scope="col" class="text-center">Data de Lançamento</th>
          <th scope="col" class="text-center">Duração</th>
          <th scope="col" class="text-center">Trailer</th>
          <th scope="col" class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(movie, index) in movies" :key="movie.id">
          <th scope="row" class="text-center">{{ index + 1 }}</th>
          <td class="text-center">{{ movie.title }}</td>
          <td class="text-center">{{ formatDate(movie.release_date) }}</td>
          <td class="text-center">{{ movie.duration }} min</td>
          <td class="text-center">
            <a v-if="movie.trailer_link" :href="movie.trailer_link" target="_blank">Assistir</a>
            <span v-else>Não disponível</span>
          </td>
          <td class="text-center">
            <RouterLink :to="`/filmes/cadastro/${movie.id}`" class="btn btn-warning btn-sm me-2">
              <i class="fa fa-edit"></i>
            </RouterLink>
            <button @click="deleteMovie(movie.id)" class="btn btn-danger btn-sm">
              <i class="fa fa-trash"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { api } from '@/axios.ts';
import { ref, onMounted } from 'vue';
import Swal from 'sweetalert2';

const movies = ref([]);

const getMovies = async () => {
  try {
    const response = await api.get('/movies');
    movies.value = response.data;
  } catch (error) {
    console.error('Erro ao carregar os filmes:', error);
  }
};

const formatDate = (dateString) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  return date.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric' });
};

const deleteMovie = async (id) => {
  Swal.fire({
    title: 'Tem certeza?',
    text: 'Esta ação não pode ser desfeita!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sim, excluir!',
    cancelButtonText: 'Cancelar'
  }).then(async (result) => {
    if (result.isConfirmed) {
      try {
        await api.delete(`/movies/${id}`);
        movies.value = movies.value.filter(movie => movie.id !== id);
        Swal.fire('Excluído!', 'O filme foi removido com sucesso.', 'success');
      } catch (error) {
        Swal.fire('Erro!', 'Não foi possível excluir o filme.', 'error');
        console.error('Erro ao excluir o filme:', error);
      }
    }
  });
};

onMounted(getMovies);
</script>
