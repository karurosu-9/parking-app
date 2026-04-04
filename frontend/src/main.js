import { createApp } from 'vue'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap-icons/font/bootstrap-icons.min.css'
import 'vue-toastification/dist/index.css'
import './style.css'
import App from './App.vue'
import router from './routes'
import Toast from 'vue-toastification'

createApp(App)
    .use(Toast)
    .use(router)
    .mount('#app')
