<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Centres" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block min-w-full">
                        <div class="flex justify-between pb-4 relative text-gray-400 focus-within:text-gray-600 items-center">
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-10 w-4 text-gray-400" viewBox="0 0 24 24" fill="none">
                                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </span>
                                <input type="text" class="h-10 border-2 border-gray-300 w-full appearance-none focus:ring-0 focus:border-gray-300 py-1 pl-10 pr-4 text-gray-700 bg-white rounded-md" placeholder="Search" v-debounce:800ms="search" v-model="params.search">
                            </div>
                            <div class="flex" v-if="$page.props.can.create_centres">
                                <BreezeButton :route="route('centres.create')">New Centre</BreezeButton>
                            </div>
                        </div>
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-300">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider max-w-xs" width="1%">#</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider max-w-xs" width="5%">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider max-w-xs" width="7%">Address</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider max-w-xs" width="5%">Country</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" width="2%">Status</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" width="2%">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-if="!$page.props.centres.data.length">
                                        <td class="text-center" colspan="10">
                                            <div class="p-3">
                                                No Record Found! 
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr class="hover:bg-gray-200" v-for="centre, index in $page.props.centres.data">
                                        <td class="px-6 py-3">
                                            <span class="font-semibold text-black text-sm dark:text-white">{{ index + 1 }}</span>
                                        </td>
                                        <td class="px-6 py-3">
                                            <span class="font-semibold whitespace-break-spaces text-sm">{{ centre.centre_name }}</span>
                                        </td>
                                        <td class="px-6 py-3">
                                            <span class="font-semibold whitespace-break-spaces text-sm">{{ centre.centre_address ? centre.centre_address : 'Not Available'}}</span>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            <span class="font-semibold whitespace-break-spaces text-sm">{{ centre.country_name ? centre.country_name : 'Not Set' }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="centre.centre_status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"> {{ centre.centre_status ? 'Active' : 'Not Active' }} </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium">
                                            <div class="flex justify-center space-x-2">
                                                <!-- <BreezeButton :buttonType="'blue'" title="View Images" @click="viewImages(centre.centre_id)" v-if="$page.props.can.view_centres">View Images</BreezeButton> -->
                                                <BreezeButton :buttonType="'warning'" title="Edit School" @click="editCentre(centre.centre_id)" v-if="$page.props.can.edit_centres">Edit</BreezeButton>
                                                <BreezeButton :buttonType="'danger'" title="Delete School" @click="deleteCentre(centre.centre_id)" v-if="$page.props.can.delete_centres">Delete</BreezeButton>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <Pagination :page_data="$page.props.centres" :params="params"></Pagination>
                        </div>
                    </div>
                </div>
            </div>
            <ConfirmationModal 
                :show="isOpen" 
                @close="isOpen = false"
                confirmationAlert="danger"
                confirmationTitle="Delete Centre"
                confirmationText="Are you sure want to delete this centre?"
                confirmationButton="Delete"
                confirmationMethod="delete"
                :confirmationRoute="confirmationRoute"
                :confirmationData="confirmationData"
            >
            </ConfirmationModal>
            <ImageBox
                @closeImagebox="closeImage"
                :images="images"
                :openLightbox="isOpenImagebox"
            ></ImageBox>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { ref } from 'vue';
import { SearchIcon, TrashIcon, PencilIcon, PhotographIcon } from '@heroicons/vue/solid'
import { Head, Link } from '@inertiajs/inertia-vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import Pagination from '@/Components/Pagination.vue'
import ImageBox from "@alfaandfriends/image-light-box";
import { debounce } from 'vue-debounce'

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon, PhotographIcon, ImageBox, Pagination,
        ConfirmationModal, Head, Link,
    },
    props: {
        filter: Object,
        centre_images: Object
    },
    created(){
        this.images.push({
            thumb: "https://media.istockphoto.com/vectors/no-image-available-sign-vector-id1138179183?k=20&m=1138179183&s=612x612&w=0&h=iJ9y-snV_RmXArY4bA-S4QSab0gxfAMXmXwn5Edko1M=",
            src: "https://media.istockphoto.com/vectors/no-image-available-sign-vector-id1138179183?k=20&m=1138179183&s=612x612&w=0&h=iJ9y-snV_RmXArY4bA-S4QSab0gxfAMXmXwn5Edko1M=",
            caption: "Not Available",
        })
    },
    data(){
        return{
            isOpen: false,
            isOpenImagebox: false,
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
            },
            images: [],
        }
    },
    methods: {
        deleteCentre(userID){
            this.confirmationRoute = 'centres.destroy'
            this.confirmationData = userID
            this.isOpen = true
        },
        editCentre(centre_id){
            this.$inertia.get(route('centres.edit'), {centre_id: centre_id}, { preserveState: true})
        },
        viewImages(centre_id){
            axios.get(this.route('centres.get_images'), {
                params: {
                    'centre_id': centre_id
                }})
                .then((response)=>{
                    this.images = ''
                    this.images = []
                    this.images = response.data
                    this.isOpenImagebox = true
                    document.body.classList.add('overflow-hidden')
                })
        },
        closeImage(){
            this.isOpenImagebox = false
            document.body.classList.remove('overflow-hidden')
        },
        search(){
            this.$inertia.get(this.route('centres'), this.params, { replace: true, preserveState: true});
        }
    }
}
</script>
