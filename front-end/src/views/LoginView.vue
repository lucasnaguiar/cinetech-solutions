<template>
    <div class="flex min-h-full flex-1 items-center justify-center px-4 py-12 mt-64 sm:px-6 lg:px-8">
        <div class="w-full max-w-sm space-y-10">
            <div>
                <img class="mx-auto h-10 w-auto"
                    src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" />
                <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Acesse sua conta</h2>
            </div>
            <form class="space-y-6" @submit.prevent="onSubmit">
                <div>
                    <div class="col-span-2">
                        <input id="email-address" name="email" type="email" autocomplete="email" aria-label="E-mail"
                            class="block w-full rounded-t-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:relative focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            placeholder="E-mail" v-model="loginForm.email" />
                    </div>
                    <div class="-mt-px">
                        <input id="password" name="password" type="password" autocomplete="current-password"
                            aria-label="Senha"
                            class="block w-full rounded-b-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:relative focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            placeholder="Senha" v-model="loginForm.password" />
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex gap-3">
                        <div class="flex h-6 shrink-0 items-center">
                            <div class="group grid size-4 grid-cols-1">
                                <input id="remember-me" name="remember-me" type="checkbox"
                                    class="col-start-1 row-start-1 appearance-none rounded border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-[:disabled]:stroke-gray-950/25"
                                    viewBox="0 0 14 14" fill="none">
                                    <path class="opacity-0 group-has-[:checked]:opacity-100" d="M3 8L6 11L11 3.5"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path class="opacity-0 group-has-[:indeterminate]:opacity-100" d="M3 7H11"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                        <label for="remember-me" class="block text-sm/6 text-gray-900">Lembrar-me</label>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Entrar</button>
                </div>
            </form>
        </div>
    </div>
</template>
<script setup lang="ts">
import { ref } from 'vue'
import { api } from '@/axios.ts'
import { useRouter } from 'vue-router';
import { useLoadingStore } from '@/stores/loading.ts'
const loadingStore = useLoadingStore();

const loginForm = ref({
    email: 'lucasbarbary@gmail.com',
    password: 'teste@123',
})

const router = useRouter();

const onSubmit = () => {
    loadingStore.loading = true

    api.post('/login',
        {
            email: loginForm.value.email,
            password: loginForm.value.password
        }
    )
        .then(function (response) {
            if (response.status === 200) {
                localStorage.setItem('access_token', response.data.token)
                router.push({ name: 'movie-list' })
            }
        })
        .catch(function (error) {
            console.error(error);
        }).finally(function () {
            loadingStore.loading = false
        });
}


</script>