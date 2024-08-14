<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Orders" />

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
            <Button @click="$inertia.get(route('orders.create'))" v-if="$page.props.can.create_orders">
                <PlusCircle class="h-4 w-4" />
                <span class="ml-1 hidden sm:block">New Order</span>
            </Button>
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-5 gap-2" v-if="show_filters">
            <ComboBox :items="$page.props.status" label-property="name" value-property="id" @select="search" v-model="params.status" select-placeholder="Select Status" can-clear="true" search-placeholder="Search status..."></ComboBox>
        </div>
        <Card>
            <template #content>
                <Table>
                    <TableHeader class="bg-gray-100">
                        <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Date</TableHead>
                        <TableHead>Attachments</TableHead>
                        <TableHead>Shipment Tracking</TableHead>
                        <TableHead class="text-center">Status</TableHead>
                        <TableHead class="text-center">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!$page.props.orders.data.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="order, index in $page.props.orders.data">
                            <TableCell>{{ $page.props.orders.from + index }}</TableCell>
                            <TableCell>
                                <div class="flex flex-col">
                                    <span class='font-medium'>{{ order.parent_full_name }}</span>
                                    <small class="font-medium text-muted-foreground">{{ order.parent_calling_code }}{{ order.parent_contact }}</small>
                                </div>
                            </TableCell>
                            <TableCell>{{ moment(order.created_at).format('DD/MM/Y') }}</TableCell>
                            <TableCell class="cursor-pointer space-x-1">
                                <Badge variant="outline" class="px-3 py-1 hover:bg-slate-900 hover:text-white" @click="viewInvoice(order.id, index)">
                                    <Download class="h-3 w-3 mr-2"/>{{ generating[index].invoice ? 'Generating...' : 'Invoice'}}
                                </Badge>
                                <Badge variant="outline" class="px-3 py-1 hover:bg-slate-900 hover:text-white" @click="viewPackingSlip(order.id, index)">
                                    <Download class="h-3 w-3 mr-2"/>{{ generating[index].packing_slip ? 'Generating...' : 'Packing Slip'}}
                                </Badge>
                            </TableCell>
                            <TableCell>
                                <Badge variant="secondary" v-if="order.shipping_provider_name">{{ order.shipping_provider_name }} - {{ order.tracking_number }}</Badge>
                                <Badge variant="secondary" v-else>No Tracking Available</Badge>
                            </TableCell>
                            <TableCell class="text-center cursor-pointer">
                                <Badge>{{ order.status_name }}</Badge>
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
                                        <DropdownMenuItem v-if="$page.props.can.edit_orders" @click="editOrder(order.id)">Edit</DropdownMenuItem>
                                        <DropdownMenuItem v-if="$page.props.can.delete_orders" @click="deleteOrder(order.id)">Delete</DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Pagination :page_data="$page.props.orders" :params="params"></Pagination>
        <DeleteConfirmation :open="confirmation.is_open" @close="confirmation.is_open = false" :routeName="confirmation.route_name" :id="confirmation.id">
            <template #title>Delete Order</template>
            <template #description>Are you sure want to delete this order?</template>
        </DeleteConfirmation>
    </BreezeAuthenticatedLayout>
</template>

<script>
import moment from 'moment';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue'
import { debounce } from 'vue-debounce'
import { MagnifyingGlassIcon } from '@radix-icons/vue'
import { MoreVertical, PlusCircle, Filter, Download } from 'lucide-vue-next';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import DropdownMenu from '@/Components/ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuTrigger from '@/Components/ui/dropdown-menu/DropdownMenuTrigger.vue';
import DropdownMenuContent from '@/Components/ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '@/Components/ui/dropdown-menu/DropdownMenuItem.vue';
import Card from '@/Components/Card.vue'
import DeleteConfirmation from '@/Components/DeleteConfirmation.vue';
import { Badge } from '@/Components/ui/badge'

export default {
    components: {
        Pagination, DeleteConfirmation, Head, Link, Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow,
    },
    data(){
        return{
            show_filters: false,
            show_invoice: false,
            show_packing_slip: false,
            show_delete_order: false,
            confirmation_data: '',
            show_tracking_status: false,
            tracking_status: [],
            confirmation: {
                is_open: false,
                route_name: '',
                id: ''
            },
            params: {
                search: this.$page.props.filter.search ? this.$page.props.filter.search : '',
                status: this.$page.props.filter.status ? this.$page.props.filter.status : '',
            },
            invoice_data: [],
            packing_slip_data: [],
            generating: []
        }
    },
    methods: {
        viewTrackingStatus(tracking_status){
            this.tracking_status    =   JSON.parse(tracking_status)
            this.show_tracking_status = true
        },
        editOrder(order_id){
            this.$inertia.get(route('orders.edit'), {order_id: order_id})
        },
        deleteOrder(order_id){
            this.confirmation.route_name    = 'orders.destroy'
            this.confirmation.id            = order_id
            this.confirmation.is_open       = true
        },
        viewInvoice(order_id, index){
            if(this.generating[index].invoice){
                return
            }
            this.generating[index].invoice = true
            axios.get(route('orders.invoice.generate'), {
                responseType: 'blob', // Set the response type to 'blob' to handle binary data
                params: {
                    'order_id': order_id
                }
            })
            .then(response => {
                // Create a Blob object from the response data
                const blob = new Blob([response.data], { type: 'application/pdf' });

                // Create a URL for the Blob object
                const pdfUrl = URL.createObjectURL(blob);

                // Open the PDF in a new tab
                window.open(pdfUrl, '_blank');
                this.generating[index].invoice = false
            })
            .catch(error => {
                console.error('Error fetching PDF:', error);
                this.generating[index].invoice = false
            });
            // this.invoice_data = this.$page.props.orders.data[index]
            // this.show_invoice = true
        },
        viewPackingSlip(order_id, index){
            if(this.generating[index].packing_slip){
                return
            }
            this.generating[index].packing_slip = true
            axios.get(route('orders.packing_slip.generate'), {
                responseType: 'blob', // Set the response type to 'blob' to handle binary data
                params: {
                    'order_id': order_id
                }
            })
            .then(response => {
                // Create a Blob object from the response data
                const blob = new Blob([response.data], { type: 'application/pdf' });

                // Create a URL for the Blob object
                const pdfUrl = URL.createObjectURL(blob);

                // Open the PDF in a new tab
                window.open(pdfUrl, '_blank');
                this.generating[index].packing_slip = false
            })
            .catch(error => {
                console.error('Error fetching PDF:', error);
                this.generating[index].packing_slip = false
            });
            // this.packing_slip_data = this.$page.props.orders.data[index]
            // this.show_packing_slip = true
        },
        showFilters(){
            this.show_filters = !this.show_filters
        },
        search(){
            this.$inertia.get(this.route('orders'), this.params, { replace: true, preserveState: true});
        }
    },
    created(){
        this.$page.props.orders.data.forEach(element => {
            this.generating.push({
                invoice: false,
                packing_slip: false
            })
        });
    }
}
</script>
