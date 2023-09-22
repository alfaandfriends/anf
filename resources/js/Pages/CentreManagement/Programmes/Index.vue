<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
    import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Programmes" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block min-w-full">
                        <div class="flex justify-between pb-4 relative text-gray-400 focus-within:text-gray-600 items-center">
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none">
                                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </span>
                                <input type="text" class="h-10 border-2 border-gray-300 w-full appearance-none focus:ring-0 focus:border-gray-300 py-1 pl-10 pr-4 text-gray-700 bg-white rounded-md" placeholder="Search" v-model="params.search">
                            </div>
                            <div class="flex" v-if="$page.props.can.create_programmes">
                                <BreezeButton :route="route('programmes.create')">New Programme</BreezeButton>
                            </div>
                        </div>
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-300">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" width="2">#</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Programme Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Country</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-if="!$page.props.programme_list.data.length">
                                        <td class="text-center" colspan="10">
                                            <div class="p-3">
                                                No Record Found! 
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr class="hover:bg-gray-200" v-for="(programme, index) in $page.props.programme_list.data" :key="programme.id">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-700">{{ ++index }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ programme.programme_name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ programme.country }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="programme.status == 1 ? ' bg-green-100 text-green-800' : ' bg-red-100 text-red-800'"> {{ programme.status == 1 ? 'Active' : 'Not Active' }} </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center space-x-2">
                                                <BreezeButton  buttonType="warning" @click="editProgramme(programme.id)" v-if="$page.props.can.edit_programmes">
                                                    Edit
                                                </BreezeButton>
                                                <BreezeButton buttonType="danger" @click="deleteProgramme(programme.id)" v-if="$page.props.can.delete_programmes">
                                                    Delete
                                                </BreezeButton>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <Pagination :page_data="$page.props.programme_list"></Pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ConfirmationModal 
            :show="isOpen" 
            @close="isOpen = false"
            confirmationAlert="danger"
            confirmationTitle="Delete Programme"
            confirmationText="Are you sure want to delete this programme?"
            confirmationButton="Delete"
            confirmationMethod="delete"
            :confirmationRoute="confirmationRoute"
            :confirmationData="confirmationData"
        />
    </BreezeAuthenticatedLayout>
</template>
<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { SearchIcon, TrashIcon, PencilIcon, PhotographIcon } from '@heroicons/vue/solid'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import Pagination from '@/Components/Pagination.vue'

export default {
    components: {
        Head, Link, ConfirmationModal, SearchIcon, Pagination
    },
    props: {
        filter: Object,
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
            params: {
                search: this.filter.search ? this.filter.search : '',
            },
        };
    },
    watch: {
        params: {
            handler(){
                if(this.params){
                    this.$inertia.get(this.route('programmes'), this.params, { replace: true, preserveState: true});
                }
            },
            deep: true
        }
    },
    methods: {
        editProgramme(programme_id){
            this.$inertia.get(this.route('programmes.edit'), {'programme_id': programme_id});
        },
        deleteProgramme(programme_id){
            this.confirmationTitle="Delete Programme"
            this.confirmationText="Are you sure want to delete this programme?"
            this.confirmationButton="Delete"
            this.confirmationMethod="delete"
            this.confirmationRoute = 'programmes.destroy'
            this.confirmationData = programme_id
            this.isOpen = true
        }
    }

}
</script>