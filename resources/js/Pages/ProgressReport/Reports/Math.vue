<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <div id="progress_report" class="p-5 h-[297mm] w-[210mm]">
        <div class="flex justify-center mb-5">
            <img src="/storage/progress_report/banner.png" class="w-full h-[200px]" alt="">
        </div>
        <div class="flex justify-center mb-5">
            <span class="font-bold text-2xl">Monthly Progress Report</span>
        </div>
        <dl class="divide-y divide-gray-300 border-2 border-gray-600 px-10 mb-5">
            <div class="px-4 py-2 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium leading-6 text-gray-900">Child's Name:</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 col-span-2">Dhiya Rania Alayna Binti Muhammad Eqbal (8)</dd>
            </div>
            <div class="px-4 py-2 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium leading-6 text-gray-900">Date Joined:</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 col-span-2">May 2022</dd>
            </div>
            <div class="px-4 py-2 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium leading-6 text-gray-900">Class Type / level:</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 col-span-2">ANF Maths (Level 2)</dd>
            </div>
            <div class="px-4 py-2 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium leading-6 text-gray-900">Teacher:</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 col-span-2">Hazma Syarihan binti Mohamed Rafique</dd>
            </div>
        </dl>
        <div class="flex justify-center mb-5">
            <table class="w-full">
                <thead>
                    <tr class="border">
                        <th class="border-2 border-gray-600 py-2 px-4 text-sm w-1/12">Date</th>
                        <th class="border-2 border-gray-600 py-2 px-4 text-sm w-3/12">Book / Unit</th>
                        <th class="border-2 border-gray-600 py-2 px-4 text-sm w-4/12">Lesson</th>
                        <th class="border-2 border-gray-600 py-2 px-4 text-sm w-4/12">Assessments through Observations</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="!data.length">
                        <td colspan="10" class="text-center">No record</td>
                    </tr>
                    <tr v-else v-for="report, report_index in data">
                        <td class="border-2 text-center border-gray-600 py-2 px-4 text-sm">
                            <div class="flex flex-col">
                                {{ moment(report.date).format('DD/MM/Y') }}
                                {{report.attendance_status_name}}
                            </div>
                        </td>
                        <td class="border-2 border-gray-600 py-2 px-4">
                            <div class="flex justify-center text-sm" v-for="item, item_index in JSON.parse(report.report_data)">
                                {{ item.term_book_name }}
                            </div>
                        </td>
                        <td class="border-2 border-gray-600 py-2 px-4">
                            <div class="flex justify-start text-sm" v-for="item, item_index in JSON.parse(report.report_data)">
                                {{ item.lesson_name }}
                            </div>
                        </td>
                        <td class="border-2 border-gray-600 py-2 px-4 text-sm">{{report.comments}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
  </div>
</template>
<script>
import moment from 'moment';

export default {
    props: {
        data: Object
    },
    data(){
        return{
            // data_items: JSON.parse(this.$page.props.report_data)
        }
    }
}
</script>