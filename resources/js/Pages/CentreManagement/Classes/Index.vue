<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Classes" />

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
                    <span class="ml-1 hidden sm:block">Filter</span>
                </Button>
            </div>
            <Button @click="addClass(params.centre_id)" v-if="$page.props.can.create_classes">
                <PlusCircle class="h-4 w-4" />
                <span class="ml-1 hidden sm:block">New Class</span>
            </Button>
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-5 gap-2" v-if="show_filters">
            <ComboBox :items="$page.props.allowed_centres" label-property="label" value-property="ID" @select="search" v-model="params.centre_id" select-placeholder="Select Centre" search-placeholder="Search centre..."></ComboBox>
            <ComboBox :items="$page.props.days_of_the_week" label-property="name" value-property="id" @select="search" v-model="params.day" select-placeholder="Day of the Week" search-placeholder="Search day..."></ComboBox>
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
    props: {
        filter: Object,
    },
    data(){
        return{
            show_filters: false,
            confirmation: {
                is_open: false,
                route_name: '',
                id: ''
            },
            params: {
                search: this.$page.props.filter.search ? this.$page.props.filter.search : '',
                centre_id: this.$page.props.filter.centre_id ? Number(this.$page.props.filter.centre_id) : '',
                day: this.$page.props.filter.day ? Number(this.$page.props.filter.day) : '',
            }
        }
    },
    methods: {
        addClass(centreID){
            this.$inertia.get(this.route('classes.create'), {'centre_id': centreID});
        },
        editClass(classID){
            this.$inertia.get(this.route('classes.edit'), {'class_id': classID});
        },
        deleteClass(class_id){
            this.confirmation.route_name    = 'classes.destroy'
            this.confirmation.id            = class_id
            this.confirmation.is_open       = true
        },
        showFilters(){
            this.show_filters = !this.show_filters
        },
        search(){
            this.$inertia.get(this.route('classes'), this.params, { replace: true, preserveState: true});
        }
    }
}
</script>
