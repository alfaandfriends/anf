<template>
    <!-- Menu Position Top (Desktop and Tablet) -->
    <!-- Menu Position Bottom (Mobile) -->
    <nav class="fixed inset-x-0 bottom-0 z-10 text-gray-700 bg-white md:border-gray-200 md:border-b-2 md:top-16 md:sticky">
        <div class="flex items-center justify-center max-w-4xl px-3 md:justify-between mx-auto">
            <div class="flex space-x-0 md:space-x-4">
                <Link :href="route('parent.home')" :class="(route().current('parent.home')) ? 'text-gray-800' : ''" class="flex px-3 py-3 text-gray-500 hover:text-gray-800 cursor-pointer">
                    <span class="text-sm font-semibold md:text-base">Home</span>
                </Link>
                <Link :href="route('parent.invoices.index')" :class="(route().current('parent.invoices.index')) ? 'text-gray-800' : ''" class="flex px-3 py-3 text-gray-500 hover:text-gray-800 cursor-pointer">
                    <span class="text-sm font-semibold md:text-base">Fee Invoices</span>
                </Link>
                <Link :href="route('parent.art-gallery.index')" :class="(route().current('parent.art-gallery.index')) ? 'text-gray-800' : ''" class="flex px-3 py-3 text-gray-500 hover:text-gray-800 cursor-pointer">
                    <span class="text-sm font-semibold md:text-base">Art Gallery</span>
                </Link>
                <div class="relative group flex px-3 py-3 text-gray-500 hover:text-gray-800 cursor-pointer">
                    <button class="text-sm font-semibold md:text-base text-gray-500 hover:text-gray-800" id="moreButton">
                        More
                        <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="z-30 hidden flex-col absolute border border-gray-200 py-2 px-4 bg-white h-fit w-64 text-slate-600 bottom-10 md:-bottom-0 right-2 md:top-10 md:left-0 rounded-lg shadow-xl group-hover:block">
                        <!-- Additional menu items here -->
                        <a href="#" class="text-sm font-semibold md:text-base block py-2 px-3 text-gray-500 hover:text-gray-800">Story Book</a>
                        <a href="#" class="text-sm font-semibold md:text-base block py-2 px-3 text-gray-500 hover:text-gray-800">Notice</a>
                        <!-- Add more menu items as needed -->
                    </div>
                </div>
            </div>
            <!-- <div class="hidden md:flex">
                <div class="relative group flex px-3 py-3 text-gray-500 hover:text-gray-800 cursor-pointer">
                    <button class="flex items-center space-x-2 text-sm font-semibold md:text-base text-slate-600" id="moreButton">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 512 512">
                            <path d="M0 224c0 17.7 14.3 32 32 32s32-14.3 32-32c0-53 43-96 96-96H320v32c0 12.9 7.8 24.6 19.8 29.6s25.7 2.2 34.9-6.9l64-64c12.5-12.5 12.5-32.8 0-45.3l-64-64c-9.2-9.2-22.9-11.9-34.9-6.9S320 19.1 320 32V64H160C71.6 64 0 135.6 0 224zm512 64c0-17.7-14.3-32-32-32s-32 14.3-32 32c0 53-43 96-96 96H192V352c0-12.9-7.8-24.6-19.8-29.6s-25.7-2.2-34.9 6.9l-64 64c-12.5 12.5-12.5 32.8 0 45.3l64 64c9.2 9.2 22.9 11.9 34.9 6.9s19.8-16.6 19.8-29.6V448H352c88.4 0 160-71.6 160-160z"/>
                        </svg>
                        <span class="text-sm">Switch Child</span>
                    </button>
                    <div class="z-30 hidden flex-col absolute border border-gray-200 py-2 px-4 bg-white h-fit min-w-[20rem] text-slate-600 bottom-10 md:-bottom-0 right-2 md:top-10 md:right-0 rounded-lg shadow-xl group-hover:block">
                        <div class="px-3 pt-2 text-sm font-bold">Child List</div>
                        <hr class="my-3">
                        <button href="#" class="flex w-full items-center space-x-4 text-sm font-semibold md:text-base py-2 px-3 text-gray-500 hover:text-gray-800" v-if="$page.props.user_has_children.length" v-for="info in $page.props.user_has_children" @click="switchChild(info.child_id, info.student_id)">
                            <span class="text-left">{{ info.name }}</span>
                            <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded" v-if="!switching && info.child_id == $page.props.current_active_child.child_id">Currently View</span>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded" v-if="switching && info.child_id == $page.props.current_active_child.child_id">Switching</span>
                        </button>
                        <div class="flex justify-between items-center w-full py-4 px-10 border-b" v-else>
                            <span class="text-gray-400">No children added</span>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'

</script>

<script>
export default {
    // data(){
    //     return{
    //         switching: false
    //     }
    // },
    // methods: {
    //     switchChild(child_id, student_id){
    //         if(this.switching){
    //             return
    //         }
    //         this.switching = true
    //         axios.post(route('parent.switch_child', {child_id: child_id, student_id: student_id}))
    //         .then(response => {
    //             if(response.data){
    //                 location.reload()
    //             }
    //         });
    //     }
    // }
}
</script>

<style scoped>
ion-icon {
    font-size: 24px;
}
</style>
