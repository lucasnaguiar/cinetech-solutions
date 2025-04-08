<!-- MovieModal.vue -->
<template>
  <div class="modal modal-lg fade" id="movieDetailsModal" tabindex="-1" aria-labelledby="movieDetailsModalLabel"
    aria-hidden="true" v-if="movie">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="movieDetailsModalLabel">{{ movie.title }}</h5>
          <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div v-if="movie.trailer_link" class="ratio ratio-16x9 mb-4">
            <iframe :src="embedYouTubeUrl(movie.trailer_link)" frameborder="0" allowfullscreen></iframe>
          </div>

          <ul>
            <li class="inline px-1 font-bold" v-for="genre in movieDetail?.genres"> <span
                class="rounded-full bg-gray-200 px-2.5 py-0.5 text-sm whitespace-nowrap text-gray-700">
                {{ genre.name }}
              </span></li>
          </ul>
          <p><strong>Descrição:</strong> {{ movie.description }}</p>
          <p><strong>Lançamento:</strong> {{ formatDate(movie.release_date) }}</p>
          <p><strong>Duração:</strong> {{ movie.duration }}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="closeModal">Fechar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { api } from '@/axios';
import { defineProps, defineEmits, onMounted, ref } from 'vue';
const movieDetail = ref();

const props = defineProps({
  movie: Object
});


onMounted(() => {
  api.get('/movies/' + props.movie.id).then(
    (response) => {
      movieDetail.value = response.data
    }
  )
})

const emit = defineEmits(['close']);

const closeModal = () => {
  emit('close');
};

const embedYouTubeUrl = (url) => {
  const videoId = url.split('v=')[1]?.split('&')[0];
  return videoId ? `https://www.youtube.com/embed/${videoId}` : '';
};

const formatDate = (dateString) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  return date.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric' });
};
</script>
