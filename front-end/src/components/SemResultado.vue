<template>
  <div class="row">
    <div class="col-12 text-center">
      <img :src="no_results" alt="Logo">
      <h4 class=" text-secondary">{{ message ?? 'Nenhum resultado encontrado'}}</h4>
    </div>
  </div>
</template>
<script setup>
import no_results from '@/assets/no-results.webp';

const props = defineProps(['message'])
</script>
