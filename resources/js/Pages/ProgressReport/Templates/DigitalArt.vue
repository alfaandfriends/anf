<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Progress Report" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <StudentInformation></StudentInformation>
        <Card>
            <template #title>Progress Reports</template>
            <template #content>
                <Table>
                    <TableHeader class="bg-gray-100">
                        <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Date</TableHead>
                        <TableHead>Teacher's Name</TableHead>
                        <TableHead class="text-center">Status</TableHead>
                        <TableHead class="text-center">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!$page.props.progress_reports.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="result, index in $page.props.progress_reports">
                            <TableCell>{{ index + 1 }}</TableCell>
                            <TableCell>{{ moment(result.date).format('DD/MM/Y') }}</TableCell>
                            <TableCell>{{ result.display_name }}</TableCell>
                            <TableCell class="text-center">
                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs rounded" :class="[{'bg-green-200 text-green-600': result.attendance_status == 1}, {'bg-red-200 text-red-600': result.attendance_status == 2}, {'bg-gray-200 text-gray-600': result.attendance_status == 3}]">{{ result.attendance_status_name }}</span>
                            </TableCell>
                            <TableCell class="text-center">
                                <Button variant="outline" @click="viewProgressReport(index)">Edit</Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <FeedbackSummary :report_details="$page.props.report_details"/>
        <Dialog v-model:open="show_progress_report">
            <template #title>Edit Progress Report</template>
            <template #content>
                <div class="p-1 grid grid-cols-1 gap-4">
                    <div class="">
                        <Label>Date<span class="text-red-500">*</span></Label>
                        <Datepicker v-model="form.date" mode="date" format="dd/MM/Y" :error="!form.date"></Datepicker>
                    </div>
                    <div class="mb-3">
                        <Label>Teacher's Name<span class="text-red-500">*</span></Label>
                        <ComboBox :items="list.teachers" label-property="display_name" value-property="ID" :error="form.attendance_status == 1 && !form.teacher_user_id" v-model="form.teacher_user_id" :select-placeholder="form.teacher_name" search-placeholder="Search teacher..." @search="findTeachers" :loading="loading.teachers"></ComboBox>
                    </div>
                    <div class="">
                        <Label>Theme</Label>
                        <ComboBox :items="$page.props.art_themes" label-property="name" value-property="id" v-model="search.theme_id" select-placeholder="Select Theme" search-placeholder="Search theme..." @select="getLessons(search.theme_id)"></ComboBox>
                    </div>
                    <div class="">
                        <Label>Lesson</Label>
                        <ComboBox :items="options.lessons" label-property="name" value-property="id" v-model="search.lesson_id" select-placeholder="Select Lesson" search-placeholder="Search lesson..." @select="getActivity(search.lesson_id)" :loading="loading.lessons"></ComboBox>
                    </div>
                    <div class="">
                        <Label>Activity</Label>
                        <ComboBox :items="options.activities" label-property="name" value-property="id" v-model="search.activity_id" select-placeholder="Select Activitiy" search-placeholder="Search activity..." @select="getOutcomes(search.activity_id)" :loading="loading.activities"></ComboBox>
                    </div>
                    <div class="">
                        <Label>Learning Outcome</Label>
                        <ComboBox :items="options.outcomes" label-property="name" value-property="id" v-model="search.outcome_id" select-placeholder="Select Outcome" search-placeholder="Search outcome..." @select="addItem()" :loading="loading.outcomes"></ComboBox>
                    </div>
                    <div class="mb-3">
                        <Label>Objectives</Label>
                        <div class="px-4 py-2 bg-slate-100 rounded-lg" v-if="!form.report_data.length">
                            <Label>No objectives found.</Label>
                        </div>
                        <Collapsible class=" bg-white" v-model="open_objectives" v-else v-for="data, index in form.report_data">
                            <template #trigger>
                                <div class="flex items-center space-x-2">
                                    <Label>{{ data.theme_name }} : {{ data.lesson_name }}</Label>
                                    <Label class="text-red-600 cursor-pointer" @click="deleteItem(index)">Delete</Label>
                                </div>
                            </template>
                            <template #content>
                                <div class="p-1">
                                    <div class="flex flex-col space-y-1">
                                        <Badge>
                                            <span>{{ data.activity_name }}</span>
                                        </Badge>
                                        <Badge variant="outline">
                                            <span>{{ data.outcome_name }}</span>
                                        </Badge>
                                    </div>
                                    <ul class="pt-3 divide-y">
                                        <li class="" v-for="objective, objective_index in data.objectives">
                                            <Label class="flex items-center space-x-2 py-2">
                                                <Checkbox :value="objective.id" :checked="form.report_data[index].objectives[objective_index].achieved" @click.native="form.report_data[index].objectives[objective_index].achieved = !form.report_data[index].objectives[objective_index].achieved"/>
                                                <span class="cursor-pointer">{{ objective.name }}</span> 
                                            </Label>
                                        </li>
                                    </ul>
                                </div>
                            </template>
                        </Collapsible>
                        <Label class="text-xs text-red-500 font-semibold" v-if="!form.report_data.length && form.attendance_status == 1">At least one (1) objective is required.</Label>
                    </div>
                    <div class="">
                        <Label>Comments</Label>
                        <Textarea rows="3" v-model.lazy="form.comments"></Textarea>
                    </div>
                    <div class="">
                        <Label>Status</Label>
                        <ComboBox :items="$page.props.attendance_status" label-property="name" value-property="id" :error="form.attendance_status == 3" v-model="form.attendance_status" select-placeholder="Select Status" search-placeholder="Search status..."></ComboBox>
                    </div>
                </div>
            </template>
            <template #footer>
                <Button variant="outline" @click="show_progress_report = false">Cancel</Button>
                <Button @click="updateProgressReport">Save</Button>
            </template>
        </Dialog>
    </BreezeAuthenticatedLayout>
