<template>
  <div class="d-flex justify-content-end mb-3">
    <RouterLink :to="{ name: 'genre-create' }">
      <button class="btn btn-primary">
        <i class="fa fa-plus me-2"></i>Novo Genero
      </button>
    </RouterLink>
  </div>

  <div class="mt-5 rounded-3">
    <table class="table table-responsive border border-1 shadow rounded-3 p-2">
      <thead>
        <tr>
          <th scope="col" class="text-center">ID</th>
          <th scope="col" class="text-center">Nome</th>
          <th scope="col" class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(genre, index) in genres" :key="genre.id">
          <td class="text-center">{{ genre.id }}</td>
          <td class="text-center">{{ genre.name }}</td>
          <td class="text-center">
            <RouterLink :to="`/admin/generos/cadastro/${genre.id}`" class="btn btn-warning btn-sm me-2">
              <i class="fa fa-edit"></i>
            </RouterLink>
            <button @click="deleteGenre(genre.id)" class="btn btn-danger btn-sm">
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

const genres = ref([]);
const movies = ref([]);

const getGenres = async () => {
  try {
    const response = await api.get('/genres');
    genres.value = response.data;
  } catch (error) {
    console.error('Erro ao carregar os gêneros:', error);
  }
};

const deleteGenre = async (id) => {
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
        await api.delete(`/genres/${id}`);
        movies.value = movies.value.filter(genre => genre.id !== id);
        Swal.fire('Excluído!', 'O genero foi removido com sucesso.', 'success');
      } catch (error) {
        Swal.fire('Erro!', 'Não foi possível excluir o genero.', 'error');
        console.error('Erro ao excluir o genero:', error);
      }
    }
  });
};

onMounted(() => {
  getGenres()
});
</script>
