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
    </dl>
  </div>
</template>
<script setup lang="ts">
import {api} from '@/axios.ts'
import type Product from '@/types/product';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router'
const route = useRoute()

onMounted(() => {
  getProdutc()
})
const product = ref<Product>()

const getProdutc = async () => {
  await api.get('/products/'+route.params.id).then(
    (response) => {
      product.value = response.data
    }
  );
}
</script>
