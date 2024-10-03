<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Diagnostic Test" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <Card>
            <template #content>
                <Table>
                    <TableHeader class="bg-gray-100">
                        <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Level</TableHead>
                        <TableHead>Result</TableHead>
                        <TableHead>Date Taken</TableHead>
                        <TableHead class="text-center">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!$page.props.answer_record.data.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="result, index in $page.props.answer_record.data">
                            <TableCell>{{ $page.props.answer_record.from + index }}</TableCell>
                            <TableCell>{{ result.dt_name }}</TableCell>
                            <TableCell>{{ result.total_correct_answers + '/' + result.total_answers }}</TableCell>
                            <TableCell>{{ moment(result.created_at).format('DD/MM/YYYY') }}</TableCell>
                            <TableCell class="text-center space-x-2">
                                <Button @click="!processing_item[index].process && !processing ? viewReport(result.dt_details_id) : ''">
                                    
                                    <div class="flex items-center space-x-2" v-if="processing_item[index].process && processing">
                                        <svg class="inline-block h-4 w-4 animate-spin rounded-full border-2 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]" viewBox="0 0 24 24">
                                        </svg>
                                        <span>Generating...</span>
                                    </div>
                                    <span v-else>View Report</span>
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <canvas id="canvas" ref="canvas" style="display: none;"></canvas>
    </BreezeAuthenticatedLayout>
</template>



<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Card from '@/Components/Card.vue'
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import moment from 'moment';

export default {
    components: {
        Head, Link
    },
    data(){
        return{
            processing: false,
            processing_item: [],
        }
    },
    methods: {
        viewReport(dt_details_id){
            this.$inertia.get(route('diagnostic_test.report', dt_details_id))
        },
    },
    created(){
        this.$page.props.answer_record.data.map(()=>{
            this.processing_item.push({
                'process':false
            })
        })
    },
}
</script>