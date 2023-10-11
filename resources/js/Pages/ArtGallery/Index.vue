<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Art Gallery" />

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
                                <input type="text" class="h-10 border-2 border-gray-300 w-full appearance-none focus:ring-0 focus:border-gray-300 py-1 pl-10 pr-4 text-gray-700 bg-white rounded-md" placeholder="Search" v-debounce:800ms="search" v-model="params.search">
                            </div>
                            <div class="flex">
                                <BreezeButton class="py-2 px-4 rounded-r-none border-r border-r-white" :route="route('art_gallery.create')" v-if="$page.props.can.create_art_gallery">Upload Artwork</BreezeButton>
                                <div class="relative inline-block text-left group">
                                    <BreezeButton class="py-2 px-1 rounded-l-none text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 128 512">
                                            <path d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"/>
                                        </svg>
                                    </BreezeButton>
                                    <div class="absolute z-50 rounded-md shadow-lg origin-top-right right-0 group-hover:block hidden border-x border-x-indigo-600 border-b border-b-indigo-600 rounded-t-none">
                                        <div class="rounded-md ring-0 ring-red-500 ring-opacity-5 bg-white">
                                            <a :href="route('art_gallery.setting.levels')" class="flex items-center space-x-2 font-medium whitespace-nowrap rounded-md px-4 py-2 text-gray-800 hover:bg-indigo-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 512 512">
                                                    <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/>
                                                </svg>
                                                <span>Setting</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-300">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14">#</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/14">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Level</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Theme</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Lesson - Title</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Activity</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-if="!$page.props.arts.data.length">
                                        <td class="text-center" colspan="10">
                                            <div class="p-3">
                                                No Record Found! 
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr class="hover:bg-gray-200" v-for="(result, index) in $page.props.arts.data" :key="result.id">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-700">{{ ++index }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ result.student_name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ result.level }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ result.theme }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900"> {{ result.lesson }} </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ result.activity }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center space-x-2">
                                                <BreezeButton buttonType="blue" class="py-1 px-2" @click="viewArtwork(result.art_file_location)" v-if="$page.props.can.edit_art_gallery">View</BreezeButton>
                                                <BreezeButton buttonType="danger" @click="deleteArtwork(result.artwork_id)" v-if="$page.props.can.delete_art_gallery">Delete</BreezeButton>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :page_data="$page.props.arts" :params="params"></Pagination>
                        <Modal :showModal="open_modal" modalType="sm" @hideModal="open_modal = false">
                            <template v-slot:header>
                                <h3 class="text-gray-900 text-xl font-semibold">                
                                    Student's Artwork
                                </h3>                
                            </template>
                            <template v-slot:content>
                                <div class="w-full md:w-[48rem]">
                                    <!-- <div class=" w-2/12"> -->
                                        <img :src="artwork.file_location" class="object-scale-down" alt="">
                                    <!-- </div> -->
                                </div>
                            </template>
                            <template v-slot:footer>
                                <div class="flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                                    <BreezeButton buttonType="gray" @click="open_modal = false">Close</BreezeButton>
                                </div>
                            </template>
                        </Modal>
                    </div>
                </div>
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

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon,
        ConfirmationModal, Head, Link, Modal, Pagination
    },
    props: {
        filter: Object,
    },
    computed: {
        baseUrl() {
            return window.location.origin;
        }
    },
    data(){
        return{
            isOpen: false,
            open_modal: false,
            confirmationData: '',
            confirmationRoute: '',
            params: {
                search: this.filter.search ? this.filter.search : '',
                centre_id: this.filter.centre_id ? this.filter.centre_id : '',
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
                    this.artwork.file_location = window.location.origin+'/images/no_image.jpg'
                }
                else{
                    this.artwork.file_location  = window.location.origin+'/storage/art_gallery/'+artwork_file_location;
                }
                this.open_modal         = true
            })
        },
        deleteArtwork(artwork_id){
            this.confirmationRoute = 'art_gallery.destroy'
            this.confirmationData = artwork_id
            this.isOpen = true
        },
        search(){
            this.$inertia.get(this.route('art_gallery'), this.params, { replace: true, preserveState: true});
        }
    }
}
</script>