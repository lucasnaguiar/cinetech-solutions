import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

const app = createApp(App)
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import {
    NMessageProvider,
    // outros componentes Naive UI que você usa
  } from 'naive-ui'

 app.component('NMessageProvider', NMessageProvider)

app.use(createPinia())
app.use(router)

app.mount('#app')
