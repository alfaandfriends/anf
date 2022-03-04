<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>
<script>
export default {
    data(){
        return{
            params: {
                search: null,
                page: null,
            }
        }
    },
    methods: {
        selectPage(url){
            const page_number   =   url.searchParams.get('page')
            this.page           =   page_number;
        }
    },
    watch: {
        params: {
            handler(){
                this.$inertia.get(this.route('users'), this.params, { replace: true, preserveState: true});
            },
            deep: true
        }
    }
}
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <div class="py-6">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="mx-auto sm:px-6">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="pt-2 relative mx-auto text-gray-600">
                            <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:ring-0 focus:border-gray-300"
                            type="text" v-model="params.search" placeholder="Search">
                            <button type="submit" class="absolute right-0 top-0 mt-5 mr-4">
                            <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                                viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"
                                width="512px" height="512px">
                                <path
                                d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                            </svg>
                            </button>
                        </div>
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th> -->
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="user in $page.props.user_list.data" :key="user.ID">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ user.first_name }} {{ user.last_name }}</div>
                                                <div class="text-sm text-gray-500">{{ user.email }}</div>
                                            </div>
                                            </div>
                                        </td>
                                        <!-- <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Regional Paradigm Technician</div>
                                            <div class="text-sm text-gray-500">Optimization</div>
                                        </td> -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"> Active </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Admin</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                                <div class="flex-1 flex justify-between sm:hidden">
                                    <a :href="$page.props.user_list.prev_page_url" v-if="$page.props.user_list.prev_page_url" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Previous </a>
                                    <a :href="$page.props.user_list.next_page_url"  v-if="$page.props.user_list.next_page_url" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Next </a>
                                </div>
                                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-sm text-gray-700">
                                            Showing
                                            <span class="font-medium">{{ $page.props.user_list.from }}</span>
                                            to
                                            <span class="font-medium">{{ $page.props.user_list.to }}</span>
                                            of
                                            <span class="font-medium">{{ $page.props.user_list.total }}</span>
                                            results
                                        </p>
                                    </div>
                                    <div>
                                        <nav id="pagination" class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                                            <a  v-for="(link, key) in $page.props.user_list.links" 
                                                :key="key" 
                                                :href="link.url"
                                                class="" 
                                                :class="(link.active == false && link.url == null ? 'select-none bg-white border-gray-200 text-gray-300 relative inline-flex items-center px-4 py-2 border text-sm font-medium'
                                                                     : (link.active ? 'select-none z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium' 
                                                                                                             : ('select-none bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium')))"  
                                                v-html="link.label"
                                                @click="selectPage(link.url)"
                                            >
                                            </a>
                                            <!-- <a href="" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                                <span class="sr-only">Previous</span>
                                            </a>
                                          
                                            <a href="#" aria-current="page" class=""> 1 </a>
                                            <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium"> 2 </a>
                                            <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 hidden md:inline-flex relative items-center px-4 py-2 border text-sm font-medium"> 3 </a>
                                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700"> ... </span>
                                            <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 hidden md:inline-flex relative items-center px-4 py-2 border text-sm font-medium"> 8 </a>
                                            <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium"> 9 </a>
                                            <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium"> 10 </a>
                                            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                                <span class="sr-only">Next</span>
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </a> -->
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
