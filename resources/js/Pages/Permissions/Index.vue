<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <Head title="Permissions" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Permissions
            </h2>
        </template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block w-full lg:w-1/2">
                        <div class="flex pb-4 relative text-gray-400 focus-within:text-gray-600">
                            <button class="bg-indigo-700 hover:bg-indigo-900 text-white font-bold py-2 px-4 rounded" @click="addPermission()"> 
                                Add Permission
                            </button>
                            <!-- <SearchIcon class="text-gray-600 h-4 w-4 fill-current pointer-events-none absolute top-1/4 left-3"></SearchIcon>
                            <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:ring-0 focus:border-gray-300 appearance-none  block pl-10"
                                    type="text" v-model="params.search" placeholder="Search"> -->
                        </div>
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/6">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 overflow-y-scroll">
                                    <tr v-if="!$page.props.permissions.length">
                                        <td class="text-center" colspan="10">
                                            <div class="p-3">
                                                No Record Found! 
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr class="hover:bg-gray-200" v-for="(permission, roleID) in $page.props.permissions" :key="roleID">
                                        <td class="px-3 py-3">
                                            <div class="flex items-center">
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ permission.name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-3 text-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" 
                                                  :class="permission.status == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"> {{ permission.status == 1 ? 'Active' : 'Not Active' }} </span>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center">
                                                <div class="pr-1">
                                                    <button class="text-white font-bold py-1 px-1 border rounded bg-yellow-500 hover:bg-yellow-600 border-yellow-600" 
                                                            @click="editRole(permission.id)" 
                                                            title="Edit Role"
                                                    >
                                                        <PencilIcon class="text-white-600 h-4 w-4 fill-current"></PencilIcon>
                                                    </button>
                                                </div>
                                                <div class="">
                                                    <button class="text-white font-bold py-1 px-1 border rounded bg-red-500 hover:bg-red-600 border-red-600" 
                                                            @click="deleteRole(permission.id)" 
                                                            title="Delete Permission"
                                                    >
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
                confirmationTitle="Delete Role"
                confirmationText="Are you sure want to delete this permission?"
                confirmationButton="Delete"
                confirmationMethod="delete"
                confirmationRoute="permissions.destroy"
                :confirmationData="confirmationData"
            >
            </ConfirmationModal>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { SearchIcon, TrashIcon, PencilIcon } from '@heroicons/vue/solid'
import { Head } from '@inertiajs/inertia-vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue'

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon,
        ConfirmationModal, Head
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
        addPermission(){
            this.$inertia.get(route('permissions.create'));
        },
        deleteRole(roleID){
            this.isOpen = true
            this.confirmationData = roleID
        },
        editRole(roleID){
            this.$inertia.get(route('permissions.edit'), {permission: roleID});
        }
    }
}
</script>
