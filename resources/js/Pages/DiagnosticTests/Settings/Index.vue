<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Diagnostic Test" />
    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="flex items-center justify-end">
            <Button @click="addLanguage">
                <PlusCircle class="h-4 w-4" />
                <span class="ml-1 hidden sm:block">New Language</span>
            </Button>
        </div>
        <Card>
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
                        <TableRow v-if="!$page.props.languages.data.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="language, index in $page.props.languages.data">
                            <TableCell>{{ $page.props.languages.from + index }}</TableCell>
                            <TableCell>{{ language.name }}</TableCell>
                            <TableCell class="text-center space-x-2">
                                <Button @click="editLanguage(language.id)">Edit</Button>
                                <Button variant="destructive" @click="deleteLanguage(language.id)">Delete</Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Pagination :page_data="$page.props.languages"></Pagination>
        <DeleteConfirmation :open="confirmation.is_open" @close="confirmation.is_open = false" :routeName="confirmation.route_name" :id="confirmation.id">
            <template #title>Delete Language</template>
            <template #description>Are you sure want to delete this language?</template>
        </DeleteConfirmation>
        <Dialog v-model:open="form_modal" :key="form.id">
            <template #title>Language Setting</template>
            <template #content>
                <div class="grid grid-cols-1 gap-4 py-4">
                    <div class="">
                        <Label for="language_name">Name<span class="text-red-500">*</span></Label>
                        <Input id="language_name" type="text" :error="errors.name" v-model="form.name"></Input>
                    </div>
                    <div class="">
                        <Label for="guideline_header">Guideline Title<span class="text-red-500">*</span></Label>
                        <Input id="guideline_header" type="text" :error="errors.guideline_header" v-model="form.guideline_header"></Input>
                    </div>
                    <div class="">
                        <Label for="guideline_body">Guideline Body<span class="text-red-500">*</span></Label>
                        <Textarea :rows="6" id="guideline_body" type="text" :error="errors.guideline_body" v-model="form.guideline_body" placeholder="Press enter to break a new line"></Textarea>
                    </div>
                    <div class="">
                        <Label for="final_message">Final Message<span class="text-red-500">*</span></Label>
                        <Textarea :rows="3" id="final_message" type="text" :error="errors.final_message" v-model="form.final_message"></Textarea>
                    </div>
                    <div class="space-y-2">
                        <Label for="email_input">PIC Emails</Label>
                        <div class="grid grid-cols-12 gap-2">
                            <div class="col-span-10">
                                <Input id="email_input" type="text" v-model="form.email_input" placeholder="Enter PIC Email"></Input>
                            </div>
                            <div class="col-span-2">
                                <Button class="py-2.5 px-4" @click="addEmail()">
                                    <PlusCircle class="h-4 w-4" />
                                    <span class="ml-1 hidden sm:block">Add</span>
                                </Button>
                            </div>
                        </div>
                        <div class="">
                            <ul class="w-full text-sm font-medium divide-dashed divide-y text-gray-900 bg-white border border-gray-200 rounded-lg">
                                <li class="flex text-xs sm:text-sm w-full px-4 py-2 space-x-1 items-center" v-if="form.pic_emails.length" v-for="email, index in form.pic_emails"><span>{{ email.email }}</span><span class="text-xs cursor-pointer uppercase text-red-500 hover:underline" @click="deleteEmail(index)"><MinusCircle class="w-4 h-4"></MinusCircle></span></li>
                                <li class="w-full px-4 py-2 space-x-4 bg-gray-100" v-else><span class="font-semibold text-gray-600 italic text-sm">No email has been added.</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </template>
            <template #footer>
                <Button variant="outline" @click="form_modal = false">Cancel</Button>
                <Button @click="form.id != '' ? update() : store() ">Save</Button>
            </template>
        </Dialog>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { PlusCircle, MinusCircle } from 'lucide-vue-next';
import Card from '@/Components/Card.vue'
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import Pagination from '@/Components/Pagination.vue'
import axios from 'axios'
import DeleteConfirmation from '@/Components/DeleteConfirmation.vue';   
import Dialog from '@/Components/DialogModal.vue'

export default {
    components: {
        Head, Link
    },
    data() {
        return {
            confirmation: {
                is_open: false,
                route_name: '',
                id: ''
            },
            form_modal: false,
            open_delete_modal: false,
            confirmation_data: '',
            confirmation_route: '',
            processing: false,
            errors: {
                name: false,
                guideline_header: false,
                guideline_body: false,
                final_message: false,
                email_input: false,
            },
            form:{
                id: '',
                name: '',
                guideline_header: '',
                guideline_body: '',
                final_message: '',
                email_input: '',
                pic_emails: []
            }
        }
    },
    methods: {
        navigate(route){
            this.$inertia.visit(route)
        },
        addLanguage(){
            this.clearForm()
            this.form_modal = true
        },
        editLanguage(language_id){
            if(this.processing){
                return
            }
            this.processing = true
            this.clearForm()
            axios.get(route('dt.settings.languages.edit'), { params: { language_id: language_id } })
            .then(response => {
                this.form.id                = response.data.language_info.id
                this.form.name              = response.data.language_info.name
                this.form.guideline_header  = response.data.language_info.guideline_header
                this.form.guideline_body    = response.data.language_info.guideline_body
                this.form.final_message     = response.data.language_info.final_message
                this.form.pic_emails        = response.data.pic_emails
                this.form_modal = true
                this.processing = false
            })
            .catch(error => {
                this.processing = false
            });
        },
        deleteLanguage(language_id){
            this.confirmation.route_name    = 'dt.settings.languages.destroy'
            this.confirmation.id            = language_id
            this.confirmation.is_open       = true
        },
        store(){
            if(this.processing){
                return
            }
            const formValid =   this.validateForm();
            if(formValid){
                this.processing = true
                this.$inertia.post(route('dt.settings.languages.store'), this.form, {
                    onSuccess: page => {
                        this.form_modal = false
                        this.processing = false
                    },
                })
            }
            return
        },
        update(){
            if(this.processing){
                return
            }
            const formValid =   this.validateForm();
            if(formValid){
                this.processing = true
                this.$inertia.post(route('dt.settings.languages.update'), this.form, {
                    onSuccess: page => {
                        this.form_modal = false
                        this.processing = false
                    },
                })
            }
            return
        },
        addEmail(){
            const emailIsvalid  = this.validateEmailInput()
            if(!emailIsvalid){
                return
            }
            this.form.pic_emails.push({
                'email': this.form.email_input
            })
            this.form.email_input = ''
        },
        deleteEmail(index){
            this.form.pic_emails.splice(index, 1)
        },
        clearForm(){
            this.form.id = ''
            this.form.name = ''
            this.form.guideline_header = ''
            this.form.guideline_body = ''
            this.form.final_message = ''
            this.form.email_input = ''
            this.form.pic_emails = []
            for (let key in this.errors) {
                this.errors[key] = false;
            }
        },
        validateForm() {
            for (let key in this.errors) {
                this.errors[key] = false;
            }
            for (let key in this.form) {
                if (key === 'id' || key === 'email_input' || key === 'pic_emails') {
                    continue;
                }
                if (this.form[key].trim() === '') {
                    this.errors[key] = true;
                }
            }
            return Object.values(this.errors).every(value => !value);
        },
        validateEmailInput(){
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            const emailIsValid = emailRegex.test(this.form.email_input);

            this.errors.email_input = emailIsValid ? false : true

            return emailIsValid
        }
    }

}
</script>
                                