<template>
    <!-- Notification Button -->
    <div class="relative">
        <button @click="open = true" class="mt-1.5 mr-5">
            <BellIcon class="w-7 h-7 md:w-6 md:h-6" aria-hidden="true" />
            <!-- New Notification Alert -->
            <div class="absolute w-3 h-3 bg-red-500 rounded-full top-1 right-4 animate-ping"></div>
            <div class="absolute w-3 h-3 bg-red-700 rounded-full top-1 right-4"></div>
        </button>
    </div>

    <TransitionRoot as="template" :show="open" class="z-50">
        <Dialog as="div" class="fixed inset-0 overflow-hidden" @close="open = false">
            <div class="absolute inset-0 overflow-hidden">
                <TransitionChild as="template" enter="ease-in-out duration-500" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-500" leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="absolute inset-0 transition-opacity bg-black bg-opacity-50" />
                </TransitionChild>

                <div class="fixed inset-y-0 right-0 flex max-w-full">
                    <TransitionChild
                        as="template"
                        enter="transform transition ease-in-out duration-500 sm:duration-700"
                        enter-from="translate-x-full"
                        enter-to="translate-x-0"
                        leave="transform transition ease-in-out duration-500 sm:duration-700"
                        leave-from="translate-x-0"
                        leave-to="translate-x-full"
                    >
                        <div class="w-screen max-w-md">
                            <div class="flex flex-col h-full overflow-y-scroll bg-white shadow-md">
                                <div class="flex-1 py-5 overflow-y-auto">
                                    <!-- Header -->
                                    <div class="flex items-start justify-between px-5">
                                        <DialogTitle class="text-lg font-bold text-gray-700">Notifications</DialogTitle>
                                        <div class="flex items-center">
                                            <button type="button" class="mt-1 text-gray-400 hover:text-gray-500" @click="open = false">
                                                <XIcon class="w-5 h-5" aria-hidden="true" />
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-10 md:mt-8">
                                        <div class="flow-root">
                                            <ul role="list" class="-my-6 divide-y divide-gray-200">
                                                <!-- Notifications List -->
                                                <li v-for="notification in notifications" :key="notification.id">
                                                    <!-- Link -->
                                                    <a :href="notification.href" class="flex items-center h-auto p-5 cursor-pointer hover:bg-indigo-50">
                                                        <!-- Image -->
                                                        <div class="w-12 h-12 overflow-hidden rounded-full">
                                                            <img :src="notification.imageSrc" />
                                                        </div>
                                                        <div class="flex flex-col flex-1 ml-4">
                                                            <div class="flex justify-between font-medium text-left text-gray-700">
                                                                <!-- Title -->
                                                                <h3>
                                                                    {{ notification.title }}
                                                                </h3>
                                                                <!-- New Notification Alert -->
                                                                <p v-show="notification.new" class="flex-shrink-0 w-3 h-3 my-auto ml-2 bg-red-700 rounded-full"></p>
                                                            </div>
                                                            <!-- Date -->
                                                            <p class="mt-2 text-sm font-medium text-left text-gray-400">
                                                                {{ notification.date }}
                                                            </p>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import { ref } from 'vue'
import { Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { XIcon, BellIcon } from '@heroicons/vue/solid'

const notifications = [
    {
        id: 1,
        new: true,
        title: 'Start the school year strong with Plus!',
        href: 'https://www.google.com',
        date: 'A week ago',
        imageSrc: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
        id: 2,
        new: true,
        title: 'Start the school year strong with Plus. Learn the fun and simple way!',
        href: '#',
        date: 'A week ago',
        imageSrc: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
]

export default {
    name: 'Notification',
    components: {
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        XIcon,
        BellIcon,
    },
    setup() {
        const open = ref(false)

        return {
            notifications,
            open,
        }
    },
}
</script>
