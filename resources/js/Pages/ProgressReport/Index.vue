<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Progress Report" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="flex items-center justify-between">
            <div class="flex justify-between space-x-2">
                <div class="relative">
                    <MagnifyingGlassIcon class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
                    <Input type="text" placeholder="Search" class="w-full rounded-lg bg-background pl-8 md:w-[200px] lg:w-[336px]" v-debounce:800ms="search" v-model="params.search"/>
                </div>
                <Button class="border border-slate-700 border-dashed bg-white text-slate-800 hover:bg-slate-50" @click="showFilters()"> 
                    <Filter class="h-4 w-4" />
                    <span class="ml-1 hidden sm:block">Filters</span>
                </Button>
                <Button @click="$inertia.get(route('progress_report.settings'))"> 
                    <Cog class="h-4 w-4" />
                    <span class="ml-1 hidden sm:block">Setting</span>
                </Button>
            </div>
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-5 gap-2" v-if="show_filters">
            <ComboBox :items="$page.props.allowed_centres" label-property="label" value-property="ID" @select="search" v-model="params.centre_id" select-placeholder="Centres" search-placeholder="Search centre..."></ComboBox>
            <ComboBox canClear :items="$page.props.programmes" label-property="name" value-property="id" @select="search" v-model="params.programme_id" select-placeholder="Programmes" search-placeholder="Search programme...">
                <template #label="{ item }">
                    {{ item.name }} ({{ item.country_name }})
                </template>
                <template #label-content="{ selectedItem, selectedItems, multiple }">
                    <span v-if="selectedItem">{{ selectedItem.name }} ({{ selectedItem.country_name }})</span>
                </template>
            </ComboBox>
            <ComboBox canClear :items="$page.props.levels" label-property="level" value-property="level" @select="search" v-model="params.programme_level" select-placeholder="Level" search-placeholder="Search level...">
                <template #label="{ item }">
                    Level {{ item.level }}
                </template>
                <template #label-content="{ selectedItem, selectedItems, multiple }">
                    <span v-if="selectedItem">Level {{ selectedItem.level }}</span>
                </template>
            </ComboBox>
            <div>
                <Datepicker v-model="params.date" mode="month" format="MMM Y" @select="search"></Datepicker>
            </div>
            <div class="">
                <Button @click="$inertia.get(route('progress_report'))">Clear Search</Button>
            </div>
        </div>
        <Card>
            <template #content>
                <Table>
                    <TableHeader class="bg-gray-100">
                        <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Centre</TableHead>
                        <TableHead>Month / Year</TableHead>
                        <TableHead>Total Present</TableHead>
                        <TableHead>Total Absent</TableHead>
                        <TableHead class="text-center">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!$page.props.progress_reports.data.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="result, index in $page.props.progress_reports.data">
                            <TableCell>{{ $page.props.progress_reports.from + index }}</TableCell>
                            <TableCell>
                                {{ result.student_name }}
                                <div class="flex space-x-1">
                                    <Badge>
                                        <span>{{ result.programme_name }}</span>
                                    </Badge>
                                    <Badge variant="outline">
                                        <span>Level {{ result.programme_level }}</span>
                                    </Badge>
                                </div>
                            </TableCell>
                            <TableCell>{{ result.centre_name }}</TableCell>
                            <TableCell>{{ moment(result.month).format('MMMM Y') }}</TableCell>
                            <TableCell>{{ result.total_present + '/' + result.total_class }}</TableCell>
                            <TableCell>{{ result.total_absent + '/' + result.total_class }}</TableCell>
                            <TableCell class="text-center">
                                <div class="flex justify-center space-x-2">
                                    <Button variant="outline" @click="viewProgressReport(result.progress_report_id)" v-if="$page.props.can.view_progress_report">Edit</Button>
                                    <Button variant="destructive" @click="showProgressReport(result.progress_report_id)" v-if="$page.props.can.view_progress_report">{{ generate.id == result.progress_report_id && generate.running ? 'Generating...'  : 'Generate'}}</Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Pagination :page_data="$page.props.progress_reports" :params="params"></Pagination>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { MagnifyingGlassIcon } from '@radix-icons/vue'
import { Filter, Cog } from 'lucide-vue-next';
import moment from 'moment';
import axios from 'axios';
import { Badge } from '@/Components/ui/badge'
import { debounce } from 'vue-debounce'
import Card from '@/Components/Card.vue'
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import Pagination from '@/Components/Pagination.vue'

export default {
    components: {
        Head, Link
    },
    data(){
        return{
            show_filters: false,
            generate: {
                id: '',
                running: false,
            },
            params: {
                search: this.$page.props.filter.search ? this.$page.props.filter.search : '',
                centre_id: this.$page.props.filter.centre_id ? this.$page.props.filter.centre_id : '',
                programme_id: this.$page.props.filter.programme_id ? this.$page.props.filter.programme_id : '',
                date: this.$page.props.filter.date ? this.$page.props.filter.date : { month: new Date().getMonth(), year: new Date().getFullYear() },
                programme_level: this.$page.props.filter.programme_level ? this.$page.props.filter.programme_level : '',
            },
        }
    },
    methods: {
        viewProgressReport(progress_report_id){
            this.$inertia.get(this.route('progress_report.details'), {'progress_report_id': progress_report_id}, { })
        },
        showProgressReport(progress_report_id, student_fee){
            if(this.generate.running){
                return
            }
            this.generate.running = true
            axios.get(route('progress_report.full_reports'), {
                responseType: 'blob', // Set the response type to 'blob' to handle binary data
                params: {
                    progress_report_id: progress_report_id, 
                    student_fee: student_fee
                }
            })
            .then(response => {
                // Create a Blob object from the response data
                const blob = new Blob([response.data], { type: 'application/pdf' });

                // Create a URL for the Blob object
                const pdfUrl = URL.createObjectURL(blob);

                // Open the PDF in a new tab
                window.open(pdfUrl, '_blank');
                this.generate.running = false
            })
            .catch(error => {
                console.error('Error fetching PDF:', error);
                this.generate.running = false
            });
        },
        search(){
            this.$inertia.get(this.route('progress_report'), this.params, { replace: true, preserveState: true})
        },
        showFilters(){
            this.show_filters = !this.show_filters
        },
    },
}
</script>