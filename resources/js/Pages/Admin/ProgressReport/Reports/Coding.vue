<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <div id="progress_report" class="p-5 h-[297mm] w-[210mm]">
        <div class="flex justify-center mb-5">
            <img src="/images/progress_report/coding_robotic.png" class="w-full h-[200px]" alt="">
        </div>
        <Header :report_data="data"></Header>
        <div class="flex justify-center mb-5">
            <table class="w-full">
                <thead>
                    <tr class="border">
                        <th class="border-2 border-gray-600 py-2 px-4 text-sm w-1/12">Date</th>
                        <th class="border-2 border-gray-600 py-2 px-4 text-sm w-7/12">Lesson / Module</th>
                        <th class="border-2 border-gray-600 py-2 px-4 text-sm w-4/12">Assessments</th>
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
                                        <span class="underline text-left font-semibold">{{ item.lesson_name }} : {{ item.topic_name }}</span>
                                        <span class="text-left italic">{{ item.objective_name }}</span>    
                                        <ul class="mt-3 space-y-0.5 text-gray-800">
                                            <li class="flex" v-for="objective in item.activities_procedures">
                                                <div class="flex">
                                                    <svg v-if="objective.achieved" xmlns="http://www.w3.org/2000/svg" class="mt-0.5 w-4 h-4 mr-2 flex-shrink-0" viewBox="0 0 512 512">
                                                        <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-111 111-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L369 209z"/>
                                                    </svg>
                                                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="mt-0.5 w-4 h-4 mr-2 flex-shrink-0" viewBox="0 0 512 512">
                                                        <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/>
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
                    </template>
                </tbody>
            </table>
        </div>
  </div>
</template>
<script>
import moment from 'moment';
import Header from './Header.vue';

export default {
    props: {
        data: Object
    },
}
</script>