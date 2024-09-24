<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Students" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <Tabs :centre_id="params.centre_id"></Tabs>
        <div class="flex items-center justify-between">
            <div class="flex space-x-2">
                <div class="relative">
                    <MagnifyingGlassIcon class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
                    <Input type="text" placeholder="Search" class="w-full rounded-lg bg-background pl-8 md:w-[200px] lg:w-[336px]" v-debounce:800ms="search" v-model="params.search"/>
                </div>
            </div>
            <Button @click="newAdmission" v-if="$page.props.can.create_students">
                <PlusCircle class="h-4 w-4" />
                <span class="ml-1 hidden sm:block">New Admission</span>
            </Button>
        </div>
        <Card>
            <template #content>
                <Table>
                    <TableHeader class="bg-gray-100">
                        <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Parent</TableHead>
                        <TableHead class="text-center">Status</TableHead>
                        <TableHead class="text-center">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!$page.props.students.data.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="student, index in $page.props.students.data">
                            <TableCell>{{ $page.props.students.from + index }}</TableCell>
                            <TableCell>{{ student.name }}</TableCell>
                            <TableCell>{{ student.parent_name }}</TableCell>
                            <TableCell class="text-center">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="student.status == true ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"> {{ student.status == true ? 'Active' : 'Inactive' }}</span>
                            </TableCell>
                            <TableCell class="text-center">
                                <Button variant="outline" v-if="$page.props.can.edit_students" @click="editStudent(student.id)">Edit</Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Pagination :page_data="$page.props.students" :params="params"></Pagination>
    </BreezeAuthenticatedLayout>
</template>



<script>
import { MagnifyingGlassIcon } from '@radix-icons/vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import { PlusCircle } from 'lucide-vue-next';
import Tabs from './Tabs.vue'
import Card from '@/Components/Card.vue'
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import Pagination from '@/Components/Pagination.vue'
import { debounce } from 'vue-debounce'

export default {
    components: {
        Head, Link, Pagination, Tabs
    },
    data(){
        return{
            params: {
                search: this.$page.props.filter.search ? this.$page.props.filter.search : '',
                centre_id: this.$page.props.filter.centre_id ? this.$page.props.filter.centre_id : '',
            }
        }
    },
    methods: {
        newAdmission(centreID){
            this.$inertia.get(this.route('students.create'), {'centre_id': centreID});
        },
        editStudent(studentID){
            this.$inertia.get(this.route('students.edit'), {'student_id': studentID});
        },
        search(){
            this.$inertia.get(this.route('students.unassigned'), this.params, { replace: true, preserveState: true});
        }
    }
}
</script>
