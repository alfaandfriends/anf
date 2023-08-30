<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
    import BreezeButton from '@/Components/Button.vue';
</script>
<template>
    <Head title="Notifications" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block min-w-full">
                        <div class="h-full flex flex-col">
                    
                        <!-- Bottom section -->
                            <div class="min-h-0 flex-1 flex overflow-hidden">
                        
                                <!-- Message list-->
                                <div class="h-full relative flex flex-col border-r border-gray-200 bg-gray-100 w-1/3">
                                    <div class="flex-shrink-0">
                                        <div class="h-16 px-6 flex flex-col justify-center bg-blue-200">
                                            <div class="flex items-baseline space-x-3">
                                                <h2 class="text-lg font-medium text-gray-900">Notifications</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h-[74vh]">
                                        <div class="flex flex-row space-x-2 border-t border-b border-gray-200 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-500">
                                            <button class="shadow-md inline-flex items-center border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="route().current('notifications', {'filter':'unread'}) || route().current('notifications', {'filter':'read'}) ? 'bg-blue-400 px-2 py-1' : 'bg-blue-700 py-1 px-2'" @click="showAllNotifications()">All</button>
                                            <button class="shadow-md inline-flex items-center border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="route().current('notifications', {'filter':'unread'}) ? 'bg-blue-700 px-2 py-1' : 'bg-blue-400 py-1 px-2'" @click="showReadNotifications()">Unread</button>
                                            <button class="shadow-md inline-flex items-center border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest focus:outline-none transition ease-in-out duration-150 cursor-pointer" :class="route().current('notifications', {'filter':'read'}) ? 'bg-blue-700 px-2 py-1' : 'bg-blue-400 py-1 px-2'" @click="showUnreadNotifications()">Read</button>
                                        </div>
                                        <div class="bg-blue-100 h-[70vh] overflow-hidden overflow-y-auto no-scrollbar" v-if="!$page.props.notifications.length">
                                            <div aria-label="Message list" class="h-full text-center pt-6">
                                                <span class="text-md text-gray-500">Nothing to see here.</span>
                                            </div>
                                        </div>
                                        <div class="bg-white h-[70vh] overflow-hidden hover:overflow-y-auto no-scrollbar w-full" v-else @scroll="onScroll">
                                            <div aria-label="Message list" class="h-full">
                                                <ul role="list" class="border-b border-gray-200 divide-y divide-gray-200">
                                                    <li v-for="notification in $page.props.notifications" :key="notification.id" :class="[route().current('view_notification', {'id': notification.id}) ? 'bg-indigo-50' : '', notification.seen ? '' : 'bg-blue-200']" class="relative cursor-pointer bg-white py-5 px-6 hover:bg-indigo-50" @click="viewNotification(notification.id)">
                                                        <div class="flex justify-between space-x-3">
                                                            <div class="min-w-0 flex-1">
                                                                <a :href="notification.href" class="block focus:outline-none">
                                                                <span class="absolute inset-0" aria-hidden="true" />
                                                                <p class="text-sm font-medium text-gray-900 truncate">{{ notification.sender }}</p>
                                                                </a>
                                                            </div>
                                                            <TimeAgo class="flex-shrink-0 whitespace-nowrap text-sm text-gray-500" :datetime="notification.created_at"></TimeAgo>
                                                        </div>
                                                        <div class="mt-1">
                                                            <p class="line-clamp-2 text-sm text-gray-600">
                                                                {{ notification.message }}
                                                            </p>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Main area -->
                                <div class="flex flex-col grow w-full">
                                    <div class="flex h-16 items-center justify-end bg-blue-200">
                                    </div>
                                    <div class="flex flex-col">
                                        <div class="flex h-[74vh] justify-center items-center bg-white" v-if="!$page.props.user_notifications.length">
                                            <img src="/images/no_notification_yet.png" class="h-1/3 w-1/5" alt="">
                                        </div>
                                        <div class="flex justify-center h-[74vh] overflow-y-auto no-scrollbar" v-else>
                                            <slot>
                                            </slot>
                                        </div>
                                    </div>
                                </div>
                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
  
<script>
    import { ref } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import moment from 'moment';
    import TimeAgo from '@/Components/TimeAgo.vue'
    import { Dialog, DialogOverlay, Menu, MenuButton, MenuItem, MenuItems, TransitionChild, TransitionRoot, } from '@headlessui/vue'
    import { ArchiveIcon as ArchiveIconSolid, ChevronDownIcon, ChevronUpIcon, DotsVerticalIcon, FolderDownloadIcon, PencilIcon, ReplyIcon, SearchIcon, UserAddIcon, } from '@heroicons/vue/solid'
    import { ArchiveIcon as ArchiveIconOutline, BanIcon, BellIcon, FlagIcon, InboxIcon, MenuIcon, PencilAltIcon, UserCircleIcon, XIcon, } from '@heroicons/vue/outline'
  
  
    export default {
        components: {
        Dialog,
        DialogOverlay,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        TransitionChild,
        TransitionRoot,
        Link,
        TimeAgo,
        ArchiveIconSolid,
        BellIcon,
        ChevronDownIcon,
        ChevronUpIcon,
        DotsVerticalIcon,
        FolderDownloadIcon,
        MenuIcon,
        PencilIcon,
        ReplyIcon,
        SearchIcon,
        UserAddIcon,
        XIcon,
        },
        setup() {
            const open = ref(false)
        
            return {
                user,
                navigation,
                sidebarNavigation,
                userNavigation,
                messages,
                open,
            }
        },
        data(){
            return {
                current_data_count: 10
            }
        },
        methods: {
            viewNotification(approval_process_id){
                this.$inertia.get(route('view_notification'), {'id' : approval_process_id, 'data_count' : this.current_data_count}, {
                    preserveScroll: true,
                    preserveState: true,
                })
            },
            deleteNotification(notification_id){
                this.$inertia.delete(route('delete_notification', notification_id))
            },
            showAllNotifications(){
                this.$inertia.get(route('notifications'))
            },
            showUnreadNotifications(){
                this.$inertia.get(route('notifications'), {'filter': 'read'}, {
                    preserveScroll: true,
                })
            },
            showReadNotifications(){
                this.$inertia.get(route('notifications'), {'filter': 'unread'}, {
                    preserveScroll: true,
                })
            },
            onScroll ({ target: { scrollTop, clientHeight, scrollHeight }}) {
                if (scrollTop + clientHeight >= scrollHeight) {
                    axios.get(route('show_more_notifications'), { params: { data_count: this.current_data_count += 10}})
                    .then((res) => {
                        this.$page.props.notifications = res.data
                    })
                }
            }
        }
    }
  </script>