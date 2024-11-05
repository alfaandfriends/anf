<template>
    <div class="fixed inset-x-0 bottom-0 z-20 bg-white border border-t md:border-gray-200 md:top-[5rem] md:sticky"> 
        <Disclosure as="nav" class="text-white bg-white" v-slot="{ open }">
            <div class="max-w-2xl mx-auto">
                <Menu as="div" class="flex justify-evenly items-center font-medium h-16 md:h-20">
                    <div class="">
                        <Link 
                            :href="route('parent.home')" 
                            :class="(route().current('parent.home')) ? 'text-indigo-500 border-b-2 border-transparent border-indigo-500 ' : 'text-gray-500 group-hover:text-indigo-500 border-b-2 border-transparent group-hover:border-indigo-500'" 
                            class="flex flex-col space-y-1 items-center justify-center text-center mx-auto px-4 pt-2 w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 576 512">
                                    <path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/>
                                </svg>
                                <span class="block text-sm pb-1">Home</span>
                        </Link>
                    </div>
                    <div class="" v-if="$page.props.can.view_kids">
                        <Link 
                            :href="route('parent.children')" 
                            :class="(route().current('parent.children')) ? 'text-indigo-500' : 'text-gray-500'" 
                            class="flex flex-col space-y-1 items-center justify-center text-center mx-auto px-4 pt-2 w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 384 512">
                                    <path d="M256 64A64 64 0 1 0 128 64a64 64 0 1 0 128 0zM152.9 169.3c-23.7-8.4-44.5-24.3-58.8-45.8L74.6 94.2C64.8 79.5 45 75.6 30.2 85.4s-18.7 29.7-8.9 44.4L40.9 159c18.1 27.1 42.8 48.4 71.1 62.4V480c0 17.7 14.3 32 32 32s32-14.3 32-32V384h32v96c0 17.7 14.3 32 32 32s32-14.3 32-32V221.6c29.1-14.2 54.4-36.2 72.7-64.2l18.2-27.9c9.6-14.8 5.4-34.6-9.4-44.3s-34.6-5.5-44.3 9.4L291 122.4c-21.8 33.4-58.9 53.6-98.8 53.6c-12.6 0-24.9-2-36.6-5.8c-.9-.3-1.8-.7-2.7-.9z"/>
                                </svg>
                                <span class="block text-sm pb-1 whitespace-nowrap">Kids</span>
                        </Link>
                    </div>
                    <div class="" v-if="$page.props.can.view_messages">
                        <Link 
                            :href="route('parent.messages')" 
                            :class="(route().current('parent.messages')) ? 'text-indigo-500' : 'text-gray-500'" 
                            class="flex flex-col space-y-1 items-center justify-center text-center mx-auto px-4 pt-2 w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 640 512">
                                    <path d="M208 352c114.9 0 208-78.8 208-176S322.9 0 208 0S0 78.8 0 176c0 38.6 14.7 74.3 39.6 103.4c-3.5 9.4-8.7 17.7-14.2 24.7c-4.8 6.2-9.7 11-13.3 14.3c-1.8 1.6-3.3 2.9-4.3 3.7c-.5 .4-.9 .7-1.1 .8l-.2 .2 0 0 0 0C1 327.2-1.4 334.4 .8 340.9S9.1 352 16 352c21.8 0 43.8-5.6 62.1-12.5c9.2-3.5 17.8-7.4 25.3-11.4C134.1 343.3 169.8 352 208 352zM448 176c0 112.3-99.1 196.9-216.5 207C255.8 457.4 336.4 512 432 512c38.2 0 73.9-8.7 104.7-23.9c7.5 4 16 7.9 25.2 11.4c18.3 6.9 40.3 12.5 62.1 12.5c6.9 0 13.1-4.5 15.2-11.1c2.1-6.6-.2-13.8-5.8-17.9l0 0 0 0-.2-.2c-.2-.2-.6-.4-1.1-.8c-1-.8-2.5-2-4.3-3.7c-3.6-3.3-8.5-8.1-13.3-14.3c-5.5-7-10.7-15.4-14.2-24.7c24.9-29 39.6-64.7 39.6-103.4c0-92.8-84.9-168.9-192.6-175.5c.4 5.1 .6 10.3 .6 15.5z"/>
                                </svg>
                                <span class="block text-sm pb-1 whitespace-nowrap">Messages</span>
                        </Link>
                    </div>
                    <div class="relative" v-if="$page.props.can.view_class">
                        <MenuButton
                        :class="(route().current('parent.stories')) ? 'text-indigo-500' : 'text-gray-500'" 
                            class=" flex flex-col space-y-1 items-center justify-center text-center mx-auto px-4 pt-2 w-full text-gray-500 group-hover:text-indigo-500 border-b-2 border-transparent group-hover:border-indigo-500"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 576 512">
                                <path d="M249.6 471.5c10.8 3.8 22.4-4.1 22.4-15.5V78.6c0-4.2-1.6-8.4-5-11C247.4 52 202.4 32 144 32C93.5 32 46.3 45.3 18.1 56.1C6.8 60.5 0 71.7 0 83.8V454.1c0 11.9 12.8 20.2 24.1 16.5C55.6 460.1 105.5 448 144 448c33.9 0 79 14 105.6 23.5zm76.8 0C353 462 398.1 448 432 448c38.5 0 88.4 12.1 119.9 22.6c11.3 3.8 24.1-4.6 24.1-16.5V83.8c0-12.1-6.8-23.3-18.1-27.6C529.7 45.3 482.5 32 432 32c-58.4 0-103.4 20-123 35.6c-3.3 2.6-5 6.8-5 11V456c0 11.4 11.7 19.3 22.4 15.5z"/>
                                </svg>
                            <span class="block text-sm pb-1 whitespace-nowrap">Class</span>
                        </MenuButton>
                        <transition
                        enter-active-class="transition duration-100 ease-out"
                        enter-from-class="transform scale-95 opacity-0"
                        enter-to-class="transform scale-100 opacity-100"
                        leave-active-class="transition duration-75 ease-in"
                        leave-from-class="transform scale-100 opacity-100"
                        leave-to-class="transform scale-95 opacity-0"
                        >
                            <MenuItems
                                class="absolute w-72 divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none bottom-16 right-0 md:bottom-auto md:right-auto"
                            >
                                <div class="px-2 py-1" v-if="$page.props.children_classes.length" v-for="child_class in $page.props.children_classes">
                                    <MenuItem v-slot="{ active }">
                                        <button
                                        @click="$inertia.get(route('parent.stories', child_class.programme_id))"
                                        class="text-gray-600 group hover:bg-indigo-500 hover:text-white flex justify-left w-full items-center rounded-md px-2 py-2 text-sm"
                                        >
                                        {{ child_class.programme_name }}
                                        </button>
                                    </MenuItem>
                                </div>
                                <div class="px-2 py-1" v-else>
                                    <MenuItem>
                                        <button
                                        class="text-gray-600 group flex justify-left w-full cursor-default items-center rounded-md px-2 py-2 text-sm"
                                        >
                                        No class found.
                                        </button>
                                    </MenuItem>
                                </div>
                            </MenuItems>
                        </transition>
                    </div>
                </Menu>
            </div>
        </Disclosure>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
</script>

<style scoped>
ion-icon {
    font-size: 24px;
}
</style>
