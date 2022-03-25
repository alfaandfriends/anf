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
                    <div class="align-top inline-block w-full lg:w-1/2 px-2 mb-3">
                        <div class="flex pb-4 relative text-gray-400 focus-within:text-gray-600">
                            <Link :href="route('menus.add_menu')" as="button" class="bg-indigo-700 hover:bg-indigo-900 text-white font-bold py-2 px-4 rounded">
                                Add Menu
                            </Link>
                        </div>
                        <div class="shadow overflow-hidden overflow-x-auto hover:no-scrollbar border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 w-full    ">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">#</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/6">Menu Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/6">Route Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Status</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/6">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 overflow-y-scroll">
                                    <tr v-if="$page.props.menus.length == 0">
                                        <td class="text-center" colspan="10">
                                            <div class="p-3">
                                                No Record Found! 
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr class="hover:bg-gray-200" v-for="(menu, menuID) in $page.props.menus" :key="menuID">
                                        <td class="px-6 py-2 whitespace-nowrap text-sm">{{ ++menuID }}</td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ menu.menu_label }}</div>
                                            </div>
                                            </div>
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900" :class="menu.menu_route ? '' : 'font-extrabold font-black'">{{ menu.menu_route ? menu.menu_route : 'None' }}</div>
                                            </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="menu.menu_status == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"> {{ menu.menu_status == 1 ? 'Active' : 'Not Active'}} </span>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex">
                                                <div class="pr-1">
                                                    <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-1 border border-yellow-700 rounded" @click="editMenu(menu.id)" title="Edit">
                                                        <PencilIcon class="text-white-600 h-4 w-4 fill-current"></PencilIcon>
                                                    </button>
                                                </div>
                                                <div class="pr-1">
                                                    <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-1 border border-red-700 rounded" @click="deleteMenu(menu.id)" title="Delete">
                                                        <TrashIcon class="text-white-600 h-4 w-4 fill-current"></TrashIcon>
                                                    </button>
                                                </div>
                                                <div class="pr-1">
                                                    <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-1 border border-blue-700 rounded" @click="showSubMenu(menu.id)" title="View Sub Menu">
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
                    <div class="align-top inline-block w-full lg:w-1/2 px-2" v-show="show_sub_menu">
                        <div class="flex pb-4 relative text-gray-400 focus-within:text-gray-600 lg:justify-end">
                            
                            <Link @click="addSubMenu(menu_id)" class="bg-indigo-700 hover:bg-indigo-900 text-white font-bold py-2 px-4 rounded" as="button">
                                Add Sub Menu
                            </Link>
                            <!-- <SearchIcon class="text-gray-600 h-4 w-4 fill-current pointer-events-none absolute top-1/4 left-3"></SearchIcon>
                            <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:ring-0 focus:border-gray-300 appearance-none  block pl-10"
                                    type="text" v-model="params.search" placeholder="Search"> -->
                        </div>
                        <div class="shadow overflow-hidden overflow-x-auto hover:no-scrollbar border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 w-full">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">#</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/6">Sub Menu Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/6">Route Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/6">Status</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 overflow-y-scroll">
                                    <tr v-if="$page.props.sub_menus.length == 0">
                                        <td class="text-center" colspan="10">
                                            <div class="p-3">
                                                No Record Found! 
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr class="hover:bg-gray-200" v-for="(sub_menu, menuID) in $page.props.sub_menus" :key="menuID">
                                        <td class="px-6 py-2 whitespace-nowrap text-sm">{{ ++menuID }}</td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ sub_menu.menu_sub_label }}</div>
                                            </div>
                                            </div>
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900" :class="sub_menu.menu_sub_route ? '' : 'font-extrabold'">{{ sub_menu.menu_sub_route ? sub_menu.menu_sub_route : 'None' }}</div>
                                            </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" 
                                                  :class="sub_menu.menu_sub_status == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"> {{ sub_menu.menu_sub_status == 1 ? 'Active' : 'Not Active' }} </span>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex">
                                                <div class="pr-1">
                                                    <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-1 border border-yellow-700 rounded" @click="editSubMenu(sub_menu.id)" title="Delete">
                                                        <PencilIcon class="text-white-600 h-4 w-4 fill-current"></PencilIcon>
                                                    </button>
                                                </div>
                                                <div class="pr-1">
                                                    <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-1 border border-red-700 rounded" @click="deleteSubMenu(sub_menu.id)" title="Delete">
                                                        <TrashIcon class="text-white-600 h-4 w-4 fill-current"></TrashIcon>
                                                    </button>
                                                </div>
                                            </div>
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
                :confirmationRoute="confirmationRoute"
                :confirmationData="confirmationData"
            >
            </ConfirmationModal>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { SearchIcon, TrashIcon, PencilIcon, ChevronRightIcon } from '@heroicons/vue/solid'
import { Head, Link } from '@inertiajs/inertia-vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue'

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon, ChevronRightIcon,
        ConfirmationModal, Head, Link
    },
    props: {
        show_sub_menu: Boolean,
        menu_id: String,
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
        showSubMenu(menu_id){
            this.$inertia.get(route('menus'), {menu_id: menu_id})
        },
        addSubMenu(menu_id){
            this.$inertia.get(route('menus.add_sub_menu'), {menu_id: menu_id})
        },
        editMenu(menu_id){
            this.$inertia.get(route('menus.edit_menu'), {menu_id: menu_id})
        },
        editSubMenu(menu_id){
            this.$inertia.get(route('menus.edit_sub_menu'), {menu_id: menu_id})
        },
        deleteMenu(menu_id){
            this.confirmationRoute = 'menus.destroy_menu'
            this.confirmationData = menu_id
            this.isOpen = true
        },
        deleteSubMenu(menu_id){
            this.confirmationRoute = 'menus.destroy_sub_menu'
            this.confirmationData = menu_id
            this.isOpen = true
        },
    },
}
</script>
