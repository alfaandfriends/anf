<template>
    <!-- Menu Position Top (Desktop and Tablet) -->
    <!-- Menu Position Bottom (Mobile) -->
    <nav class="fixed inset-x-0 bottom-0 z-30 text-gray-700 bg-white md:border-gray-200 md:border-b-2 md:top-0 md:sticky">
        <div class="flex items-center justify-between max-w-4xl px-5 py-3 mx-auto md:justify-center">
            <!-- Home -->
            <Link :href="route('parent.home')" :class="(route().current('parent.home')) ? 'underline text-gray-800' : ''" class="flex md:mr-10 cursor-pointer">
                <div class="flex mr-2 md:mr-3">
                    <ion-icon name="home-outline"></ion-icon>
                </div>
                <span class="text-lg font-semibold md:text-base">Home</span>
            </Link>
            <!-- <Link :href="route('parent.notice.index')" :class="(route().current('parent.notice.index')) ? 'underline text-gray-800' : ''" class="flex md:mr-10 cursor-pointer">
                <div class="flex mr-2 md:mr-3">
                    <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                </div>
                <span class="text-lg font-semibold md:text-base">NOTICE BOARD</span>
            </Link> -->
            <Link :href="route('parent.invoices.index')" :class="(route().current('parent.invoices.index')) ? 'underline text-gray-800' : ''" class="flex md:mr-10 cursor-pointer">
                <div class="flex mr-2 md:mr-3">
                    <ion-icon name="storefront-outline"></ion-icon>
                </div>
                <span class="text-lg font-semibold md:text-base">Fee Invoices</span>
            </Link>
            <Link :href="route('parent.art_galleries.index')" :class="(route().current('parent.art_galleries.index')) ? 'underline text-gray-800' : ''" class="flex md:mr-10 cursor-pointer">
                <div class="flex mr-2 md:mr-3">
                    <ion-icon name="storefront-outline"></ion-icon>
                </div>
                <span class="text-lg font-semibold md:text-base">Art Gallery</span>
            </Link>
            <!-- <Menu as="div" class="relative">
                <MenuButton class="flex font-semibold place-items-center">
                    <div class="mt-1.5 mr-2 md:mr-3">
                        <ion-icon name="ellipsis-horizontal-circle-outline"></ion-icon>
                    </div>
                    <div class="text-lg md:text-base">MORE</div>
                </MenuButton>
                <transition
                    enter-active-class="transition duration-100 ease-out"
                    enter-from-class="transform scale-95 opacity-0"
                    enter-to-class="transform scale-100 opacity-100"
                    leave-active-class="transition duration-75 ease-in"
                    leave-from-class="transform scale-100 opacity-100"
                    leave-to-class="transform scale-95 opacity-0">
                    <MenuItems class="absolute bottom-12 md:bottom-auto w-56 py-2.5 md:w-64 mt-2 origin-top-right bg-white shadow-md -right-1.5 rounded-xl focus:outline-none">
                        <MenuItem class="px-5 py-2.5 items-center md:hidden">
                            <Link :href="route('parent.invoices.index')" :class="(route().current('parent.invoices.index')) ? 'underline text-gray-800' : ''" class="flex cursor-pointer">
                                <div class="mt-1 mr-2 md:mr-3">
                                    <ion-icon name="storefront-outline"></ion-icon>
                                </div>
                                <span class="text-lg font-semibold">FEE INVOICES</span>
                            </Link>
                        </MenuItem>
                        <MenuItem class="px-5 py-2.5 items-center">
                            <Link :href="route('parent.art_galleries.index')" :class="(route().current('parent.art_galleries.index')) ? 'underline text-gray-800' : ''" class="flex cursor-pointer">
                                <div class="mt-1 mr-2 md:mr-3">
                                    <ion-icon name="calendar-outline"></ion-icon>
                                </div>
                                <span class="text-lg font-semibold md:text-base">ART GALLERY</span>
                            </Link>
                        </MenuItem>
                        <MenuItem class="px-5 py-2.5 items-center">
                            <Link :href="route('parent.homeworks.index')" :class="(route().current('parent.homeworks.index')) ? 'underline text-gray-800' : ''" class="flex cursor-pointer">
                                <div class="mt-1 mr-2 md:mr-3">
                                    <ion-icon name="calendar-outline"></ion-icon>
                                </div>
                                <span class="text-lg font-semibold md:text-base">HOMEWORK</span>
                            </Link>
                        </MenuItem>
                        <MenuItem class="px-5 py-2.5 items-center">
                            <Link :href="route('parent.study_materials.index')" :class="(route().current('parent.study_materials.index')) ? 'underline text-gray-800' : ''" class="flex cursor-pointer">
                                <div class="mt-1 mr-2 md:mr-3">
                                    <ion-icon name="calendar-outline"></ion-icon>
                                </div>
                                <span class="text-lg font-semibold md:text-base">STUDY MATERIALS</span>
                            </Link>
                        </MenuItem>
                        <MenuItem class="px-5 py-2.5 items-center">
                            <Link :href="route('parent.storybooks.index')" :class="(route().current('parent.storybooks.index')) ? 'underline text-gray-800' : ''" class="flex cursor-pointer">
                                <div class="mt-1 mr-2 md:mr-3">
                                    <ion-icon name="calendar-outline"></ion-icon>
                                </div>
                                <span class="text-lg font-semibold md:text-base">STORYBOOK</span>
                            </Link>
                        </MenuItem>
                        <MenuItem class="px-5 py-2.5 items-center">
                            <Link :href="route('parent.attendances.index')" :class="(route().current('parent.attendances.index')) ? 'underline text-gray-800' : ''" class="flex cursor-pointer">
                                <div class="mt-1 mr-2 md:mr-3">
                                    <ion-icon name="calendar-outline"></ion-icon>
                                </div>
                                <span class="text-lg font-semibold md:text-base">ATTENDANCE</span>
                            </Link>
                        </MenuItem>
                    </MenuItems>
                </transition>
            </Menu> -->
        </div>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
</script>

<style scoped>
ion-icon {
    font-size: 24px;
}
</style>
