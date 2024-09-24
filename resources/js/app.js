import './bootstrap';
// import '../css/app.css';
import '@vueform/toggle/themes/default.css'
import '@vueform/multiselect/themes/default.css'
import '@vuepic/vue-datepicker/dist/main.css'
import 'cropperjs/dist/cropper.js'
import 'cropperjs/dist/cropper.css'

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { vue3Debounce } from 'vue-debounce';
import  VueHtmlToPaper from './Plugins/VueHtmlToPaper'
import axios from 'axios';
import { setupCalendar } from 'v-calendar';

/* Shadcn UI */
import { Label } from '@/Components/ui/label'
import { Input } from '@/Components/ui/input'
import { Textarea } from '@/Components/ui/textarea'
import { Button } from '@/Components/ui/button'
import { Checkbox } from '@/Components/ui/checkbox'
import { Switch } from '@/Components/ui/switch'
import { RadioGroup, RadioGroupItem  } from '@/Components/ui/radio-group'
import ComboBox from '@/Components/ComboBox.vue'
import Datepicker from '@/Components/Datepicker.vue'
/* Intercept axios reques@/Components/Datepicker.vue
// axios.interceptors.response.use(
//     response => response,
//     error => {
//       if (error.response && error.response.status === 401 || error.response && error.response.status === 419) {
//         window.location.href = '/login';
//       }
//       return Promise.reject(error);
//     }
// );

/* Main */
createInertiaApp({
    title: (title) => `${title}`,
    resolve: name => name.startsWith('Components/') ? require(`./${name}.vue`) : require(`./Pages/${name}.vue`),
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(VueHtmlToPaper)
            .use(setupCalendar)
            .directive('debounce', vue3Debounce({
                lock: true,
            }))
            .mixin({ methods: { route } })
            .component('Label', Label)
            .component('Input', Input)
            .component('Textarea', Textarea)
            .component('Button', Button)
            .component('Checkbox', Checkbox)
            .component('Switch', Switch)
            .component('RadioGroup', RadioGroup)
            .component('RadioGroupItem', RadioGroupItem)
            .component('ComboBox', ComboBox)
            .component('Datepicker', Datepicker)
            .mount(el);
    },
});

/* Progress bar color */
InertiaProgress.init({
    color: '#8c4dff',
});