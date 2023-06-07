<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Roles" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block w-full lg:w-1/2 px-2">
                        <div class="flex pb-4 relative text-gray-400 focus-within:text-gray-600">
                            <BreezeButton @click="addRole()"> 
                                Add Role
                            </BreezeButton>
                            <!-- <SearchIcon class="text-gray-600 h-4 w-4 fill-current pointer-events-none absolute top-1/4 left-3"></SearchIcon>
                            <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg focus:ring-0 focus:border-gray-300 appearance-none  block pl-10"
                                    type="text" v-model="params.search" placeholder="Search"> -->
                        </div>
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-300">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Group</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 overflow-y-scroll">
                                    <tr v-if="!$page.props.roles.length">
                                        <td class="text-center" colspan="10">
                                            <div class="p-3">
                                                No Record Found! 
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr class="hover:bg-gray-200" v-for="(role, roleID) in $page.props.roles" :key="roleID">
                                        <td class="px-2 py-3">
                                            <div class="flex items-center">
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ role.display_name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-2 py-3">
                                            <div class="flex items-center">
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ role.role_group_name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-2 py-3 text-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" 
                                                  :class="role.status == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"> {{ role.status == 1 ? 'Active' : 'Not Active' }} </span>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center space-x-2">
                                                <BreezeButton buttonType="warning" @click="editRole(role.id)" title="Edit Role" > Edit </BreezeButton>
                                                <BreezeButton buttonType="danger" @click="deleteRole(role.id)" title="Delete"> Delete </BreezeButton>
                                                <BreezeButton buttonType="blue" title="Assign Permissions" @click="assignPermissions(role.id)"> Permissions </BreezeButton>
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
                @close="isOpen = false"
                confirmationAlert="danger"
                confirmationTitle="Delete Role"
                confirmationText="Are you sure want to delete this role?"
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

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon, ChevronRightIcon,
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
        addRole(){
            this.$inertia.get(route('roles.create'));
        },
        deleteRole(roleID){
            this.isOpen = true
            this.confirmationData = roleID
        },
        editRole(roleID){
            this.$inertia.get(route('roles.edit'), {'role_id': roleID});
        },
        assignPermissions(role_id){
            this.$inertia.get(route('roles.assign_pemissions'), {'role_id': role_id});
        }
    }
}
</script>
