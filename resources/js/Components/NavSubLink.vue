<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['href', 'active']);

const classes = computed(() => props.active
    ? ' flex items-center py-2 pl-12 pr-4 transition cursor-pointer text-white font-semibold bg-gray-800'
    : 'flex items-center py-2 pl-12 pr-4 transition cursor-pointer hover:text-white hover:font-semibold hover:bg-gray-800'
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
