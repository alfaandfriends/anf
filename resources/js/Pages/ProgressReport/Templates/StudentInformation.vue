<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Card>
        <template #title>Student Information</template>
        <template #content>
            <div class="grid grid-cols-1 2xl:grid-cols-3 gap-4">
                <div>
                    <Label>Name</Label>
                    <Input disabled v-model="name"></Input>
                </div>
                <div>
                    <Label>Date Joined</Label>
                    <Input disabled v-model="date_joined"></Input>
                </div>
                <div>
                    <Label>Programme / Level</Label>
                    <Input disabled v-model="programme_level"></Input>
                </div>
            </div>
        </template>
    </Card>
</template>

<script>
import moment from 'moment';
import Card from '@/Components/Card.vue'

export default {
    data() {
        return {
            name: this.$page.props.student_info.name,
            date_joined: moment(this.$page.props.student_info.joined_date).format('DD MMM Y'),
            programme_level: this.$page.props.student_info.programme + ' / Level ' + this.$page.props.student_info.level
        }
    }
}
</script>