<template>
    <div class="fixed top-0 inset-x-0 z-50 text-gray-700 bg-white md:top-0 md:sticky">
        <Disclosure as="nav" class="text-white bg-indigo-600" v-slot="{ open }">
            <div class="max-w-4xl px-5 mx-auto">
                <div class="flex items-center justify-between h-16 md:h-20">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <a class="flex items-center space-x-4 font-bold select-none" :href="route('parent.home')">
                            <img class="object-scale-down h-10 md:h-12" src="/images/anf-logo-main-2x.png" alt="">
                        </a>
                    </div>
                    <div class="flex">
                        <div class="flex items-center">

                            <!-- Profile Menu -->
                            <Menu as="div" class="relative">
                                <!-- Desktop and Tablet Button (Open Menu Items) -->
                                <div class="hidden md:flex">
                                    <MenuButton class="flex rounded-full pl-5 py-5 space-x-4 items-center">
                                        <span class="truncate max-w-xs text-lg font-semibold">{{ $page.props.current_active_child.child_name }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 448 512">
                                            <path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"/>
                                        </svg>
                                    </MenuButton>
                                </div>
                                <!-- Mobile Button (Open Disclosure Panel) -->
                                <div class="flex md:hidden">
                                    <DisclosureButton class="flex space-x-4 items-center">
                                        <span class="truncate max-w-[200px] text-lg font-semibold">{{ $page.props.current_active_child.child_name }}</span>
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
                                            <div class="font-medium text-gray-700">
                                                Hi, <span class="font-bold">{{ $page.props.auth.user.display_name }}</span>
                                            </div>
                                        </div>
                                        <!-- Navigation -->
                                        <div class="flex items-center px-5 my-1 py-2 font-medium text-gray-700 hover:bg-indigo-50 cursor-pointer" @click="viewProfile">
                                            <UserCircleIcon class="w-6 h-6 mr-3" />Profile
                                        </div>
                                        
                                        <!-- <div to="/settings" class="flex items-center px-5 py-2 font-medium text-gray-700 hover:bg-indigo-50"><CogIcon class="w-6 h-6 mr-3" />Settings</div>
                                        <div to="/helpdesk" class="flex items-center px-5 py-2 font-medium text-gray-700 hover:bg-indigo-50"><QuestionMarkCircleIcon class="w-6 h-6 mr-3" />Helpdesk</div> -->
                                        <hr>
                                        <BreezeNavLink :href="route('logout')" method="post" as="button" class="flex items-center space-x-3 w-full ml-1 px-5 py-2 mt-3 font-medium text-left text-gray-700 hover:text-gray-700 hover:bg-indigo-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="currentcolor" viewBox="0 0 512 512">
                                                <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/>
                                            </svg>
                                            <span>Log Out</span>
                                        </BreezeNavLink>
                                        <div class="w-full p-4 rounded-lg text-gray-800">
                                            <div class="flex justify-between px-3 pt-2 mt-2 items-center text-sm font-bold text-left">
                                                <span>Children List</span>
                                                <a :href="route('parent.children')" class="text-sm text-indigo-600 cursor-pointer font-medium hover:underline">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700" fill="currentColor" viewBox="0 0 512 512">
                                                        <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                            <hr class="my-3">
                                            <button href="#" class="flex items-center space-x-4 text-sm font-semibold md:text-base py-2 px-3" v-if="$page.props.user_has_children.length" v-for="info in $page.props.user_has_children" @click="switchChild(info.child_id, info.child_name, info.student_id)">
                                                <span class="text-gray-500 hover:text-gray-800 text-left text-sm">{{ info.child_name }}</span>
                                                <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded" v-if="!switching && info.child_id == $page.props.current_active_child.child_id">Current</span>
                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded" v-if="switching && info.child_id == $page.props.current_active_child.child_id">Switching</span>
                                            </button>
                                            <div class="flex justify-between items-center w-full px-3" v-else>
                                                <span class="text-gray-500 font-semibold text-sm">No children added. </span>
                                            </div>
                                        </div>
                                    </MenuItems>
                                </transition>
                            </Menu>
                        </div>
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
                    
                    <!-- <div to="/settings" class="flex items-center px-5 py-3 font-medium text-gray-700 hover:bg-indigo-50"><CogIcon class="w-6 h-6 mr-3" />Settings</div>
                    <div to="/helpdesk" class="flex items-center px-5 py-3 font-medium text-gray-700 hover:bg-indigo-50"><QuestionMarkCircleIcon class="w-6 h-6 mr-3" />Helpdesk</div> -->
                    <div class="py-2 mt-2 border-t">
                        <BreezeNavLink :href="route('logout')" method="post" as="button" class="flex items-center space-x-3 w-full ml-1 px-5 py-2 mt-3 font-medium text-left text-gray-700 hover:text-gray-700 hover:bg-indigo-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="currentcolor" viewBox="0 0 512 512">
                                <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/>
                            </svg>
                            <span>Log Out</span>
                        </BreezeNavLink>
                    </div>
                    <div class="flex justify-center md:hidden">
                        <div class="w-full p-4 rounded-lg text-gray-800">
                            <div class="flex justify-between px-3 pt-2 mt-2 items-center text-sm font-bold text-left">
                                <span>Children List</span>
                                <a :href="route('parent.children')" class="text-sm text-indigo-600 cursor-pointer font-medium hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700" fill="currentColor" viewBox="0 0 512 512">
                                        <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/>
                                    </svg>
                                </a>
                            </div>
                            <hr class="my-3">
                            <button href="#" class="flex items-center space-x-4 text-sm font-semibold md:text-base py-2 px-3" v-if="$page.props.user_has_children.length" v-for="info in $page.props.user_has_children" @click="switchChild(info.child_id, info.child_name, info.student_id)">
                                <span class="text-gray-500 hover:text-gray-800 text-left">{{ info.child_name }}</span>
                                <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded" v-if="!switching && info.child_id == $page.props.current_active_child.child_id">Current</span>
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded" v-if="switching && info.child_id == $page.props.current_active_child.child_id">Switching</span>
                            </button>
                            <div class="flex justify-between items-center w-full px-3" v-else>
                                <span class="text-gray-500 font-semibold text-sm">No children added. </span>
                            </div>
                        </div>
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
