<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Countries" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="flex items-center justify-between">
            <div class="relative">
                <MagnifyingGlassIcon class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
                <Input type="text" placeholder="Search" class="w-full rounded-lg bg-background pl-8 md:w-[200px] lg:w-[336px]" v-debounce:800ms="search" v-model="params.search"/>
            </div>
            <Button @click="$inertia.get(route('countries.create'))" v-if="$page.props.can.create_country">
                <PlusCircle class="h-4 w-4" />
                <span class="ml-1 hidden sm:block">New Country</span>
            </Button>
        </div>
        <Card>
            <template #content>
                <Table>
                    <TableHeader class="bg-gray-100">
                        <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Country Code</TableHead>
                        <TableHead>Currency Name</TableHead>
                        <TableHead>Currency Code</TableHead>
                        <TableHead>Currency Symbol</TableHead>
                        <TableHead>Calling Code</TableHead>
                        <TableHead class="text-center">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!$page.props.country_list.data.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="country_list, index in $page.props.country_list.data">
                            <TableCell>{{ $page.props.country_list.from + index }}</TableCell>
                            <TableCell>{{ country_list.name }}</TableCell>
                            <TableCell>{{ country_list.country_code }}</TableCell>
                            <TableCell class="capitalize">{{ country_list.currency_name }}</TableCell>
                            <TableCell>{{ country_list.currency_code }}</TableCell>
                            <TableCell>{{ country_list.currency_symbol }}</TableCell>
                            <TableCell>{{ country_list.calling_code }}</TableCell>
                            <TableCell class="text-center">
                                <Button variant="destructive" v-if="$page.props.can.delete_country" @click="deleteCountry(country_list.id)">Delete</Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Pagination :page_data="$page.props.country_list" :params="params"></Pagination>
        <DeleteConfirmation :open="confirmation.is_open" @close="confirmation.is_open = false" :routeName="confirmation.route_name" :id="confirmation.id">
            <template #title>Delete Country</template>
            <template #description>Are you sure want to delete this country?</template>
        </DeleteConfirmation>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue'
import { debounce } from 'vue-debounce'
import { MagnifyingGlassIcon } from '@radix-icons/vue'
import { PlusCircle } from 'lucide-vue-next';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import Card from '@/Components/Card.vue'
import DeleteConfirmation from '@/Components/DeleteConfirmation.vue';   

export default {
    components: {
        Pagination, DeleteConfirmation, Head, Link, Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow,
    },
    data() {
        return {
            confirmation: {
                is_open: false,
                route_name: '',
                id: ''
            },
            params: {
                search: this.$page.props.filter ? this.$page.props.filter.search : '',
            },
        };
    },
    props: {
        country_list: Object,
    },
    methods: {
        deleteCountry(country_id){
            this.confirmation.route_name    = 'countries.destroy'
            this.confirmation.id            = country_id
            this.confirmation.is_open       = true
        },
        search(){
            this.$inertia.get(this.route('countries'), this.params, { replace: true, preserveState: true});
        }
    }

}
</script>
                                