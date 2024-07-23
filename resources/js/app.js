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

/* Shadcn UI */
import { Label } from '@/Components/ui/label'
import { Input } from '@/Components/ui/input'
import { Textarea } from '@/Components/ui/textarea'
import { Button } from '@/Components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle, CardFooter } from '@/Components/ui/card'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/Components/ui/dropdown-menu'
import { Sheet, SheetContent, SheetTrigger } from '@/Components/ui/sheet'
import { ScrollArea } from '@/Components/ui/scroll-area'
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/Components/ui/accordion'
import { Command, CommandDialog, CommandEmpty, CommandGroup, CommandInput, CommandItem, CommandList, CommandSeparator, CommandShortcut } from '@/Components/ui/command'
import { Popover, PopoverContent, PopoverTrigger } from '@/Components/ui/popover'
import ComboBox from '@/Components/ComboBox.vue'

/* Intercept axios request */
axios.interceptors.response.use(
    response => response,
    error => {
      if (error.response && error.response.status === 401 || error.response && error.response.status === 419) {
        window.location.href = '/login';
      }
      return Promise.reject(error);
    }
);

/* Main */
createInertiaApp({
    title: (title) => `${title}`,
    resolve: name => name.startsWith('Components/') ? require(`./${name}.vue`) : require(`./Pages/${name}.vue`),
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(VueHtmlToPaper)
            .directive('debounce', vue3Debounce({
                lock: true,
            }))
            .mixin({ methods: { route } })
            .component('Label', Label)
            .component('Input', Input)
            .component('Textarea', Textarea)
            .component('Card', Card)
            .component('CardContent', CardContent)
            .component('CardDescription', CardDescription)
            .component('CardHeader', CardHeader)
            .component('CardTitle', CardTitle)
            .component('CardFooter', CardFooter)
            .component('Button', Button)
            .component('DropdownMenu', DropdownMenu)
            .component('DropdownMenuContent', DropdownMenuContent)
            .component('DropdownMenuItem', DropdownMenuItem)
            .component('DropdownMenuLabel', DropdownMenuLabel)
            .component('DropdownMenuSeparator', DropdownMenuSeparator)
            .component('DropdownMenuTrigger', DropdownMenuTrigger)
            .component('Sheet', Sheet)
            .component('SheetContent', SheetContent)
            .component('SheetTrigger', SheetTrigger)
            .component('ScrollArea', ScrollArea)
            .component('Accordion', Accordion)
            .component('AccordionContent', AccordionContent)
            .component('AccordionItem', AccordionItem)
            .component('AccordionTrigger', AccordionTrigger)
            .component('Command', Command)
            .component('CommandDialog', CommandDialog)
            .component('CommandEmpty', CommandEmpty)
            .component('CommandGroup', CommandGroup)
            .component('CommandInput', CommandInput)
            .component('CommandItem', CommandItem)
            .component('CommandList', CommandList)
            .component('CommandSeparator', CommandSeparator)
            .component('CommandShortcut', CommandShortcut)
            .component('Popover', Popover)
            .component('PopoverContent', PopoverContent)
            .component('PopoverTrigger', PopoverTrigger)
            .component('ComboBox', ComboBox)
            .mount(el);
    },
});

/* Progress bar color */
InertiaProgress.init({
    color: '#8c4dff',
});