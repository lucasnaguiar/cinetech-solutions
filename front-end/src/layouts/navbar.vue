<template>
  <nav class="navbar navbar-dark bg-dark">
    <div class="container d-flex justify-content-between align-items-center position-relative">
      <a class="navbar-brand fw-bold" href="#">
        Cine<span class="text-warning">Tech</span> Solutions
      </a>
    </div>
  </nav>
</template>

<script setup>
import { ref } from 'vue';

</script>

<style scoped>
/* Estilização do menu */
.dropdown-item {
  min-width: 80px;
  z-index: 1000;
  /* Garante que o botão 'Sair' fique acima de outros elementos */
}

/* Garante que o container do menu tenha o posicionamento relativo */
.container {
  position: relative;
}
</style>
