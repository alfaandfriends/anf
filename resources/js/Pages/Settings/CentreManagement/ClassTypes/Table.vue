<script setup>
    import BreezeButton from '@/Components/Button.vue';
</script>
<template>
    <div class="flex pb-2 justify-end">
        <BreezeButton class="py-3" :route="route('settings.class_types.create')">New Class Type</BreezeButton>
    </div>
    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" width="3">#</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class Type</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-if="!$page.props.class_types.data.length">
                    <td class="text-center" colspan="10">
                        <div class="p-3">
                            No Record Found! 
                        </div>
                    </td>
                </tr> 
                <tr class="hover:bg-gray-200" v-for="(class_types, index) in $page.props.class_types.data" :key="class_types.ID">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-700">{{ ++index }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ class_types.name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                        <div class="flex justify-center">
                            <div class="flex pr-1">
                                <BreezeButton buttonType="warning" @click="editFeeType(class_types.id)">
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" class="text-white-600 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg> -->
                                    Edit
                                </BreezeButton>
                            </div>
                            <div class="flex">
                                <BreezeButton buttonType="danger" @click="deleteFeeType(class_types.id)">
                                    <!-- <TrashIcon class="text-white-600 h-4 w-4 fill-current"></TrashIcon> -->
                                    Delete
                                </BreezeButton>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination :page_data="$page.props.class_types" :params="params"></Pagination>
    </div>
</template>
<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import Pagination from '@/Components/Pagination.vue'

export default {
    components: {
        Head, Link, ConfirmationModal, Pagination
    },
    data() {
        return {
            isOpen: false,
            current_tab: 1,
            confirmationTitle: '',
            confirmationText: '',
            confirmationAlert: '',
            confirmationButton: '',
            confirmationMethod: '',
            confirmationData: '',
            confirmationRoute: '',
        };
    },
    methods: {
        editFeeType(class_type_id){
            this.$inertia.get(route('settings.class_types.edit'), {'class_type_id': class_type_id})
        },
        deleteFeeType(class_type_id){
            this.confirmationTitle="Delete Class Type"
            this.confirmationText="Are you sure want to delete this class type?"
            this.confirmationButton="Delete"
            this.confirmationMethod="delete"
            this.confirmationRoute = 'settings.class_types.destroy'
            this.confirmationData = class_type_id
            this.isOpen = true
        },
    }

}
</script>