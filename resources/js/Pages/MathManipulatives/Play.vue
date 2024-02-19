<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Math Manipulatives" />
    <iframe class="w-screen h-screen absolute" :src="'/math_manipulatives/'+ $page.props.name + '/index.html'"></iframe>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Headers
    },
}
</script>