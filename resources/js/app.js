require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';  
import VueGuidedTour from "@alfaandfriends/vue-guided-tour";
import { vue3Debounce } from 'vue-debounce';

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
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(VueGuidedTour)
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
