<template>
    <!-- Menu Position Top (Desktop and Tablet) -->
    <!-- Menu Position Bottom (Mobile) -->
    <nav class="fixed overflow-x-auto inset-x-0 bottom-0 z-20 bg-white border border-t md:border-gray-200 md:border-b-2 md:top-16 md:sticky">
        <simplebar data-simplebar-auto-hide="true" class="flex items-center md:justify-center max-w-4xl px-3 mx-auto">
            <div class="flex mt-1">
                <div class="flex-1 group">
                    <a 
                        :href="route('parent.home')" 
                        :class="(route().current('parent.home')) ? 'text-indigo-500 border-b-2 border-transparent border-indigo-500 ' : 'text-gray-500 group-hover:text-indigo-500 border-b-2 border-transparent group-hover:border-indigo-500'" 
                        class="flex flex-col space-y-1 items-center justify-center text-center mx-auto px-4 pt-2 w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 576 512">
                                <path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/>
                            </svg>
                            <span class="block text-xs pb-1">Home</span>
                    </a>
                </div>
                <div class="flex-1 group">
                    <a 
                        :href="route('parent.invoices')" 
                        :class="(route().current('parent.invoices')) ? 'text-indigo-500 border-b-2 border-transparent border-indigo-500 ' : 'text-gray-500 group-hover:text-indigo-500 border-b-2 border-transparent group-hover:border-indigo-500'" 
                        class="flex flex-col space-y-1 items-center justify-center text-center mx-auto px-4 pt-2 w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 384 512">
                                <path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM80 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm16 96H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V256c0-17.7 14.3-32 32-32zm0 32v64H288V256H96zM240 416h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H240c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                            </svg>
                            <span class="block text-xs pb-1 whitespace-nowrap">Fee Invoices</span>
                    </a>
                </div>
                <div class="flex-1 group">
                    <a 
                        :href="route('parent.art_gallery')" 
                        :class="(route().current('parent.art_gallery')) ? 'text-indigo-500 border-b-2 border-transparent border-indigo-500 ' : 'text-gray-500 group-hover:text-indigo-500 border-b-2 border-transparent group-hover:border-indigo-500'" 
                        class="flex flex-col space-y-1 items-center justify-center text-center mx-auto px-4 pt-2 w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 512 512">
                                <path d="M512 256c0 .9 0 1.8 0 2.7c-.4 36.5-33.6 61.3-70.1 61.3H344c-26.5 0-48 21.5-48 48c0 3.4 .4 6.7 1 9.9c2.1 10.2 6.5 20 10.8 29.9c6.1 13.8 12.1 27.5 12.1 42c0 31.8-21.6 60.7-53.4 62c-3.5 .1-7 .2-10.6 .2C114.6 512 0 397.4 0 256S114.6 0 256 0S512 114.6 512 256zM128 288a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm0-96a32 32 0 1 0 0-64 32 32 0 1 0 0 64zM288 96a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm96 96a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/>
                            </svg>
                            <span class="block text-xs pb-1 whitespace-nowrap">Art Gallery</span>
                    </a>
                </div>
                <div class="flex-1 group">
                    <a 
                        :href="route('parent.art_book')" 
                        :class="(route().current('parent.art_book')) ? 'text-indigo-500 border-b-2 border-transparent border-indigo-500 ' : 'text-gray-500 group-hover:text-indigo-500 border-b-2 border-transparent group-hover:border-indigo-500'" 
                        class="flex flex-col space-y-1 items-center justify-center text-center mx-auto px-4 pt-2 w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 576 512">
                                <path d="M249.6 471.5c10.8 3.8 22.4-4.1 22.4-15.5V78.6c0-4.2-1.6-8.4-5-11C247.4 52 202.4 32 144 32C93.5 32 46.3 45.3 18.1 56.1C6.8 60.5 0 71.7 0 83.8V454.1c0 11.9 12.8 20.2 24.1 16.5C55.6 460.1 105.5 448 144 448c33.9 0 79 14 105.6 23.5zm76.8 0C353 462 398.1 448 432 448c38.5 0 88.4 12.1 119.9 22.6c11.3 3.8 24.1-4.6 24.1-16.5V83.8c0-12.1-6.8-23.3-18.1-27.6C529.7 45.3 482.5 32 432 32c-58.4 0-103.4 20-123 35.6c-3.3 2.6-5 6.8-5 11V456c0 11.4 11.7 19.3 22.4 15.5z"/>
                            </svg>
                            <span class="block text-xs pb-1 whitespace-nowrap">Art Book</span>
                    </a>
                </div>
            </div>
        </simplebar>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
</script>

<script>
import simplebar from 'simplebar-vue';
import 'simplebar-vue/dist/simplebar.min.css';

export default {
  components: {
    simplebar,
  },
}
</script>

<style scoped>
ion-icon {
    font-size: 24px;
}
</style>
