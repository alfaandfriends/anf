<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <Head title="Menus" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Menus
            </h2>
        </template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-top inline-block w-full lg:w-1/2 px-2">
                        <div class="flex pb-4 relative text-gray-400 focus-within:text-gray-600">
                            <a :href="route('menus.add_menu')" as="button" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded">
                                Add Menu
                            </a>
                        </div>
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 w-full    ">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">#</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/6">Menu Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/6">Menu Type</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Status</th>
                                        <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th> -->
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/6">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 overflow-y-scroll">
                                    <tr v-if="$page.props.parent_menus.length == 0">
                                        <td class="text-center" colspan="10">
                                            <div class="p-3">
                                                No Record Found! 
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr class="hover:bg-gray-200" v-for="(parent_menu, menuID) in $page.props.parent_menus" :key="menuID">
                                        <td class="px-6 py-2 whitespace-nowrap text-sm">{{ ++menuID }}</td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ parent_menu.menu_label }}</div>
                                            </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap text-sm">{{ parent_menu.menu_parent == null ? 'Parent' : 'Child'}}</td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"> {{ parent_menu.status == 'Y' ? 'Active' : 'Not Active'}} </span>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex">
                                                <div class="pr-1">
                                                    <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-1 border border-red-700 rounded" @click="deleteUser(roleID)" title="Delete">
                                                        <TrashIcon class="text-white-600 h-4 w-4 fill-current"></TrashIcon>
                                                    </button>
                                                </div>
                                                <div class="pr-1">
                                                    <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-1 border border-yellow-700 rounded" @click="deleteUser(roleID)" title="Edit">
                                                        <PencilIcon class="text-white-600 h-4 w-4 fill-current"></PencilIcon>
                                                    </button>
                                                </div>
                                                <div class="pr-1">
                                                    <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-1 border border-blue-700 rounded" @click="showSubMenu(parent_menu.id)" title="View Sub Menu">
                                                        <ChevronRightIcon class="text-white-600 h-4 w-4 fill-current"></ChevronRightIcon>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="align-top inline-block w-full lg:w-1/2 px-2" v-show="show_child_menu">
                        <div class="flex pb-4 relative text-gray-400 justify-end focus-within:text-gray-600">
                            <a :href="route('roles.create')" as="button" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded">
                                Add Sub Menu
                            </a>
                            <!-- <SearchIcon class="text-gray-600 h-4 w-4 fill-current pointer-events-none absolute top-1/4 left-3"></SearchIcon>
                            <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:ring-0 focus:border-gray-300 appearance-none  block pl-10"
                                    type="text" v-model="params.search" placeholder="Search"> -->
                        </div>
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 w-full">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">#</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/6">Menu Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/6">Menu Type</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/6">Status</th>
                                        <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th> -->
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 overflow-y-scroll">
                                    <tr v-if="$page.props.child_menus.length == 0">
                                        <td class="text-center" colspan="10">
                                            <div class="p-3">
                                                No Record Found! 
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr class="hover:bg-gray-200" v-for="(child_menu, menuID) in $page.props.child_menus" :key="menuID">
                                        <td class="px-6 py-2 whitespace-nowrap text-sm">{{ ++menuID }}</td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ child_menu.menu_label }}</div>
                                            </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap text-sm">{{ child_menu.menu_parent == null ? 'Parent' : 'Child'}}</td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" 
                                                  :class="child_menu.status == 'Y' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"> {{ child_menu.status == 'Y' ? 'Active' : 'Not Active' }} </span>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap text-center text-sm font-medium">
                                            <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-1 border border-red-700 rounded" @click="deleteUser(roleID)" title="Delete">
                                                <TrashIcon class="text-white-600 h-4 w-4 fill-current"></TrashIcon>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <ConfirmationModal 
                :show="isOpen" 
                @close="isOpen = !isOpen"
                confirmationAlert="danger"
                confirmationTitle="Delete Menu"
                confirmationText="Are you sure want to delete this menu?"
                confirmationButton="Delete"
                confirmationMethod="delete"
                confirmationRoute="roles.destroy"
                :confirmationData="confirmationData"
            >
            </ConfirmationModal>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { SearchIcon, TrashIcon, PencilIcon, ChevronRightIcon } from '@heroicons/vue/solid'
import { Head } from '@inertiajs/inertia-vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import { watch } from '@vue/runtime-core';

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon, ChevronRightIcon,
        ConfirmationModal, Head
    },
    props: {
        child_menus: Object,
        show_child_menu: Boolean
    },
    data(){
        return{
            isOpen: false,
            confirmationTitle: '',
            confirmationText: '',
            confirmationAlert: '',
            confirmationButton: '',
            confirmationMethod: '',
            confirmationRoute: '',
            confirmationData: '',
        }
    },
    methods: {
        deleteUser(roleID){
            this.isOpen = true
            this.confirmationData = roleID
        },
        showSubMenu(menuID){
            this.$inertia.get('/menus', {parent_id: menuID},
            {
            })
        },
    },
}
</script>
