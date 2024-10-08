<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Centres" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="flex items-center justify-between space-x-1">
            <div class="relative">
                <MagnifyingGlassIcon class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
                <Input type="text" placeholder="Search" class="w-full rounded-lg bg-background pl-8 md:w-[200px] lg:w-[336px]" v-debounce:800ms="search" v-model="params.search"/>
            </div>
            <Button @click="$inertia.get(route('centres.create'))" v-if="$page.props.can.create_centres">
                <PlusCircle class="h-4 w-4" />
                <span class="ml-1 hidden sm:block">New Centre</span>
            </Button>
        </div>
        <Card>
            <template #content>
                <Table>
                    <TableHeader class="bg-gray-100">
                        <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Address</TableHead>
                        <TableHead>Country</TableHead>
                        <TableHead class="text-center">Status</TableHead>
                        <TableHead class="text-center">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!$page.props.centres.data.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found 
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="centre, index in $page.props.centres.data">
                            <TableCell>{{ $page.props.centres.from + index }}</TableCell>
                            <TableCell>{{ centre.centre_name }}</TableCell>
                            <TableCell>{{ centre.centre_address ? centre.centre_address : 'Not Available'}}</TableCell>
                            <TableCell>{{ centre.country_name ? centre.country_name : 'Not Set' }}</TableCell>
                            <TableCell class="text-center">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full whitespace-nowrap" :class="centre.centre_status == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"> {{ centre.centre_status == 1 ? 'Active' : 'Not Active' }} </span>
                            </TableCell>
                            <TableCell class="text-center">
                                <div class="flex items center justify-center space-x-2">
                                    <Button variant="outline" v-if="$page.props.can.edit_centres" @click="editCentre(centre.centre_id)">Edit</Button>
                                    <Button variant="destructive" v-if="$page.props.can.delete_centres" @click="deleteCentre(centre.centre_id)">Delete</Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Pagination :page_data="$page.props.centres" :params="params"></Pagination>
        <DeleteConfirmation :open="confirmation.is_open" @close="confirmation.is_open = false" :routeName="confirmation.route_name" :id="confirmation.id">
            <template #title>Delete Centre</template>
            <template #description>Are you sure want to delete this centre?</template>
        </DeleteConfirmation>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue'
import { debounce } from 'vue-debounce'
import { MagnifyingGlassIcon } from '@radix-icons/vue'
import { MoreVertical, PlusCircle } from 'lucide-vue-next';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import DropdownMenu from '@/Components/ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuTrigger from '@/Components/ui/dropdown-menu/DropdownMenuTrigger.vue';
import DropdownMenuContent from '@/Components/ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '@/Components/ui/dropdown-menu/DropdownMenuItem.vue';
import Card from '@/Components/Card.vue'
import DeleteConfirmation from '@/Components/DeleteConfirmation.vue';

export default {
    components: {
        Pagination, DeleteConfirmation, Head, Link,Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow,
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
        deleteCentre(id){
            this.confirmation.route_name    = 'centres.destroy'
            this.confirmation.id            = id
            this.confirmation.is_open       = true
        },
        editCentre(centre_id){
            this.$inertia.get(route('centres.edit'), {centre_id: centre_id}, { preserveState: true})
        },
        search(){
            this.$inertia.get(this.route('centres'), this.params, { replace: true, preserveState: true});
        }
    }
}
</script>
