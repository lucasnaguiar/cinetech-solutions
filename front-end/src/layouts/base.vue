<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import Navbar from "@/layouts/navbar.vue";
</script>

<template>
  <div class="d-flex">
    <nav id="sidebar" class="bg-dark text-white vh-100 p-3">
      <h4 class="text-center">Menu</h4>
      <ul class="nav flex-column">
        <li class="nav-item">
          <RouterLink :to="{ name: 'home' }" class="nav-link text-white d-flex align-items-center">
            <i class="fas fa-home me-2"></i> <span>Home</span>
          </RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink :to="{ name: 'movie-list' }" class="nav-link text-white d-flex align-items-center">
            <i class="fas fa-film me-2"></i> <span>Filmes</span>
          </RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink :to="{ name: 'genre-list' }" class="nav-link text-white d-flex align-items-center">
            <i class="fas fa-box me-2"></i> <span>Gêneros</span>
          </RouterLink>
        </li>
      </ul>

    </nav>

    <div class="flex-grow-1 p-4">
      <RouterView />
    </div>
  </div>
</template>


<style scoped></style>
