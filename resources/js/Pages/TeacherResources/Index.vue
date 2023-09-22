<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Teacher Resources" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block min-w-full">
                        <div class="flex justify-between pb-4 relative text-gray-400 focus-within:text-gray-600 items-center">
                            <div class="flex space-x-2">
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg class="h-10 w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none">
                                            <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                    <input type="text" class="h-10 border-2 border-gray-300 w-full appearance-none focus:ring-0 focus:border-gray-300 py-1 pl-10 pr-4 text-gray-700 bg-white border rounded-md" placeholder="Search" v-model="params.search">
                                </div>
                                <div class="flex">
                                    <Multiselect 
                                        v-model="params.programme_id"
                                        valueProp="id"
                                        :appendNewOption="false"
                                        :searchable="true"
                                        :options="$page.props.programmes"
                                        :clearOnSelect="false"
                                        :canClear="true"
                                        :canDeselect="true"
                                        trackBy="name"
                                        label="name"
                                        placeholder="Programme"
                                        :classes="{
                                            container: 'relative mx-auto w-64 flex items-center justify-end box-border cursor-pointer border-2 border-gray-300 rounded-lg bg-white text-base leading-snug outline-none h-10',
                                            containerDisabled: 'cursor-default bg-gray-100',
                                            containerOpen: 'rounded-b-none',
                                            containerActive: 'border-2 border-gray-300',
                                            singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                            singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                            search: 'w-full mt-1 h-8 absolute inset-0 focus:border-none outline-none focus:ring-0 appearance-none border-2 border-transparent focus:border-gray-300 text-base font-sans bg-white rounded-lg',
                                            placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500',
                                            clear: 'pr-10 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 text-gray-800',
                                            clearIcon: 'fa fa-heart bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                                            spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0',
                                            dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                            dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                            dropdownHidden: 'hidden',
                                            options: 'flex flex-col p-0 m-0 list-none w-full',
                                            group: 'p-0 m-0',
                                            groupLabel: 'flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                                            groupLabelPointable: 'cursor-pointer',
                                            groupLabelPointed: 'bg-gray-300 text-black-700',
                                            groupLabelSelected: 'bg-gray-100 text-black',
                                            groupLabelSelectedPointed: 'bg-gray-100 text-black opacity-90',
                                            groupOptions: 'p-0 m-0',
                                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3',
                                            optionPointed: 'text-gray-800 bg-gray-100',
                                            optionSelected: 'text-white bg-indigo-500',
                                            optionDisabled: 'text-gray-300 cursor-not-allowed',
                                            optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                            optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                            noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                            noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                            fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                                        }"
                                    />
                                </div>
                            </div>
                            <div class="flex">
                                <BreezeButton :route="route('teacher_resources.create')" v-if="$page.props.can.create_teacher_resources">New Resource</BreezeButton>
                            </div>
                        </div>
                        <table class="table-auto min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14">#</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/14">Title</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Programme</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Level</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-if="!$page.props.teacher_resources.data.length">
                                    <td class="text-center" colspan="10">
                                        <div class="p-3">
                                            No Record Found! 
                                        </div>
                                    </td>
                                </tr> 
                                <tr class="hover:bg-gray-200" v-for="(result, index) in $page.props.teacher_resources.data" :key="result.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-700">{{ ++index }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ result.title }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ result.programme }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ result.level }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center space-x-2">
                                            <BreezeButton buttonType="blue" @click="viewResource(result.id)" v-if="$page.props.can.view_teacher_resources">View / Download</BreezeButton>
                                            <BreezeButton buttonType="warning" @click="editResource(result.id)" v-if="$page.props.can.edit_teacher_resources">Edit</BreezeButton>
                                            <BreezeButton buttonType="danger" @click="deleteResource(result.id)" v-if="$page.props.can.delete_teacher_resources">Delete</BreezeButton>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Pagination :page_data="$page.props.teacher_resources"></Pagination>
                    </div>
                </div>
            </div>
        </div>
        <ConfirmationModal 
            :show="isOpen" 
            @close="isOpen = false"
            confirmationAlert="danger"
            confirmationTitle="Delete Resource"
            confirmationText="Are you sure want to delete this resource?"
            confirmationButton="Delete"
            confirmationMethod="delete"
            :confirmationRoute="confirmationRoute"
            :confirmationData="confirmationData"
        />
        <Modal :showModal="show_resource" @hideModal="show_resource = false">
            <template v-slot:header>
                <h3 class="text-gray-900 text-xl font-semibold">                
                    Resource Information
                </h3>                
            </template>
            <template v-slot:content>
                <div class="flex items-center justify-center p-5 h-72" v-if="loading_resource">
                    <div class="flex space-x-2 animate-pulse">
                        <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                        <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                        <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                    </div>
                </div>
                <div class="p-6 overflow-y-auto no-scrollbar space-y-4" v-else>
                    <template v-if="resource_data.media_type_id == 1">
                        <div class="flex justify-center" v-html="resource_data.content"></div>
                    </template>
                    <template v-if="resource_data.media_type_id == 2">
                        <div class="flex justify-center">
                            <iframe :src="'storage/teacher_resources/'+resource_data.content" width="100%" height="600px"></iframe>
                        </div>
                    </template>
                    <template v-if="resource_data.media_type_id == 3">
                        <div class="flex justify-center">
                            <iframe class="flex-1" :src="'https://view.officeapps.live.com/op/view.aspx?src=' + baseUrl() + '/storage/teacher_resources/' + resource_data.content + '&embedded=true'" style="width:600px; height:500px;" frameborder="0"></iframe>
                        </div>
                    </template>
                    
                    <div class="flex justify-center">
                        <div class="w-11/12 p-4">
                            <div class="mt-6 border-t border-gray-100">
                                <dl class="divide-y divide-gray-100">
                                    <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Title</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ resource_data.title }}</dd>
                                    </div>
                                    <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Programme / Level</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ resource_data.programme + ` ( Level ${resource_data.level} )` }}</dd>
                                    </div>
                                    <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Language</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ resource_data.language }}</dd>
                                    </div>
                                    <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Media Type</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ resource_data.media_type_name }}</dd>
                                    </div>
                                    <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Created Date</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ moment(resource_data.created_at).format('DD/MM/Y') }}</dd>
                                    </div>
                                    <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Last Updated</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ moment(resource_data.updated_at).format('DD/MM/Y') }}</dd>
                                    </div>
                                    <div class="flex">
                                        <button class="flex-1 mt-3 py-2 px-6 rounded bg-indigo-500 hover:bg-indigo-600 text-white" @click="downloadFile(resource_data.content)" v-if="resource_data.media_type_id == 2 || resource_data.media_type_id == 3">Download</button>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:footer>
                <div class="flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                    <BreezeButton buttonType="gray" @click="show_resource = false">Close</BreezeButton>
                </div>
            </template>
        </Modal>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { SearchIcon, TrashIcon, PencilIcon } from '@heroicons/vue/solid'
