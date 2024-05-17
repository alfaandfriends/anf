<template>
    <div class="flex justify-center mb-5">
        <span class="font-bold text-2xl">Monthly Progress Report</span>
    </div>
    <dl class="divide-y divide-gray-300 border-2 border-gray-600 px-5 py-2 mb-3">
        <div class="px-4 py-2 grid grid-cols-3 gap-4 items-center">
            <dt class="text-sm font-medium leading-6 text-gray-900">Student's Name:</dt>
            <dd class="mt-1 text-sm leading-6 text-gray-700 col-span-2">{{ report_data.student_data.student_name }}</dd>
        </div>
        <div class="px-4 py-2 grid grid-cols-3 gap-4 items-center">
            <dt class="text-sm font-medium leading-6 text-gray-900">Date Joined:</dt>
            <dd class="mt-1 text-sm leading-6 text-gray-700 col-span-2">{{ date_joined }}</dd>
        </div>
        <div class="px-4 py-2 grid grid-cols-3 gap-4 items-center">
            <dt class="text-sm font-medium leading-6 text-gray-900">Class Type / level:</dt>
            <dd class="mt-1 text-sm leading-6 text-gray-700 col-span-2">{{ report_data.student_data.programme_name }} / Level {{ report_data.student_data.programme_level }}</dd>
        </div>
        <!-- <div class="px-4 py-2 grid grid-cols-3 gap-4 items-center">
            <dt class="text-sm font-medium leading-6 text-gray-900">Teacher:</dt>
            <dd class="mt-1 text-sm leading-6 text-gray-700 col-span-2">{{ report_data.student_data.student_name }}</dd>
        </div> -->
    </dl>
</template>

<script>
import moment from 'moment';

export default {
    props: {
        report_data: Object
    },
    data(){
        return{
            date_joined: ''
        }
    },
    mounted(){
        this.date_joined = moment(this.report_data.student_data.date_joined).format('MMM Y')
    }
}
</script>