<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Navigation from '@/Pages/Docs/Layouts/Navigation.vue'
import Header from '@/Pages/Docs/Layouts/Header.vue'
</script>


<template>
    <Header></Header>
    <main class="relative flex mx-auto max-w-8xl">
        <Navigation></Navigation>
        <div class="flex-auto min-w-0 px-4 py-10 md:pl-72 lg:max-w-none lg:pr-0 lg:pl-8 xl:px-16">
            <slot/>
        </div>
    </main>
</template>