<template>
    <!-- Menu Position Top (Desktop and Tablet) -->
    <!-- Menu Position Bottom (Mobile) -->
    <nav class="fixed inset-x-0 bottom-0 z-30 text-gray-700 bg-white md:border-gray-200 md:border-b-2 md:top-0 md:sticky">
        <div class="flex items-center justify-between max-w-4xl px-5 py-3 mx-auto md:justify-center">
            <!-- Home -->
            <router-link to="/" class="flex md:mr-10">
                <div class="flex mr-2 md:mr-3">
                    <ion-icon name="home-outline"></ion-icon>
                </div>
                <span class="text-lg font-semibold md:text-base">HOME</span>
            </router-link>
            <!-- Message -->
            <router-link to="/message" class="flex md:mr-10">
                <div class="flex mr-2 md:mr-3">
                    <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                </div>
                <span class="text-lg font-semibold md:text-base">MESSAGE</span>
            </router-link>
            <!-- Shop (Desktop and Tablet) -->
            <router-link to="/shop" class="hidden md:flex md:mr-10">
                <div class="flex mr-2 md:mr-3">
                    <ion-icon name="storefront-outline"></ion-icon>
                </div>
                <span class="text-lg font-semibold md:text-base">SHOP</span>
            </router-link>
            <!-- More -->
            <Menu as="div" class="relative">
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
                        <!-- Shop (Mobile) -->
                        <MenuItem class="px-5 py-2.5 items-center md:hidden">
                            <router-link to="/shop" class="flex">
                                <div class="mt-1 mr-2 md:mr-3">
                                    <ion-icon name="storefront-outline"></ion-icon>
                                </div>
                                <span class="text-lg font-semibold">SHOP</span>
                            </router-link>
                        </MenuItem>
                        <!-- Events -->
                        <MenuItem class="px-5 py-2.5 items-center">
                            <router-link to="/shop" class="flex">
                                <div class="mt-1 mr-2 md:mr-3">
                                    <ion-icon name="calendar-outline"></ion-icon>
                                </div>
                                <span class="text-lg font-semibold md:text-base">EVENTS</span>
                            </router-link>
                        </MenuItem>
                    </MenuItems>
                </transition>
            </Menu>
        </div>
    </nav>
</template>

<script>
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'

export default {
    name: 'Navigation',
    components: { Menu, MenuButton, MenuItem, MenuItems },
}
</script>

<style scoped>
ion-icon {
    font-size: 24px;
}
</style>
