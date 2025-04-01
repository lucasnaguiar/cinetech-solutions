<template>
  <div class="flow-root">
    <dl class="-my-3 divide-y divide-gray-100 text-sm">
      <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
        <dt class="font-medium text-gray-900">Nome do Produto</dt>
        <dd class="text-gray-700 sm:col-span-2">{{ product?.name }}</dd>
      </div>

      <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
        <dt class="font-medium text-gray-900">Quantidade</dt>
        <dd class="text-gray-700 sm:col-span-2">{{ product?.stock_quantity }}</dd>
      </div>

      <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
        <dt class="font-medium text-gray-900">Preço</dt>
        <dd class="text-gray-700 sm:col-span-2">R$ {{ product?.price }}</dd>
      </div>

      <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
        <dt class="font-medium text-gray-900">Data de Criação</dt>
        <dd class="text-gray-700 sm:col-span-2">{{ product?.created_at }}</dd>
      </div>

      <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
        <dt class="font-medium text-gray-900">Descrição</dt>
        <dd class="text-gray-700 sm:col-span-2">
          {{ product?.description }}
        </dd>
      </div>

      <div class="flex">
        <div class="mt-6 flex items-center justify-end gap-x-6">
          <RouterLink to="/">
            <button type="button" class="text-sm/6 font-semibold text-gray-900">Voltar</button>
          </RouterLink>
          <button type="button"
            class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-gray-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">Editar</button>
          <button type="button" @click="destroyProduct()"
            class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Excluir</button>
        </div>
      </div>
    </dl>
  </div>
</template>
<script setup lang="ts">
import { api } from '@/axios.ts'
// import type Product from '@/types/product';
import { onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router'
const route = useRoute()
const router = useRouter()

onMounted(() => {
  getProdutc()
})
const product = ref<Product>()

const getProdutc = async () => {
  await api.get('/genres/' + route.params.id).then(
    (response) => {
      product.value = response.data
      console.log(product.value)
    }
  );
}

const destroyProduct = async () => {
  await api.delete('/genres/' + route.params.id).then(
    (response) => {
      router.push('/')
    }
  ).catch(function (error) {
    console.error(error.response.data);
  });
}
</script>
