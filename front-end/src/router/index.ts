import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import ProductDetailView from '@/views/ProductDetailView.vue'
import MovieCreateView from '@/views/MovieCreateView.vue'
import ProductEditView from '@/views/ProductEditView.vue'
import MovieListView from "@/views/MovieListView.vue";
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      meta: { layout: 'none' }

    },
    {
      path: '/filmes/cadastro',
      name: 'movie-create',
      component: MovieCreateView,
    },
    {
      path: '/filmes/cadastro/:id?',
      name: 'movie-form',
      component: MovieCreateView,
    },

    {
      path: '/filmes',
      name: 'movie-list',
      component: MovieListView,
    },
    {
      path: '/genero/:id',
      name: 'product-detail',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: ProductDetailView,
    },
    {
      path: '/filmes/editar/:id',
      name: 'movie-update',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: MovieCreateView,
    },
  ],
})

export default router
