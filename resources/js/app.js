require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';  
import VueGuidedTour from "@alfaandfriends/vue-guided-tour";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'ALFA and Friends';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: name => name.startsWith('Components/') ? require(`./${name}.vue`) : require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(VueGuidedTour)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init(
    {   color: '#9E7BFF',
        showSpinner: true,
    });
