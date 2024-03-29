<template>
    <TransitionRoot :show="open">
        <Dialog as="div" class="fixed z-40 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10" v-if="level == 'info'">
                                    <InformationCircleIcon class="h-6 w-6 text-blue-600" aria-hidden="true"/>
                                </div>
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10" v-if="level == 'danger'">
                                    <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true"/>
                                </div>
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10" v-if="level == 'warning'">
                                    <ExclamationCircleIcon class="h-6 w-6 text-yellow-600" aria-hidden="true"/>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> {{ title }} </DialogTitle>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">{{ message }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed" :class="buttonClass" @click="emit('toggle:alert', false, true)">
                                OK
                            </button>
                            <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-offset-2 focus:ring-0 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed" @click="emit('toggle:alert', false, false)">Cancel</button>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia'
import { Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationIcon, InformationCircleIcon, ExclamationCircleIcon } from '@heroicons/vue/outline'
import { ref, watch } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    level: {
        type: String,
        required: true,
    },
    message: {
        type: String,
        required: true,
    },
    open: {
        type: Boolean,
        required: true,
    }
});

const buttonClass = ref();

watch(() => props.level, (newValue) => {
    if(newValue === 'info'){
        buttonClass.value = 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500'
    }
    if(newValue === 'warning'){
        buttonClass.value = 'bg-yellow-400 hover:bg-yellow-500 focus:ring-yellow-200'
    }
    if(newValue === 'danger'){
        buttonClass.value = 'bg-red-600 hover:bg-red-700 focus:ring-red-500'
    }
});

const emit = defineEmits(['toggle:alert']);
</script>
