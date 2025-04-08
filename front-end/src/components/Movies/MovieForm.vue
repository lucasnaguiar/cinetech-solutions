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

        <!-- Capa do Filme -->
        <n-form-item-gi :span="12" label="Capa do Filme" path="cover">
          <n-upload accept="image/*" :show-file-list="false" :default-upload="false" @change="handleCoverUpload">
            <n-button>Selecionar Arquivo</n-button>
          </n-upload>
          <n-text v-if="formData.cover" depth="3" class="ml-2">
            {{ formData.cover.name }}
          </n-text>
        </n-form-item-gi>

        <!-- Descrição -->
        <n-form-item-gi :span="24" label="Descrição" path="description">
          <n-input v-model:value="formData.description" type="textarea" :rows="3"
            placeholder="Digite a descrição do filme" />
        </n-form-item-gi>
      </n-grid>

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
import {
  NCard,
  NForm,
  NFormItemGi,
  NInput,
  NCheckboxGroup,
  NCheckbox,
  NDatePicker,
  NInputNumber,
  NUpload,
  NButton,
  NSpace,
  NGrid,
  NText,
  type FormRules,
  type FormInst,
  useMessage
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
  cover: File | null;
}

// Dados do formulário
const formData = ref<MovieForm>({
  title: '',
  genres: [],
  trailer_link: '',
  release_date: '',
  duration: null,
  description: '',
  cover: null
});

// Lista de gêneros
const genreList = ref<Genre[]>([]);

// Estado de carregamento
const isLoading = ref(false);

// Referência do formulário para validação
const formRef = ref<FormInst | null>(null);

// Mensagens de notificação

// Conversão de data para o date-picker
const releaseDateTimestamp = computed(() => {
  return formData.value.release_date
    ? new Date(formData.value.release_date).getTime()
    : null;
});

// Handler para mudança de data
const handleDateChange = (timestamp: number | null) => {
  formData.value.release_date = timestamp
    ? new Date(timestamp).toISOString().split('T')[0]
    : '';
};

// Handler para upload de capa
const handleCoverUpload = ({ file }: { file: File }) => {
  formData.value.cover = file;
};

// Regras de validação
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
  ],
  cover: [
    {
      required: true,
      message: 'Por favor, selecione uma capa',
      trigger: 'change'
    }
  ]
};

// Carrega a lista de gêneros
const loadGenres = async () => {
  try {
    const response = await api.get('/genres');
    genreList.value = response.data;
  } catch (error) {

    console.error(error);
  }
};

// Envia o formulário
const handleSubmit = async () => {
  try {
    // Valida o formulário
    await formRef.value?.validate();

    isLoading.value = true;

    // Prepara o FormData
    const payload = new FormData();
    payload.append('title', formData.value.title);
    payload.append('trailer_link', formData.value.trailer_link);
    payload.append('release_date', formData.value.release_date);
    payload.append('duration', String(formData.value.duration));
    payload.append('description', formData.value.description);

    if (formData.value.cover) {
      payload.append('cover', formData.value.cover);
    }

    payload.append('genres', JSON.stringify(formData.value.genres));

    // Envia para a API
    const response = await api.post('/movies', payload, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });

    // Feedback de sucesso


    // Reseta o formulário
    formData.value = {
      title: '',
      genres: [],
      trailer_link: '',
      release_date: '',
      duration: null,
      description: '',
      cover: null
    };

    return response.data;
  } catch (error) {
    console.error('Erro ao cadastrar filme:', error);

    throw error;
  } finally {
    isLoading.value = false;
  }
};

// Carrega os gêneros quando o componente é montado
onMounted(() => {
  loadGenres();
});
</script>

<style scoped>
.ml-2 {
  margin-left: 8px;
}
</style>