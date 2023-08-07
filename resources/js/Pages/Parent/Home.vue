<template>
    <Head title="Home" />
    <Authenticated>
        <div class="bg-white overflow-hidden shadow rounded-lg border">
            <div class="px-6 md:px-6 py-5">
                <span class="text-lg leading-6 text-gray-900 font-semibold">
                    Academy Information
                </span>
            </div>
            <hr>
            <div class="border-t border-gray-200 px-6 py-4" v-if="!$page.props.user_has_children.length">
                <span class="">No children have been added at the moment.</span>
            </div>
            <ul class="flex flex-col px-4 md:px-6 py-4 md:py-6 rounded-lg space-y-4" v-else-if="$page.props.current_active_child.student_id">
                <li class="relative flex py-4 px-6 rounded-t-inherit rounded-xl bg-white border-2 border-dashed border-indigo-400" v-for="academic in $page.props.academics">
                    <div class="flex flex-col space-y-2">
                        <h6 class="mb-2 leading-normal font-bold font-sans underline">{{ academic.programme_name }}</h6>
                        <span class="leading-tight text-sm font-sans">Level: <span class="font-semibold text-slate-700 sm:ml-2">{{ academic.programme_level }}</span></span>
                        <span class="leading-tight text-sm font-sans">Centre: <span class="font-semibold text-slate-700 sm:ml-2">{{ academic.centre_name }}</span></span>
                        <span class="leading-tight text-sm font-sans">Class Type: <span class="font-semibold text-slate-700 sm:ml-2">{{ academic.class_type }}</span></span>
                    </div>
                </li>
            </ul>
            <div class="border-t border-gray-200 px-6 py-4" v-else>
                <span class="italic">Sorry, this little cutie is not a student.</span>
            </div>
        </div>
    </Authenticated>
</template>

<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
</script>

