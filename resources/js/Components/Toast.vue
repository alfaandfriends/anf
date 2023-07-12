<style>
    .toast-animate-enter-active {
        transition: all 0.3s ease-out;
    }

    .toast-animate-leave-active {
        transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
    }

    .toast-animate-enter-from,
    .toast-animate-leave-to {
        transform: translateX(20px);
        opacity: 0;
    }
</style>
<template>
    <div>
        <!-- success message -->
        <Transition name="toast-animate">
            <template v-if="toastData.type == 'success' && visible">
                <div class="top-10 fixed right-10 z-40 flex items-center justify-between max-w-sm p-4 bg-white border rounded-md shadow-sm shadow-green-600 cursor-pointer" @click="closeToast">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                        </svg>
                        <p class="ml-3 text-sm font-bold text-green-600">{{ toastData.message }}</p>
                    </div>
                    <span class="inline-flex items-center cursor-pointer ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                </div>
            </template>
        </Transition>

        <!-- info message -->
        <Transition name="toast-animate">
            <template v-if="toastData.type == 'info' && visible">
                <div class="top-10 fixed right-10 z-40 flex items-center justify-between max-w-sm p-4 bg-white border rounded-md shadow-sm shadow-blue-600 cursor-pointer" @click="closeToast">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                        </svg>
                        <p class="ml-3 text-sm font-bold text-blue-600">{{ toastData.message }}</p>
                    </div>
                    <span class="inline-flex items-center cursor-pointer ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                </div>
            </template>
            <!-- info message -->
        </Transition>

        <!-- warning message -->
        <Transition name="toast-animate">
            <template v-if="toastData.type == 'warning' && visible">
                <div class="top-10 fixed right-10 z-40 flex items-center justify-between max-w-sm p-4 bg-white border rounded-md shadow-sm shadow-yellow-500 cursor-pointer" @click="closeToast">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="ml-3 text-sm font-bold text-yellow-500">{{ toastData.message }}</p>
                    </div>
                    <span class="inline-flex items-center cursor-pointer ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                </div>
            </template>
        </Transition>

        <!-- error message -->
        <Transition name="toast-animate">
            <template v-if="toastData.type == 'error' && visible">
                <div class="top-10 fixed right-10 z-40 flex items-center justify-between max-w-sm p-4 bg-white border rounded-md shadow-sm shadow-red-600 cursor-pointer" @click="closeToast">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                        </svg>
                        <p class="ml-3 text-sm font-bold text-red-600">{{ toastData.message }}</p>
                    </div>
                    <span class="inline-flex items-center cursor-pointer ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                </div>
            </template>
        </Transition>
    </div>
</template>

<script>

export default {
    props:{
        toastData: Object,
    },
    data(){
        return{
            visible: false,
            timeout: null
        }
    },
    mounted(){
        if(this.timeout){
            clearTimeout(this.timeout);
        }
        this.timeout = setTimeout(() => this.visible = false, 10000);
    },
    watch:{
        toastData:{
            immediate: true,
            deep: true,
            handler(){
                this.visible = true
                if(this.timeout){
                    clearTimeout(this.timeout);
                }
                this.timeout = setTimeout(() => this.visible = false, 10000);
            }
        }
    },
    methods: {
        closeToast(){
            this.visible = false
        }
    }
}
</script>
