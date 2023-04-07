<template>
    <ol class="inline-flex items-center space-x-1" v-if="breadcrumbs">
        <li class="inline-flex items-center" v-for="(breadcrumb, index) in breadcrumbs" :key="index">
            <svg v-if="index >= 1" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
            <div v-if="index == 0 && breadcrumbs.length <= 1" class="flex items-center text-white">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                <span class="ml-1 text-sm font-semibold">{{ breadcrumb.title }}</span>
            </div>
            <Link  v-else-if="index == 0 && breadcrumbs.length > 1 || (index+1) < breadcrumbs.length" 
                :href="breadcrumb.url" 
                class="inline-flex items-center text-sm font-medium text-white">
                <svg v-if="index == 0" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                <span class="ml-1 text-sm font-semibold">{{ breadcrumb.title }}</span>
            </Link>
            <div v-else class="flex items-center">
                <span class="ml-1 text-sm font-semibold text-white">{{ breadcrumb.title }}</span>
            </div>
        </li>
    </ol>
    <ol class="inline-flex items-center space-x-1" v-else>
        <li class="inline-flex items-center">
            <div class="flex items-center">
                <span class="ml-1 text-sm font-semibold text-white">Please set breadcrumbs at routes/breadcrumbs.php</span>
            </div>
        </li>
    </ol>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Link
    },
    props: {
        breadcrumbs: Object
    }
}
</script>