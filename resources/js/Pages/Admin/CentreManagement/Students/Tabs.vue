<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <div class="flex justify-between bg-white rounded px-4 py-2 border border-gray-400">
        <nav class="flex gap-2" aria-label="Tabs">
            <a :href="route('students')" class="self-center shrink-0 rounded-lg px-4 py-2 text-sm font-medium text-indigo-500 hover:bg-indigo-200 hover:text-indigo-500" :class="route().current('students') ? 'bg-indigo-100 text-indigo-400' : ''">Active</a>
            <a :href="route('students.inactive')" class="self-center shrink-0 rounded-lg px-4 py-2 text-sm font-medium text-indigo-500 hover:bg-indigo-200 hover:text-indigo-500" :class="route().current('students.inactive') ? 'bg-indigo-100 text-indigo-400' : ''">Inactive</a>
            <a :href="route('students.unassigned')" class="self-center shrink-0 rounded-lg px-4 py-2 text-sm font-medium text-indigo-500 hover:bg-indigo-200 hover:text-indigo-500" :class="route().current('students.unassigned') ? 'bg-indigo-100 text-indigo-400' : ''">Unassigned</a>
        </nav>
        <BreezeButton @click="newAdmission" v-if="$page.props.can.create_students">New Admission</BreezeButton>
    </div>
</template>

<script>
export default {
    methods: {
        newAdmission(){
            this.$inertia.get(this.route('students.create'), {'centre_id': this.$page.props.centre_id});
        },
    }
}
</script>