<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Diagnostic Test" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="flex items-center justify-between space-x-2">
            <div class="flex justify-between space-x-2">
                <div class="relative">
                    <MagnifyingGlassIcon class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
                    <Input type="text" placeholder="Search" class="w-full rounded-lg bg-background pl-8 md:w-[200px] lg:w-[336px]" v-debounce:800ms="search" v-model="params.search"/>
                </div>
                <Button class="border border-slate-700 border-dashed bg-white text-slate-800 hover:bg-slate-50" @click="showFilters()"> 
                    <Filter class="h-4 w-4" />
                    <span class="ml-1 hidden sm:block">Filters</span>
                </Button>
                <Button class="" @click="$inertia.get(route('dt.settings.languages'))"> 
                    <Languages class="h-4 w-4" />
                    <span class="ml-1 hidden sm:block">Languages Setting</span>
                </Button>
            </div>
            <Button @click="$inertia.get(route('dt.settings.create'))" v-if="$page.props.can.view_diagnostic_test">
                <PlusCircle class="h-4 w-4" />
                <span class="ml-1 hidden sm:block">New Diagnostic Test</span>
            </Button>
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-5 gap-2" v-if="show_filters">
            <ComboBox :canClear="true" :items="$page.props.languages" label-property="name" value-property="id" @select="search" v-model="params.language_id" select-placeholder="Languages" search-placeholder="Search language..."></ComboBox>
            <ComboBox :canClear="true" :items="$page.props.ages" label-property="name" value-property="id" @select="search" v-model="params.age_id" select-placeholder="Ages" search-placeholder="Search age..."></ComboBox>
            <div class="">
                <Button @click="$inertia.get(route('dt.settings'))">Clear Search</Button>
            </div>
        </div>
        <Card>
            <template #content>
                <Table>
                    <TableHeader class="bg-gray-100">
                        <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Age</TableHead>
                        <TableHead>Language</TableHead>
                        <TableHead class="text-center">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!$page.props.diagnostic_test_list.data.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="diagnostic_test_list, index in $page.props.diagnostic_test_list.data">
                            <TableCell>{{ $page.props.diagnostic_test_list.from + index }}</TableCell>
                            <TableCell>{{ diagnostic_test_list.name }}</TableCell>
                            <TableCell>{{ diagnostic_test_list.age }}</TableCell>
                            <TableCell>{{ diagnostic_test_list.language }}</TableCell>
                            <TableCell class="text-center space-x-2">
                                <Button variant="outline" v-if="$page.props.can.view_diagnostic_test" @click="editDiagnosticTest(diagnostic_test_list.id)">Edit</Button>
                                <Button v-if="$page.props.can.view_diagnostic_test" @click="viewDiagnosticTest(diagnostic_test_list.id)">Details</Button>
                                <Button variant="destructive" v-if="$page.props.can.view_diagnostic_test" @click="deleteDiagnosticTest(diagnostic_test_list.id)">Delete</Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Pagination :page_data="$page.props.diagnostic_test_list" :params="params"></Pagination>
        <DeleteConfirmation :open="confirmation.is_open" @close="confirmation.is_open = false" :routeName="confirmation.route_name" :id="confirmation.id">
            <template #title>Delete Diagnostic Test</template>
            <template #description>Are you sure want to delete this diagnostic test?</template>
        </DeleteConfirmation>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { MagnifyingGlassIcon } from '@radix-icons/vue'
import { Filter, PlusCircle, Languages } from 'lucide-vue-next';
import Card from '@/Components/Card.vue'
import Pagination from '@/Components/Pagination.vue'
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import DeleteConfirmation from '@/Components/DeleteConfirmation.vue';   

export default {
    components: {
        Head, Link, Pagination
    },
    data() {
        return {
            show_filters: false,
            confirmation: {
                is_open: false,
                route_name: '',
                id: ''
            },
            params: {
                search: this.$page.props.filter.search ? this.$page.props.filter.search : '',
                language_id: this.$page.props.filter.language_id ? this.$page.props.filter.language_id : '',
                age_id: this.$page.props.filter.age_id ? this.$page.props.filter.age_id : '',
            }
        };
    },
    props: {
        diagnostic_test_list: Object,
    },
    methods: {
        editDiagnosticTest(dt_id){
            this.$inertia.get(route('dt.settings.edit'), {'dt_id': dt_id})
        },
        viewDiagnosticTest(dt_id){
            this.$inertia.get(route('dt.settings.details'), {'dt_id': dt_id})
        },
        deleteDiagnosticTest(dt_id){
            this.confirmation.route_name    = 'dt.settings.destroy'
            this.confirmation.id            = dt_id
            this.confirmation.is_open       = true
        },
        search(){
            this.$inertia.get(this.route('dt.settings'), this.params, { replace: true, preserveState: true});
        },
        showFilters(){
            this.show_filters = !this.show_filters
        },
    }

}
</script>
                                