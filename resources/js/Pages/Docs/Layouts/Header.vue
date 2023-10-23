<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue'
</script>

<template>
    <header class="sticky px-6 top-0 z-50 flex items-center justify-between py-4 border-b shadow-lg bg-white backdrop-blur-sm border-slate-400/40">
        <div class="flex items-center flex-grow basis-0">
            <a :href="route('docs.workflow')" class="flex items-center text-lg font-semibold tracking-tight text-slate-900 space-x-4">
                <BreezeApplicationLogo class="block h-9 w-auto" />
                <span>Documentation</span>
            </a>
        </div>
    
        <div class="items-center justify-end flex-grow hidden basis-0 md:flex">
            <a :href="route('admin.login')" class="px-4 py-2 text-sm font-semibold rounded bg-slate-900 text-slate-50 transition ease-in-out delay-75 hover:scale-105 duration-200">
                Go to App
            </a>
        </div>
    </header>
</template>