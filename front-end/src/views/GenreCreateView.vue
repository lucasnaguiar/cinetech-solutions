<template>
  <div class="mt-5">
    <div class="border border-1 p-2 rounded-3 shadow pb-4 mx-2">
      <h2 class="text-base/7 font-semibold text-gray-900">
        {{ isEditing ? 'Editar Gênero' : 'Cadastro de Gêneros' }}
      </h2>

      <div class="pm-2">
        <div class="mt-10 row">
          <div class="col-6">
            <label for="title" class="block text-sm/6 font-medium text-gray-900">Nome</label>
            <input type="text" id="title" v-model="genre.name" class="form-control" />
          </div>

          <div class="col-span-full">
            <label for="description" class="block text-sm/6 font-medium text-gray-900">Descrição</label>
            <textarea id="description" rows="3" v-model="genre.description" class="form-control"></textarea>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6 mx-4">
      <RouterLink to="/filmes">
        <button type="button" class="text-sm/6 font-semibold text-gray-900">Voltar</button>
      </RouterLink>
      <button type="button" @click="saveGenre" class="btn btn-primary">
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
const genreId = ref(null);

const genre = ref({
  name: '',
  description: '',
});


onMounted(() => {
  // loadMovie();
});

const saveGenre = async () => {
  const formData = new FormData();
  formData.append('name', genre.value.name);
  formData.append('description', genre.value.description);

  try {
    if (isEditing.value) {
      await api.put(`/genres/${genreId.value}`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });

      Swal.fire({
        icon: 'success',
        title: 'Genero atualizado com sucesso!',
        confirmButtonText: 'OK'
      }).then(() => {
        router.push('/filmes');
      });

    } else {
      await api.post('/genres', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });

      Swal.fire({
        icon: 'success',
        title: 'Genero cadastrado com sucesso!',
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
