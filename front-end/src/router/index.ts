import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import MovieCreateView from '@/views/MovieCreateView.vue'
import GenreCreateView from '@/views/GenreCreateView.vue'
import MovieListView from "@/views/MovieListView.vue";
import GenreListView from "@/views/GenreListView.vue";
import LoginView from '@/views/LoginView.vue'
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      meta: { layout: 'none', requiresAuth: false }

    },
    {
      path: '/admin/filmes/cadastro',
      name: 'movie-create',
      component: MovieCreateView,
      meta: { requiresAuth: true },

    },
    {
      path: '/admin/generos/cadastro',
      name: 'genre-create',
      component: GenreCreateView,
      meta: { requiresAuth: true },
    },
    {
      path: '/admin/filmes/cadastro/:id?',
      name: 'movie-form',
      component: MovieCreateView,
      meta: { requiresAuth: true },

    },
    {
      path: '/admin/filmes',
      name: 'movie-list',
      component: MovieListView,
      meta: { requiresAuth: true },

    },
    {
      path: '/admin/generos',
      name: 'genre-list',
      component: GenreListView,
      meta: { requiresAuth: true },

    },
    {
      path: '/admin/filmes/editar/:id',
      name: 'movie-update',
      component: MovieCreateView,
      meta: { requiresAuth: true },

    },
    {
      path: '/admin/login',
      name: 'login',
      component: LoginView,
      meta: { layout: 'none' }
    },
  ],
})
const auth = {
  isLoggedIn() {
    const token = localStorage.getItem('access_token');
    return !!token; // Retorna true se o token existir
  },
}

router.beforeEach((to, from) => {
  if (to.meta.requiresAuth && !auth.isLoggedIn()) {
    return {
      path: 'admin/login',
    }
  }
})

export default router
