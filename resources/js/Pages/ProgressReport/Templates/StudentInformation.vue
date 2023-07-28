<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
        <div class="mb-5">
            <h1 class="font-bold text-indigo-800">Information</h1>
            <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
        </div>
        <dl class="divide-y divide-gray-100">
            <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Child's Name:</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ this.$page.props.student_info.name }}</dd>
            </div>
            <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Date Joined</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ moment(this.$page.props.student_info.joined_date).format('DD MMM Y') }}</dd>
            </div>
            <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Class Type / Level</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ this.$page.props.student_info.programme + ' / Level ' + this.$page.props.student_info.level }}</dd>
            </div>
        </dl>
    </div>
</template>

<script>
import moment from 'moment';
</script>