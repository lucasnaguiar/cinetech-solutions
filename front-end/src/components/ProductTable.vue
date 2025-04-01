<template>
  <div class="overflow-x-auto rounded-lg border border-gray-200">
    <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
      <thead class="ltr:text-left rtl:text-right">
        <tr>
          <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Nome</th>
          <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Quantidade</th>
        </tr>
      </thead>

      <tbody class="divide-y divide-gray-200">
<!--        <tr v-for="product in products" :key="product.id">-->
<!--          <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ product.name }}</td>-->
<!--          <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ product.stock_quantity }}</td>-->
<!--        </tr>-->
      </tbody>
    </table>
  </div>
</template>
<script setup lang="ts">
import {api} from '@/axios.ts'
// import type Product from '@/types/product';
import { onMounted, ref } from 'vue';

const products = ref<Product[]>([]);
// onMounted(() => {
//   getProdutcs()
// })

// const getProdutcs = async () => {
//   await api.get('/gender').then(
//     (response) => {
//       products.value = response.data
//     }
//   );
// }
</script>
