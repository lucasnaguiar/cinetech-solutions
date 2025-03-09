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
        <tr v-for="product in products" :key="product.id">
          <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ product.name }}</td>
          <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ product.stock_quantity }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script setup lang="ts">
const products = [
  {
    "id": 1,
    "name": "Iphone 15 Pro Max",
    "description": "um celular doidao",
    "price": "4000.00",
    "stock_quantity": 10,
    "created_at": "2025-03-09 17:27:48"
  },
  {
    "id": 2,
    "name": "Iphone 15 Pro Max",
    "description": "um celular doidao",
    "price": "4000.00",
    "stock_quantity": 10,
    "created_at": "2025-03-09 17:39:27"
  },
  {
    "id": 3,
    "name": "Iphone 15 Pro Max",
    "description": "um celular doidao",
    "price": "4000.00",
    "stock_quantity": 10,
    "created_at": "2025-03-09 20:23:17"
  },
  {
    "id": 4,
    "name": "Relogio ROlex",
    "description": "relogio automatico",
    "price": "32723.00",
    "stock_quantity": 2,
    "created_at": "2025-03-09 20:38:38"
  }
];
</script>
