<template>
    <ul class="flex flex-wrap justify-start space-x-1 text-white border-0">
        <li>
            <Link :href="route('settings.countries')" class="inline-block px-4 py-2"
                    :class="route().current('settings.countries') ? 'bg-white text-indigo-800 border-indigo-500 border-t-2' :
                                        'bg-indigo-500 text-white border-indigo-500 border-t-2 hover:bg-indigo-700 hover:border-indigo-700'">Country List</Link>
        </li>
    </ul>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
export default {
    components: {
        Link
    },
    data(){
        return {
            active_dt: false
        }
    },
    mounted(){
        this.active_dt = window.location.href.startsWith(window.location.origin + '/control-panel/general/countries') ? true : false
    }
}
</script>