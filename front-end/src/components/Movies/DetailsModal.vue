<!-- MovieModal.vue -->
<template>
  <div class="modal modal-lg fade" id="movieDetailsModal" tabindex="-1" aria-labelledby="movieDetailsModalLabel" aria-hidden="true" v-if="movie">
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
          <p><strong>Gênero:</strong> {{ movie.genre }}</p>
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
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
  movie: Object
});

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
