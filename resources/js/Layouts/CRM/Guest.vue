<script setup>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-indigo-200">
        <div class="flex flex-col justify-center items-center space-y-4">
            <Link href="/">
                <BreezeApplicationLogo class=" w-32 fill-current text-gray-500" />
            </Link>
            <h3 class="text-xl font-bold text-gray-700 text-center">CRM Login</h3>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
