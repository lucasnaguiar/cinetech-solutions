<template>
  <n-card class="mb-4" title="Cadastro de Filmes">
    <n-form ref="formRef" :model="formData" :rules="rules" @submit.prevent="handleSubmit">
      <n-grid :cols="24" :x-gap="24">
        <!-- Título -->
        <n-form-item-gi :span="12" label="Título" path="title">
          <n-input v-model:value="formData.title" placeholder="Digite o título do filme" />
        </n-form-item-gi>

        <!-- Gêneros -->
        <n-form-item-gi :span="12" label="Gênero" path="genres">
          <n-checkbox-group v-model:value="formData.genres">
            <n-space item-style="display: flex;">
              <n-checkbox v-for="genre in genreList" :key="genre.id" :value="genre.id" :label="genre.name" />
            </n-space>
          </n-checkbox-group>
        </n-form-item-gi>

        <!-- Link do Trailer -->
        <n-form-item-gi :span="12" label="Link do Trailer (YouTube)" path="trailer_link">
          <n-input v-model:value="formData.trailer_link" placeholder="Cole o link do YouTube" />
        </n-form-item-gi>

        <!-- Data de Lançamento -->
        <n-form-item-gi :span="12" label="Data de Lançamento" path="release_date">
          <n-date-picker :value="releaseDateTimestamp" @update:value="handleDateChange" type="date"
            value-format="yyyy-MM-dd" clearable />
        </n-form-item-gi>

        <!-- Duração -->
        <n-form-item-gi :span="12" label="Duração (Minutos)" path="duration">
          <n-input-number v-model:value="formData.duration" :min="1" clearable />
        </n-form-item-gi>

        <!-- Descrição -->
        <n-form-item-gi :span="24" label="Descrição" path="description">
          <n-input v-model:value="formData.description" type="textarea" :rows="3"
            placeholder="Digite a descrição do filme" />
        </n-form-item-gi>
      </n-grid>
      <div>
        <div class="col-span-full">
          <label for="cover-photo" class="block text-sm/6 font-medium text-gray-900">Cover photo</label>
          <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
            <div class="text-center">
              <svg v-if="!previewUrl" class="mx-auto size-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor"
                aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd"
                  d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z"
                  clip-rule="evenodd" />
              </svg>
              <img v-if="previewUrl" class="h-64" :src="previewUrl" alt="">
              <div class="mt-4 flex text-sm/6 text-gray-600">
                <label for="file-upload"
                  class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 focus-within:outline-hidden hover:text-indigo-500">
                  <span>Upload a file</span>
                  <input id="file-upload" name="cover-upload" type="file" class="sr-only" @change="handleCoverUpload">
                </label>
              </div>
              <p class="text-xs/5 text-gray-600">PNG, JPG até 2mb</p>
            </div>
          </div>
        </div>
      </div>
      <!-- Botões -->
      <n-space justify="end" class="mt-4">
        <router-link to="/filmes">
          <n-button type="default">Voltar</n-button>
        </router-link>
        <n-button type="primary" attr-type="submit" :loading="isLoading" :disabled="isLoading">
          Cadastrar
        </n-button>
      </n-space>
    </n-form>

  </n-card>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { api } from '@/axios';
import { useRouter, useRoute } from 'vue-router';
import {
  NCard,
  NForm,
  NFormItemGi,
  NInput,
  NCheckboxGroup,
  NCheckbox,
  NDatePicker,
  NInputNumber,
  NButton,
  NSpace,
  NGrid,
  NText,
  type FormRules,
  type FormInst
} from 'naive-ui';

interface Genre {
  id: number;
  name: string;
}

interface MovieForm {
  title: string;
  genres: number[];
  trailer_link: string;
  release_date: string;
  duration: number | null;
  description: string;
}

const formData = ref<MovieForm>({
  title: '',
  genres: [],
  trailer_link: '',
  release_date: '',
  duration: '',
  description: '',
});
const route = useRoute();

