<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['href', 'active']);

const classes = computed(() => props.active
    ? ' flex items-center px-4 py-3 text-gray-200 transition bg-gray-800 cursor-pointer group hover:bg-gray-800 hover:text-gray-200'
    : 'flex items-center px-4 py-3 transition cursor-pointer group hover:bg-gray-800 hover:text-gray-200'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
