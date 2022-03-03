<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['href', 'active']);

const classes = computed(() => props.active
    ? ' flex items-center py-2 pl-12 pr-4 transition cursor-pointer bg-gray-800 text-gray-200'
    : 'flex items-center py-2 pl-12 pr-4 transition cursor-pointer hover:bg-gray-800 hover:text-gray-200'
);

const expand = computed(() => props.active
    ? true
    : false
);
</script>

<template>
    <Link :href="href" :class="classes" :expand="expand">
        <slot />
    </Link>
</template>
