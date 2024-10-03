<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Progress Report" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 items-start">
            <Card>
                <template #title>
                    <div class="flex justify-between">
                        <Button @click="$inertia.get(route('progress_report.settings.little_bot.lessons', {'level_id': $page.props.level_id}))">Back</Button>
                        <Button @click="create">New Topic</Button>
                    </div>
                </template>
                <template #content>
                    <Table>
                        <TableHeader class="bg-gray-100">
                            <TableRow>
                            <TableHead>#</TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead class="text-center">Action</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-if="!$page.props.topics.length">
                                <TableCell class="text-center" colspan="10">
                                    <div class="p-3">
                                        No Record Found
                                    </div>
                                </TableCell>
                            </TableRow> 
                            <TableRow v-for="result, index in $page.props.topics">
                                <TableCell>{{ index + 1 }}</TableCell>
                                <TableCell>{{ result.name }}</TableCell>
                                <TableCell class="text-center">
                                    <div class="flex justify-center space-x-2">
                                        <Button variant="outline" @click="edit(result.id, result.name)">Edit</Button>
                                        <Button variant="destructive" @click="destroy(result.id)">Delete</Button>
                                        <Button @click="viewObjectives(result.id)">View Objectives</Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </template>
            </Card>
            <Card v-if="show_create">
                <template #title>Add Topic</template>
                <template #content>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <Label>Name<span class="text-red-500">*</span></Label>
                            <Input type="text" :error="errors.topic_name" v-model="form.topic_name"></Input>
                        </div>
                    </div>
                </template>
                <template #footer>
                    <div class="flex justify-end">
                        <Button @click="store">Save</Button>
                    </div>
                </template>
            </Card>
            <Card class="flex flex-col h-auto" v-if="show_edit">
                <template #title>Edit Topic</template>
                <template #content>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <Label>Name<span class="text-red-500">*</span></Label>
                            <Input type="text" :error="errors.topic_name" v-model="form.topic_name"></Input>
                        </div>
                    </div>
                </template>
                <template #footer>
                    <div class="flex justify-end">
                        <Button @click="update">Save</Button>
                    </div>
                </template>
            </Card>
        </div>
        <DeleteConfirmation :open="confirmation.is_open" @close="confirmation.is_open = false" :routeName="confirmation.route_name" :id="confirmation.id">
            <template #title>Delete Topic</template>
            <template #description>Are you sure want to delete this topic?</template>
        </DeleteConfirmation>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Card from '@/Components/Card.vue'
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import DeleteConfirmation from '@/Components/DeleteConfirmation.vue';

export default {
    components: {
        Head, Link
    },
    data(){
        return{
            show_create: false,
            show_edit: false,
            confirmation: {
                is_open: false,
                route_name: '',
                id: ''
            },
            form:{
                id: '',
                lesson_id: this.$page.props.lesson_id,
                topic_name: ''
            },
            errors:{
                topic_name: false
            }
        }
    },
    methods: {
        create(){
            this.form.topic_name       = ''
            this.show_create            = true
            this.show_edit              = false
        },
        edit(id, topic_name){
            this.form.id                = id
            this.form.topic_name       = topic_name
            this.show_edit              = true
            this.show_create            = false
        },
        store(){
            if(!this.form.topic_name){
                this.errors.topic_name = true
                return
            }
            this.$inertia.post(route('progress_report.settings.little_bot.topics.store'), this.form, {preserveState: false})
        },
        update(){
            if(!this.form.topic_name){
                this.errors.topic_name = true
                return
            }
            this.$inertia.post(route('progress_report.settings.little_bot.topics.update'), this.form, {preserveState: false})
        },
        destroy(id){
            this.confirmation.route_name    = 'progress_report.settings.little_bot.topics.destroy'
            this.confirmation.id            = id
            this.confirmation.is_open       = true
        },
        viewObjectives(topic_id){
            this.$inertia.get(route('progress_report.settings.little_bot.objectives'), {'level_id': this.$page.props.level_id, 'lesson_id' : this.$page.props.lesson_id, 'topic_id' : topic_id})
        },
    }
}
</script>