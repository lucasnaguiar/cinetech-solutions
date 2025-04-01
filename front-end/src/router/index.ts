import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import ProductDetailView from '@/views/ProductDetailView.vue'
import MovieCreateView from '@/views/MovieCreateView.vue'
import ProductEditView from '@/views/ProductEditView.vue'
import MovieListView from "@/views/MovieListView.vue";
import LoginView from '@/views/LoginView.vue'
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
    {
      path: '/login',
      name: 'login',
      component: LoginView,
      meta: { requiresAuth: false },
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
  // instead of having to check every route record with
  // to.matched.some(record => record.meta.requiresAuth)
  if (to.meta.requiresAuth && !auth.isLoggedIn()) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    return {
      path: '/login',
      // save the location we were at to come back later
      // query: { redirect: to.fullPath },
    }
  }
})

export default router
