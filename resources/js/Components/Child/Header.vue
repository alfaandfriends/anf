<template>
    <div class="sticky top-0 z-40 md:relative">
        <Disclosure as="nav" class="text-white bg-yellow-500" v-slot="{ open }">
            <div class="max-w-4xl px-5 mx-auto">
                <div class="flex items-center justify-between h-20 md:h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="text-xl font-bold select-none">
                            <router-link to="/">
                                <span>ALFA and Friends</span>
                            </router-link>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="flex items-center">
                            <!-- Notification -->
                            <Notification />

                            <!-- Cart -->
                            <Cart />

                            <!-- Profile Menu -->
                            <Menu as="div" class="relative">
                                <!-- Desktop and Tablet Button (Open Menu Items) -->
                                <div class="hidden md:flex">
                                    <MenuButton class="flex rounded-full">
                                        <img class="w-10 h-10 rounded-full" :src="user.imageUrl" />
                                    </MenuButton>
                                </div>
                                <!-- Mobile Button (Open Disclosure Panel) -->
                                <div class="flex md:hidden">
                                    <DisclosureButton>
                                        <img v-if="!open" class="w-12 h-12 rounded-full" :src="user.imageUrl" aria-hidden="true" />
                                        <img v-else class="w-12 h-12 rounded-full" :src="user.imageUrl" aria-hidden="true" />
                                    </DisclosureButton>
                                </div>
                                <transition
                                    enter-active-class="transition duration-100 ease-out"
                                    enter-from-class="transform scale-95 opacity-0"
                                    enter-to-class="transform scale-100 opacity-100"
                                    leave-active-class="transition duration-75 ease-in"
                                    leave-from-class="transform scale-100 opacity-100"
                                    leave-to-class="transform scale-95 opacity-0"
                                >
                                    <!-- Desktop and Tablet Menu -->
                                    <MenuItems class="absolute w-64 py-3 mt-2 origin-top-right bg-white shadow-md -right-1 rounded-xl focus:outline-none">
                                        <div class="px-5 pt-2 pb-3 mb-2 border-b">
                                            <!-- Header -->
                                            <div class="font-medium text-gray-700">
                                                Hey,
                                                <span class="font-bold">{{ user.name }}</span>
                                            </div>
                                        </div>
                                        <!-- Navigation -->
                                        <router-link to="/profile" class="flex items-center px-5 py-2 font-medium text-gray-700 hover:bg-indigo-50"><UserCircleIcon class="w-6 h-6 mr-3" />Profile</router-link>
                                        <router-link to="/settings" class="flex items-center px-5 py-2 font-medium text-gray-700 hover:bg-indigo-50"><CogIcon class="w-6 h-6 mr-3" />Settings</router-link>
                                        <router-link to="/helpdesk" class="flex items-center px-5 py-2 font-medium text-gray-700 hover:bg-indigo-50"><QuestionMarkCircleIcon class="w-6 h-6 mr-3" />Helpdesk</router-link>
                                        <div class="pt-2 mt-2 border-t">
                                            <button class="w-full px-5 py-2 font-medium text-left text-gray-700 hover:bg-indigo-50">Log Out</button>
                                        </div>
                                    </MenuItems>
                                </transition>
                            </Menu>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu -->
            <DisclosurePanel class="md:hidden">
                <div class="bg-white shadow-md">
                    <!-- Header -->
                    <div class="flex items-center p-5 mb-2 border-b">
                        <div class="font-medium text-gray-700">
                            Hey, <span class="font-bold">{{ user.name }}</span>
                        </div>
                    </div>
                    <!-- Navigation -->
                    <router-link to="/profile" class="flex items-center px-5 py-3 font-medium text-gray-700 hover:bg-indigo-50"><UserCircleIcon class="w-6 h-6 mr-3" />Profile</router-link>
                    <router-link to="/settings" class="flex items-center px-5 py-3 font-medium text-gray-700 hover:bg-indigo-50"><CogIcon class="w-6 h-6 mr-3" />Settings</router-link>
                    <router-link to="/helpdesk" class="flex items-center px-5 py-3 font-medium text-gray-700 hover:bg-indigo-50"><QuestionMarkCircleIcon class="w-6 h-6 mr-3" />Helpdesk</router-link>
                    <div class="py-2 mt-2 border-t">
                        <button class="w-full px-5 py-3 font-medium text-left text-gray-700 hover:bg-indigo-50">Log Out</button>
                    </div>
                </div>
            </DisclosurePanel>
        </Disclosure>
    </div>
    <MenuBar />
</template>

<script>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItems } from '@headlessui/vue'
import { UserCircleIcon, CogIcon, QuestionMarkCircleIcon } from '@heroicons/vue/solid'
import Notification from '../components/Notification.vue'
import Cart from '../components/Cart.vue'
import MenuBar from '../components/MenuBar.vue'

const user = {
    name: 'Mohd Shazwan Abu Hanipah',
    imageUrl: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
}

export default {
    name: 'Header',
    components: {
        Notification,
        Cart,
        MenuBar,
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        Menu,
        MenuButton,
        MenuItems,
        UserCircleIcon,
        CogIcon,
        QuestionMarkCircleIcon,
    },
    setup() {
        return {
            user,
        }
    },
}
</script>
