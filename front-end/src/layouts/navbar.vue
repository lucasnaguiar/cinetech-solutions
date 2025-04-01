<template>
  <nav class="navbar navbar-dark bg-dark">
    <div class="container d-flex justify-content-between align-items-center position-relative">
      <a class="navbar-brand fw-bold" href="#">
        Cine<span class="text-warning">Tech</span> Solutions
      </a>
      <div>
        <template v-if="user">
          <span class="text-warning fw-bold">Olá, {{ user.name }}</span>
          <div class="d-inline-flex align-items-center ms-3" @click="toggleMenu" style="border-radius: 50%; width: 35px; height: 35px; background-color: #f39c12; color: white; justify-content: center; align-items: center; cursor: pointer;">
            {{ user.name[0] }}
          </div>

          <!-- Menu de opções (Sair) no canto direito abaixo do ícone -->
          <div v-if="showMenu" class="position-absolute mx-2" style="top: 45px; right: 0; z-index: 999;">
            <button class="dropdown-item fw-semibold text-center bg-white text-warning border border-1 rounded-3 border-warning p-1" @click="logout">
              <i class="fa fa-sign-out-alt me-2"></i> Sair
            </button>
          </div>
        </template>
        <template v-else>
          <button class="btn btn-outline-warning d-flex align-items-center" @click="login">
            <i class="fa fa-user me-2"></i> Entrar
          </button>
        </template>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref } from 'vue';

// Simulando um usuário logado
const user = ref(null);

// Estado para controlar a exibição do menu
const showMenu = ref(false);

// Função para alternar a visibilidade do menu
const toggleMenu = () => {
  showMenu.value = !showMenu.value;
};

// Simulando login
const login = () => {
  user.value = { name: "João" };
};

// Função de logout
const logout = () => {
  user.value = null;
  showMenu.value = false; // Esconde o menu após logout
};
</script>

<style scoped>
/* Estilização do menu */
.dropdown-item {
  min-width: 80px;
  z-index: 1000; /* Garante que o botão 'Sair' fique acima de outros elementos */
}

/* Garante que o container do menu tenha o posicionamento relativo */
.container {
  position: relative;
}
</style>
