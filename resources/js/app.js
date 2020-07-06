//Подключение axios
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

//Подключение библиотек
import Vue from 'vue'
import Store from './Stores/Store';
import Buefy from 'buefy'
import 'buefy/dist/buefy.css'

Vue.use(Buefy)

//Подключение VUE компонентов из папки components
const files = require.context('./components/', false, /\.vue$/i);
console.log(files);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

//Инициализация VUE
let app = new Vue({
    el: '#app',
    data: Store
});
