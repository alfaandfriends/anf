<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Products" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="flex items-center justify-between">
            <div class="flex space-x-2">
                <div class="relative">
                    <MagnifyingGlassIcon class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
                    <Input type="text" placeholder="Search" class="w-full rounded-lg bg-background pl-8 md:w-[200px] lg:w-[336px]" v-debounce:800ms="search" v-model="params.search"/>
                </div>
                <Button class="border border-slate-700 border-dashed bg-white text-slate-800 hover:bg-slate-50" @click="showFilters()"> 
                    <Filter class="h-4 w-4" />
                    <span class="ml-1 hidden sm:block">Filters</span>
                </Button>
            </div>
            <Button @click="addClass(params.centre_id)" v-if="$page.props.can.create_classes">
                <PlusCircle class="h-4 w-4" />
                <span class="ml-1 hidden sm:block">New Class</span>
            </Button>
        </div>
        <Card>
            <template #content>
                <Table>
                    <TableHeader class="bg-gray-100">
                        <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Programme</TableHead>
                        <TableHead>Level</TableHead>
                        <TableHead>Day</TableHead>
                        <TableHead>Time</TableHead>
                        <TableHead>Type</TableHead>
                        <TableHead class="text-center">Status</TableHead>
                        <TableHead class="text-center">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!$page.props.classes.data.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="classes, index in $page.props.classes.data">
                            <TableCell class="cursor-pointer" @click="editClass(classes.id)">{{ $page.props.classes.from + index }}</TableCell>
                            <TableCell class="cursor-pointer" @click="editClass(classes.id)">{{ classes.programme_name }}</TableCell>
                            <TableCell class="cursor-pointer" @click="editClass(classes.id)">{{ classes.level }}</TableCell>
                            <TableCell class="cursor-pointer" @click="editClass(classes.id)">{{ classes.class_day }}</TableCell>
                            <TableCell class="cursor-pointer" @click="editClass(classes.id)">
                                {{ moment(classes.start_time).format('h:mm A') }} - {{ moment(classes.end_time).format('h:mm A') }}
                            </TableCell>
                            <TableCell class="cursor-pointer" @click="editClass(classes.id)">{{ classes.type }}</TableCell>
                            <TableCell class="text-center cursor-pointer" @click="editClass(classes.id)">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="classes.status == 1 ? ' bg-green-100 text-green-800' : ' bg-red-100 text-red-800'"> {{ classes.status == 1 ? 'Active' : 'Not Active' }} </span>
                            </TableCell>
                            <TableCell class="text-center">
                                <DropdownMenu>
                                    <DropdownMenuTrigger as-child>
                                    <Button size="icon" variant="outline" class="h-8 w-8">
                                        <MoreVertical class="h-3.5 w-3.5" />
                                        <span class="sr-only">More</span>
                                    </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent align="end">
                                        <DropdownMenuItem v-if="$page.props.can.edit_classes" @click="editClass(classes.id)">Edit</DropdownMenuItem>
                                        <DropdownMenuItem v-if="$page.props.can.delete_classes" @click="deleteClass(classes.id)">Delete</DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Pagination :page_data="$page.props.classes" :params="params"></Pagination>
        <DeleteConfirmation :open="confirmation.is_open" @close="confirmation.is_open = false" :routeName="confirmation.route_name" :id="confirmation.id">
            <template #title>Delete Class</template>
            <template #description>Are you sure want to delete this class?</template>
        </DeleteConfirmation>
        <div class="py-4 px-4">
            <div class="flex justify-end mb-3" v-if="$page.props.can.create_products">
                <BreezeButton :url="route('products.create')">Add New Product</BreezeButton>
            </div>
            <hr class="my-3 border border-dashed border-gray-400">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-2 mb-3">
                <div class="relative w-full">
                    <svg class="absolute top-2.5 left-3 h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <input type="text" class="h-10 border-2 border-gray-300 w-full appearance-none focus:ring-0 focus:border-gray-300 py-1 pl-10 pr-4 text-gray-700 bg-white rounded-md" v-debounce:800ms="search" v-model="params.search">
                </div>
            </div>
            <div class="overflow-x-auto">
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
                                        No Record Found
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
                    <Pagination :page_data="$page.props.products" :params="params"></Pagination>
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
import moment from 'moment';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue'
import { debounce } from 'vue-debounce'
import { MagnifyingGlassIcon } from '@radix-icons/vue'
import { MoreVertical, PlusCircle, Filter } from 'lucide-vue-next';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import DropdownMenu from '@/Components/ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuTrigger from '@/Components/ui/dropdown-menu/DropdownMenuTrigger.vue';
import DropdownMenuContent from '@/Components/ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '@/Components/ui/dropdown-menu/DropdownMenuItem.vue';
import Card from '@/Components/Card.vue'
import DeleteConfirmation from '@/Components/DeleteConfirmation.vue';

export default {
    components: {
        Pagination, DeleteConfirmation, Head, Link, Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow,
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
