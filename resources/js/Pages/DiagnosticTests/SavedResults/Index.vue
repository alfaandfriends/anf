<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Diagnostic Test" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="relative">
            <MagnifyingGlassIcon class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
            <Input type="text" placeholder="Search" class="w-full rounded-lg bg-background pl-8 md:w-[200px] lg:w-[336px]" v-debounce:800ms="search" v-model="params.search"/>
        </div>
        <Card>
            <template #content>
                <Table>
                    <TableHeader class="bg-gray-100">
                        <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Email</TableHead>
                        <TableHead>Contact Number</TableHead>
                        <TableHead>Centre</TableHead>
                        <TableHead>Admitted</TableHead>
                        <TableHead>Notes</TableHead>
                        <TableHead class="text-center">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!$page.props.saved_results.data.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="result, index in $page.props.saved_results.data">
                            <TableCell>{{ $page.props.saved_results.from + index }}</TableCell>
                            <TableCell>{{ result.child_id ? result.student_name : result.child_name }} - Age ({{ result.child_id ?  moment().diff(result.student_dob, 'years') : result.child_age }})</TableCell>
                            <TableCell>{{ result.parent_email }}</TableCell>
                            <TableCell>{{ result.parent_contact }}</TableCell>
                            <TableCell>{{ result.centre_name }}</TableCell>
                            <TableCell><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="result.admitted == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"> {{ result.admitted == 1 ? 'Yes' : 'No' }} </span></TableCell>
                            <TableCell>{{ result.notes }}</TableCell>
                            <TableCell class="text-center space-x-2">
                                <div class="flex justify-center space-x-2">
                                    <Button variant="outline" @click="updateStatus(result.id, result.admitted, result.centre_id, result.notes)">Status</Button>
                                    <Button @click="viewDetails(result.id)">View Details</Button>
                                    <Button variant="destructive" @click="deleteStatus(result.id)">Delete</Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Pagination :page_data="$page.props.saved_results" :params="params"></Pagination>
        <DeleteConfirmation :open="confirmation.is_open" @close="confirmation.is_open = false" :routeName="confirmation.route_name" :id="confirmation.id">
            <template #title>Delete Result</template>
            <template #description>Are you sure want to delete this result?</template>
        </DeleteConfirmation>
        <Dialog v-model:open="open_modal">
            <template #title>Status</template>
            <template #content>
                <div class="p-1 grid grid-cols-1 gap-4">
                    <Label for="admitted" class="flex items-center space-x-1 cursor-pointer">
                        <Checkbox class="mr-1" id="admitted" :value="true" :checked="form.admitted" @click.native="form.admitted = !form.admitted"/>
                        Admitted
                    </Label>
                    <div class="">
                        <Label>Centre<span class="text-red-500">*</span></Label>
                        <ComboBox canClear :items="$page.props.allowed_centres" label-property="label" value-property="ID" :error="$page.props.errors.centre_id" v-model="form.centre_id" select-placeholder="Select Centre" search-placeholder="Search centre..."></ComboBox>
                    </div>
                    <Textarea rows="3" placeholder="Notes..." v-model="form.notes"></Textarea>
                </div>
            </template>
            <template #footer>
                <Button variant="outline" @click="open_modal = false">Cancel</Button>
                <Button @click="saveStatus">Save</Button>
            </template>
        </Dialog>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { MagnifyingGlassIcon } from '@radix-icons/vue'
import Card from '@/Components/Card.vue'
import Pagination from '@/Components/Pagination.vue'
import DeleteConfirmation from '@/Components/DeleteConfirmation.vue';   
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import moment from 'moment';
import Modal from '@/Components/Modal.vue'
import Dialog from '@/Components/DialogModal.vue'

export default {
    components: {
        Head, Link, Modal, Pagination
    },
    props: {
        filter: Object,
    },
    data(){
        return{
            open_modal: false,
            confirmation: {
                is_open: false,
                route_name: '',
                id: ''
            },
            params: {
                search: this.filter.search ? this.filter.search : '',
                centre_id: this.filter.centre_id ? this.filter.centre_id : '',
            },
            form: {
                result_id: '',
                admitted: false,
                centre_id: false,
                notes: ''
            }
        }
    },
    methods: {
        viewDetails(result_id){
            this.$inertia.get(this.route('diagnostic_test.saved_result.details'), {'result_id': result_id});
        },
        updateStatus(result_id, admitted, centre_id, notes){
            this.form.result_id     = result_id
            this.form.admitted      = admitted == 1 ? true : false
            this.form.centre_id     = centre_id ? centre_id : ''
            this.form.notes         = notes
            this.open_modal         = true
        },
        deleteStatus(result_id){
            this.confirmation.route_name    = 'diagnostic_test.delete_result'
            this.confirmation.id            = result_id
            this.confirmation.is_open       = true
        },
        saveStatus(){
            this.$inertia.post(this.route('diagnostic_test.saved_result.save_status'), this.form, { onSuccess: page => {            
                this.open_modal = false
            }});
        },
        search(){
            this.$inertia.get(this.route('diagnostic_test.saved_result'), this.params, { replace: true, preserveState: true});
        },
    }
}
</script>