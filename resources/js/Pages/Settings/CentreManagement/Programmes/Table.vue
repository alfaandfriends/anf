<script setup>
    import BreezeButton from '@/Components/Button.vue';
</script>
<template>
    <div class="flex pb-2 justify-end">
        <BreezeButton :route="route('settings.programmes.create')" class="py-3">New Programme</BreezeButton>
    </div>
    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" width="2">#</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Programme Name</th>
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
                        <div class="text-sm font-medium text-gray-900">{{ programme.name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="programme.status == 1 ? ' bg-green-100 text-green-800' : ' bg-red-100 text-red-800'"> {{ programme.status == 1 ? 'Active' : 'Not Active' }} </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                        <div class="flex justify-center">
                            <div class="flex pr-1">
                                <BreezeButton  buttonType="warning" @click="editProgramme(programme.id)">
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" class="text-white-600 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg> -->
                                    Edit
                                </BreezeButton>
                            </div>
                            <div class="flex">
                                <BreezeButton buttonType="danger" @click="deleteProgramme(programme.id)">
                                    <!-- <TrashIcon class="text-white-600 h-4 w-4 fill-current"></TrashIcon> -->
                                    Delete
                                </BreezeButton>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <template v-if="$page.props.programme_list.data.length">
            <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 bg-gray-200">
                <div class="flex-1 flex justify-between sm:hidden">
                    <a :href="$page.props.programme_list.prev_page_url" v-if="$page.props.programme_list.prev_page_url" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Previous </a>
                    <a :href="$page.props.programme_list.next_page_url"  v-if="$page.props.programme_list.next_page_url" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Next </a>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing
                            <span class="font-medium">{{ $page.props.programme_list.from }}</span>
                            to
                            <span class="font-medium">{{ $page.props.programme_list.to }}</span>
                            of
                            <span class="font-medium">{{ $page.props.programme_list.total }}</span>
                            results
                        </p>
                    </div>
                    <div>
                        <nav id="pagination" class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                            <Link v-for="(link, key) in $page.props.programme_list.links"
                                :key="key"
                                :href="link.url ? link.url : '#'"
                                :class="(link.active == false && link.url == null ? 'select-none bg-white border-gray-200 text-gray-300 relative inline-flex items-center px-4 py-2 border text-sm font-medium cursor-not-allowed'
                                                    : (link.active ? 'select-none z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium' 
                                                                                            : ('select-none bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium')))"  
                                v-html="link.label"
                            >
                            </Link>
                        </nav>
                    </div>
                </div>
            </div>
            <ConfirmationModal 
                :show="isOpen" 
                @close="isOpen = false"
                confirmationAlert="danger"
                :confirmationTitle="confirmationTitle"
                :confirmationText="confirmationText"
                :confirmationButton="confirmationButton"
                :confirmationMethod="confirmationMethod"
                :confirmationRoute="confirmationRoute"
                :confirmationData="confirmationData"
            >
            </ConfirmationModal>
        </template>
    </div>
</template>
<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue'

export default {
    components: {
        Head, Link, ConfirmationModal
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
        editProgramme(programme_id){
            this.$inertia.get(this.route('settings.programmes.edit'), {'programme_id': programme_id});
        },
        deleteProgramme(programme_id){
            this.confirmationTitle="Delete Programme"
            this.confirmationText="Are you sure want to delete this programme?"
            this.confirmationButton="Delete"
            this.confirmationMethod="delete"
            this.confirmationRoute = 'settings.programmes.destroy'
            this.confirmationData = programme_id
            this.isOpen = true
        }
    }

}
</script>