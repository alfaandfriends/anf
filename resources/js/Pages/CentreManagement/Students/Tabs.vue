<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import { Link } from '@inertiajs/inertia-vue3'
</script>

<template>
    <div class="flex justify-between">
        <Tabs :default-value="route().current('students') ? 'active' : route().current('students.inactive') ? 'inactive' : 'unassigned'">
            <TabsList>
            <TabsTrigger @click="$inertia.get(route('students'))" value="active">
                Active
            </TabsTrigger>
            <TabsTrigger @click="$inertia.get(route('students.inactive'))" value="inactive">
                Inactive
            </TabsTrigger>
            <TabsTrigger @click="$inertia.get(route('students.unassigned'))" value="unassigned">
                Unassigned
            </TabsTrigger>
            </TabsList>
        </Tabs>
        <Button @click="newAdmission" v-if="$page.props.can.create_students">New Admission</Button>
    </div>
</template>

<script>
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/Components/ui/tabs'

export default {
    methods: {
        newAdmission(){
            this.$inertia.get(this.route('students.create'), {'centre_id': this.$page.props.centre_id});
        },
    }
}
</script>