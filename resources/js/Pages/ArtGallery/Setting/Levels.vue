<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Art Gallery" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
            <Card>
                <template #title>
                    <div class="flex justify-end">
                        <Button @click="create">New Level</Button>
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
                            <TableRow v-if="!$page.props.levels.length">
                                <TableCell class="text-center" colspan="10">
                                    <div class="p-3">
                                        No Record Found
                                    </div>
                                </TableCell>
                            </TableRow> 
                            <TableRow v-for="result, index in $page.props.levels">
                                <TableCell>{{ index + 1 }}</TableCell>
                                <TableCell>{{ result.name }}</TableCell>
                                <TableCell class="text-center">
                                    <div class="flex justify-center space-x-2">
                                        <Button variant="outline" @click="edit(result.id, result.name)">Edit</Button>
                                        <Button variant="destructive" @click="destroy(result.id)">Delete</Button>
                                        <Button @click="viewThemes(result.id)">View Themes</Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </template>
            </Card>
            <Card v-if="show_create">
                <template #title>Add Level</template>
                <template #content>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <Label>Name<span class="text-red-500">*</span></Label>
                            <Input type="text" :error="errors.level_name" v-model="form.level_name"></Input>
                        </div>
                    </div>
                </template>
                <template #footer>
                    <div class="flex justify-end">
                        <Button @click="store">Save</Button>
                    </div>
                </template>
            </Card>
            <Card v-if="show_edit">
                <template #title>Edit Level</template>
                <template #content>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <Label>Name<span class="text-red-500">*</span></Label>
                            <Input type="text" :error="errors.level_name" v-model="form.level_name"></Input>
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
            <template #title>Delete Level</template>
            <template #description>Are you sure want to delete this level?</template>
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
                level_name: ''
            },
            errors:{
                level_name: false
            }
        }
    },
    methods: {
        viewThemes(level_id){
            this.$inertia.get(route('art_gallery.setting.themes'), {'level_id' : level_id})
        },
        create(){
            this.form.level_name    = ''
            this.show_create        = true
            this.show_edit          = false
        },
        store(){
            if(!this.form.level_name){
                this.errors.level_name = true
                return
            }
            this.$inertia.post(route('art_gallery.setting.levels.store'), this.form, {preserveState: false})
        },
        edit(id, level_name){
            this.form.id            = id
            this.form.level_name    = level_name
            this.show_edit          = true
            this.show_create        = false
        },
        update(){
            if(!this.form.level_name){
                this.errors.level_name = true
                return
            }
            this.$inertia.post(route('art_gallery.setting.levels.update'), this.form, {preserveState: false})
        },
        destroy(id){
            this.confirmation.route_name    = 'art_gallery.setting.levels.delete'
            this.confirmation.id            = id
            this.confirmation.is_open       = true
        }
    }
}
</script>