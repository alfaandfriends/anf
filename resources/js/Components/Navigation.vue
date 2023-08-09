<template>
    <!-- Menu Position Top (Desktop and Tablet) -->
    <!-- Menu Position Bottom (Mobile) -->
    <nav class="fixed inset-x-0 bottom-0 z-10 text-gray-700 bg-white md:border-gray-200 md:border-b-2 md:top-16 md:sticky">
        <div class="flex items-center justify-center max-w-4xl px-3 mx-auto">
            <div class="flex space-x-0 md:space-x-4">
                <Link :href="route('parent.home')" :class="(route().current('parent.home')) ? 'text-gray-800' : ''" class="flex px-3 py-3 text-gray-500 hover:text-gray-800 cursor-pointer">
                    <span class="text-sm font-semibold md:text-base">Home</span>
                </Link>
                <Link :href="route('parent.invoices')" :class="(route().current('parent.invoices')) ? 'text-gray-800' : ''" class="flex px-3 py-3 text-gray-500 hover:text-gray-800 cursor-pointer">
                    <span class="text-sm font-semibold md:text-base">Fee Invoices</span>
                </Link>
                <Link :href="route('parent.art_gallery')" :class="(route().current('parent.art_gallery')) ? 'text-gray-800' : ''" class="flex px-3 py-3 text-gray-500 hover:text-gray-800 cursor-pointer">
                    <span class="text-sm font-semibold md:text-base">Art Gallery</span>
                </Link>
                <div class="relative group flex px-3 py-3 text-gray-500 hover:text-gray-800 cursor-pointer">
                    <button class="text-sm font-semibold md:text-base text-gray-500 hover:text-gray-800" id="moreButton">
                        More
                        <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="z-30 hidden flex-col absolute border border-gray-200 py-2 px-4 bg-white h-fit w-64 text-slate-600 bottom-10 md:-bottom-0 right-2 md:top-10 md:left-0 rounded-lg shadow-xl group-hover:block">
                        <!-- Additional menu items here -->
                        <a href="#" class="text-sm font-semibold md:text-base block py-2 px-3 text-gray-500 hover:text-gray-800">Story Book</a>
                        <!-- Add more menu items as needed -->
                    </div>
                </div>
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
