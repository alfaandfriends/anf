<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue'
import { Link } from '@inertiajs/inertia-vue3'
import { CircleUser, Menu } from 'lucide-vue-next'
import { useToast } from '@/Components/ui/toast/use-toast'
import { Toaster } from '@/Components/ui/toast'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/Components/ui/dropdown-menu'
import { Sheet, SheetContent, SheetTrigger } from '@/Components/ui/sheet'
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/Components/ui/accordion'
import { ScrollArea } from '@/Components/ui/scroll-area'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'

const { toast } = useToast()

export default {
    components: {
        CircleUser, Menu,
        BreezeApplicationLogo, Link, Breadcrumbs, useToast, Toaster, DropdownMenu, DropdownMenuContent, DropdownMenuItem, 
        DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger, Sheet, SheetContent, SheetTrigger, Accordion, AccordionContent, AccordionItem, 
        AccordionTrigger, ScrollArea
    },
    data() {
        return {
            current_route: '',
            menu_setting: [],
            menu_opened: {
                section_key: '',
                menu_key: ''
            },
            notificationOpen: false,
            showingNavigationDropdown: false,
            sideBar: false,
            selected: '',
            notifications: [],
            username: '',
            darkMode: false,
            currentToast: null,
        }
    },
    watch: {
        '$page.props.flash': {
            handler() {
                this.$nextTick(() => {
                    this.currentToast = toast({
                        description: this.$page.props.flash.message,
                        variant: this.$page.props.flash.type,
                    });
                });
            },
            deep: true, 
        },
    },
    methods: {
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
        closeNotification(status){
            if(status){
                this.notificationOpen = false
            }
        },
        impersonate(){
            if(this.username){
                this.$inertia.get(route('impersonate', this.username))
            }
        }
    },
    created(){
        this.initMenu()
        this.$nextTick(() => {
            const { flash } = this.$page.props;
            if (flash && flash.type && flash.message) {
                this.currentToast = toast({
                    description: flash.message,
                    variant: flash.type,
                });
            }
        });
    },
    mounted(){
        this.$nextTick(() => {
            const { flash } = this.$page.props;
            if (flash && flash.type && flash.message) {
                this.currentToast = toast({
                    description: flash.message,
                    variant: flash.type,
                });
            }
        });
    },
    beforeUnmount() {
        if (this.currentToast) {
            this.currentToast.dismiss();
        }
    },
}
</script>

