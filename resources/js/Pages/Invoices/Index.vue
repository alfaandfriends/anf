<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Fee Invoices" />

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
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-5 gap-2" v-if="show_filters">
            <ComboBox :items="$page.props.allowed_centres" label-property="label" value-property="ID" @select="search" v-model="params.centre_id" select-placeholder="Centres" search-placeholder="Search centre..."></ComboBox>
            <ComboBox :items="$page.props.programmes" label-property="name" value-property="id" @select="search" v-model="params.programme_id" :canClear="true" select-placeholder="Programmes" search-placeholder="Search programme..."> 
                <template #label="{ item }">
                    {{ item.name }} ({{ item.country_name }})
                </template>
                <template #label-content="{ selectedItem, selectedItems, multiple }">
                    <span v-if="selectedItem">{{ selectedItem.name }} ({{ selectedItem.country_name }})</span>
                </template>
            </ComboBox>
            <div>
                <Datepicker v-model="params.date" mode="month" format="MMM Y" @select="search"></Datepicker>
            </div>
            <div class="">
                <Button @click="$inertia.get(route('fee.invoices'))">Clear Search</Button>
            </div>
        </div>
        <Card>
            <template #content>
                <Table>
                    <TableHeader class="bg-gray-100">
                        <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Student Name</TableHead>
                        <TableHead>Invoice No.</TableHead>
                        <TableHead>Date Issued</TableHead>
                        <TableHead>Due Date</TableHead>
                        <TableHead>Amount</TableHead>
                        <TableHead class="text-center">Status</TableHead>
                        <TableHead class="text-center">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!$page.props.invoices.data.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="invoice, index in $page.props.invoices.data">
                            <TableCell>{{ $page.props.invoices.from + index }}</TableCell>
                            <TableCell>{{ invoice.student_name }}</TableCell>
                            <TableCell>
                                <Badge variant="">#{{ invoice.invoice_number }}</Badge>
                            </TableCell>
                            <TableCell>{{ moment(invoice.date_issued).format('DD MMM Y') }}</TableCell>
                            <TableCell>{{ moment(invoice.due_date).format('DD MMM Y') }}</TableCell>
                            <TableCell>{{ invoice.amount }}</TableCell>
                            <TableCell class="text-center" @click="editInvoice(invoice.id)">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="[invoice.status_bg_color, invoice.status_text_color]"> {{ invoice.status }} </span>
                            </TableCell>
                            <TableCell class="text-center">
                                <Button variant="outline" v-if="$page.props.can.edit_fee_invoices" @click="editInvoice(invoice.id)">Edit</Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Pagination :page_data="$page.props.invoices" :params="params"></Pagination>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { MagnifyingGlassIcon } from '@radix-icons/vue'
import { Filter } from 'lucide-vue-next';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Card from '@/Components/Card.vue'
import { Badge } from "@/Components/ui/badge"
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import Pagination from '@/Components/Pagination.vue'
import moment from 'moment';
import { debounce } from 'vue-debounce'


export default {
    components: {
        Head, Link, Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow,
    },
    data(){
        return{
            show_filters: false,
            open_modal: false,
            params: {
                search: this.$page.props.filter.search ? this.$page.props.filter.search : '',
                centre_id: this.$page.props.filter.centre_id ? parseInt(this.$page.props.filter.centre_id) : '',
                programme_id: this.$page.props.filter.programme_id ? parseInt(this.$page.props.filter.programme_id) : '',
                date: this.$page.props.filter.date ? this.$page.props.filter.date : { month: new Date().getMonth(), year: new Date().getFullYear() },
            },
            invoice_data: {
                parent_name: '',
                parent_address: '',
                invoice_number: '',
                invoice_items: [],
                date_issued: '',
                due_date: '',
                total_amount: ''
            }
        }
    },
    methods: {
        editInvoice(invoice_id){
            this.$inertia.get(route('fee.invoices.edit'), {'invoice_id':invoice_id, 'params': this.params}, {preserveState: false})
        },
        search(){
            this.$inertia.get(route('fee.invoices'), this.params, { replace: true, preserveState: true})
        },
        showFilters(){
            this.show_filters = !this.show_filters
        },
    },
}
</script>