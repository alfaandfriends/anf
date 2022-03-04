<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue'
import BreezeDropdown from '@/Components/Dropdown.vue'
import BreezeDropdownLink from '@/Components/DropdownLink.vue'
import BreezeNavLink from '@/Components/NavLink.vue'
import BreezeNavSubLink from '@/Components/NavSubLink.vue'
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import { Link } from '@inertiajs/inertia-vue3'
import { ViewGridIcon, CogIcon, ChevronRightIcon, LogoutIcon, XIcon, MenuIcon } from '@heroicons/vue/solid'
export default {
    components: {
        BreezeApplicationLogo, Link,
        BreezeDropdown, BreezeDropdownLink, BreezeNavLink, BreezeResponsiveNavLink, BreezeNavSubLink,
        CogIcon, ChevronRightIcon, LogoutIcon, ViewGridIcon, XIcon, MenuIcon,
    },
    data() {
        return {
            showingNavigationDropdown: false,
            sideBar: false,
            openControlPanel: false,
            openSetting: false,
        }
    },
    methods(){

    }
}
</script>

<template>
    <div class="flex">
        <!-- Sidebar -->
        <div class="min-h-screen bg-gray-50" x-data="{ sideBar: false }">
            <div class="flex">
                <nav class="fixed top-0 left-0 z-20 h-full pb-10 overflow-x-hidden overflow-y-auto transition origin-left transform bg-gray-900 w-60 sm:translate-x-0" 
                     :class="{ '-translate-x-full': !sideBar, 'translate-x-0': sideBar }"
                >
                    <span class="flex items-center px-4 py-5 text-white font-bold">ALFA and Friends</span>
                    <nav class="text-sm font-medium text-gray-500">
                        <BreezeNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            <ViewGridIcon class="h-5 w-5 mr-2"></ViewGridIcon>
                            <span class="select-none">Dashboard</span> 
                        </BreezeNavLink>
                        <div x-data="collapse()">
                            <div class="flex items-center justify-between px-4 py-3 transition cursor-pointer group hover:bg-gray-800 hover:text-gray-200" role="button" x-spread="trigger" @click="openControlPanel = !openControlPanel">
                                <div class="flex items-center">
                                    <CogIcon class="h-5 w-5 mr-2"></CogIcon>
                                    <span class="select-none">Control Panel</span>
                                </div>
                                <ChevronRightIcon :class="{ 'rotate-90': openControlPanel }" class="shrink-0 w-4 h-4 ml-2 transition transform"></ChevronRightIcon>
                            </div>
                            <div class="mb-4" x-spread="collapse">
                                <BreezeNavSubLink :href="route('users')" :active="route().current('users')"><span class="select-none">Users</span></BreezeNavSubLink>
                                <BreezeNavSubLink :href="route('roles')" :active="route().current('roles')"><span class="select-none">Roles</span></BreezeNavSubLink>
                                <BreezeNavSubLink :href="route('permissions')" :active="route().current('permissions')"><span class="select-none">Permissions</span></BreezeNavSubLink>
                            </div>
                        </div>
                        <div x-data="collapse()">
                            <div class="flex items-center justify-between px-4 py-3 transition cursor-pointer group hover:bg-gray-800 hover:text-gray-200" role="button" x-spread="trigger" @click="openSetting = !openSetting">
                                <div class="flex items-center">
                                    <CogIcon class="h-5 w-5 mr-2"></CogIcon>
                                    <span class="select-none">Site Setting</span>
                                </div>
                                <ChevronRightIcon :class="{ 'rotate-90': openSetting }" class="shrink-0 w-4 h-4 ml-2 transition transform"></ChevronRightIcon>
                            </div>
                            <div class="mb-4" x-spread="collapse">
                                <BreezeNavSubLink :href="route('users')" :active="route().current('users')"><span class="select-none">Users</span></BreezeNavSubLink>
                                <BreezeNavSubLink :href="route('roles')" :active="route().current('roles')"><span class="select-none">Roles</span></BreezeNavSubLink>
                                <BreezeNavSubLink :href="route('permissions')" :active="route().current('permissions')"><span class="select-none">Permissions</span></BreezeNavSubLink>
                            </div>
                        </div>
                        <BreezeNavLink class="w-full sm:hidden" :href="route('logout')" method="post" as="button">
                            <LogoutIcon class="h-5 w-5 mr-2"></LogoutIcon>
                            Log Out
                        </BreezeNavLink>
                    </nav>
                </nav>
                <div class="fixed top-0 left-0 z-10 h-full pb-10 overflow-x-hidden overflow-y-auto transition origin-left transform w-full sm:translate-x-0 sm:hidden"
                    :class="{ '-translate-x-full': !sideBar, 'translate-x-0': sideBar }"
                    @click="showingNavigationDropdown = !showingNavigationDropdown, sideBar = !sideBar">
                </div>
                <div class="ml-0 transition md:ml-60 bg-indigo-100">
                </div>
            </div>
        </div>
        <div class="min-h-screen bg-gray-100 w-full">
            <nav class="bg-white border-b border-gray-100 sticky top-0">
                <!-- Primary Navigation Menu -->
                <div class="mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                        <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <BreezeApplicationLogo class="block h-9 w-auto" />
                                </Link>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <BreezeDropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                <div class=" w-10 h-10 rounded-full overflow-hidden border-2 dark:border-white border-gray-900 mr-2">
                                                    <img :src="$page.props.auth.user.avatar" alt="" class="w-full h-full object-cover"/>
                                                </div>
                                                <span class="">{{$page.props.auth.user.display_name}}</span>
                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </span>
                                    </template>
                                    <template #content>
                                        <BreezeDropdownLink :href="route('logout')">
                                            Profile
                                        </BreezeDropdownLink>
                                        <BreezeDropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </BreezeDropdownLink>
                                    </template>
                                </BreezeDropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden"> 
                            <button class=" inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" 
                                    @click="showingNavigationDropdown = !showingNavigationDropdown, sideBar = !sideBar" 
                            >
                                <MenuIcon class="h-6 w-6" :class="{hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown}"/>
                                <XIcon class="h-6 w-6" :class="{hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown}"/>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <!-- <div class="sm:hidden" 
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown}"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <BreezeResponsiveNavLink
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                        >
                        Dashboard
                        </BreezeResponsiveNavLink>
                    </div> -->

                <!-- Responsive Settings Options -->
                    <!-- <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>
                        <div class="mt-3 space-y-1">
                        </div>
                    </div> -->
                <!-- </div> -->
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
