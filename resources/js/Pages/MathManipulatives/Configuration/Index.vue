<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Math Manipulatives" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="flex items-center justify-end space-x-2">
            <Button @click="$inertia.get(route('math_manipulatives.configuration.create'))">
                <PlusCircle class="h-4 w-4" />
                <span class="ml-1 hidden sm:block">New Math Manipulative</span>
            </Button>
        </div>
        <Card>
            <template #content>
                <Table>
                    <TableHeader class="bg-gray-100">
                        <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Title</TableHead>
                        <TableHead>Folder Name</TableHead>
                        <TableHead>Date Upload</TableHead>
                        <TableHead class="text-center">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!$page.props.math_manipulatives.data.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="info, index in $page.props.math_manipulatives.data">
                            <TableCell>{{ $page.props.math_manipulatives.from + index }}</TableCell>
                            <TableCell>{{ info.name }}</TableCell>
                            <TableCell>{{ info.folder_name }}</TableCell>
                            <TableCell>{{ moment(info.created_at, "HH:mm:ss").format('DD/MM/Y') }}</TableCell>
                            <TableCell class="text-center space-x-2">
                                <Button variant="destructive" @click="deleteFolder(info.id)">Delete</Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Pagination :page_data="$page.props.math_manipulatives" :params="params"></Pagination>
        <DeleteConfirmation :open="confirmation.is_open" @close="confirmation.is_open = false" :routeName="confirmation.route_name" :id="confirmation.id">
            <template #title>Delete Math Manipulative</template>
            <template #description>Are you sure want to delete this math manipulative?</template>
        </DeleteConfirmation>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import moment from 'moment';
import { PlusCircle } from 'lucide-vue-next';
import Card from '@/Components/Card.vue'
import Pagination from '@/Components/Pagination.vue'
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import DeleteConfirmation from '@/Components/DeleteConfirmation.vue';   

export default {
    components: {
        Head, Link
    },
    data(){
        return{
            confirmation: {
                is_open: false,
                route_name: '',
                id: ''
            },
            params: {
                search: ''
            }
        }
    },
    watch: {
    },
    methods: {
        openNewTab(){
            window.open(route('math_manipulatives.play'), '_blank')
        },
        deleteFolder(math_manipulative_id){
            this.confirmation.route_name    = 'math_manipulatives.configuration.delete'
            this.confirmation.id            = math_manipulative_id
            this.confirmation.is_open       = true
        }
    }
}
</script>