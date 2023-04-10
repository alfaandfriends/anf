import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import VueGuidedTour from "@alfaandfriends/vue-guided-tour";
import { vue3Debounce } from 'vue-debounce';
import  VueHtmlToPaper from './Plugins/VueHtmlToPaper'

import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';


/* App title */
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'ALFA and Friends Centre';

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
            .use(VueGuidedTour)
            .use(VueHtmlToPaper)
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
    showSpinner: true,
});
