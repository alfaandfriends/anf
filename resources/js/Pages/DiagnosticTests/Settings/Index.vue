<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Diagnostic Test" />
    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="shadow border-gray-700 rounded bg-white">
                <div class="p-6">
                    <!-- <div class="sm:hidden">
                        <label for="Tab" class="sr-only">Tab</label>
                
                        <select id="Tab" class="w-full rounded-md border-gray-200">
                            <option>Settings</option>
                            <option>Messages</option>
                            <option>Archive</option>
                            <option select>Notifications</option>
                        </select>
                    </div> -->
                
                    <div class="hidden sm:block">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex gap-6" aria-label="Tabs">
                                <button @click="route().current('dt.settings.languages') ? '' : navigate(route('dt.settings.languages'))" class="inline-flex shrink-0 items-center gap-2 border-b-2 px-1 pb-4 text-sm font-medium" :class="route().current('dt.settings.languages') ? 'text-indigo-700 border-indigo-500' : ' text-gray-500 hover:border-indigo-300 hover:text-indigo-700'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 640 512">
                                        <path d="M0 128C0 92.7 28.7 64 64 64H256h48 16H576c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H320 304 256 64c-35.3 0-64-28.7-64-64V128zm320 0V384H576V128H320zM178.3 175.9c-3.2-7.2-10.4-11.9-18.3-11.9s-15.1 4.7-18.3 11.9l-64 144c-4.5 10.1 .1 21.9 10.2 26.4s21.9-.1 26.4-10.2l8.9-20.1h73.6l8.9 20.1c4.5 10.1 16.3 14.6 26.4 10.2s14.6-16.3 10.2-26.4l-64-144zM160 233.2L179 276H141l19-42.8zM448 164c11 0 20 9 20 20v4h44 16c11 0 20 9 20 20s-9 20-20 20h-2l-1.6 4.5c-8.9 24.4-22.4 46.6-39.6 65.4c.9 .6 1.8 1.1 2.7 1.6l18.9 11.3c9.5 5.7 12.5 18 6.9 27.4s-18 12.5-27.4 6.9l-18.9-11.3c-4.5-2.7-8.8-5.5-13.1-8.5c-10.6 7.5-21.9 14-34 19.4l-3.6 1.6c-10.1 4.5-21.9-.1-26.4-10.2s.1-21.9 10.2-26.4l3.6-1.6c6.4-2.9 12.6-6.1 18.5-9.8l-12.2-12.2c-7.8-7.8-7.8-20.5 0-28.3s20.5-7.8 28.3 0l14.6 14.6 .5 .5c12.4-13.1 22.5-28.3 29.8-45H448 376c-11 0-20-9-20-20s9-20 20-20h52v-4c0-11 9-20 20-20z"/>
                                    </svg>
                                    Languages
                                </button>
                            </nav>
                        </div>
                        <Languages v-if="route().current('dt.settings.languages')" :languages="$page.props.languages"></Languages>
                    </div>
                </div>
            </div>

        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Languages from './Languages.vue'

export default {
    components: {
        Head, Link, Languages
    },
    data() {
        return {
        };
    },
    methods: {
        navigate(route){
            this.$inertia.visit(route)
        }
    }

}
</script>
                                