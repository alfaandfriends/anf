<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Art Gallery" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block min-w-full px-2">
                        <div class="flex justify-between mb-4">
                            <div class="flex space-x-2">
                                <div class="flex relative text-gray-400 focus-within:text-gray-600">
                                    <SearchIcon class="text-gray-600 h-4 w-4 fill-current pointer-events-none absolute top-1/4 left-3" :style="'top:30%'"></SearchIcon>
                                    <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg focus:ring-0 focus:border-gray-300 appearance-none  block pl-10"
                                            type="text" v-model="params.search" placeholder="Search">
                                </div>
                            </div>
                            <div class="flex">
                                <BreezeButton :route="route('art_gallery.create')">Upload Artwork</BreezeButton>
                            </div>
                        </div>
                        <table class="table-auto min-w-full divide-y divide-gray-200">
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
                                            <BreezeButton buttonType="blue" class="py-1 px-2" @click="viewArtwork(result.art_file_location)">View</BreezeButton>
                                            <BreezeButton buttonType="danger" @click="deleteArtwork(result.artwork_id)">Delete</BreezeButton>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Pagination :page_data="$page.props.arts"></Pagination>
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
    watch: {
        params: {
            handler(){
                if(this.params){
                    this.$inertia.get(this.route('art_gallery'), this.params, { replace: true, preserveState: true});
                }
            },
            deep: true
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
            // const image = new Image()
            // var image_exist = true
            // image.src = window.location.origin+'/storage/art_gallery/'+artwork_file_location;
            // image.onload = () => {
            //     image_exist = true
            // };
            // image.onerror = () => {
            //     image_exist = false
            // };
            // console.log(image.src)
            // console.log(image_exist)
            // if(image_exist){
            //     
            // }
            // else{
            //     this.artwork.file_location = window.location.origin+'/images/no_image.jpg'
            // }
        },
        deleteArtwork(artwork_id){
            this.confirmationRoute = 'art_gallery.destroy'
            this.confirmationData = artwork_id
            this.isOpen = true
        }
    }
}
</script>