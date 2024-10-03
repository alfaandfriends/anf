<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Assessments" />

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
            </div>
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-5 gap-2" v-if="show_filters">
            <ComboBox :items="$page.props.allowed_centres" label-property="label" value-property="ID" @select="search" v-model="params.centre_id" select-placeholder="Centres" search-placeholder="Search centre..."></ComboBox>
            <ComboBox canClear :items="$page.props.options.programmes" label-property="name" value-property="id" @select="search" v-model="params.programme_id" select-placeholder="Programmes" search-placeholder="Search programme...">
                <template #label="{ item }">
                    {{ item.name }} ({{ item.country_name }})
                </template>
                <template #label-content="{ selectedItem, selectedItems, multiple }">
                    <span v-if="selectedItem">{{ selectedItem.name }} ({{ selectedItem.country_name }})</span>
                </template>
            </ComboBox>
            <ComboBox canClear :items="$page.props.options.levels" label-property="level" value-property="level" @select="search" v-model="params.level" select-placeholder="Level" search-placeholder="Search level...">
                <template #label="{ item }">
                    Level {{ item.level }}
                </template>
                <template #label-content="{ selectedItem, selectedItems, multiple }">
                    <span v-if="selectedItem">Level {{ selectedItem.level }}</span>
                </template>
            </ComboBox>
            <div class="">
                <Button @click="$inertia.get(route('assessments'))">Clear Search</Button>
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
                        <TableHead class="text-center">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!$page.props.assessments.data.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="assessment, index in $page.props.assessments.data">
                            <TableCell>{{ $page.props.assessments.from + index }}</TableCell>
                            <TableCell>
                                {{ assessment.student_name }}
                                <div class="flex space-x-1">
                                    <Badge>
                                        <span>{{ assessment.programme_name }}</span>
                                    </Badge>
                                    <Badge variant="outline">
                                        <span>Level {{ assessment.programme_level }}</span>
                                    </Badge>
                                </div>
                            </TableCell>
                            <TableCell>{{ assessment.centre_name }}</TableCell>
                            <TableCell class="text-center">
                                <div class="flex justify-center space-x-2">
                                    <Button variant="outline" @click="editAssessment(assessment.programme_level, index)">Edit</Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Pagination :page_data="$page.props.assessments" :params="params"></Pagination>
        
        <Dialog v-model:open="show_assessment_modal">
            <template #title>Edit Assessment</template>
            <template #content>
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-200">
                            <th class="px-3 py-1 border w-6/12 text-sm text-left">Unit</th>
                            <th class="px-3 py-1 border w-3/12 text-sm text-center">Pre</th>
                            <th class="px-3 py-1 border w-3/12 text-sm text-center">Post</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="unit, index in units" :key="unit.id">
                            <td class="px-3 py-0.5 whitespace-nowrap text-sm">{{ unit.name }}</td>
                            <td class="px-3 py-0.5 text-center">
                                <input class="min-w-20 px-2 h-7 w-full border text-center text-xs rounded placeholder:text-gray-400 outline-black" type="text" placeholder="score" :value="getAssessmentPre(index)" @change="setAssessmentPre(index, $event.target.value)">
                            </td>
                            <td class="px-3 py-0.5 text-center">
                                <input class="min-w-20 px-2 h-7 w-full border text-center text-xs rounded placeholder:text-gray-400 outline-black" type="text" placeholder="score" :value="getAssessmentPost(index)" @change="setAssessmentPost(index, $event.target.value)">
                            </td>
                        </tr>
                        <tr>
                            <td class="px-3 py-0.5 whitespace-nowrap text-sm">Final Assessment</td>
                            <td class="px-3 py-0.5 text-center">
                                <input class="min-w-20 px-2 h-7 w-full border text-center text-xs rounded placeholder:text-gray-400 outline-black" type="text" placeholder="score" v-model="form.final_pre_score">
                            </td>
                            <td class="px-3 py-0.5 text-center">
                                <input class="min-w-20 px-2 h-7 w-full border text-center text-xs rounded placeholder:text-gray-400 outline-black" type="text" placeholder="score" v-model="form.final_post_score">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>
            <template #footer>
                <Button variant="outline" @click="show_assessment_modal = false">Cancel</Button>
                <Button @click="submit">Save</Button>
            </template>
        </Dialog>
    </BreezeAuthenticatedLayout>
</template>



<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { MagnifyingGlassIcon } from '@radix-icons/vue'
import { Filter, Cog } from 'lucide-vue-next';
import { Badge } from '@/Components/ui/badge'
import { debounce } from 'vue-debounce'
import Dialog from '@/Components/DialogModal.vue'
import axios from 'axios';
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
            show_assessment_modal: false,
            params: {
                search: this.$page.props.filter.search ? this.$page.props.filter.search : '',
                centre_id: this.$page.props.filter.centre_id ? this.$page.props.filter.centre_id : '',
                programme_id: this.$page.props.filter.programme_id ? this.$page.props.filter.programme_id : '',
                level: this.$page.props.filter.level ? this.$page.props.filter.level : '',
            },
            units: [],
            form: {
                student_id: '',
                programme_level_fee_id: '',
                assessments: [],
                final_pre_score: '',
                final_post_score: '',
            }
        }
    },
    methods: {
        addClass(centreID){
            this.$inertia.get(this.route('assessments.create'), {'centre_id': centreID});
        },
        editAssessment(level, index){
            this.form.assessments = []
            axios.get(route('assessments.create', level))
            .then((response)=>{
                this.units = response.data
                this.form.student_id = this.$page.props.assessments.data[index].student_id
                this.form.programme_level_fee_id = this.$page.props.assessments.data[index].programme_level_fee_id
                this.form.final_pre_score = this.$page.props.assessments.data[index].final_pre_score
                this.form.final_post_score = this.$page.props.assessments.data[index].final_post_score
                const assessments_data = JSON.parse(this.$page.props.assessments.data[index].assessments)
                this.units.map(item=>{
                    this.form.assessments.push({    
                        'unit_id': item.id,
                        'unit_name': item.name,
                        'pre' : assessments_data && assessments_data.find(data_unit=>data_unit.unit_id == item.id).pre ? assessments_data.find(data_unit=>data_unit.unit_id == item.id).pre : '',
                        'post': assessments_data && assessments_data.find(data_unit=>data_unit.unit_id == item.id).post ? assessments_data.find(data_unit=>data_unit.unit_id == item.id).post : '',
                    })
                })
                this.show_assessment_modal = true
            })
        },
        submit(){
            this.$inertia.post(this.route('assessments.store'), this.form, { preserveState: false});
        },
        search(){
            this.$inertia.get(this.route('assessments'), this.params, { replace: true, preserveState: true});
        },
        getAssessmentPre(index) {
            return this.form.assessments[index]?.pre || '';  // Provide a default value if `pre` is undefined
        },
        setAssessmentPre(index, value) {
            if (this.form.assessments[index]) {
                this.form.assessments[index].pre = value
            }
        },
        getAssessmentPost(index) {
            return this.form.assessments[index]?.post || '';  // Provide a default value if `post` is undefined
        },
        setAssessmentPost(index, value) {
            if (this.form.assessments[index]) {
                this.form.assessments[index].post = value
            }
        },
        showFilters(){
            this.show_filters = !this.show_filters
        },
    }
}
</script>
