<template>
    <!-- Menu Position Top (Desktop and Tablet) -->
    <!-- Menu Position Bottom (Mobile) -->
    <nav class="fixed inset-x-0 bottom-0 z-10 text-gray-700 bg-white md:border-gray-200 md:border-b-2 md:top-16 md:sticky">
        <div class="flex items-center justify-center max-w-4xl px-3 mx-auto overflow-x-auto">
            <div class="flex space-x-0 md:space-x-4">
                <Link :href="route('parent.home')" :class="(route().current('parent.home')) ? 'text-gray-900' : ''" class="flex px-3 py-3 text-gray-500 hover:text-gray-900 cursor-pointer">
                    <span class="text-sm font-semibold md:text-base whitespace-nowrap">Home</span>
                </Link>
                <Link :href="route('parent.invoices')" :class="(route().current('parent.invoices')) ? 'text-gray-900' : ''" class="flex px-3 py-3 text-gray-500 hover:text-gray-900 cursor-pointer">
                    <span class="text-sm font-semibold md:text-base whitespace-nowrap">Fee Invoices</span>
                </Link>
                <Link :href="route('parent.art_gallery')" :class="(route().current('parent.art_gallery')) ? 'text-gray-900' : ''" class="flex px-3 py-3 text-gray-500 hover:text-gray-900 cursor-pointer">
                    <span class="text-sm font-semibold md:text-base whitespace-nowrap">Art Gallery</span>
                </Link>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'

</script>

<script>
export default {
}
</script>

<style scoped>
ion-icon {
    font-size: 24px;
}
</style>
