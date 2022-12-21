<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
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
                                <div class="h-full relative flex flex-col w-96 border-r border-gray-200 bg-gray-100">
                                    <div class="flex-shrink-0">
                                        <div class="h-16 px-6 flex flex-col justify-center bg-indigo-200">
                                        <div class="flex items-baseline space-x-3">
                                            <h2 class="text-lg font-medium text-gray-900">Notifications</h2>
                                        </div>
                                        </div>
                                        <div class="flex flex-row space-x-2 border-t border-b border-gray-200 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-500">
                                            <BreezeButton buttonType="blue" class="bg-blue-400">All</BreezeButton>
                                            <BreezeButton buttonType="blue" class="bg-blue-400">Unread</BreezeButton>
                                            <BreezeButton buttonType="blue">Read</BreezeButton>
                                        </div>
                                    </div>
                                    <div class="h-[70vh] bg-indigo-100">
                                        <div aria-label="Message list" class="h-full overflow-y-auto">
                                            <ul role="list" class="border-b border-gray-200 divide-y divide-gray-200">
                                            <li v-for="message in messages" :key="message.id" :class="message.active ? 'bg-gray-200' : ''" class="relative bg-white py-5 px-6 hover:bg-gray-50">
                                                <div class="flex justify-between space-x-3">
                                                <div class="min-w-0 flex-1">
                                                    <a :href="message.href" class="block focus:outline-none">
                                                    <span class="absolute inset-0" aria-hidden="true" />
                                                    <p class="text-sm font-medium text-gray-900 truncate">{{ message.sender }}</p>
                                                    <p class="text-sm text-gray-500 truncate">{{ message.subject }}</p>
                                                    </a>
                                                </div>
                                                <time :datetime="message.datetime" class="flex-shrink-0 whitespace-nowrap text-sm text-gray-500">{{ message.date }}</time>
                                                </div>
                                                <div class="mt-1">
                                                <p class="line-clamp-2 text-sm text-gray-600">
                                                    {{ message.preview }}
                                                </p>
                                                </div>
                                            </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Main area -->
                                <div class="flex flex-1 flex-col">
                                    <div class="flex h-16 items-center justify-end bg-indigo-200">
                                        <div class="px-4 sm:px-6 lg:px-8">
                                            <div class="flex justify-end">
                                                <button type="button" class="-ml-px relative items-center px-4 py-2 shadow-md rounded-md text-sm font-medium bg-red-500 hover:bg-red-600 text-white focus:outline-none focus:ring-0">
                                                    <span>Delete</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col">
                                        <div class="flex justify-center">
                                            <div class="align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform m-4 w-full p-6">
                                                <div class="text-center">
                                                    <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> ANFC Setia Tropika </DialogTitle>
                                                    <div class="pt-2">
                                                        <a target="_blank" :href="route('centres.edit', {'centre_id': 13})" class="rounded shadow-md px-2 py-1 bg-indigo-500 text-[13px] text-white">View centre</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex justify-center">
                                            <div class="flex-col w-full px-4 pb-4 space-y-2 overflow-y-auto h-[61vh] no-scrollbar">
                                                <div class="bg-white rounded-lg shadow-xl p-4">
                                                    <div class="pb-2">
                                                        <div class="md:grid md:grid-cols-2">
                                                            <div class="md:mt-0 md:col-span-2">
                                                                <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                                                    <div class="sm:row-span-3">
                                                                        <div class="mb-5 border-b-indigo-500 border-b border-dashed">
                                                                            <h2 class="font-display font-bold text-indigo-600">Centre Details</h2>
                                                                        </div>
                                                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                                                            <div class="mb-4">
                                                                                <label for="first_name" class="block text-sm text-gray-700 font-bold"> Name <span class="text-red-500">*</span></label>
                                                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                                                    <input type="text" name="first_name" id="first_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.name ? 'border-red-300' : 'border-gray-300'" autocomplete="off"/>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                                                            <div class="mb-4">
                                                                                <label for="first_name" class="block text-sm text-gray-700 font-bold"> Contact Number <span class="text-red-500">*</span></label>
                                                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                                                    <input type="text" name="first_name" id="first_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.name ? 'border-red-300' : 'border-gray-300'" autocomplete="off"/>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-4">
                                                                                <label for="first_name" class="block text-sm text-gray-700 font-bold"> Email <span class="text-red-500">*</span></label>
                                                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                                                    <input type="text" name="first_name" id="first_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.name ? 'border-red-300' : 'border-gray-300'" autocomplete="off"/>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                                                            <div class="mb-4">
                                                                                <label for="first_name" class="block text-sm text-gray-700 font-bold"> Address <span class="text-red-500">*</span></label>
                                                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                                                    <textarea name="first_name" id="first_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.name ? 'border-red-300' : 'border-gray-300'" autocomplete="off"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-white rounded-lg shadow-xl p-4">
                                                    <div class="pb-2">
                                                        <div class="md:grid md:grid-cols-2">
                                                            <div class="md:mt-0 md:col-span-2">
                                                                <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                                                    <div class="sm:row-span-3">
                                                                        <div class="mb-5 border-b-indigo-500 border-b border-dashed">
                                                                            <h2 class="font-display font-bold text-indigo-600">Principal Details</h2>
                                                                        </div>
                                                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                                                            <div class="mb-4">
                                                                                <label for="first_name" class="block text-sm text-gray-700 font-bold"> Name <span class="text-red-500">*</span></label>
                                                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                                                    <input type="text" name="first_name" id="first_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.name ? 'border-red-300' : 'border-gray-300'" autocomplete="off"/>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-4">
                                                                                <label for="first_name" class="block text-sm text-gray-700 font-bold"> Name <span class="text-red-500">*</span></label>
                                                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                                                    <input type="text" name="first_name" id="first_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.name ? 'border-red-300' : 'border-gray-300'" autocomplete="off"/>
                                                                                </div>
                                                                            </div>
                                                                        </div>  
                                                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                                                            <div class="mb-4">
                                                                                <label for="first_name" class="block text-sm text-gray-700 font-bold"> Name <span class="text-red-500">*</span></label>
                                                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                                                    <input type="text" name="first_name" id="first_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.name ? 'border-red-300' : 'border-gray-300'" autocomplete="off"/>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-4">
                                                                                <label for="first_name" class="block text-sm text-gray-700 font-bold"> Name <span class="text-red-500">*</span></label>
                                                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                                                    <input type="text" name="first_name" id="first_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.name ? 'border-red-300' : 'border-gray-300'" autocomplete="off"/>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-white rounded-lg shadow-xl p-4">
                                                    <div class="pb-2">
                                                        <div class="md:grid md:grid-cols-2">
                                                            <div class="md:mt-0 md:col-span-2">
                                                                <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                                                    <div class="sm:row-span-3">
                                                                        <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                                                                            <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:col-start-2 sm:text-sm" @click="open = false">Approve</button>
                                                                            <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:col-start-1 sm:text-sm" @click="open = false" ref="cancelButtonRef">Reject</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
    import { Dialog, DialogOverlay, Menu, MenuButton, MenuItem, MenuItems, TransitionChild, TransitionRoot, } from '@headlessui/vue'
    import { ArchiveIcon as ArchiveIconSolid, ChevronDownIcon, ChevronUpIcon, DotsVerticalIcon, FolderDownloadIcon, PencilIcon, ReplyIcon, SearchIcon, UserAddIcon, } from '@heroicons/vue/solid'
    import { ArchiveIcon as ArchiveIconOutline, BanIcon, BellIcon, FlagIcon, InboxIcon, MenuIcon, PencilAltIcon, UserCircleIcon, XIcon, } from '@heroicons/vue/outline'
  
    const messages = [
        {
        id: 1,
        active: true,
        subject: '',
        sender: 'Nur Ezzati',
        href: '#',
        date: '1d ago',
        datetime: '2021-01-27T16:35',
        preview:
            'Waiting for your approval on ANFC Setia Tropika update.',
        },
        {
        id: 2,
        active: false,
        subject: '',
        sender: 'Mohd Shazwan',
        href: '#',
        date: '1d ago',
        datetime: '2021-01-27T16:35',
        preview:
            'Waiting for your approval on ANFC Bukit Jalil deletion.',
        },
        {
        id: 3,
        active: false,
        subject: '',
        sender: 'Mohd Shazwan',
        href: '#',
        date: '1d ago',
        datetime: '2021-01-27T16:35',
        preview:
            'Waiting for your approval on ANFC Bukit Puchong update.',
        },
        {
        id: 4,
        active: false,
        subject: '',
        sender: 'Mohd Shazwan',
        href: '#',
        date: '1d ago',
        datetime: '2021-01-27T16:35',
        preview:
            'Waiting for your approval on ANFC Palembang deletion.',
        },
    ]
  
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
    created(){
        
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
  }
  </script>