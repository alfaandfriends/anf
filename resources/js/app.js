import './bootstrap';
// import '../css/app.css';
import '@vueform/toggle/themes/default.css'
import '@vueform/multiselect/themes/default.css'
import '@vuepic/vue-datepicker/dist/main.css';
import 'cropperjs/dist/cropper.js';
import 'cropperjs/dist/cropper.css';
import 'vue-loading-overlay/dist/css/index.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { Inertia } from '@inertiajs/inertia'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { vue3Debounce } from 'vue-debounce';
import  VueHtmlToPaper from './Plugins/VueHtmlToPaper'
import {useLoading} from 'vue-loading-overlay'
import {LoadingPlugin} from 'vue-loading-overlay';
import axios from 'axios';

/* Intercept axios request */
axios.interceptors.response.use(
    response => response,
    error => {
      if (error.response && error.response.status === 401 || error.response && error.response.status === 419) {
        // Unauthorized response, perform redirect
        // Example: Redirect to login page
        window.location.href = '/login';
      }
      return Promise.reject(error);
    }
);


/* App title */
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'ALFA and Friends App';

/* Remove app data in inspect element */
const cleanApp = () => {
    document.getElementById('app').removeAttribute('data-page')
}
document.addEventListener('inertia:finish', cleanApp)

/* Main */
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: name => name.startsWith('Components/') ? require(`./${name}.vue`) : require(`./Pages/${name}.vue`),
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(VueHtmlToPaper)
            .use(LoadingPlugin)
            .directive('debounce', vue3Debounce({
                lock: true,
            }))
            .mixin({ methods: { route } })
            .mount(el);
    },
}).then(cleanApp);

/* Progress bar color */
InertiaProgress.init({
    color: '#9E7BFF',
});

/* Loading */
// const $loading = useLoading({
//     container: null,
//     loader: 'bars',
//     lockScroll: false,
//     zIndex: 9999,
//     opacity: 0.2,
//     color: '#4f46e5',
//     backgroundColor: 'black'
// });

// var loader

// Inertia.on('start', () => loader = $loading.show() )
// Inertia.on('finish', () => loader.hide() )