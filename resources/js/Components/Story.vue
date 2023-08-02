<template>
    <div class="bg-white border-2 border-gray-200 rounded-xl p-4">
        <!-- Header -->
        <div class="flex items-center gap-3 p-3 border-b md:gap-5 md:p-5">
            <!-- Profile Image -->
            <div class="flex-shrink-0">
                <img class="w-12 h-12 rounded-full" src="https://placehold.co/200x200" alt="" />
            </div>
            <div>
                <!-- Name -->
                <h3 class="text-lg font-bold text-gray-700">Mrs. Nurul Asma Mohamad Rodzi</h3>
                <!-- Class -->
                <h4 class="font-semibold text-gray-400">ANF Centre Class L3-1</h4>
                <!-- Date -->
                <p class="mt-1 text-sm font-medium text-gray-400">Yesterday</p>
            </div>
        </div>

        <!-- Captions -->
        <p class="p-3 font-medium text-gray-700 md:p-5">Ara Saffiya doing rainbow art and crafts activities. It's so much fun!</p>

        <!-- Post Image -->
        <div>
            <img class="object-cover object-center w-full h-96" src="https://images.unsplash.com/photo-1613950190144-4f2a84c75e8c?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1534&q=80" />
        </div>

        <!-- Counters -->
        <div class="flex justify-between px-8 py-5 text-sm text-gray-400">
            <!-- Love Counter -->
            <!-- Click to open Loves Dialog -->
            <button @click="openLovesDialog" type="button" class="flex items-center font-bold hover:text-gray-500">
                <HeartIcon class="w-4 h-4 mr-2" />
                1 Love
            </button>
            <!-- Comments Counter -->
            <!-- Click to toggle visibility of the Comments -->
            <button @click="showComments = !showComments" type="button" class="flex items-center font-bold hover:text-gray-500">
                <AnnotationIcon class="w-4 h-4 mr-2" />
                1 Comment
            </button>
        </div>

        <!-- Loves Dialog -->
        <TransitionRoot appear :show="isOpen" as="template">
            <Dialog as="div" @close="closeLovesDialog">
                <div class="fixed inset-x-0 z-50 inset-y-32 md:inset-y-16">
                    <div class="px-3 text-center">
                        <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0">
                            <DialogOverlay class="fixed inset-0 bg-black opacity-50" />
                        </TransitionChild>

                        <span class="inline-block h-screen" aria-hidden="true"> &#8203; </span>

                        <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95" enter-to="scale-100" leave="duration-50 ease-in" leave-from="scale-100" leave-to="opacity-0 scale-95">
                            <div class="inline-block w-full max-w-md overflow-hidden text-left transition-all transform bg-white shadow-md rounded-xl">
                                <!-- Header -->
                                <DialogTitle as="div" class="relative p-5 text-lg font-bold text-gray-700 border-b">
                                    Loves
                                    <!-- Close Button -->
                                    <button @click="closeLovesDialog" type="button" class="absolute text-gray-400 top-6 right-5">
                                        <XIcon class="w-5 h-5" />
                                    </button>
                                </DialogTitle>
                                <!-- Loved List -->
                                <div class="p-5 space-y-5 overflow-y-auto max-h-96">
                                    <div class="flex items-center">
                                        <!-- Profile Image -->
                                        <img class="w-10 h-10 mr-3 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                                        <!-- Name -->
                                        <div class="font-medium text-gray-700">Mohd Shazwan (Jebat Naufal's Parent)</div>
                                    </div>
                                </div>
                            </div>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Love/Loved Button -->
        <div class="px-5 pb-5 text-gray-400">
            <button @click="isLoved = !isLoved" type="button" class="w-full p-3 border-2 border-b-8 border-gray-200 hover:text-gray-500 hover:bg-gray-100 hover:border-gray-300 rounded-xl">
                <div class="flex items-center justify-center" v-if="!isLoved">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <div class="font-bold">Love</div>
                </div>
                <div class="flex items-center justify-center" v-else>
                    <HeartIcon class="w-5 h-5 mr-2 text-red-600" />
                    <div class="font-bold">Loved!</div>
                </div>
            </button>
        </div>

        <!-- Comments -->
        <div v-show="showComments">
            <!-- Comments List -->
            <div class="p-3 space-y-5 border-t md:p-5 md:space-y-5">
                <div>
                    <!-- Profile Image -->
                    <div class="flex mr-5">
                        <img class="w-10 h-10 mt-1 mr-3 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                        <div>
                            <!-- Name -->
                            <h4 class="font-bold text-gray-700">Mohd Shazwan (Jebat Naufal's Parent)</h4>
                            <!-- Comment -->
                            <p class="font-medium text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                            <!-- Date -->
                            <p class="mt-2 text-sm font-medium text-gray-400">2 days ago</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Write a Comment -->
            <div class="flex p-5 border-t">
                <!-- Profile Image -->
                <img class="w-10 h-10 mr-3 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                <!-- Comment Box -->
                <TextareaAutoResize name="comment" class="mr-3 focus:ring-2 focus:outline-none focus:ring-indigo-400 focus:border-indigo-400 focus:z-10" />
                <!-- Submit Button -->
                <button type="submit" class="items-center px-8 py-2 bg-indigo-700 border-b-8 border-indigo-800 max-h-12 rounded-xl hover:bg-indigo-600">
                    <div class="font-semibold text-white">Send</div>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
// https://www.youtube.com/watch?v=HDiPOkFIP60&ab_channel=Codecourse
// Autosizing the textarea height as the user types
import TextareaAutoResize from './Misc/TextareaAutoResize.vue'
import { ref } from 'vue'
import { TransitionRoot, TransitionChild, Dialog, DialogOverlay, DialogTitle } from '@headlessui/vue'
import { HeartIcon, AnnotationIcon, XIcon } from '@heroicons/vue/solid'

export default {
    name: 'StoryFeeds',
    components: {
        TextareaAutoResize,
        TransitionRoot,
        TransitionChild,
        Dialog,
        DialogOverlay,
        DialogTitle,
        HeartIcon,
        AnnotationIcon,
        XIcon,
    },
    setup() {
        let isOpen = ref(false)
        let showComments = ref(false)
        let isLoved = ref(false)

        return {
            isOpen,
            closeLovesDialog() {
                isOpen.value = false
            },
            openLovesDialog() {
                isOpen.value = true
            },
            showComments,
            isLoved,
        }
    },
}
</script>
