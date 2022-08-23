<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue'
import BreezeDropdown from '@/Components/Dropdown.vue'
import BreezeDropdownLink from '@/Components/DropdownLink.vue'
import BreezeNavLink from '@/Components/NavLink.vue'
import BreezeNavSubLink from '@/Components/NavSubLink.vue'
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import { Link } from '@inertiajs/inertia-vue3'
import { ViewGridIcon, CogIcon, ChevronRightIcon, LogoutIcon, XIcon, MenuIcon } from '@heroicons/vue/solid'
import Toast from '@/Components/Toast.vue'
import VueGuidedTour from "@alfaandfriends/vue-guided-tour/src/components/vueGuidedTour.vue";
import Breadcrumbs from '@/Components/Breadcrumbs.vue'

export default {
    components: {
        BreezeApplicationLogo, Link, Toast, VueGuidedTour,
        BreezeDropdown, BreezeDropdownLink, BreezeNavLink, BreezeResponsiveNavLink, BreezeNavSubLink, Breadcrumbs,
        CogIcon, ChevronRightIcon, LogoutIcon, ViewGridIcon, XIcon, MenuIcon,
    },
    data() {
        return {
            showingNavigationDropdown: false,
            sideBar: false,
            showSiteSetting: false,
            isOpen: false,
            selected: '',
            steps: [
                {
                    target: '.step-1',
                    content: 'This is the menus',
                },
                {
                    target: '.step-2',
                    content: 'This is your profile',
                }
            ]
        }
    },
    props: {
        breadcrumbs: Object
    },
    created(){
        // route().current('users') || route().current('roles') || route().current('permissions')|| route().current('roles.create') ? this.showControlPanel = true : this.showControlPanel = false
    },
    methods: {
        toggleMenu (item) {
            item == this.selected ? this.isOpen = !this.isOpen : this.isOpen = true
            this.selected = item
        },
        completedTour(status){
            if(status){
                this.$inertia.post(route('users.completed_tour'), {user_id: this.$inertia.page.props.auth.user.ID})
            }
        }
    },
    mounted() {
        console.log(this.$inertia.page.props)
        if(this.$inertia.page.props.auth.first_time_login == 1){
            this.$vgt.start(0);
        }
    },
}
</script>

<style src="@vueform/toggle/themes/default.css"></style>


<template>
    <div class="flex">
        <!-- Sidebar -->
        <div class="min-h-screen bg-gray-50 step-1" x-data="{ sideBar: false }">
            <div class="flex">
                <nav class="fixed top-0 left-0 z-30 h-full overflow-x-hidden overflow-y-auto no-scrollbar transition origin-left transform bg-gray-900 w-60 sm:translate-x-0" 
                     :class="{ '-translate-x-full': !sideBar, 'translate-x-0': sideBar }"
                >
                    <span class="flex items-center px-4 py-5 text-white font-bold">ALFA and Friends</span>
                    <nav class="text-sm font-medium text-gray-500">
                        <template v-for="menu_data, key in $page.props.menu" :key="key">
                            <template v-if="menu_data.menu_route">
                                <BreezeNavLink v-if="$page.props.can[menu_data.permission_name]" :href="route(menu_data.menu_route)" :active="route().current(menu_data.menu_route)">
                                    <span class="mr-2" v-html="menu_data.menu_icon"></span>
                                    <span class="select-none">{{ menu_data.menu_label }}</span> 
                                </BreezeNavLink>
                            </template>
                            <template v-else>
                                <div v-if="$page.props.can[menu_data.permission_name]">
                                    <div class="flex items-center justify-between px-4 py-3 transition cursor-pointer group hover:bg-gray-800 hover:text-gray-200" role="button" @click="toggleMenu(key)">
                                        <div class="flex items-center">
                                            <span class="mr-2" v-html="menu_data.menu_icon"></span>
                                            <span class="select-none">{{ menu_data.menu_label }}</span> 
                                        </div>
                                        <ChevronRightIcon :class="{ 'rotate-90': isOpen && key === selected }" class="shrink-0 w-4 h-4 ml-2 transition transform"></ChevronRightIcon>
                                    </div>
                                    <div class="mb-3" v-if="isOpen && key === selected">
                                        <template v-for="(sub_menu_data, key) in menu_data.sub_menu" :key="key">
                                            <BreezeNavSubLink :href="sub_menu_data.sub_menu_route ? route(sub_menu_data.sub_menu_route) : ''" 
                                                            :active="sub_menu_data.sub_menu_route ? route().current(sub_menu_data.sub_menu_route) : ''"
                                            >
                                            <span class="select-none">{{ sub_menu_data.sub_menu_label }}</span>
                                            </BreezeNavSubLink>
                                        </template>
                                    </div>
                                </div>
                            </template>
                            
                        </template>
                        <BreezeNavLink class="w-full sm:hidden" :href="route('logout')" method="post" as="button">
                            <LogoutIcon class="h-6 w-6 mr-2"></LogoutIcon>
                            Log Out
                        </BreezeNavLink>
                        <BreezeNavLink class="w-full sticky sm:hidden bg-blue-900 text-white" :href="route('profile')">
                            <div class="w-8 h-8 rounded-full overflow-hidden border-2 dark:border-white border-gray-900 mr-2">
                                <img v-if="$page.props.auth.profile_photo" :src="'/storage/'+$page.props.auth.profile_photo" alt="" class="w-full h-full object-cover select-none"/>
                                <svg v-else class="h-full w-full text-gray-300 border rounded-full" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            My Account
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
            <VueGuidedTour :steps="steps" @afterEnd="completedTour"></VueGuidedTour>
            <Toast :toastData="$page.props.flash"></Toast>
            <nav class="bg-white border-b border-gray-100 sticky top-0 z-20">
                <!-- Primary Navigation Menu -->
                <div class="mx-auto px-4 sm:px-6 lg:px-8 shadow-md">
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
                                        <span class="inline-flex rounded-md step-2">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                <div class=" w-10 h-10 rounded-full overflow-hidden border-2 dark:border-white border-gray-900 mr-2">
                                                    <img v-if="$page.props.auth.profile_photo" :src="'/storage/'+$page.props.auth.profile_photo" alt="" class="w-full h-full object-cover select-none"/>
                                                    <svg v-else class="h-full w-full text-gray-300 border rounded-full" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                    </svg>
                                                </div>
                                                <span class="select-none">{{$page.props.auth.user.display_name}}</span>
                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </span>
                                    </template>
                                    <template #content>
                                        <BreezeDropdownLink :href="route('profile')">
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
            </nav>

            <!-- Page Heading -->
            <header class="bg-indigo-200 shadow" v-if="$slots.header">
                <div class="flex mx-auto py-3 px-4 sm:px-6 lg:px-6 justify-between">
                    <!-- <slot name="header" /> -->
                    <Breadcrumbs :breadcrumbs="$page.props.breadcrumbs"/>
                </div>
            </header>

            <!-- Page Content -->
            <main class="min-h-screen bg-gray-100">
                <slot/>
            </main>
            <div class="py-5 px-6 bg-slate-700 text-white">
                <span class="text-sm font-extrabold">&copy; </span><span class="text-sm">{{new Date().getFullYear()}} ALFA And Friends </span>
            </div>
        </div>
    </div>
</template>