import { Head, Link } from '@inertiajs/inertia-vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import Pagination from '@/Components/Pagination.vue'
import moment from 'moment';
import Modal from '@/Components/Modal.vue'
import Multiselect from '@vueform/multiselect'

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon, Head, Link, ConfirmationModal, Modal, Multiselect
    },
    data(){
        return{
            loading_resource: false,
            show_resource: false,
            isOpen: false,
            confirmationData: '',
            confirmationRoute: '',
            open_modal: false,
            params: {
                search: this.$page.props.filter ? this.$page.props.filter.search : '',
                programme_id: this.$page.props.filter ? this.$page.props.filter.programme_id : '',
            },
            resource_data: [],
        }
    },
    watch: {
        params: {
            handler(){
                this.$inertia.get(route('teacher_resources'), this.params)
            },
            deep: true
        }
    },
    methods: {
        viewResource(resource_id){
            this.resource_data      =   []
            this.show_resource      =   true
            this.loading_resource   =   true
            axios.get(route('teacher_resources.get_resource'), {
                    params: {
                        'resource_id': resource_id
                    }
                })
                .then(response => {
                    this.resource_data      =   response.data
                    this.loading_resource   =   false
                });
        },
        editResource(resource_id){
            this.$inertia.get(route('teacher_resources.edit'), {'resource_id':resource_id})
        },
        deleteResource(resource_id){
            this.confirmationRoute = 'teacher_resources.destroy'
            this.confirmationData = resource_id
            this.isOpen = true
        },
        baseUrl() {
            const { protocol, host } = window.location;
            return `${protocol}//${host}`;
        },
        downloadFile(filename){
            axios.get(route('download.teacher_resources', filename), {
                responseType: 'blob', // Set the response type to 'blob'
            })
            .then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', filename); // Specify the file name
                document.body.appendChild(link);
                link.click();
            })
            .catch(error => {
                console.error(error);
            });
        }
    },
}
</script>