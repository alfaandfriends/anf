<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue'
import BreezeButton from '@/Components/Button.vue'
import BreezeDropdown from '@/Components/Dropdown.vue'
import BreezeDropdownLink from '@/Components/DropdownLink.vue'
import BreezeNavLink from '@/Components/NavLink.vue'
import BreezeNavSubLink from '@/Components/NavSubLink.vue'
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import { Link } from '@inertiajs/inertia-vue3'
import { ViewGridIcon, CogIcon, ChevronRightIcon, LogoutIcon, XIcon, MenuIcon } from '@heroicons/vue/solid'
import Toast from '@/Components/Toast.vue'
import VueGuidedTour from "@alfaandfriends/vue-guided-tour/src/components/vueGuidedTour.vue"
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import { fortawesome } from '@fortawesome/free-regular-svg-icons'
import TimeAgo from '@/Components/TimeAgo.vue'

export default {
    components: {
        BreezeApplicationLogo, Link, Toast, VueGuidedTour, BreezeButton,
        BreezeDropdown, BreezeDropdownLink, BreezeNavLink, BreezeResponsiveNavLink, BreezeNavSubLink, Breadcrumbs, TimeAgo,
        CogIcon, ChevronRightIcon, LogoutIcon, ViewGridIcon, XIcon, MenuIcon
    },
    data() {
        return {
            menu_setting: [],
            menu_opened: {
                section_key: '',
                menu_key: ''
            },
            notificationOpen: false,
            showingNavigationDropdown: false,
            sideBar: false,
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
            ],
            notifications: [],
            username: '',
        }
    },
    methods: {
        toggleMenu(section_key, menu_key) {
            const sectionKeyToFind = section_key.toString();
            const menuKeyToFind = menu_key.toString();
            
            const menu = this.menu_setting.find(menu_data => menu_data.section_key === sectionKeyToFind && menu_data.menu_key === menuKeyToFind);
            menu.is_open = !menu.is_open;
        },
        checkMenuIsOpen(section_key, menu_key){
            const sectionKeyToFind = section_key.toString();
            const menuKeyToFind = menu_key.toString();
            
            const menu = this.menu_setting.find(menu_data => menu_data.section_key === sectionKeyToFind && menu_data.menu_key === menuKeyToFind);
            return menu.is_open
        },
        initMenu(){
            for (let section_key in this.$page.props.menu) {
                for (let menu_key in this.$page.props.menu[section_key]['menus']) {
                    if(!this.$page.props.menu[section_key]['menus'][menu_key]['menu_route']){
                        this.menu_setting.push({'section_key': section_key, 'menu_key': menu_key, 'is_open' : false})
                    }
                    for (let sub_menu in this.$page.props.menu[section_key]['menus'][menu_key]['sub_menus']) {
                        const sub_menu_route    =   this.$page.props.menu[section_key]['menus'][menu_key]['sub_menus'][sub_menu]['sub_menu_route']
                        if(route().current() && route().current().startsWith(sub_menu_route)){
                            const menu = this.menu_setting.find(menu_data => menu_data.section_key === section_key && menu_data.menu_key === menu_key);
                            menu.is_open = true
                            this.menu_opened.section_key = section_key
                            this.menu_opened.menu_key = menu_key
                        }
                    }
                }
            }
        },
        completedTour(status){
            if(status){
                this.$inertia.post(route('users.completed_tour'), {user_id: this.$inertia.page.props.auth.user.ID})
            }
        },
        closeNotification(status){
            if(status){
                this.notificationOpen = false
            }
        },
        impersonate(){
            if(this.username){
                this.$inertia.get(route('impersonate', this.username))
            }
        },
        subscribeGlobalChannel(){
            Echo.leave('notifications.'+this.$page.props.auth.user.ID)
            Echo.channel('notifications.'+this.$page.props.auth.user.ID)
            .listen('.Notifications', (data) => {
                this.$page.props.user_has_notifications = true
                this.$page.props.user_notifications.unshift({
                    'id': data.new_notification_id,
                    'panel_icon': data.panel_icon,
                    'panel_content': data.panel_content,
                    'created_at': data.created_at
                })
                if(this.$page.props.notifications){
                    this.$page.props.notifications.unshift({
                        'id': data.new_notification_id,
                        'sender': data.sender,
                        'message': data.notification_message,
                        'created_at': data.created_at
                    })
                }
            });
        },
        subscribeApprovalChannel(){
            /* approvals */
            this.$page.props.user_has_roles.forEach((role_id)=>{
                Echo.leave('approval.' + role_id)
                Echo.channel('approval.' + role_id)
                .listen('.Approval', (data) => {
                    this.$page.props.user_has_notifications = true
                    this.$page.props.user_notifications.unshift({
                        'id': data.new_notification_id,
                        'panel_icon': data.panel_icon,
                        'panel_content': data.panel_content,
                        'created_at': data.created_at
                    })
                    if(this.$page.props.notifications){
                        this.$page.props.notifications.unshift({
                            'id': data.new_notification_id,
                            'sender': data.sender,
                            'message': data.notification_message,
                            'created_at': data.created_at
                        })
                    }
                });
            })
        }
    },
    mounted() {
        this.subscribeGlobalChannel()
        this.subscribeApprovalChannel()
        // if(this.$page.props.auth.first_time_login == 1 && this.$page.props.auth.profile_updated == 1){
        //     this.$vgt.start(0);
        // }
    },
    created(){
        this.initMenu()
    }
}
</script>

