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
            </div>
            <Button @click="$inertia.get(route('products.create'))" v-if="$page.props.can.create_products">
                <PlusCircle class="h-4 w-4" />
                <span class="ml-1 hidden sm:block">New Product</span>
            </Button>
        </div>
        <Card>
            <template #content>
                <Table>
                    <TableHeader class="bg-gray-100">
                        <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Description</TableHead>
                        <TableHead class="text-center">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!$page.props.products.data.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="product, index in $page.props.products.data">
                            <TableCell class="cursor-pointer" @click="editProduct(product.id)">{{ $page.props.products.from + index }}</TableCell>
                            <TableCell class="cursor-pointer" @click="editProduct(product.id)">{{ product.name }}</TableCell>
                            <TableCell class="cursor-pointer" @click="editProduct(product.id)">{{ product.description }}</TableCell>
                            <TableCell class="text-center">
                                <DropdownMenu>
                                    <DropdownMenuTrigger as-child>
                                    <Button size="icon" variant="outline" class="h-8 w-8">
                                        <MoreVertical class="h-3.5 w-3.5" />
                                        <span class="sr-only">More</span>
                                    </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent align="end">
                                        <DropdownMenuItem v-if="$page.props.can.edit_products" @click="editProduct(product.id)">Edit</DropdownMenuItem>
                                        <DropdownMenuItem v-if="$page.props.can.delete_products" @click="deleteProduct(product.id)">Delete</DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Pagination :page_data="$page.props.products" :params="params"></Pagination>
        <DeleteConfirmation :open="confirmation.is_open" @close="confirmation.is_open = false" :routeName="confirmation.route_name" :id="confirmation.id">
            <template #title>Delete Product</template>
            <template #description>Are you sure want to delete this product?</template>
        </DeleteConfirmation>
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
            confirmation: {
                is_open: false,
                route_name: '',
                id: ''
            },
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
            this.confirmation.route_name    = 'products.destroy'
            this.confirmation.id            = product_id
            this.confirmation.is_open       = true
        },
        search(){
            this.$inertia.get(this.route('products'), this.params, { replace: true, preserveState: true});
        }
    }
}
</script>