const genreList = ref<Genre[]>([]);

const coverFile = ref<File | null>();
const previewUrl = ref()
const isLoading = ref(false);
const movieId = ref();
const formRef = ref<FormInst | null>(null);


const releaseDateTimestamp = computed(() => {
  return formData.value.release_date
    ? new Date(formData.value.release_date).getTime()
    : null;
});

const handleDateChange = (timestamp: number | null) => {
  formData.value.release_date = timestamp
    ? new Date(timestamp).toISOString().split('T')[0]
    : '';
};

function handleCoverUpload(event) {
  const file = event.target.files[0]
  if (file) {
    coverFile.value = file
    previewUrl.value = URL.createObjectURL(file)
  }
}


const rules: FormRules = {
  title: [
    { required: true, message: 'Por favor, insira o título do filme', trigger: 'blur' },
    { min: 2, message: 'O título deve ter pelo menos 2 caracteres', trigger: 'blur' }
  ],
  genres: [
    {
      type: 'array',
      required: true,
      message: 'Selecione pelo menos um gênero',
      trigger: 'change'
    }
  ],
  trailer_link: [
    { required: true, message: 'Por favor, insira o link do trailer', trigger: 'blur' },
    {
      pattern: /^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/,
      message: 'Insira um link válido do YouTube',
      trigger: 'blur'
    }
  ],
  release_date: [
    { required: true, message: 'Selecione a data de lançamento', trigger: 'blur' }
  ],
  duration: [
    { required: true, type: 'number', message: 'Insira a duração em minutos', trigger: 'blur' },
    { type: 'number', min: 1, message: 'A duração deve ser maior que 0', trigger: 'blur' }
  ],
  description: [
    { required: true, message: 'Por favor, insira a descrição', trigger: 'blur' },
    { min: 10, message: 'A descrição deve ter pelo menos 10 caracteres', trigger: 'blur' }
  ]
};

const loadGenres = async () => {
  try {
    const response = await api.get('/genres');
    genreList.value = response.data;
  } catch (error) {

    console.error(error);
  }
};

const handleSubmit = async () => {
  try {

    await formRef.value?.validate();

    isLoading.value = true;

    const payload = new FormData();
    payload.append('title', formData.value.title);
    payload.append('trailer_link', formData.value.trailer_link);
    payload.append('release_date', formData.value.release_date);
    payload.append('duration', String(formData.value.duration));
    payload.append('description', formData.value.description);
    payload.append('genres', JSON.stringify(formData.value.genres));


    const response = await api.put('/movies/' + movieId.value, payload, {
      headers: { 'Content-Type': 'application/json' }
    });

    formData.value = {
      title: '',
      genres: [],
      trailer_link: '',
      release_date: '',
      duration: null,
      description: '',
    };

    if (response.status == 200 && coverFile.value) {
      movieId.value = response.data.id
      sendImage()
    }

    return response.data;
  } catch (error) {
    console.error('Erro ao cadastrar filme:', error);

    throw error;
  } finally {
    isLoading.value = false;
  }
};

const sendImage = async () => {

  const imageFormData = new FormData();
  imageFormData.append("cover", coverFile.value);

  await fetch('http://127.0.0.1:48000/api/movies/' + movieId.value + '/update-cover', {
    method: 'POST',
    body: imageFormData,
  })
}

onMounted(() => {
  loadGenres();
  loadMovie();
});

const loadMovie = async () => {
  if (route.params.id) {
    movieId.value = route.params.id;
    try {
      const response = await api.get(`/movies/${movieId.value}`);
      formData.value = response.data;
      const genreIds = response.data.genres.map(item => item.id);
      formData.value.genres = genreIds;
    } catch (error) {
      console.error('Erro ao carregar genero:', error);
    }
  }
};
</script>

<style scoped>
.ml-2 {
  margin-left: 8px;
}
</style>