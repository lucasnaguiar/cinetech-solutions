<template>
    <div class="border p-2 rounded-3 shadow pb-4 mx-2">
        <h2 class="text-base/7 font-semibold text-gray-900">
            {{ isEditing ? 'Editar Filme' : 'Cadastro de Filmes' }}
        </h2>

        <div class="pm-2">
            <div class="mt-10 row">
                <div class="col-6">
                    <label for="title" class="block text-sm/6 font-medium text-gray-900">Título</label>
                    <Field type="text" id="title" name="title" v-model="title.value" class="form-control"
                        rules="required|min:3" />
                    <ErrorMessage name="title" class="text-danger small" />
                </div>

                <div class="col-6">
                    <label class="block text-sm/6 font-medium text-gray-900">Gênero</label>
                    <div class="mt-2">
                        <div v-for="genre in genreList" :key="genre.id" class="form-check">
                            <input type="checkbox" :id="'genre-' + genre.id" :value="genre.id" v-model="genresValue"
                                class="form-check-input">
                            <label :for="'genre-' + genre.id" class="form-check-label">{{ genre.name }}</label>
                        </div>
                    </div>
                    <ErrorMessage name="genres" class="text-danger small" />
                </div>
                <!-- Trailer -->
                <div class="col-6 mt-2">
                    <label for="trailer" class="block text-sm/6 font-medium text-gray-900">Link do Trailer
                        (YouTube)</label>
                    <Field type="text" id="trailer" name="trailer_link" v-model="trailer_link.value"
                        class="form-control" rules="required|url" />
                    <ErrorMessage name="trailer_link" class="text-danger small" />
                </div>

                <!-- Data de Lançamento -->
                <div class="col-6 mt-2">
                    <label for="release_date" class="block text-sm/6 font-medium text-gray-900">Data de
                        Lançamento</label>
                    <Field type="date" id="release_date" name="release_date" v-model="release_date.value"
                        class="form-control" rules="required" />
                    <ErrorMessage name="release_date" class="text-danger small" />
                </div>

                <!-- Duração -->
                <div class="col-6 mt-2">
                    <label for="duration" class="block text-sm/6 font-medium text-gray-900">Duração (Minutos)</label>
                    <Field type="number" id="duration" name="duration" v-model="duration.value" class="form-control"
                        rules="required|numeric|min_value:1" />
                    <ErrorMessage name="duration" class="text-danger small" />
                </div>

                <!-- Capa do Filme -->
                <div class="col-6 mt-2">
                    <label for="cover" class="block text-sm/6 font-medium text-gray-900">Capa do Filme</label>
                    <!-- <input type="file" accept="image/*" @change="handleCoverUpload" class="form-control" name="cover"/> -->
                    <Field type="file" accept="image/*" @change="handleCoverUpload" class="form-control" name="cover"
                        rules="required|numeric|min_value:1" />
                    <ErrorMessage name="cover" class="text-danger small" />
                </div>
            </div>
        </div>

        <div class="col-span-full">
            <label for="description" class="block text-sm/6 font-medium text-gray-900">Descrição</label>
            <Field as="textarea" id="description" name="description" class="form-control" rules="required"></Field>
            <ErrorMessage name="description" class="text-danger small" />
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6 mx-4">
            <RouterLink to="/filmes">
                <button type="button" class="text-sm/6 font-semibold text-gray-900">Voltar</button>
            </RouterLink>
            <button type="button" class="btn btn-primary" @click="submitForm">
                {{ isEditing ? 'Atualizar' : 'Cadastrar' }}
            </button>
        </div>
    </div>
</template>
<script setup lang="ts">
import type Movie from '@/types/movie';
import type Genre from '@/types/genre';
import { onMounted, ref } from 'vue';
import { api } from '@/axios.ts';
import { useForm, Field, ErrorMessage, useField } from 'vee-validate';

import * as yup from 'yup';

const validationSchema = yup.object({
    title: yup.string().required('Título é obrigatório'),
    trailer_link: yup.string().required('Deve ser um link válido'),
    release_date: yup.date().required('Data de lançamento é obrigatória'),
    duration: yup.number().required('Duração é obrigatória').positive().integer(),
    description: yup.string().required('Descrição é obrigatória'),
    genres: yup.array().min(1, 'Selecione pelo menos um gênero').required('Gênero é obrigatório'),
    cover: yup.mixed().test('required-file', 'A capa do filme é obrigatória', () => {
        return !!coverFile.value; // Retorna `true` se houver arquivo, `false` se estiver vazio
    })
});

const { handleSubmit, errors } = useForm({
    validationSchema,
    initialValues: {
        title: 'matrix 2',
        trailer_link: 'www.google.com.br',
        release_date: '2025-04-01',
        duration: '120',
        description: 'fdjfslhfdsfhsfhsjfsd',

    }
});

const genreList = ref<Genre[]>([])

const isEditing = ref(false)
const coverFile = ref<File>()

const title = useField('title');
const trailer_link = useField('trailer_link');
const release_date = useField('release_date');
const duration = useField('duration');
const description = useField('description');
const { value: genresValue, errorMessage: genresError } = useField<number[]>('genres', undefined, {
  initialValue: []
});
const cover = useField('cover', yup.mixed().test('required-file', 'A capa do filme é obrigatória', () => {
    return !!coverFile.value;
}));

const emit = defineEmits<{
    (event: 'submit-form', data: FormData): void;
}>();

const submitForm = handleSubmit((values) => {
    const formData = new FormData();
    console.log(values)
    formData.append('title', values.title);
    formData.append('trailer_link', values.trailer_link);
    formData.append('release_date', values.release_date);
    formData.append('duration', values.duration);
    formData.append('description', values.description);
    
    formData.append('genres[]', values.genres);


    // Se houver um arquivo de capa, adicioná-lo
    if (coverFile.value) {
        formData.append('cover', values.cover);
    }


    emit('submit-form', formData)
});


onMounted(() => {
    getGenres()
})

const handleCoverUpload = (event: Event) => {
    const input = event.target as HTMLInputElement;
    if (input.files && input.files.length > 0) {
        coverFile.value = input.files[0];
    }
};

const getGenres = async () => {
    api.get('/genres',
    )
        .then(function (response) {
            if (response.status === 200) {
                genreList.value = response.data
            }
        })
        .catch(function (error) {
            console.error(error);
        })
};
</script>