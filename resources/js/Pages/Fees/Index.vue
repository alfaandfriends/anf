<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <Head title="Sessions" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Fee List
            </h2>
        </template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block min-w-full px-2">
                        <div class="flex pb-4 relative text-gray-400 focus-within:text-gray-600 justify-between">
                            <div class="flex justify-start">
                                <SearchIcon class="text-gray-600 h-4 w-4 fill-current pointer-events-none absolute top-1/4 left-3"></SearchIcon>
                                <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:ring-0 focus:border-gray-300 appearance-none  block pl-10"
                                        type="text" v-model="params.search" placeholder="Search">
                                <div class="pl-2">
                                    <select  v-model="params.centre" class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:ring-0 focus:border-gray-300 appearance-none block" name="" id="">
                                        <option :value="centre.ID" v-for="centre in centre_options" :key="centre.ID" :checked="params.centre == centre.ID">{{ centre.label }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <Link :href="route('fees.create')" class="py-2 px-4 rounded bg-indigo-600 hover:bg-indigo-700 text-white font-bold">Add New Class</Link>
                            </div>
                        </div>
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" width="3">#</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Fee</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Start Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">End Date</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-if="!$page.props.fees.data.length">
                                        <td class="text-center" colspan="10">
                                            <div class="p-3">
                                                No Record Found! 
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr class="hover:bg-gray-200" v-for="(fees, index) in $page.props.fees.data" :key="fees.ID">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-700">{{ ++index }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 font-bold">{{ fees.label }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="text-sm font-medium text-gray-900 flex justify-center items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span class="pl-2">{{ moment(fees.start_date).format('DD/MM/YYYY') }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="text-sm font-medium text-gray-900 flex justify-center items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span class="pl-2">{{ moment(fees.end_date).format('DD/MM/YYYY') }}</span>
                                                
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center">
                                                <div class="flex pr-1">
                                                    <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-1 border border-yellow-700 rounded" title="Edit Class" @click="editSession(fees.ID)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-white-600 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="flex">
                                                    <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-1 border border-red-700 rounded" title="Delete Class" @click="deleteSession(fees.ID)">
                                                        <TrashIcon class="text-white-600 h-4 w-4 fill-current"></TrashIcon>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <template v-if="$page.props.fees.data.length">
                                <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 bg-gray-200">
                                    <div class="flex-1 flex justify-between sm:hidden">
                                        <a :href="$page.props.fees.prev_page_url" v-if="$page.props.fees.prev_page_url" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Previous </a>
                                        <a :href="$page.props.fees.next_page_url"  v-if="$page.props.fees.next_page_url" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Next </a>
                                    </div>
                                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                        <div>
                                            <p class="text-sm text-gray-700">
                                                Showing
                                                <span class="font-medium">{{ $page.props.fees.from }}</span>
                                                to
                                                <span class="font-medium">{{ $page.props.fees.to }}</span>
                                                of
                                                <span class="font-medium">{{ $page.props.fees.total }}</span>
                                                results
                                            </p>
                                        </div>
                                        <div>
                                            <nav id="pagination" class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                                                <Link v-for="(link, key) in $page.props.fees.links"
                                                    :key="key"
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
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            <ConfirmationModal 
                :show="isOpen" 
                @close="isOpen = !isOpen"
                confirmationAlert="danger"
                confirmationTitle="Delete Fee"
                confirmationText="Are you sure want to delete this session?"
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
import { SearchIcon, TrashIcon, PencilIcon } from '@heroicons/vue/solid'
import { Head, Link } from '@inertiajs/inertia-vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import moment from 'moment';

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon,
        ConfirmationModal, Head, Link
    },
    props: {
        filter: Object,
        centre_options: Object,
    },

    data(){
        return{
            isOpen: false,
            userID: '',
            confirmationTitle: '',
            confirmationText: '',
            confirmationAlert: '',
            confirmationButton: '',
            confirmationMethod: '',
            confirmationData: '',
            confirmationRoute: '',
            params: {
                search: this.filter.search ? this.filter.search : '',
                centre: this.filter.centre ? this.filter.centre : ''
            }
        }
    },
    watch: {
        params: {
            handler(){
                if(this.params){
                    this.$inertia.get(this.route('fees'), this.params, { replace: true, preserveState: true});
                }
            },
            deep: true
        }
    },
    methods: {
        editSession(sessionID){
            this.$inertia.get(this.route('fees.edit'), {'session_id': sessionID});
        },
        deleteSession(sessionID){
            this.confirmationRoute = 'fees.destroy'
            this.confirmationData = sessionID
            this.isOpen = true
        }
    }
}
</script>
