<template>
  <div class="row">
    <div class="col-12 d-flex justify-content-end">
      <Link
          v-for="link in dados.links"
          :key="link.label"
          :as="!link.url || link.active ? 'button' : 'a'"
          :disabled="!link.url || link.active"
          class="btn me-1"
          :class="{'btn-primary text-white': link.active, 'btn-outline-primary': !link.active}"
          :href="link.url ?? '#!'"
          preserve-state
          :only="only ?? ['dados']"
      >
        <template v-if="link.label.includes('Previous')">
          <i class="fas fa-angle-left"></i>
        </template>
        <template v-else-if="link.label.includes('Next')">
          <i class="fas fa-angle-right"></i>
        </template>
        <template v-else>
          {{ link.label }}
        </template>
      </Link>
    </div>
  </div>
</template>

<script setup>
const props = defineProps(['dados', 'only']);
</script>
