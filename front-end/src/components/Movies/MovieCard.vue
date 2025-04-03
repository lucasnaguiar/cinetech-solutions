<!-- MovieCard.vue -->
<template>
  <div class="col-xl-2 col-lg-3 col-md-4 col-sm-12 mb-4">
    <div class="card shadow-sm">
      <div class="card-header p-1 fw-semibold">
        {{ movie.genre }}
      </div>
      <img :src="coverUrl + movie.cover" class="" alt="Imagem de capa">
      <div class="card-body">
        <h5 class="card-title">{{ movie.title }}</h5>
        <div class="btn btn-sm btn-primary mt-4" @click="showDetails">
          <i class="fa fa-plus fs-6 mx-1" aria-hidden="true"></i>
          Detalhes
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, ref } from 'vue';

const props = defineProps({
  movie: Object,
  onShowDetails: Function
});
const coverUrl = ref(import.meta.env.VITE_API_BASE_URL)
const showDetails = () => {
  props.onShowDetails(props.movie);
};
</script>
