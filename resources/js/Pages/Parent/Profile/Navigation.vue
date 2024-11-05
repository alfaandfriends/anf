<template>
    <div class="bg-white p-6 border border-gray-300 shadow rounded-lg">
        <ul class="flex flex-col space-y-2">
            <li>
                <strong class="block text-xs font-medium uppercase text-gray-400">General</strong>
                <ul class="mt-2 space-y-1">
                    <li>
                        <Link :href="route('parent.profile')" class="block rounded-lg px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-indigo-100 hover:text-gray-700" :class="route().current('parent.profile') ? 'bg-indigo-100' : ''">Profile</Link>
                    </li>
                    <li>
                        <Link :href="route('parent.profile.security')" class="block rounded-lg px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-indigo-100 hover:text-gray-700" :class="route().current('parent.profile.security') ? 'bg-indigo-100' : ''">Security</Link>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
</script>