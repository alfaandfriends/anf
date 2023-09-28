<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Product" />

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
                                        <svg class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none">
                                            <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                    <input type="text" class="h-10 border-2 border-gray-300 w-full appearance-none focus:ring-0 focus:border-gray-300 py-1 pl-10 pr-4 text-gray-700 bg-white rounded-md" placeholder="Search" v-debounce:800ms="search" v-model="params.search">
                                </div>
                                <!-- <button @click="show_filter = !show_filter" class="text-indigo-600 flex space-x-2 items-center bg-white hover:bg-indigo-50 border border-indigo-600 px-4 py-1.5 rounded-md">
                                    <span>Filters</span> 
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 512 512">
                                        <path d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z"/>
                                    </svg>
                                </button> -->
                            </div>
                            <div class="flex">
                                <BreezeButton :route="route('products.create')" v-if="$page.props.can.create_products">Add New Product</BreezeButton>
                            </div>
                        </div>
                        <!-- <div class="w-full shadow p-5 rounded-lg bg-white mb-3" v-if="show_filter">
                            <div class="flex items-center justify-between">
                                <p class="font-medium">
                                    Filters
                                </p>
                            </div>
                            <div>
                                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 mt-4">
                                    <select class="px-4 py-3 w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm">
                                    <option value="">All Type</option>
                                    <option value="for-rent">For Rent</option>
                                    <option value="for-sale">For Sale</option>
                                    </select>
                            
                                    <select class="px-4 py-3 w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm">
                                    <option value="">Furnish Type</option>
                                    <option value="fully-furnished">Fully Furnished</option>
                                    <option value="partially-furnished">Partially Furnished</option>
                                    <option value="not-furnished">Not Furnished</option>
                                    </select>
                            
                                    <select class="px-4 py-3 w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm">
                                    <option value="">Any Price</option>
                                    <option value="1000">RM 1000</option>
                                    <option value="2000">RM 2000</option>
                                    <option value="3000">RM 3000</option>
                                    <option value="4000">RM 4000</option>
                                    </select>
                            
                                    <select class="px-4 py-3 w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm">
                                    <option value="">Floor Area</option>
                                    <option value="200">200 sq.ft</option>
                                    <option value="400">400 sq.ft</option>
                                    <option value="600">600 sq.ft</option>
                                    <option value="800 sq.ft">800</option>
                                    <option value="1000 sq.ft">1000</option>
                                    <option value="1200 sq.ft">1200</option>
                                    </select>
                            
                                    <select class="px-4 py-3 w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm">
                                    <option value="">Bedrooms</option>
                                    <option value="1">1 bedroom</option>
                                    <option value="2">2 bedrooms</option>
                                    <option value="3">3 bedrooms</option>
                                    <option value="4">4 bedrooms</option>
                                    <option value="5">5 bedrooms</option>
                                    </select>
                            
                                    <select class="px-4 py-3 w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm">
                                    <option value="">Bathrooms</option>
                                    <option value="1">1 bathroom</option>
                                    <option value="2">2 bathrooms</option>
                                    <option value="3">3 bathrooms</option>
                                    <option value="4">4 bathrooms</option>
                                    <option value="5">5 bathrooms</option>
                                    </select>
                            
                                    <select class="px-4 py-3 w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm">
                                    <option value="">Bathrooms</option>
                                    <option value="1">1 space</option>
                                    <option value="2">2 space</option>
                                    <option value="3">3 space</option>
                                    </select>
                                </div>
                            </div>
                        </div> -->
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-300">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14">#</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/14">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/14">Description</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-if="!$page.props.products.data.length">
                                        <td class="text-center" colspan="10">
                                            <div class="p-3">
                                                No Record Found!
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-200" v-for="(product, index) in $page.props.products.data" :key="index">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-700">{{ index + 1 }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ product.name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ product.description }}</div>
                                        </td>
                                        <td class="flex px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                            <BreezeButton @click="editProduct(product.id)" buttonType="warning" title="Edit Category" v-if="$page.props.can.edit_products">
                                                Edit
                                            </BreezeButton>
                                            <BreezeButton @click="deleteProduct(product.id)" buttonType="danger" title="Delete Product" v-if="$page.props.can.delete_products">
                                                Delete
                                            </BreezeButton>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <Pagination :page_data="$page.props.products"></Pagination>
                        </div>
                    </div>
                </div>
            </div>
            <ConfirmationModal
                :show="show_confirmation"
                @close="show_confirmation = false"
                confirmationAlert="danger"
                confirmationTitle="Delete Product"
                confirmationText="Are you sure want to delete this product? All the variations and sub variations will deleted once you click the DELETE button. Are you sure?"
                confirmationButton="DELETE"
                confirmationMethod="delete"
                confirmationRoute="products.destroy"
                :confirmationData="product_id"
            />
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import Pagination from '@/Components/Pagination.vue';
import { SearchIcon, TrashIcon, PencilIcon } from '@heroicons/vue/solid';
import { debounce } from 'vue-debounce'

export default {
    components: {
        ConfirmationModal
    },
    data(){
        return{
            show_filter: false,
            show_confirmation: false,
            product_id: '',
            params: {
                search: this.$page.props.filter.search ? this.$page.props.filter.search : '',
            },
        }
    },
    methods: {
        editProduct(product_id){
            this.$inertia.get(this.route('products.edit'), {'product_id': product_id}, { replace: true, preserveState: true});
        },
        deleteProduct(product_id){
            this.product_id =   product_id
            this.show_confirmation = true
        },
        search(){
            this.$inertia.get(this.route('products'), this.params, { replace: true, preserveState: true});
        }
    }
}
</script>
