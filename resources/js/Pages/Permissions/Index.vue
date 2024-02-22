<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
    import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Permissions" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="m-3">
                    <div class="align-middle inline-block w-full lg:w-1/2 px-2">
                        <div class="flex pb-4 relative text-gray-400 focus-within:text-gray-600">
                            <BreezeButton @click="addPermission()" v-if="$page.props.can.create_permissions"> 
                                Add Permission
                            </BreezeButton>
                        </div>
                        
                        <nav class="text-sm font-medium text-gray-700">
                            <div class="flex items-center border border-red-500 py-3 px-4" v-if="!$page.props.permissions">
                                <span class="mr-2">No permission added.</span>
                            </div>
                            <div v-else v-for="permission, index in $page.props.permissions">
                                <div class="flex" :class="expandAccordion && index === selected ? 'bg-indigo-400 text-gray-200' : 'bg-indigo-300 hover:bg-indigo-400 text-gray-800 hover:text-gray-200'">
                                    <div class="flex flex-1 justify-between items-center px-4 py-1 transition cursor-pointer group border border-indigo-200 border-r-0 relative" role="button" @click="toggleMenu(index)">
                                        <div class="flex items-center">
                                            <span class="select-none">{{ permission.name }}</span> 
                                        </div>
                                        <ChevronRightIcon :class="{ 'rotate-90': expandAccordion && index === selected }" class="shrink-0 w-4 h-4 ml-2 transition transform"></ChevronRightIcon>
                                    </div>
                                    <div class="flex flex-none items-center px-4 py-1 transition cursor-pointer border border-indigo-200 border-l-0 text-gray-800" role="button">
                                        <div class="flex items-center space-x-2">
                                            <BreezeButton buttonType="warning" @click="editPermission(permission.id)" v-if="$page.props.can.edit_permissions">Edit</BreezeButton>
                                            <BreezeButton buttonType="danger" @click="deletePermission(permission.id)" v-if="$page.props.can.delete_permissions">Delete</BreezeButton>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col py-2 px-4 border-x border-indigo-200" v-if="expandAccordion && index === selected">
                                    <div v-if="permission.permission_sub.length < 1">
                                        <span>No sub permissions.</span>
                                    </div>
                                    <div v-else class="flex flex-col">
                                        <ul class="list-disc items-center translate-x-4">
                                            <li class="mb-1" v-for="sub_permission, index in permission.permission_sub">
                                                <span>{{ sub_permission.name }}</span>
                                            </li>
                                        </ul>
                                        <div class="flex space-x-6">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
            <ConfirmationModal 
                :show="isOpen" 
                @close="isOpen = false"
                confirmationAlert="danger"
                confirmationTitle="Delete Permission"
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
import { ViewGridIcon, CogIcon, ChevronRightIcon, LogoutIcon, XIcon, MenuIcon } from '@heroicons/vue/solid'

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon, ChevronRightIcon,
        ConfirmationModal, Head
    },
    data(){
        return{
            expandAccordion: false,
            isOpen: false,
            confirmationTitle: '',
            confirmationText: '',
            confirmationAlert: '',
            confirmationButton: '',
            confirmationMethod: '',
            confirmationRoute: '',
            confirmationData: '',
            selected: '',
        }
    },
    methods: {
        toggleMenu (item) {
            item == this.selected ? this.expandAccordion = !this.expandAccordion : this.expandAccordion = true
            this.selected = item
        },
        addPermission(){
            this.$inertia.get(route('permissions.create'));
        },
        deletePermission(permission_id){
            this.isOpen = true
            this.confirmationData = permission_id
        },
        editPermission(permission_id){
            this.$inertia.get(route('permissions.edit'), {permission_id: permission_id});
        }
    }
}
</script>
