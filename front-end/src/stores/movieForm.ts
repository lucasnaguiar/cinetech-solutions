import { defineStore } from 'pinia';
import { api } from '@/axios';
import { ref } from 'vue';
import type Movie from '@/types/movie';
import type Genre from '@/types/genre';

export const useMovieFormStore = defineStore('movieForm', () => {
  const formData = ref<Movie>({
    id: null,
    title: '',
    genres: [],
    trailer_link: '',
    release_date: '',
    duration: null,
    description: '',
    cover: null
  });

  const genreList = ref<Genre[]>([]);
  const isEditing = ref(false);
  const formRef = ref<any>(null); // Referência para o formulário
  const isLoading = ref(false); // Estado de carregamento

  const loadMovie = (movie: Movie) => {
    formData.value = { ...movie };
    isEditing.value = true;
  };

  const resetForm = () => {
    formData.value = {
      id: null,
      title: '',
      genres: [],
      trailer_link: '',
      release_date: '',
      duration: null,
      description: '',
      cover: null
    };
    isEditing.value = false;
  };

  const submitForm = async () => {
    try {
      // Valida o formulário antes de enviar
      await formRef.value?.validate();
      
      isLoading.value = true;
      
      const url = isEditing.value ? `/movies/${formData.value.id}` : '/movies';
      const method = isEditing.value ? 'PUT' : 'POST';

      const payload = new FormData();
      payload.append('title', formData.value.title || '');
      payload.append('trailer_link', formData.value.trailer_link || '');
      payload.append('release_date', formData.value.release_date || '');
      payload.append('duration', String(formData.value.duration) || '');
      payload.append('description', formData.value.description || '');

      if (formData.value.cover) {
        payload.append('cover', formData.value.cover);
      }

      if (formData.value.genres?.length) {
        payload.append('genres', JSON.stringify(formData.value.genres));
      }

      const response = await api({
        url,
        method,
        data: payload,
        headers: { 'Content-Type': 'multipart/form-data' }
      });

      resetForm();
      return response.data;
    } catch (error) {
      console.error('Erro ao enviar filme:', error);
      throw error;
    } finally {
      isLoading.value = false;
    }
  };

  return { 
    formData, 
    isEditing, 
    genreList, 
    formRef,
    isLoading,
    loadMovie, 
    resetForm, 
    submitForm 
  };
});