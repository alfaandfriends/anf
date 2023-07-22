<template>
    <!-- Mobile -->
    <div class="flex justify-center md:hidden">
        <button class="relative">
            <!-- Profile Image -->
            <img class="w-16 h-16 mr-3 rounded-full shadow-md" src="https://images.unsplash.com/photo-1603545723222-704768ce6193?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=472&q=80" />
            <!-- New Notification Alert -->
            <div class="absolute top-0 w-4 h-4 bg-green-300 rounded-full right-3 animate-ping" />
            <div class="absolute top-0 w-4 h-4 bg-green-500 rounded-full right-3" />
        </button>

        <!-- Add a Child Button -->
        <button class="w-16 h-16 text-gray-700 border-2 border-gray-300 border-dashed rounded-full">
            <PlusIcon class="mx-auto text-gray-400 w-7 h-7" />
        </button>
    </div>

    <!-- Desktop and Tablet -->
    <div class="hidden md:inline">
        <!-- Child List -->
        <div class="bg-white border-2 border-gray-200 rounded-xl">
            <button type="button" class="relative flex items-center w-full p-3 border-b hover:bg-indigo-50">
                <!-- Profile Image -->
                <img class="w-12 h-12 mr-3 rounded-full" src="https://images.unsplash.com/photo-1603545723222-704768ce6193?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=472&q=80" />
                <!-- Name -->
                <div class="text-lg font-bold text-gray-700">Jebat Naufal</div>
                <!-- New Notification Alert -->
                <div class="absolute w-4 h-4 bg-green-300 rounded-full right-6 animate-ping" />
                <div class="absolute w-4 h-4 bg-green-500 rounded-full right-6" />
            </button>
            <button type="button" class="flex items-center w-full p-3 hover:bg-indigo-50">
                <img class="w-12 h-12 mr-3 rounded-full" src="https://images.unsplash.com/photo-1532679839948-7ebc758d26b0?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=535&q=80" alt="" />
                <div class="text-lg font-bold text-gray-700">Ara Saffiya</div>
            </button>
        </div>

        <!-- Add a Child Button -->
        <div class="mt-3 bg-indigo-700 border-b-8 border-indigo-800 rounded-xl hover:bg-indigo-600">
            <button type="button" class="flex items-center justify-center w-full p-3 font-semibold text-white">Add a child</button>
        </div>
    </div>
</template>

<script>
import { PlusIcon } from '@heroicons/vue/solid'

export default {
    name: 'ChildList',
    components: {
        PlusIcon,
    },
}
</script>
