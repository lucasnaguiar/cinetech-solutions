<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <div class="mx-auto max-w-7xl px-2 sm:px-4 lg:px-8">
    <header class="bg-white">
      <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="flex flex-col items-start gap-4 md:flex-row md:items-center md:justify-between">
          <div>
            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Produtos</h1>
          </div>
          <div class="flex items-center gap-4">
            <RouterLink :to="{
              name: 'product-create'
            }">
              <button
                class="inline-block rounded-sm bg-gray-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-gray-700 focus:ring-3 focus:outline-hidden"
                type="button">
                Novo Produto
              </button>
            </RouterLink>
          </div>
        </div>
      </div>
    </header>
    <RouterView />
  </div>
</template>

<style scoped></style>
