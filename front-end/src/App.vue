<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import { RouterView } from 'vue-router'
import BasePadrao from '@/layouts/base.vue'

const route = useRoute()

// Se a rota tiver meta.layout = 'none', não aplica layout
const layout = computed(() => (route.meta.layout === 'none' ? 'div' : BasePadrao))
</script>

<template>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

  <component :is="layout">
    
    <RouterView />
  </component>
</template>

<style scoped></style>
