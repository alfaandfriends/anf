<template>
<TransitionRoot appear :show="isOpen" as="template">
    <Dialog as="div" @close="closeModal" class="relative z-50" static="true">
    <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
    >
        <div class="fixed inset-0 bg-black/40" />
    </TransitionChild>

    <div class="fixed inset-0 overflow-y-auto mt-44">
        <div
        class="flex min-h-full items-center justify-center p-4 text-center"
        >
        <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
        >
            <div class="fixed inset-0 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
            <DialogPanel
                class="w-full max-w-3xl transform rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all z-10 min-h-80"
            >
                <DialogTitle as="div" v-if="$slots.header">
                    <div class="flex items-center justify-between mb-2 rounded-t text-lg font-semibold text-slate-800 dark:text-white">
                        <slot name="header"></slot>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal"  @click="closeModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                            </svg>
                        </button>
                    </div>
                    <hr class="mb-3">
                </DialogTitle>
                <slot></slot>
                <!-- <div class="mt-4">
                    <button
                        type="button"
                        class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                        @click="closeModal"
                    >
                        Got it, thanks!
                    </button>
                </div> -->
            </DialogPanel>
        </div>
    </div>
        </TransitionChild>
        </div>
    </div>
    </Dialog>
</TransitionRoot>
</template>
  
<script setup>
import { ref } from 'vue'
</script>

<script>
import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle } from '@headlessui/vue'

export default {
    components: {
        TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle,
    },
    props: {
        isOpen: Boolean
    },
    methods: {
        closeModal() {
            this.$emit('close', false);
        }
    }
}
</script>
  