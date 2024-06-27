<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Stories" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="flex space-x-1 justify-end mb-3" v-if="$page.props.can.create_art_gallery">
                <BreezeButton :route="route('art_gallery.create')">Add Story</BreezeButton>
            </div>
            <hr class="my-3 border border-dashed border-gray-400">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-2 mb-3" @click.stop>
                <div class="relative w-full">
                    <svg class="absolute top-2.5 left-3 h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <input type="text" class="h-10 border-2 border-gray-300 w-full appearance-none focus:ring-0 focus:border-gray-300 py-1 pl-10 pr-4 text-gray-700 bg-white rounded-md" v-debounce:800ms="search" v-model="params.search">
                </div>
                <div class="relative w-full">
                    <Multiselect 
                        @select="search"
                        @deselect="search"
                        v-model="params.centre_id"
                        valueProp="ID"
                        :appendNewOption="false"
                        :searchable="true"
                        :options="$page.props.allowed_centres"
                        :clearOnSelect="true"
                        :clearOnDeselect="true"
                        :canClear="false"
                        :canDeselect="true"
                        trackBy="label"
                        label="label"
                        placeholder="All Centres"
                        :classes="{
                            container: 'relative w-full flex items-center justify-end box-border cursor-pointer border-2 border-gray-300 rounded-md bg-white text-base leading-snug outline-none h-10',
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
                <div class="relative w-full">
                    <Multiselect 
                        @select="search"
                        @deselect="search"
                        v-model="params.programme_id"
                        valueProp="id"
                        :appendNewOption="false"
                        :searchable="true"
                        :options="$page.props.programmes"
                        :clearOnSelect="true"
                        :closeOnDeselect="true"
                        :canClear="false"
                        :canDeselect="true"
                        trackBy="name"
                        label="name"
                        placeholder="All Programmes"
                            :classes="{
                                container: 'relative w-full flex items-center justify-end box-border cursor-pointer border-2 border-gray-300 rounded-md bg-white text-base leading-snug outline-none h-10',
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
                    >
                        <template #singlelabel="{ value }">
                            <div class="multiselect-single-label">
                                {{ value.name }}
                            </div>
                        </template>
                        <template #option="{ option }">
                            {{ option.name }} ({{ option.country_name }})
                        </template>
                    </Multiselect>
                </div>
                <div class="w-full self-center">
                    <BreezeButton buttonType="gray" class="py-2 px-3" :route="route('art_gallery')">Clear Search</BreezeButton>
                </div>
            </div>
            <div class="overflow-x-auto">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14">#</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/14">Title</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Reactions</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Comment</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-if="!$page.props.stories.data">
                                <td class="text-center" colspan="10">
                                    <div class="p-3">
                                        No Record Found! 
                                    </div>
                                </td>
                            </tr> 
                            <tr class="hover:bg-gray-200" v-for="(result, index) in $page.props.stories.data" :key="result.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-700">{{ ++index }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <span>{{ result.story_title }}</span>
                                        <div class="text-xs text-slate-500">{{ result.story_author_name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ moment(result.story_date).format('DD MMM Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="py-1 px-2 border border-indigo-500 bg-indigo-100 rounded-md text-indigo-600 cursor-pointer text-xs font-semibold">{{ result.reaction_count }} Reactions</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="py-1 px-2 border border-blue-500 bg-blue-100 rounded-md text-blue-600 cursor-pointer text-xs font-semibold">{{ result.reaction_count }} Comments</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center space-x-2">
                                        <BreezeButton class="py-1 px-4" @click="viewArtwork(result.art_file_location)" v-if="$page.props.can.edit_art_gallery">View</BreezeButton>
                                        <BreezeButton buttonType="warning" @click="viewArtwork(result.art_file_location)" v-if="$page.props.can.edit_art_gallery">Edit</BreezeButton>
                                        <BreezeButton buttonType="danger" @click="deleteArtwork(result.artwork_id)" v-if="$page.props.can.delete_art_gallery">Delete</BreezeButton>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :page_data="$page.props.stories" :params="params"></Pagination>
                <Modal :showModal="open_modal" modalType="sm" @hideModal="open_modal = false">
                    <template v-slot:header>
                        <div class="flex items-center justify-between py-3 px-4 border-b rounded-t font-semibold">
                            <h3 class="text-gray-900 text-xl font-semibold">                
                                Student's Artwork
                            </h3>       
                            <button type="button" @click="open_modal = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </button>
                        </div>                 
                    </template>
                    <template v-slot:content>
                        <div class="">
                            <div class="flex justify-center w-full">
                                <img :src="artwork.file_location" class="object-scale-down" alt="">
                            </div>
                        </div>
                    </template>
                    <template v-slot:footer>
                        <div class="flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                            <BreezeButton buttonType="gray" @click="open_modal = false">Close</BreezeButton>
                        </div>
                    </template>
                </Modal>
            </div>
            <ConfirmationModal 
                :show="isOpen" 
                @close="isOpen = false"
                confirmationAlert="danger"
                confirmationTitle="Delete Artwork"
                confirmationText="Are you sure want to delete this artwork?"
                confirmationButton="Delete"
                confirmationMethod="delete"
                :confirmationRoute="confirmationRoute"
                :confirmationData="confirmationData"
            />
            <FsLightbox
                :toggler="lightbox.open"
                :sources="lightbox.src"
                :exitFullscreenOnClose="true"
	        />
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { SearchIcon, TrashIcon, PencilIcon } from '@heroicons/vue/solid'
import { Head, Link } from '@inertiajs/inertia-vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import Pagination from '@/Components/Pagination.vue'
import axios from 'axios'
import Modal from '@/Components/Modal.vue'
import { debounce } from 'vue-debounce'
import Multiselect from '@vueform/multiselect'
import FsLightbox from "fslightbox-vue/v3";
import moment from "moment";

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon,
        ConfirmationModal, Head, Link, Modal, Pagination, Multiselect, FsLightbox 
    },
    props: {
        filter: Object,
    },
    watch: {
        'params.centre_id': {
            handler(){
                this.params.programme_id = ''
            },
            immediate: true
        }
    },
    data(){
        return{
            isOpen: false,
            searching: false,
            open_modal: false,
            confirmationData: '',
            confirmationRoute: '',
            lightbox: {
                open: false,
                src: [],
            },
            student_status: [{
                'id' : 1,
                'name' : 'Active'
            },{
                'id' : 0,
                'name' : 'Inactive'
            }],
            params: {
                search: this.filter.search ? this.filter.search : '',
                centre_id: this.filter.centre_id ? this.filter.centre_id : '',
                programme_id: this.filter.programme_id ? this.filter.programme_id : '',
                theme: this.filter.theme ? this.filter.theme : '',
                status: this.filter.status ? this.filter.status : '',
            },
            imageExists: false,
            artwork:{
                lesson: '',
                activity: '',
                file_location: ''
            }
        }
    },
    methods: {
        viewArtwork(artwork_file_location){
            fetch(window.location.origin+'/storage/art_gallery/'+artwork_file_location)
            .then(response => {
                if (!response.ok) {
                    this.lightbox.src = [window.location.origin+'/images/no_image.jpg']
                }
                else{
                    this.lightbox.src  = [window.location.origin+'/storage/art_gallery/'+artwork_file_location]
                }
                this.lightbox.open         = !this.lightbox.open
            })
        },
        deleteArtwork(artwork_id){
            this.confirmationRoute = 'art_gallery.destroy'
            this.confirmationData = artwork_id
            this.isOpen = true
        },
        search(){
            this.$inertia.get(this.route('stories'), this.params, { 
                replace: true, 
                preserveState: true,
                onBefore: visit => {
                    if(this.params.centre_id == ''){
                        this.params.programme_id = ''
                    }
                    this.searching = true
                },
                onFinish: visit => {
                    this.searching = false
                },
            });
        }
    }
}
</script>