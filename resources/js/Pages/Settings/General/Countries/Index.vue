<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="General Setting" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block min-w-full">
                        <TabPage/>
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg px-1">
                            <div class="flex py-2 justify-end">
                                <BreezeButton :route="route('settings.countries.create')" class="py-3">New Country</BreezeButton>
                            </div>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-300">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" width="3">#</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Country Code</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Currency</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-if="!$page.props.country_list.data.length">
                                        <td class="text-center" colspan="10">
                                            <div class="p-3">
                                                No Record Found! 
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr class="hover:bg-gray-200" v-for="(country_list, index) in $page.props.country_list.data" :key="country_list.ID">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-700">{{ ++index }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 font-bold">{{ country_list.name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 font-bold">{{ country_list.code }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 font-bold">{{ country_list.currency }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center">
                                                <div class="flex pr-1">
                                                    <BreezeButton buttonType="warning" @click="editCountry(country_list.id)">
                                                        <!-- <svg xmlns="http://www.w3.org/2000/svg" class="text-white-600 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg> -->
                                                        Edit
                                                    </BreezeButton>
                                                </div>
                                                <div class="flex">
                                                    <BreezeButton buttonType="danger" @click="deleteCountry(country_list.id)">
                                                        <!-- <TrashIcon class="text-white-600 h-4 w-4 fill-current"></TrashIcon> -->
                                                        Delete
                                                    </BreezeButton>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <template v-if="$page.props.country_list.data.length">
                                <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 bg-gray-300">
                                    <div class="flex-1 flex justify-between sm:hidden">
                                        <a :href="$page.props.country_list.prev_page_url" v-if="$page.props.country_list.prev_page_url" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Previous </a>
                                        <a :href="$page.props.country_list.next_page_url"  v-if="$page.props.country_list.next_page_url" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Next </a>
                                    </div>
                                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                        <div>
                                            <p class="text-sm text-gray-700">
                                                Showing
                                                <span class="font-medium">{{ $page.props.country_list.from }}</span>
                                                to
                                                <span class="font-medium">{{ $page.props.country_list.to }}</span>
                                                of
                                                <span class="font-medium">{{ $page.props.country_list.total }}</span>
                                                results
                                            </p>
                                        </div>
                                        <div>
                                            <nav id="pagination" class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                                                <Link v-for="(link, key) in $page.props.country_list.links"
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
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { TrashIcon } from '@heroicons/vue/solid'
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import TabPage from '@/Pages/Settings/General/Tab.vue'

export default {
    components: {
        Head, ConfirmationModal, TrashIcon, Link, TabGroup, TabList, Tab, TabPanels, TabPanel, 
    },
    data() {
        return {
            isOpen: false,
            confirmationTitle: '',
            confirmationText: '',
            confirmationAlert: '',
            confirmationButton: '',
            confirmationMethod: '',
            confirmationData: '',
            confirmationRoute: '',
        };
    },
    props: {
        country_list: Object,
    },
    methods: {
        editCountry(country_id){
            this.$inertia.get(route('settings.countries.edit'), {'country_id': country_id})
        },
        deleteCountry(country_id){
            this.confirmationTitle="Delete Country"
            this.confirmationText="Are you sure want to delete this country?"
            this.confirmationButton="Delete"
            this.confirmationMethod="delete"
            this.confirmationRoute = 'settings.countries.destroy'
            this.confirmationData = country_id
            this.isOpen = true
        },
    }

}
</script>
                                