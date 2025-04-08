<template layout="none">
  <Navbar></Navbar>

  <div class="text-center mt-5">
    <h2 class="text-3xl font-bold text-gray-800">Explore os Melhores Filmes</h2>
    <p class="mt-2 text-lg text-gray-600">Descubra uma seleção exclusiva dos melhores filmes, prontos para serem
      assistidos por você.</p>
  </div>

  <div class="container mt-5">
    <div class="row">
      <div class="col-12 d-flex justify-content-center">
        <div class="input-group border border-2 rounded-3 shadow-sm mb-3">
          <input type="text" class="form-control border border-0" placeholder="Buscar filmes..." v-model="searchQuery"
            aria-label="Buscar filmes" aria-describedby="basic-addon2">

          <div class="input-group-prepend">
            <i class="fas fa-search p-3 text-primary fw-bold"></i>
          </div>
        </div>
        <button
          class="btn btn-primary mt-1 shadow py-4 px-3 h-10 rounded-circle mx-3 d-flex align-items-center justify-content-center"
          type="button" @click="toggleSelectVisibility">
          <i class="fas fa-filter"></i>
        </button>
      </div>

      <div v-if="showSelect" class="col-12 mt-2 border border-1 p-3 mx-3 rounded-4">
        <label for="genreSelect" class="form-label">Selecione o Gênero</label>
        <select class="form-select border-2 rounded-3 shadow-sm p-2" id="genreSelect" @change="getMovies()"
          v-model="selectedGenre">
          <option>Todos os Gêneros</option>
          <option v-for="genre in genres" :key="genre.id" :value="genre.id">
            {{ genre.name }}
          </option>
        </select>
      </div>

    </div>

    <div class="row mt-5" v-if="movies.length > 0">
      <MovieCard v-for="movie in movies" :key="movie.id" :movie="movie" :onShowDetails="openModal" />
    </div>

    <div v-else class="d-flex justify-content-center align-items-center mb-5">
      <SemResultado />
    </div>

    <DetailsModal v-if="selectedMovie" :movie="selectedMovie" @close="closeModal" />
  </div>

  <Footer></Footer>
</template>

<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';
import Navbar from "@/layouts/navbar.vue";
import Footer from "@/layouts/footer.vue";
import { Modal } from 'bootstrap';
import MovieCard from "@/components/Movies/MovieCard.vue";
import DetailsModal from "@/components/Movies/DetailsModal.vue";
import { api } from "@/axios.ts";
import { debounce } from 'lodash';
import SemResultado from "@/components/SemResultado.vue";

const movies = ref<any>({ data: [], meta: {}, links: [] });
const genres = ref<any>({ data: [], meta: {}, links: [] });
const searchQuery = ref('');
const selectedMovie = ref(null);
const showSelect = ref(false);
const selectedGenre = ref()
const getMovies = async (search = '') => {
  try {
    const response = await api.get('/movies', {
      params: { search: search, genre: selectedGenre.value },
    });
    movies.value = response.data;
  } catch (error) {
    console.error('Erro ao carregar os filmes:', error);
  }
};

const getGenres = async () => {
  try {
    const response = await api.get('/genres', {
    });
    genres.value = response.data;
  } catch (error) {
    console.error('Erro ao carregar os generos:', error);
  }
};

const debouncedSearch = debounce(() => {
  getMovies(searchQuery.value);
}, 500);

watch(searchQuery, (newValue) => {
  if (newValue.length >= 3) {
    debouncedSearch();
  } else {
    getMovies();
  }
});


const toggleSelectVisibility = () => {
  showSelect.value = !showSelect.value;
};

const openModal = (movie: any) => {
  selectedMovie.value = movie;
  const modal = new Modal(document.getElementById('movieDetailsModal')!);
  modal.show();
};

const closeModal = () => {
  selectedMovie.value = null;
  const modal = Modal.getInstance(document.getElementById('movieDetailsModal')!);
  modal?.hide();
};

onMounted(() => {
  getMovies();
  getGenres();
});
</script>
