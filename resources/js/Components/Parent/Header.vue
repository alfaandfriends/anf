<template>
    <div class="fixed top-0 inset-x-0 z-50 text-gray-700 bg-white md:top-0 md:sticky">
        <Disclosure as="nav" class="text-white bg-indigo-600" v-slot="{ open }">
            <div class="max-w-3xl px-5 sm:px-3 mx-auto">
                <div class="flex justify-between gap-5 items-center h-16 md:h-20">
                    <div class="max-w-xs w-full text-center  text-md font-semibold truncate">
                        {{ $page.props.current_active_child.child_name }}
                    </div>
                    <div class="text-right">
                        <Menu as="div" class="relative">
                            <!-- Desktop and Tablet Button (Open Menu Items) -->
                            <div class="hidden md:flex">
                                <MenuButton class="flex rounded-full pl-5 pr-6 py-5 space-x-4 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 448 512">
                                        <path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"/>
                                    </svg>
                                </MenuButton>
                            </div>
                            <!-- Mobile Button (Open Disclosure Panel) -->
                            <div class="flex md:hidden">
                                <DisclosureButton class="flex space-x-4 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="currentColor" viewBox="0 0 448 512">
                                        <path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"/>
                                    </svg>
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
                                <MenuItems class="absolute w-96 py-3 mt-2 origin-top-right bg-white shadow-md -right-1 rounded-xl focus:outline-none">
                                    <div class="px-5 pt-2 pb-3 border-b">
                                        <!-- Header -->
                                        <div class="font-medium text-gray-700 text-left">
                                            Hi, <span class="font-bold">{{ $page.props.auth.user.display_name }}</span>
                                        </div>
                                    </div>
                                    <!-- Navigation -->
                                    <div class="flex items-center px-5 my-1 py-2 font-medium text-gray-700 hover:bg-indigo-50 cursor-pointer" @click="viewProfile">
                                        <UserCircleIcon class="w-6 h-6 mr-3" />Profile
                                    </div>
                                    <hr>
                                    <BreezeNavLink :href="route('logout')" method="post" as="button" class="flex items-center space-x-3 w-full ml-1 px-5 py-2 mt-3 font-medium text-left text-gray-700 hover:text-gray-700 hover:bg-indigo-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="currentcolor" viewBox="0 0 512 512">
                                            <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/>
                                        </svg>
                                        <span>Log Out</span>
                                    </BreezeNavLink>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu -->
            <DisclosurePanel class="md:hidden lg:hidden">
                <div class="bg-white shadow-md z-50">
                    <!-- Header -->
                    <div class="flex items-center p-5 mb-2 border-b">
                        <div class="font-medium text-gray-700">
                            Hi, <span class="font-bold">{{ $page.props.auth.user.display_name }}</span>
                        </div>
                    </div>
                    <!-- Navigation -->
                    <div class="cursor-pointer flex items-center px-5 py-3 font-medium text-gray-700 hover:bg-indigo-50" @click="viewProfile">
                        <UserCircleIcon class="w-6 h-6 mr-3" />Profile
                    </div>
                    <div class="py-2 mt-2 border-t">
                        <BreezeNavLink :href="route('logout')" method="post" as="button" class="flex items-center space-x-3 w-full ml-1 px-5 py-2 mt-3 font-medium text-left text-gray-700 hover:text-gray-700 hover:bg-indigo-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="currentcolor" viewBox="0 0 512 512">
                                <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/>
                            </svg>
                            <span>Log Out</span>
                        </BreezeNavLink>
                    </div>
                </div>
            </DisclosurePanel>
        </Disclosure>
    </div>
</template>

<script>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItems } from '@headlessui/vue'
import { UserCircleIcon, CogIcon, CalendarIcon, QuestionMarkCircleIcon } from '@heroicons/vue/solid'
import Notification from '@/Components/Notification.vue'
import Cart from '@/Components/Cart.vue'
import BreezeNavLink from '@/Components/NavLink.vue'

export default {
    name: 'Header',
    components: {
        Notification,
        Cart,
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        Menu,
        MenuButton,
        MenuItems,
        UserCircleIcon,
        CogIcon,
        QuestionMarkCircleIcon, 
        BreezeNavLink,
    },
    data(){
        return{
            switching: false
        }
    },
    methods: {
        switchChild(child_id, child_name, student_id){
            if(this.switching || child_id == this.$page.props.current_active_child.child_id){
                return
            }
            this.switching = true
            axios.post(route('parent.switch_child', {child_id: child_id, child_name: child_name, student_id: student_id}))
            .then(response => {
                if(response.data){
                    location.reload()
                }
            });
        },
        viewProfile(){
            this.$inertia.get(route('parent.profile'))
        }
    }
}
</script>
