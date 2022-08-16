<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <Head title="Centres" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Centre List
            </h2>
        </template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block min-w-full">
                        <div class="flex justify-between pb-4 relative text-gray-400 focus-within:text-gray-600">
                            <div class="flex">
                                <SearchIcon class="text-gray-600 h-4 w-4 fill-current pointer-events-none absolute top-1/4 left-3" :style="'top:21%'"></SearchIcon>
                                <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:ring-0 focus:border-gray-300 appearance-none  block pl-10"
                                        type="text" v-model="params.search" placeholder="Search">
                            </div>
                            <div class="flex">
                                <Link :href="route('centres.create')" class="bg-indigo-700 hover:bg-indigo-900 text-white font-bold py-2 px-4 rounded">Add Centre</Link>
                            </div>
                        </div>
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider max-w-xs" width="5%">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider max-w-xs" width="3%">Address</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" width="3%">Status</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" width="3%">Action</th>
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
                                    <tr class="hover:bg-gray-200" v-for="centre in $page.props.centres.data" :key="centre.ID">
                                        <td class="px-2 py-3">
                                            <div class="flex items-center">
                                                <div class="ml-4">
                                                    <div class="text-md font-bold text-indigo-900 uppercase mb-1">{{ centre.label }}</div>
                                                    <div class="flex items-center text-sm text-black-500">
                                                        <span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                            </svg>
                                                        </span>
                                                        <span class="pl-2">{{ centre.email }}</span>
                                                    </div>
                                                    <div class="flex text-sm text-black-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                        </svg>
                                                        <span class="pl-2">{{ centre.phone ? centre.phone : '-' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-2 py-4 whitespace-nowrap">
                                            <div class="flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                                </svg>
                                                <span class="pl-2 capitalize text-sm break-all">{{ centre.address ? centre.address : 'Not Available'}}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="centre.is_active == true ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"> {{ centre.is_active == true ? 'Active' : 'Not Active' }} </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center">
                                                <div class="flex mr-1">
                                                    <button class="bg-blue-400 hover:bg-blue-500 text-white font-bold py-1 px-1 border border-blue-600 rounded" title="View Images" @click="viewImages(centre.ID)">
                                                        <PhotographIcon class="text-white-600 h-4 w-4 fill-current"></PhotographIcon>
                                                    </button>
                                                </div>
                                                <div class="flex mr-1">
                                                    <button class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-1 px-1 border border-yellow-600 rounded" title="Edit School" @click="editCentre(centre.ID)">
                                                        <PencilIcon class="text-white-600 h-4 w-4 fill-current"></PencilIcon>
                                                    </button>
                                                </div>
                                                <div class="flex">
                                                    <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-1 border border-red-700 rounded" title="Delete School" @click="deleteCentre(centre.ID)">
                                                        <TrashIcon class="text-white-600 h-4 w-4 fill-current"></TrashIcon>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <template v-if="$page.props.centres.data.length">
                                <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 bg-gray-200">
                                    <div class="flex-1 flex justify-between sm:hidden">
                                        <a :href="$page.props.centres.prev_page_url" v-if="$page.props.centres.prev_page_url" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Previous </a>
                                        <a :href="$page.props.centres.next_page_url"  v-if="$page.props.centres.next_page_url" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Next </a>
                                    </div>
                                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                        <div>
                                            <p class="text-sm text-gray-700">
                                                Showing
                                                <span class="font-medium">{{ $page.props.centres.from }}</span>
                                                to
                                                <span class="font-medium">{{ $page.props.centres.to }}</span>
                                                of
                                                <span class="font-medium">{{ $page.props.centres.total }}</span>
                                                results
                                            </p>
                                        </div>
                                        <div>
                                            <nav id="pagination" class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                                                <Link  v-for="(link, key) in $page.props.centres.links" 
                                                    :key="key" 
                                                    :href="link.url ? link.url + '&search=' + params.search : '#'"
                                                    class="" 
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
import ImageBox from "@alfaandfriends/image-light-box";

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon, PhotographIcon, ImageBox,
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
    watch: {
        params: {
            handler(){
                if(this.params){
                    this.$inertia.get(this.route('centres'), this.params, { replace: true, preserveState: true});
                }
            },
            deep: true
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
        }
    }
}
</script>