</template>

<script>

import { Head, Link } from '@inertiajs/inertia-vue3';
import StudentInformation from '@/Pages/ProgressReport/Templates/StudentInformation.vue';
import Datepicker from '@vuepic/vue-datepicker';
import Modal from '@/Components/Modal.vue'
import moment from 'moment';
import axios from 'axios';
import Multiselect from '@vueform/multiselect'
import FeedbackSummary from './FeedbackSummary.vue'
import { debounce } from 'vue-debounce'
import Card from '@/Components/Card.vue'
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import Dialog from '@/Components/DialogModal.vue'
import Collapsible from '@/Components/Collapsible.vue'
import { Badge } from '@/Components/ui/badge'

export default {
    components: {
        Head, Link, Datepicker, Modal, Multiselect, 
    },
    data(){
        return{
            show_progress_report: false,
            open_objectives: false,
            searching: false,
            progress_report_list: {},
            disabled:{
                themes: true,
                lessons: true,
                activities: true,
                outcomes: true,
            },
            list: {
                teachers: [],
            },
            options: {
                themes: [],
                lessons: [],
                activities: [],
                outcomes: [],
                objectives: [],
            },
            loading: {
                themes: false,
                lessons: false,
                activities: false,
                outcomes: false,
                teachers: false,
            },
            search: {
                theme_id: '',
                lesson_id: '',
                activity_id: '',
                outcome_id: '',
            },
            form: {
                teacher_user_id: '',
                date: '',
                report_data: [],
                comments: '',
                attendance_status: '',
            }
        }
    },
    methods: {
        viewProgressReport(index) {
            this.clearSearch()
            this.form.report_id             =   this.$page.props.progress_reports[index].id
            this.form.teacher_user_id       =   this.$page.props.progress_reports[index].teacher_user_id
            this.form.teacher_name          =   this.$page.props.progress_reports[index].display_name
            this.form.date                  =   this.$page.props.progress_reports[index].date
            this.form.report_data           =   JSON.parse(this.$page.props.progress_reports[index].report_data) ? JSON.parse(this.$page.props.progress_reports[index].report_data) : []
            this.form.attendance_status     =   this.$page.props.progress_reports[index].attendance_status
            this.form.comments              =   this.$page.props.progress_reports[index].comments
            this.show_progress_report       =   true;
        },
        updateProgressReport() {
            if(!this.form.date || this.form.attendance_status == 3 || (this.form.attendance_status == 1 && this.form.report_data.length < 1) || (this.form.attendance_status == 1 && !this.form.teacher_user_id)){
                return
            }
            this.$inertia.post(route('progress_report.store'), this.form, {
                preserveScroll: true,
                preserveState: false,
            });
        },
        findTeachers: debounce(function(query) {
            if(query){
                this.loading.teachers = true
                axios.get(route('teachers.find'), {
                    params: {
                        'keyword': query
                    }
                })
                .then((res) => {
                    this.list.teachers = res.data
                    this.loading.teachers = false
                });
            }
        }, 1000),
        getLessons(theme_id) {
            this.loading.lessons = true;

            this.options.lessons = [];
            this.options.activities = [];
            this.options.outcomes = [];
            
            this.search.lesson_id = '';
            this.search.activity_id = '';
            this.search.outcome_id = '';

            axios.get(route('progress_report.get_art_lessons', theme_id))
            .then(response => {
                this.options.lessons  =   response.data
                this.loading.lessons = false;
            });
        },
        getActivity(lesson_id) {
            this.loading.activities = true;

            this.options.activities = [];
            this.options.outcomes = [];

            this.search.activity_id = '';
            this.search.outcome_id = '';

            axios.get(route('progress_report.get_art_activities', lesson_id))
            .then(response => {
                this.options.activities = response.data;
                this.loading.activities = false;
            });
        },
        getOutcomes(activity_id) {
            this.loading.outcomes = true;

            this.options.outcomes = [];

            this.search.outcome_id = '';

            axios.get(route('progress_report.get_art_learning_outcomes', activity_id))
            .then(response => {
                this.options.outcomes = response.data;
                this.loading.outcomes = false;
            });
        },
        addItem() {
            if(this.searching){
                return
            }
            if(this.search.theme_id && this.search.lesson_id && this.search.activity_id && this.search.outcome_id) {
                const itemExists = this.form.report_data.some(item => item.outcome_id === this.search.outcome_id);
                if(itemExists){
                    alert('Item exists!')
                }
                else{
                    this.searching = true
                    axios.get(route('progress_report.get_art_objectives', this.search.outcome_id))
                    .then(response => {
                        const new_item  =   {
                            theme_id: this.search.theme_id,
                            theme_name: this.$page.props.art_themes.find(item => item.id === this.search.theme_id)?.name,
                            lesson_id: this.search.lesson_id,
                            lesson_name: this.options.lessons.find(item => item.id === this.search.lesson_id)?.name,
                            activity_id: this.search.activity_id,
                            activity_name: this.options.activities.find(item => item.id === this.search.activity_id)?.name,
                            outcome_id: this.search.outcome_id,
                            outcome_name: this.options.outcomes.find(item => item.id === this.search.outcome_id)?.name,
                            objectives: []
                        }
                        const initialLength     =   this.form.report_data.length
                        const test              =   this.form.report_data.push(new_item)
                        const addedItemIndex    =   initialLength;
                        const addedItem         =   this.form.report_data[addedItemIndex];
                                
                        response.data.forEach(data => {
                            addedItem.objectives.push({
                                id: data.id,
                                name: data.name,
                                achieved: false
                            })
                        })
                        this.searching = false
                    });
                }
            }
        },
        deleteItem(index) {
            this.form.report_data.splice(index, 1);
        },
        clearSearch(){
            this.form.teacher_user_id = ''
            this.search.theme_id = ''
            this.search.term_book_id = ''
            this.search.lesson_id = ''
            this.search.outcome_id = ''
            this.search.activity_id = ''
        },
        scrollToTop() {
            const modalContent = this.$refs.progress_report
            if (modalContent) {
                modalContent.scrollTop = 0;
            }
        },
    },
    updated(){
        this.scrollToTop()
    },
}
</script>
