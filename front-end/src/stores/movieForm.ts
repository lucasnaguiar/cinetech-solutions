import { defineStore } from 'pinia';
import { api } from '@/axios';
import { ref, reactive } from 'vue';
import type Movie from '@/types/movie';
import type Genre from '@/types/genre';

export const useMovieFormStore = defineStore('movieForm', () => {

  const formData = reactive<Movie>({
    id: null,
    title: 'Toy Story',
    genres: [2, 3, 4],
    trailer_link: 'www.google.com.br',
    release_date: '2025-04-01',
    duration: 120,
    description: 'brinquedos',
    cover: null
  });

  const genreList = ref<Genre[]>([])

  const isEditing = ref(false);
  const loadMovie = (movie: Movie) => {
    Object.assign(formData, movie);
    isEditing.value = true;
  };

  const resetForm = () => {
    Object.assign(formData, {
      id: null,
      title: '',
      genres: [],
      trailer_link: '',
      release_date: '',
      duration: null,
      description: '',
      cover: null
    });
    isEditing.value = false;
  };


  const submitForm = async () => {
    try {

      const url = isEditing.value ? `/movies/${formData.id}` : '/movies'
      const method = isEditing.value ? 'PUT' : 'POST';

      const payload = new FormData();

      payload.append('title', formData.title || '');
      payload.append('trailer_link', formData.trailer_link || '');
      payload.append('release_date', formData.release_date || '');
      payload.append('duration', formData.duration ? formData.duration.toString() : '');
      payload.append('description', formData.description || '');

      if (formData.cover) {
        payload.append('cover', formData.cover);
      }

      payload.append('genres', JSON.stringify(formData.genres));

      const response = await api.request({
        url,
        method,
        data: payload,
        headers: { 'Content-Type': 'multipart/form-data' }
      });

      resetForm();
      return response.data;
    } catch (error) {
      throw error;
    }
  };


  return { formData, isEditing, genreList, loadMovie, resetForm, submitForm };
});