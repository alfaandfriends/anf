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
        <dl class="divide-y divide-gray-300 border-2 border-gray-600 px-5 py-2 mb-3">
            <div class="px-4 py-2 grid grid-cols-3 gap-4 items-center">
                <dt class="text-sm font-medium leading-6 text-gray-900">Student's Name:</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 col-span-2">{{ data.student_data.student_name }}</dd>
            </div>
            <div class="px-4 py-2 grid grid-cols-3 gap-4 items-center">
                <dt class="text-sm font-medium leading-6 text-gray-900">Date Joined:</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 col-span-2">{{ moment(data.student_data.date_joined).format('MMM Y') }}</dd>
            </div>
            <div class="px-4 py-2 grid grid-cols-3 gap-4 items-center">
                <dt class="text-sm font-medium leading-6 text-gray-900">Class Type / level:</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 col-span-2">{{ data.student_data.programme_name }} / Level {{ data.student_data.programme_level }}</dd>
            </div>
            <div class="px-4 py-2 grid grid-cols-3 gap-4 items-center">
                <dt class="text-sm font-medium leading-6 text-gray-900">Teacher:</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 col-span-2">{{ data.student_data.student_name }}</dd>
            </div>
        </dl>
        <div class="flex justify-center mb-5">
            <table class="w-full">
                <thead>
                    <tr class="border">
                        <th class="border-2 border-gray-600 py-2 px-4 text-sm w-1/12">Date</th>
                        <th class="border-2 border-gray-600 py-2 px-4 text-sm w-7/12">Term / Book / Unit / Lesson / Achievement</th>
                        <th class="border-2 border-gray-600 py-2 px-4 text-sm w-4/12">Assessments through Observations</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="!data.report_data.length">
                        <td colspan="10" class="text-center">No record</td>
                    </tr>
                    <template v-else v-for="report, report_index in data.report_data">
                        <tr class="border-2 text-center border-gray-600 py-2 px-4 text-sm" colspan="3">
                            <td class="border-2 border-gray-600 py-2 px-4 align-middle">
                                <div class="flex flex-col">
                                    {{ moment(report.date).format('DD/MM/Y') }}
                                    {{report.attendance_status_name}}
                                </div>
                            </td>
                            <td class="border-2 border-gray-600 py-2 px-4 align-top divide-y">
                                <template v-if="JSON.parse(report.report_data).length" v-for="item, item_index in JSON.parse(report.report_data)">
                                    <div class="flex flex-col py-3 items-start">
                                        <span class="underline">{{ item.term_book_name }} &nbsp; (Unit {{ item.unit_name }})</span>
                                        <span class="">Lesson {{ item.lesson_name }}</span>    
                                        <ul class="mt-3 space-y-0.5 text-gray-800">
                                            <li class="flex" v-for="objective in item.objectives">
                                                <div class="flex">
                                                    <svg v-if="objective.achieved" class="mt-0.5 w-4 h-4 mr-2 text-green-500 dark:text-green-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                                    </svg>
                                                    <svg v-else class="mt-0.5 w-4 h-4 mr-2 text-gray-500 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                                    </svg>
                                                    <span class="text-left">{{objective.name}}</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </template>
                            </td>
                            <td class="border-2 border-gray-600 py-2 px-4 text-sm align-top text-left">{{ report.comments }}</td>
                        </tr>
                        <!-- <template v-else>
                            <tr>
                                <td>{{ moment(report.date).format('DD/MM/Y') }}</td>
                            </tr>
                        </template> -->
                        <!-- <tr v-for="item, item_index in JSON.parse(report.report_data)" v-if="JSON.parse(report.report_data)">
                            <td class="border-2 text-center border-gray-600 py-2 px-4 text-sm">
                                <div class="flex flex-col">
                                    {{ moment(report.date).format('DD/MM/Y') }}
                                    {{report.attendance_status_name}}
                                </div>
                            </td>
                            <td class="border-2 border-gray-600 py-2 px-4 align-top">
                                {{ item.term_book_name }}
                            </td>
                            <td class="border-2 border-gray-600 py-2 px-4 align-top">
                                {{ item.lesson_name }}
                            </td>
                            <td class="border-2 border-gray-600 py-2 px-4 text-sm">{{ report.comments }}</td>
                        </tr>
                        <tr v-else>
                            <td class="border-2 text-center border-gray-600 py-2 px-4 text-sm">
                                {{ moment(report.date).format('DD/MM/Y') }}
                                {{report.attendance_status_name}}
                            </td>
                            <td class="border-2 text-center border-gray-600 py-2 px-4 text-sm"></td>
                            <td class="border-2 text-center border-gray-600 py-2 px-4 text-sm"></td>
                            <td class="border-2 text-center border-gray-600 py-2 px-4 text-sm"></td>
                        </tr> -->
                    </template>
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