<style src="@vueform/toggle/themes/default.css"></style>


<template>
    <div class="flex">
        <!-- Sidebar -->
        <div class="min-h-screen bg-gray-50 step-1 lg:w-[21rem]">
            <div class="flex">
                <nav class="fixed top-0 left-0 z-30 h-full overflow-x-hidden overflow-y-auto no-scrollbar transition origin-left transform bg-gray-900 w-[18rem] sm:translate-x-0" 
                     :class="{ '-translate-x-full': !sideBar, 'translate-x-0': sideBar }"
                >
                    <span class="flex justify-center items-center border-b border-dashed px-4 py-5 text-white font-bold">{{ $page.props.app_name }}</span>
                    <nav class="text-sm font-medium text-gray-500 p-3 space-y-4 my-3">
                        <div class="space-y-1" v-for="section, section_key in $page.props.menu">
                            <p class="uppercase text-gray-100 text-xs mb-3 tracking-wide">{{ section.name }}</p>
                            <template v-for="menu, menu_key in section.menus">
                                <template v-if="menu.menu_route">
                                    <BreezeNavLink v-if="$page.props.can[menu.menu_permission]" :href="route(menu.menu_route)" :active="route().current(menu.menu_route)" class="rounded-lg">
                                        <span class="mr-2" v-html="menu.menu_icon"></span>
                                        <span class="select-none tracking-wide">{{ menu.menu_name }}</span> 
                                    </BreezeNavLink>
                                </template>
                                <template v-else>
                                    <div class="space-y-1" v-if="$page.props.can[menu.menu_permission]">
                                        <div class="flex items-center justify-between px-4 py-2 transition cursor-pointer group hover:bg-gray-800 hover:text-gray-200 rounded-lg" :class="menu_opened.section_key == section_key && menu_opened.menu_key == menu_key ? 'text-white tracking-wide bg-gray-800' : ''" role="button" @click="toggleMenu(section_key, menu_key)">
                                            <div class="flex items-center">
                                                <span class="mr-2" v-html="menu.menu_icon"></span>
                                                <span class="select-none tracking-wide">{{ menu.menu_name }}</span> 
                                            </div>
                                            <ChevronRightIcon :class="{ 'rotate-90': checkMenuIsOpen(section_key, menu_key) }" class="shrink-0 w-4 h-4 ml-2 transition transform"></ChevronRightIcon>
                                        </div>
                                        <div class="mb-3 ml-3 space-y-1 pb-3" v-if="checkMenuIsOpen(section_key, menu_key)">
                                            <template v-for="(sub_menu, sub_menu_key) in menu.sub_menus">
                                                <BreezeNavSubLink v-if="$page.props.can[sub_menu.sub_menu_permission]" :href="sub_menu.sub_menu_route ? route(sub_menu.sub_menu_route) : ''" 
                                                                :active="sub_menu.sub_menu_route ? route().current() && route().current().startsWith(sub_menu.sub_menu_route) : ''" class="rounded-lg"
                                                >
                                                <span class="select-none tracking-normal">{{ sub_menu.sub_menu_name }}</span>
                                                </BreezeNavSubLink>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </template>
                        </div>
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

            <!-- Page Content -->
            <main class="flex flex-col bg-indigo-50 relative h-full justify-between">
                <div class="">
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
                                        <BreezeDropdown align="right" width="96" @close-notification="closeNotification">
                                            <template #trigger>
                                                <span class="inline-flex rounded-md" @click="notificationOpen = true">
                                                    <button type="button" class="inline-flex items-center px-3 py-2 ">
                                                        <div class="w-5 h-5">
                                                            <div class="relative" v-if="notificationOpen">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                                    <path d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416H416c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z"/>
                                                                </svg>
                                                                <div class="absolute" style="top: 2px; left: 10px" v-if="$page.props.user_has_notifications">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="text-red-500" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8"/>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div class="" v-else>
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                                    <path d="M256 32V49.88C328.5 61.39 384 124.2 384 200V233.4C384 278.8 399.5 322.9 427.8 358.4L442.7 377C448.5 384.2 449.6 394.1 445.6 402.4C441.6 410.7 433.2 416 424 416H24C14.77 416 6.365 410.7 2.369 402.4C-1.628 394.1-.504 384.2 5.26 377L20.17 358.4C48.54 322.9 64 278.8 64 233.4V200C64 124.2 119.5 61.39 192 49.88V32C192 14.33 206.3 0 224 0C241.7 0 256 14.33 256 32V32zM216 96C158.6 96 112 142.6 112 200V233.4C112 281.3 98.12 328 72.31 368H375.7C349.9 328 336 281.3 336 233.4V200C336 142.6 289.4 96 232 96H216zM288 448C288 464.1 281.3 481.3 269.3 493.3C257.3 505.3 240.1 512 224 512C207 512 190.7 505.3 178.7 493.3C166.7 481.3 160 464.1 160 448H288z"/>
                                                                </svg>
                                                                <div class="absolute" style="top: 11px; right: 13px" v-if="$page.props.user_has_notifications">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="text-red-500" viewBox="0 0 16 16">
                                                                        <circle cx="8" cy="8" r="8"/>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </span>
                                            </template>
                                            <template #content>
                                                <div class="overflow-y-auto max-h-60 no-scrollbar divide-y divide-dashed" v-if="$page.props.user_notifications.length">
                                                    <div class="flex justify-center" v-for="notification, index in $page.props.user_notifications" :key="notification.id">
                                                        <BreezeDropdownLink :href="route('view_notification', {'id' : notification.id})" :class="notification.seen != 1 ? 'bg-blue-200 hover:bg-blue-300' : 'bg-white hover:bg-gray-100'">
                                                            <div class="flex justify-between items-center py-2">
                                                                <div class="flex space-x-3 px-2 items-center">
                                                                    <span class="text-2xl text-[30px]" v-html="notification.panel_icon"></span>
                                                                    <span class="text-black">{{ notification.panel_content }}</span>
                                                                </div>
                                                                <div class="flex min-w-[70px]">
                                                                    <TimeAgo class="text-indigo-500" :datetime="notification.created_at"></TimeAgo>
                                                                </div>
                                                            </div>
                                                        </BreezeDropdownLink>
                                                    </div>
                                                </div>
                                                <div class="rounded-md overflow-y-auto" v-else>
                                                    <div class="bg-white-100 text-center py-4 text-blue-400">
                                                        <span class="text-sm text-gray-500">No notifications available!</span>
                                                    </div>
                                                </div>
                                                <BreezeDropdownLink :href="route('notifications')" :preserveState="false" class="text-center bg-gray-200 hover:bg-gray-300 rounded-b-md text-gray-500 font-semibold">
                                                    <a>View all notifications</a>
                                                </BreezeDropdownLink>
                                            </template>
                                        </BreezeDropdown>
                                    </div>
                                    <div class="ml-3 relative">
                                        <BreezeDropdown align="right" width="48">
                                            <template #trigger>
                                                <span class="inline-flex rounded-md step-2">
                                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 transition ease-in-out duration-150">
                                                        <div class=" w-10 h-10 rounded-full overflow-hidden border-2 border-gray-300 mr-2">
                                                            <img v-if="$page.props.auth.profile_photo" :src="'/storage/'+$page.props.auth.profile_photo" alt="" class="w-full h-full object-cover select-none"/>
                                                            <svg v-else class="h-full w-full text-gray-300 border rounded-full" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                            </svg>
                                                        </div>
                                                        <span class="select-none truncate max-w-[160px]">{{$page.props.auth.user.display_name}}</span>
                                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </button>
                                                </span>
                                            </template>
                                            <template #content>
                                                <div class="py-1">
                                                    <BreezeDropdownLink class="flex space-x-2" :href="route('profile')" v-if="this.$page.props.can.profile_access">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                                                            <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/>
                                                        </svg>
                                                        <span>Profile</span>
                                                        
                                                    </BreezeDropdownLink>
                                                    <BreezeDropdownLink class="flex space-x-2" :href="route('children')" v-if="this.$page.props.can.children_access">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 640 512">
                                                            <path d="M160 128c-35.3 0-64-28.7-64-64s28.7-64 64-64s64 28.7 64 64s-28.7 64-64 64zM88 480V400H70.2c-10.9 0-18.6-10.7-15.2-21.1l31.1-93.4L57.5 323.3c-10.7 14.1-30.8 16.8-44.8 6.2s-16.8-30.7-6.2-44.8L65.4 207c22.4-29.6 57.5-47 94.6-47s72.2 17.4 94.6 47l58.9 77.7c10.7 14.1 7.9 34.2-6.2 44.8s-34.2 7.9-44.8-6.2l-28.6-37.8L265 378.9c3.5 10.4-4.3 21.1-15.2 21.1H232v80c0 17.7-14.3 32-32 32s-32-14.3-32-32V400H152v80c0 17.7-14.3 32-32 32s-32-14.3-32-32zM480 128c-35.3 0-64-28.7-64-64s28.7-64 64-64s64 28.7 64 64s-28.7 64-64 64zm-8 256v96c0 17.7-14.3 32-32 32s-32-14.3-32-32V300.5L395.1 321c-9.4 15-29.2 19.4-44.1 10s-19.4-29.2-10-44.1l51.7-82.1c17.6-27.9 48.3-44.9 81.2-44.9h12.3c33 0 63.7 16.9 81.2 44.9L619.1 287c9.4 15 4.9 34.7-10 44.1s-34.7 4.9-44.1-10L552 300.5V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V384H472z"/>
                                                        </svg>
                                                        <span>Children</span>
                                                        
                                                    </BreezeDropdownLink>
                                                    <BreezeDropdownLink class="flex space-x-2 border-t" :href="route('logout')" method="post" as="button">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
                                                            <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                                                        </svg>
                                                        <span>Log Out</span> 
                                                    </BreezeDropdownLink>
                                                </div>
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
                    <header class="bg-indigo-600 shadow" v-if="$slots.header">
                        <div class="flex mx-auto py-3 px-4 sm:px-6 lg:px-6 justify-between">
                            <!-- <slot name="header" /> -->
                            <Breadcrumbs :breadcrumbs="$page.props.breadcrumbs"/>
                        </div>
                    </header>
                        <div class="px-6 py-3 bg-blue bg-red-500 space-y-4 lg:flex lg:space-y-0 justify-between items-center" v-if="$page.props.can.impersonate_access || $page.props.can.is_impersonated">
                            <span class="text-white text-sm italic">Warning: use with caution, any changes will reflect to user that being impersonated.</span>
                            <form @submit.prevent="impersonate" class="flex space-x-2 items-center sm:justify-end">
                                <label for="" class="text-white lg:text-sm sm:text-md font-bold">Username</label>
                                <input type="text" class="rounded py-1 px-2 border-orange-500 focus:ring-0 focus:border-orange-500" v-model="username">
                                <BreezeButton @click="impersonate" class="hidden sm:block bg-blue-600 hover:bg-blue-700 py-2 px-4">Change User</BreezeButton>
                                <BreezeButton @click="impersonate" class="sm:hidden bg-blue-600 hover:bg-blue-700 p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5zm14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5z"/>
                                    </svg>
                                </BreezeButton>
                            </form>
                        </div>
                    <slot/>
                </div>
                <div class="py-5 px-6 bg-slate-700 text-white bottom-0">
                    <span class="text-sm font-extrabold">&copy; </span><span class="text-sm">{{ new Date().getFullYear() + ' ' + $page.props.app_name }}</span>
                </div>
            </main>
        </div>
    </div>
</template>
