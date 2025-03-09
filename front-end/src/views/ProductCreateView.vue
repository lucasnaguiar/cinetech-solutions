<template>
  <form>
    <div class="space-y-12">
      <div class="border-b border-gray-900/10 pb-12">
        <h2 class="text-base/7 font-semibold text-gray-900">Cadastro de Produtos</h2>
        <p class="mt-1 text-sm/6 text-gray-600"></p>
        <div class="border-b border-gray-900/10 pb-12">
          <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="col-span-full">
              <label for="name" class="block text-sm/6 font-medium text-gray-900">Nome do Produto</label>
              <div class="mt-2">
                <input type="text" name="street-address" id="name"
                  class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-gray-600 sm:text-sm/6" />
              </div>
            </div>
            <div class="sm:col-span-2 sm:col-start-1">
              <label for="quantity" class="block text-sm/6 font-medium text-gray-900">Quantidade</label>
              <div class="mt-2">
                <input type="text" name="quantity" id="quantity"
                  class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-gray-600 sm:text-sm/6" />
              </div>
            </div>
            <div class="sm:col-span-2">
              <label for="price" class="block text-sm/6 font-medium text-gray-900">Preço</label>
              <div class="mt-2">
                <input type="text" name="price" id="price"
                  class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-gray-600 sm:text-sm/6" />
              </div>
            </div>
          </div>
        </div>

        <div class="col-span-full">
          <label for="description" class="block text-sm/6 font-medium text-gray-900">Descrição</label>
          <div class="mt-2">
            <textarea name="description" id="description" rows="3"
              class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-gray-600 sm:text-sm/6" />
          </div>
        </div>
      </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
    <RouterLink to="/">
      <button type="button" class="text-sm/6 font-semibold text-gray-900">Voltar</button>
    </RouterLink>
      <button type="submit"
        class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-gray-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">Cadastrar</button>
    </div>
  </form>
</template>

<script setup>
</script>
