<template>
    <!-- Menu Position Top (Desktop and Tablet) -->
    <!-- Menu Position Bottom (Mobile) -->
    <nav class="fixed inset-x-0 bottom-0 z-20 bg-indigo-600 md:bg-white md:border-gray-200 md:border-b-2 md:top-16 md:sticky">
        <div class="flex items-center justify-center max-w-4xl px-3 mx-auto overflow-x-auto">
            <div class="flex space-x-4 md:space-x-4">
                <Link :href="route('parent.home')" :class="(route().current('parent.home')) ? 'underline' : ''" class="flex px-3 py-3 text-white md:text-gray-700 hover:text-white md:hover:text-gray-900 cursor-pointer">
                    <span class="flex flex-col items-center text-sm font-semibold md:text-base whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:hidden" fill="currentColor" viewBox="0 0 576 512">
                            <path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/>
                        </svg>
                        <span>Home</span>
                    </span>
                </Link>
                <Link :href="route('parent.invoices')" :class="(route().current('parent.invoices')) ? 'underline' : ''" class="flex px-3 py-3 text-white md:text-gray-700 hover:text-white md:hover:text-gray-900 cursor-pointer">
                    <span class="flex flex-col items-center text-sm font-semibold md:text-base whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:hidden" fill="currentColor" viewBox="0 0 384 512">
                            <path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8V488c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488V24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16H288c8.8 0 16-7.2 16-16s-7.2-16-16-16H96zM80 352c0 8.8 7.2 16 16 16H288c8.8 0 16-7.2 16-16s-7.2-16-16-16H96c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16H288c8.8 0 16-7.2 16-16s-7.2-16-16-16H96z"/>
                        </svg>
                        <span>Fee Invoices</span>
                    </span>
                </Link>
                <Link :href="route('parent.art_gallery')" :class="(route().current('parent.art_gallery')) ? 'underline' : ''" class="flex px-3 py-3 text-white md:text-gray-700 hover:text-white md:hover:text-gray-900 cursor-pointer">
                    <span class="flex flex-col items-center text-sm font-semibold md:text-base whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:hidden" fill="currentColor" viewBox="0 0 512 512">
                            <path d="M512 256c0 .9 0 1.8 0 2.7c-.4 36.5-33.6 61.3-70.1 61.3H344c-26.5 0-48 21.5-48 48c0 3.4 .4 6.7 1 9.9c2.1 10.2 6.5 20 10.8 29.9c6.1 13.8 12.1 27.5 12.1 42c0 31.8-21.6 60.7-53.4 62c-3.5 .1-7 .2-10.6 .2C114.6 512 0 397.4 0 256S114.6 0 256 0S512 114.6 512 256zM128 288a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm0-96a32 32 0 1 0 0-64 32 32 0 1 0 0 64zM288 96a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm96 96a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/>
                        </svg>
                        <span>Art Gallery</span>
                    </span>
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
