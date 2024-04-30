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
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import TimeAgo from '@/Components/TimeAgo.vue'
import Toggle from '@vueform/toggle';
import { PerfectScrollbar } from 'vue3-perfect-scrollbar'
import 'vue3-perfect-scrollbar/dist/vue3-perfect-scrollbar.css'

export default {
    components: {
        BreezeApplicationLogo, Link, Toast, BreezeButton, Toggle,
        BreezeDropdown, BreezeDropdownLink, BreezeNavLink, BreezeResponsiveNavLink, BreezeNavSubLink, Breadcrumbs, TimeAgo, PerfectScrollbar,
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
            darkMode: false
        }
    },
    methods: {
        switchMode(){
            if(this.darkMode){

            }
            else{

            }
        },
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
        subscribeNotifications(){
            Echo.leave('test')
            Echo.channel('test')
            .listen('Test', (data) => {
                this.$page.props.user_has_notifications = true
                this.$page.props.user_notifications.unshift({
                    'id': 'test',
                    'panel_icon': '',
                    'panel_content': 'This is a test',
                    'created_at': ''
                })
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
        // this.subscribeGlobalChannel()
        // this.subscribeNotifications()
        // this.subscribeApprovalChannel()
        // if(this.$page.props.auth.first_time_login == 1 && this.$page.props.auth.profile_updated == 1){
        //     this.$vgt.start(0);
        // }
    },
    created(){
        this.initMenu()
    }
}
</script>

<template>
    <div class="flex">
        <!-- Sidebar -->
        <div class="flex min-h-screen bg-gray-50 step-1">
            <!-- Sidebar Menu -->
            <nav class="fixed bg-gray-900 w-[18rem] top-0 left-0 z-30 transition h-full origin-left overflow-y-auto no-scrollbar transform sm:translate-x-0" :class="{ '-translate-x-full': !sideBar, 'translate-x-0': sideBar }">
                <div class="flex justify-center border-b border-dotted">
                <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <Link href="/admin">
                            <BreezeApplicationLogo class="h-8 fill-current text-gray-500" />
                        </Link>
                    </div>
                    <span class="flex justify-center items-center px-4 py-5 text-white font-bold">{{ $page.props.app_name }}</span>
                </div>
                <nav class="text-sm font-medium text-gray-500 p-3 space-y-4 my-3">
                    <div class="space-y-1" v-for="section, section_key in $page.props.menu">
                        <p class="uppercase text-gray-100 text-xs mb-3">{{ section.name }}</p>
                        <template v-for="menu, menu_key in section.menus">
                            <template v-if="menu.menu_route && menu.menu_status == 1">
                                <div class="flex space-x-1">
                                    <div class="px-0.5 rounded-r bg-red-500" v-if="route().current() && route().current().startsWith(menu.menu_route)"></div>
                                    <BreezeNavLink v-if="$page.props.can[menu.menu_permission]" :href="route(menu.menu_route)" :active="route().current() && route().current().startsWith(menu.menu_route)" class="rounded-lg flex-auto">
                                        <span class="mr-3 h-8 w-8"><img :src="'/images/' + menu.menu_icon"></span>
                                        <span class="select-none font-semibold tracking-wide">{{ menu.menu_name }}</span>
                                    </BreezeNavLink>
                                </div>
                            </template>
                            <template v-else>
                                <div class="space-y-1" v-if="$page.props.can[menu.menu_permission]">
                                    <div class="flex items-center justify-between px-4 py-2 transition cursor-pointer group hover:bg-gray-800 hover:text-gray-200 rounded-lg" :class="menu_opened.section_key == section_key && menu_opened.menu_key == menu_key ? 'text-white tracking-wide bg-gray-800' : ''" role="button" @click="toggleMenu(section_key, menu_key)">
                                        <div class="flex items-center">
                                            <span class="mr-3 h-8 w-8"><img :src="'/images/' + menu.menu_icon"></span>
                                            <span class="select-none font-semibold tracking-wide">{{ menu.menu_name }}</span>
                                        </div>
                                        <ChevronRightIcon :class="{ 'rotate-90': checkMenuIsOpen(section_key, menu_key) }" class="shrink-0 w-4 h-4 ml-2 transition transform"></ChevronRightIcon>
                                    </div>
                                    <div class="mb-3 ml-3 space-y-1 pb-3" v-if="checkMenuIsOpen(section_key, menu_key)">
                                        <template v-for="(sub_menu, sub_menu_key) in menu.sub_menus">
                                            <div class="flex space-x-1" v-if="$page.props.can[sub_menu.sub_menu_permission] && sub_menu.sub_menu_status == 1">
                                                <div class="px-0.5 rounded-r bg-red-500" v-if="route().current() && route().current().startsWith(sub_menu.sub_menu_route)"></div>
                                                <BreezeNavSubLink v-if="$page.props.can[sub_menu.sub_menu_permission]" :href="sub_menu.sub_menu_route ? route(sub_menu.sub_menu_route) : ''"
                                                                :active="sub_menu.sub_menu_route ? route().current() && route().current().startsWith(sub_menu.sub_menu_route) : ''" class="rounded-lg flex-auto"
                                                >
                                                <span class="select-none tracking-wide">{{ sub_menu.sub_menu_name }}</span>
                                                </BreezeNavSubLink>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </template>
                    </div>
                    <BreezeNavLink class="w-full sm:hidden" :href="route('admin.logout')" method="post" as="button">
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
            <!-- Sidebar Outer Layer -->
            
            <div class="fixed h-screen bg-gray-200 w-full md:w-[18rem] top-0 left-0 z-10 h-fullo transition origin-left transform sm:translate-x-0 sm:hidden" :class="{ '-translate-x-full': !sideBar, 'translate-x-0': sideBar }"@click="showingNavigationDropdown = !showingNavigationDropdown, sideBar = !sideBar">
            </div>
        </div>
        <!-- Page Content -->
        <div class="flex-1 flex flex-col bg-indigo-50 justify-between w-screen sm:pl-64 md:pl-72 lg:pl-72 xl:pl-72">
            <Toast :toastData="$page.props.flash"></Toast>
            <main class="flex-grow">
                <div class="flex flex-col">
                    <nav class="bg-white border-b border-gray-100 sticky top-0 z-20">
                        <!-- Primary Navigation Menu -->
                        
                        <div class="mx-auto px-4 sm:px-6 lg:px-8 shadow-md">
                            <div class="flex justify-end h-16">
    
                                <div class="hidden sm:flex sm:items-center sm:ml-6">
                                <!-- Settings Dropdown -->
                                
                                    <!-- <div class="flex space-x-2">
                                        <Toggle @click="switchMode" v-model="darkMode"
                                            :classes="{
                                                container: 'inline-block',
                                                toggle: 'flex w-10 h-5 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
                                                toggleOn: 'bg-gray-500 border-gray-500 justify-start text-white',
                                                toggleOff: 'bg-white-400 border-gray-500 justify-end text-gray-700',
                                                handle: 'inline-block bg-gray-500 w-5 h-5 top-0 rounded-full absolute transition-all',
                                                handleOn: 'left-full transform -translate-x-full bg-white',
                                                handleOff: 'left-0 bg-gray-500',
                                            }
                                        "/>
                                        
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800" viewBox="0 0 384 512">
                                            <path d="M223.5 32C100 32 0 132.3 0 256S100 480 223.5 480c60.6 0 115.5-24.2 155.8-63.4c5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-9.8 1.7-19.8 2.6-30.1 2.6c-96.9 0-175.5-78.8-175.5-176c0-65.8 36-123.1 89.3-153.3c6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-6.3-.5-12.6-.8-19-.8z"/>
                                        </svg>
                                    </div> -->
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
                                                                    <TimeAgo class="text-indigo-500" v-if="notification.created_at != ''" :datetime="notification.created_at"></TimeAgo>
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
                                                    <BreezeDropdownLink class="flex space-x-2" :href="route('profile')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                                                            <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/>
                                                        </svg>
                                                        <span>Profile</span>
    
                                                    </BreezeDropdownLink>
                                                    <BreezeDropdownLink class="flex space-x-2 border-t" :href="route('admin.logout')" method="post" as="button">
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
                        <span class="text-white text-sm font-semibold italic whitespace-nowrap">Warning: Please use this feature with caution!</span>
                        <form @submit.prevent="impersonate" class="flex flex-col lg:flex-row w-full space-x-2 items-center md:justify-end lg:justify-end">
                            <label for="impersonate_username" class="text-white 2xl:text-sm sm:text-md font-bold">Username</label>
                            <div class="flex space-x-2 items-center">
                                <input type="text" id="impersonate_username" class="rounded py-1 px-2 border-orange-500 focus:ring-0 focus:border-orange-500" v-model="username" autocomplete="none">
                                <BreezeButton @click="impersonate" class="hidden sm:block bg-blue-600 hover:bg-blue-700 py-2 px-4">Change User</BreezeButton>
                                <BreezeButton @click="impersonate" class="sm:hidden bg-blue-600 hover:bg-blue-700 p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5zm14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5z"/>
                                    </svg>
                                </BreezeButton>
                            </div>
                        </form>
                    </div>
                    <slot/>
                </div>
            </main>
            <!-- Footer -->
            <div class="flex justify-between items-center py-5 px-6 bg-slate-700 text-white">
                <div class="">
                    <span class="text-sm font-extrabold">&copy; </span>
                    <span class="text-sm">{{ new Date().getFullYear() + ' ' + $page.props.app_name }}</span>
                </div>
            </div>
            <!-- component -->
            <!-- <div class="group fixed bottom-0 right-0 p-5  flex items-end justify-end w-24 h-24"> -->
                <!-- <div class="text-white shadow-xl flex items-center justify-center p-3 rounded-full bg-gradient-to-r from-indigo-500 to-indigo-600 z-50 absolute cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 448 512">
                        <path d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                    </svg>
                </div> -->
                <!-- <div class="absolute rounded-full transition-all duration-[0.2s] ease-out scale-y-0 group-hover:scale-y-100 group-hover:-translate-x-16   flex  p-2 hover:p-3 bg-green-300 scale-100 hover:bg-green-400 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 10.5h.375c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125H21M3.75 18h15A2.25 2.25 0 0021 15.75v-6a2.25 2.25 0 00-2.25-2.25h-15A2.25 2.25 0 001.5 9.75v6A2.25 2.25 0 003.75 18z" />
                    </svg>
                </div>
                <div class="absolute rounded-full transition-all duration-[0.2s] ease-out scale-x-0 group-hover:scale-x-100 group-hover:-translate-y-16  flex  p-2 hover:p-3 bg-blue-300 hover:bg-blue-400  text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.143 17.082a24.248 24.248 0 003.844.148m-3.844-.148a23.856 23.856 0 01-5.455-1.31 8.964 8.964 0 002.3-5.542m3.155 6.852a3 3 0 005.667 1.97m1.965-2.277L21 21m-4.225-4.225a23.81 23.81 0 003.536-1.003A8.967 8.967 0 0118 9.75V9A6 6 0 006.53 6.53m10.245 10.245L6.53 6.53M3 3l3.53 3.53" />
                    </svg>
                </div>
                <div class="absolute rounded-full transition-all duration-[0.2s] ease-out scale-x-0 group-hover:scale-x-100 group-hover:-translate-y-14 group-hover:-translate-x-14   flex  p-2 hover:p-3 bg-yellow-300 hover:bg-yellow-400 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                    </svg>
                </div> -->
            <!-- </div> -->
        </div>
    </div>
</template>