<template>
    <div class="grid min-h-screen w-full md:grid-cols-[220px_1fr] lg:grid-cols-[280px_1fr] font-noto">
        <div class="hidden border-r bg-white shadow md:block">
        <div class="flex h-full flex-col">
            <div class="flex h-14 items-center border-b px-4 lg:h-[60px] lg:px-6">
                <Link href="/admin" class="flex items-center gap-2 font-semibold h-60">
                    <BreezeApplicationLogo class="h-6 fill-current text-gray-500" />
                    <span class="font-bold">ALFA and Friends</span>
                </Link>
            </div>
            <ScrollArea class="h-full px-4 bg-white">
                <div class="flex-1">
                    <nav class="grid items-start p-2 text-sm font-medium lg:px-3 lg:py-4 gap-y-1">
                        <template v-for="section, section_key in $page.props.menu">
                            <span class="mb-1 text-xs font-bold">{{ section.name }}</span>
                            <div class="mb-3">
                                <template v-for="menu, menu_key in section.menus">
                                    <template v-if="menu.menu_route && menu.menu_status == 1">
                                        <Link
                                            v-if="$page.props.can[menu.menu_permission]"
                                            :href="route(menu.menu_route)"
                                            class="flex items-center justify-between mb-1 px-3 py-2 transition cursor-pointer group hover:bg-slate-900 hover:text-slate-200 rounded-lg"
                                            :class="route().current() && route().current().startsWith(menu.menu_route) ? 'text-white tracking-wide bg-slate-900' : ''"
                                        >
                                            <div class="flex items-center">
                                                <span class="mr-3 h-6 w-6"><img :src="'/images/' + menu.menu_icon"></span>
                                                <span class="select-none font-semibold tracking-wide">{{ menu.menu_name }}</span>
                                            </div>
                                        </Link>
                                    </template>
                                    <template v-else>
                                        <Accordion type="single" collapsible v-if="$page.props.can[menu.menu_permission]" :defaultValue="menu_opened.menu_key == menu_key && menu_opened.section_key == section_key ? `item-${menu_key}` : ''">
                                            <AccordionItem :value="`item-${menu_key}`" :class="'border-0'">
                                                <AccordionTrigger class="flex items-center justify-between px-3 py-2 transition cursor-pointer group hover:bg-slate-900 hover:text-slate-200 rounded-lg" :class="menu_opened.menu_key == menu_key && menu_opened.section_key == section_key ? 'text-white tracking-wide bg-slate-900' : ''">
                                                    <div class="flex items-center">
                                                        <span class="mr-3 h-6 w-6"><img :src="'/images/' + menu.menu_icon"></span>
                                                        <span class="select-none font-semibold tracking-wide">{{ menu.menu_name }}</span>
                                                    </div>
                                                </AccordionTrigger>
                                                <AccordionContent>
                                                    <div class="pl-9 py-0.5">
                                                        <template v-for="(sub_menu, sub_menu_key) in menu.sub_menus">
                                                            <Link 
                                                                v-if="$page.props.can[sub_menu.sub_menu_permission] && sub_menu.sub_menu_status == 1"
                                                                :href="sub_menu.sub_menu_route ? route(sub_menu.sub_menu_route) : ''"
                                                                class="flex items-center justify-between mb-1 px-3 py-1.5 transition cursor-pointer group hover:bg-slate-300 hover:text-black rounded-lg"
                                                                :class="route().current() && route().current().startsWith(sub_menu.sub_menu_route) ? 'text-black tracking-wide bg-slate-300' : ''"
                                                            >
                                                                <span class="select-none tracking-wide">{{ sub_menu.sub_menu_name }}</span>
                                                            </Link>
                                                        </template>
                                                    </div>
                                                </AccordionContent>
                                            </AccordionItem>
                                        </Accordion>
                                    </template>
                                </template>
                            </div>
                        </template>
                    </nav>
                </div>
            </ScrollArea>
        </div>
        </div>
        <div class="flex flex-col">
            <header class="flex h-14 items-center gap-4 border-b bg-white shadow px-4 lg:h-[60px] lg:px-6">
                <Sheet>
                    <SheetTrigger as-child>
                        <Button
                        variant="outline"
                        size="icon"
                        class="shrink-0 md:hidden"
                        >
                        <Menu class="h-5 w-5" />
                        <span class="sr-only">Toggle navigation menu</span>
                        </Button>
                    </SheetTrigger>
                    <SheetContent side="left" class="flex flex-col p-4">
                            <Link href="/admin" class="flex item-center">
                                <BreezeApplicationLogo class="h-6 fill-current text-gray-500" />
                                <span class="font-bold font-noto ml-3">ALFA and Friends</span>
                            </Link>
                            <ScrollArea class="h-screen px-4">
                                <div class="flex-1">
                                    <nav class="grid items-start text-sm font-medium gap-y-1">
                                        <template v-for="section, section_key in $page.props.menu">
                                            <span class="mb-1 text-xs font-semibold">{{ section.name }}</span>
                                            <div class="mb-3">
                                                <template v-for="menu, menu_key in section.menus">
                                                    <template v-if="menu.menu_route && menu.menu_status == 1">
                                                        <Link
                                                            v-if="$page.props.can[menu.menu_permission]"
                                                            :href="route(menu.menu_route)"
                                                            class="flex items-center justify-between mb-1 px-3 py-2 transition cursor-pointer group hover:bg-slate-900 hover:text-slate-200 rounded-lg"
                                                            :class="route().current() && route().current().startsWith(menu.menu_route) ? 'text-white tracking-wide bg-slate-900' : ''"
                                                        >
                                                            <div class="flex items-center">
                                                                <span class="mr-3 h-6 w-6"><img :src="'/images/' + menu.menu_icon"></span>
                                                                <span class="select-none font-semibold tracking-wide">{{ menu.menu_name }}</span>
                                                            </div>
                                                        </Link>
                                                    </template>
                                                    <template v-else>
                                                        <Accordion type="single" collapsible v-if="$page.props.can[menu.menu_permission]" :defaultValue="menu_opened.menu_key == menu_key && menu_opened.section_key == section_key ? `item-${menu_key}` : ''">
                                                            <AccordionItem :value="`item-${menu_key}`" :class="'border-0'">
                                                                <AccordionTrigger class="flex items-center justify-between px-3 py-2 transition cursor-pointer group hover:bg-slate-900 hover:text-slate-200 rounded-lg" :class="menu_opened.menu_key == menu_key && menu_opened.section_key == section_key ? 'text-white tracking-wide bg-slate-900' : ''">
                                                                    <div class="flex items-center">
                                                                        <span class="mr-3 h-6 w-6"><img :src="'/images/' + menu.menu_icon"></span>
                                                                        <span class="select-none font-semibold tracking-wide">{{ menu.menu_name }}</span>
                                                                    </div>
                                                                </AccordionTrigger>
                                                                <AccordionContent>
                                                                    <div class="pl-9 py-0.5">
                                                                        <template v-for="(sub_menu, sub_menu_key) in menu.sub_menus">
                                                                            <Link 
                                                                                v-if="$page.props.can[sub_menu.sub_menu_permission] && sub_menu.sub_menu_status == 1"
                                                                                :href="sub_menu.sub_menu_route ? route(sub_menu.sub_menu_route) : ''"
                                                                                class="flex items-center justify-between mb-1 px-3 py-1.5 transition cursor-pointer group hover:bg-slate-300 hover:text-black rounded-lg"
                                                                                :class="route().current() && route().current().startsWith(sub_menu.sub_menu_route) ? 'text-black tracking-wide bg-slate-300' : ''"
                                                                            >
                                                                                <span class="select-none tracking-wide">{{ sub_menu.sub_menu_name }}</span>
                                                                            </Link>
                                                                        </template>
                                                                    </div>
                                                                </AccordionContent>
                                                            </AccordionItem>
                                                        </Accordion>
                                                    </template>
                                                </template>
                                            </div>
                                        </template>
                                    </nav>
                                </div>
                            </ScrollArea>
                    </SheetContent>
                </Sheet>
                <div class="w-full flex-1">
                </div>
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button variant="secondary" size="icon" class="rounded-full">
                        <CircleUser class="h-5 w-5" />
                        <span class="sr-only">Toggle user menu</span>
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuLabel>{{ $page.props.auth.user.display_name}}</DropdownMenuLabel>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem @click="$inertia.get(route('profile'))">Profile</DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem @click="$inertia.post(route('admin.logout'))" >Logout</DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </header>
            <main class="flex flex-1 flex-col gap-4 p-4 lg:p-6 bg-gray-50 w-full">
                <Breadcrumbs :breadcrumbs="$page.props.breadcrumbs"/>
                <div class="px-6 py-2 bg-blue bg-red-500 space-y-4 lg:flex lg:space-y-0 justify-center text-center lg:justify-between items-center" v-if="$page.props.can.impersonate_access || $page.props.can.is_impersonated">
                    <span class="text-white text-xs font-semibold whitespace-nowrap">Warning: Please use this feature with caution!</span>
                    <form @submit.prevent="impersonate" class="flex flex-col lg:flex-row w-full space-x-2 items-center md:justify-end lg:justify-end">
                        <label for="impersonate_username" class="text-white 2xl:text-sm sm:text-md font-bold">Username</label>
                        <div class="flex space-x-2 items-center">
                            <input type="text" id="impersonate_username" class="rounded py-1 px-2 border-orange-500 focus:ring-0 focus:border-orange-500" v-model="username" autocomplete="none">
                            <Button @click="impersonate" class="px-3 py-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 512 512">
                                    <path d="M0 224c0 17.7 14.3 32 32 32s32-14.3 32-32c0-53 43-96 96-96H320v32c0 12.9 7.8 24.6 19.8 29.6s25.7 2.2 34.9-6.9l64-64c12.5-12.5 12.5-32.8 0-45.3l-64-64c-9.2-9.2-22.9-11.9-34.9-6.9S320 19.1 320 32V64H160C71.6 64 0 135.6 0 224zm512 64c0-17.7-14.3-32-32-32s-32 14.3-32 32c0 53-43 96-96 96H192V352c0-12.9-7.8-24.6-19.8-29.6s-25.7-2.2-34.9 6.9l-64 64c-12.5 12.5-12.5 32.8 0 45.3l64 64c9.2 9.2 22.9 11.9 34.9 6.9s19.8-16.6 19.8-29.6V448H352c88.4 0 160-71.6 160-160z"/>
                                </svg>
                            </Button>
                        </div>
                    </form>
                </div>
                <slot/>
                <Toaster v-if="$page.props.flash.type"/>
            </main>
            <div class="flex justify-center border-t items-center py-5 px-6 bg-white text-slate-900 font-bold">
                <span class="text-sm">{{ new Date().getFullYear() }} &copy; ALFA and Friends</span>
            </div>
        </div>
    </div>
</template>
