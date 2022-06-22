<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <Head title="Classes" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Class List
            </h2>
        </template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block min-w-full px-2">
                        <div class="flex pb-4 relative text-gray-400 focus-within:text-gray-600 justify-between">
                            <SearchIcon class="text-gray-600 h-4 w-4 fill-current pointer-events-none absolute top-1/4 left-3" :style="'top:21%'"></SearchIcon>
                            <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:ring-0 focus:border-gray-300 appearance-none  block pl-10"
                                    type="text" v-model="params.search" placeholder="Search">
                            <Link :href="route('classes.create')" class="py-2 px-4 rounded bg-indigo-600 hover:bg-indigo-700 text-white font-bold">Add New Class</Link>
                        </div>
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" width="2">#</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-if="!$page.props.classes.data.length">
                                        <td class="text-center" colspan="10">
                                            <div class="p-3">
                                                No Record Found! 
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr class="hover:bg-gray-200" v-for="(classroom, index) in $page.props.classes.data" :key="classroom.ID">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-700">{{ ++index }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ classroom.label }}</div>
                                            <!-- <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" :src="user.avatar" alt="">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm text-gray-500">{{ user.email }}</div>
                                                    <div class="">
                                                        <span v-for="(role, index) in user.user_has_role" :key="role.id">
                                                            <span class="text-slate-500" v-if="index != 0"> / </span><span class="text-indigo-400 text-sm whitespace-nowrap mt-0.5">{{ role.role.display_name ? role.role.display_name : '' }}</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="classroom.status == 1 ? ' bg-green-100 text-green-800' : ' bg-red-100 text-red-800'"> {{ classroom.status == 1 ? 'Active' : 'Not Active' }} </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center">
                                                <div class="flex pr-1">
                                                    <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-1 border border-yellow-700 rounded" title="Edit Class" @click="editClass(classroom.ID)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-white-600 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="flex">
                                                    <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-1 border border-red-700 rounded" title="Delete Class" @click="deleteClass(classroom.ID)">
                                                        <TrashIcon class="text-white-600 h-4 w-4 fill-current"></TrashIcon>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <template v-if="$page.props.classes.data.length">
                                <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 bg-gray-200">
                                    <div class="flex-1 flex justify-between sm:hidden">
                                        <a :href="$page.props.classes.prev_page_url" v-if="$page.props.classes.prev_page_url" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Previous </a>
                                        <a :href="$page.props.classes.next_page_url"  v-if="$page.props.classes.next_page_url" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Next </a>
                                    </div>
                                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                        <div>
                                            <p class="text-sm text-gray-700">
                                                Showing
                                                <span class="font-medium">{{ $page.props.classes.from }}</span>
                                                to
                                                <span class="font-medium">{{ $page.props.classes.to }}</span>
                                                of
                                                <span class="font-medium">{{ $page.props.classes.total }}</span>
                                                results
                                            </p>
                                        </div>
                                        <div>
                                            <nav id="pagination" class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                                                <Link v-for="(link, key) in $page.props.classes.links"
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
                @close="isOpen = false"
                confirmationAlert="danger"
                confirmationTitle="Delete Class"
                confirmationText="Are you sure want to delete this class?"
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
import { ref } from 'vue';
import { SearchIcon, TrashIcon, PencilIcon } from '@heroicons/vue/solid'
import { Head, Link } from '@inertiajs/inertia-vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue'

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon,
        ConfirmationModal, Head, Link
    },
    props: {
        filter: Object,
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
            }
        }
    },
    watch: {
        params: {
            handler(){
                if(this.params){
                    this.$inertia.get(this.route('classes'), this.params, { replace: true, preserveState: true});
                }
            },
            deep: true
        }
    },
    methods: {
        editClass(classroomID){
            this.$inertia.get(this.route('classes.edit'), {'class_id': classroomID});
        },
        deleteClass(classroomID){
            this.confirmationRoute = 'classes.destroy'
            this.confirmationData = classroomID
            this.isOpen = true
        }
    }
}
</script>
