<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <div class="pt-6">
        <div class="flex mb-3">
            <BreezeButton type="button" @click="addLanguage">New language</BreezeButton>
        </div>
        <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" width="3">#</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" width="5">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-if="!$page.props.languages.data.length">
                        <td class="text-center" colspan="10">
                            <div class="p-3">
                                No Record Found! 
                            </div>
                        </td>
                    </tr> 
                    <tr class="hover:bg-gray-100" v-for="(language, index) in $page.props.languages.data" :key="language.id">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-700">{{ ++index }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ language.name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center">
                                <div class="flex pr-1">
                                    <BreezeButton buttonType="warning" @click="editLanguage(language.id)">
                                        Edit
                                    </BreezeButton>
                                </div>
                                <div class="flex">
                                    <BreezeButton buttonType="danger" @click="deleteLanguage(language.id)">
                                        Delete
                                    </BreezeButton>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <Pagination :page_data="$page.props.languages" :params="params"></Pagination>
    </div>
    <Modal :showModal="form_modal" modalType="sm" @hideModal="form_modal = false" :key="form.id">
        <template v-slot:header>
            <div class="flex items-center justify-between py-3 px-4 border-b rounded-t font-semibold">        
                <h3 class="text-gray-800 tracking-wide font-semibold text-lg">              
                    Language Setting
                </h3>    
                <button type="button" @click="form_modal = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>               
        </template>
        <template v-slot:content>
            <div class="w-full md:w-[48rem] p-4 overflow-y-auto">
                <div class="grid grid-cols-1 gap-4">
                    <div class="">
                        <label for="language_name" class="block text-sm text-gray-700 font-bold"> Name <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" name="language_name" id="language_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="errors.name ? 'border-red-300' : 'border-gray-300'" v-model="form.name" autocomplete="none"/>
                        </div>
                    </div>
                    <div class="">
                        <label for="guideline_header" class="block text-sm text-gray-700 font-bold"> Guideline Title <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" name="guideline_header" id="guideline_header" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="errors.guideline_header ? 'border-red-300' : 'border-gray-300'" v-model="form.guideline_header" autocomplete="none"/>
                        </div>
                    </div>
                    <div class="">
                        <label for="guideline_body" class="block text-sm text-gray-700 font-bold"> Guideline Body <span class="text-red-500">*</span> (Press enter to break a new line) </label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <textarea rows="6" name="guideline_body" id="guideline_body" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="errors.guideline_body ? 'border-red-300' : 'border-gray-300'" v-model="form.guideline_body" autocomplete="none"></textarea>
                        </div>
                    </div>
                    <div class="">
                        <label for="final_message" class="block text-sm text-gray-700 font-bold"> Final Message <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <textarea rows="3" name="final_message" id="final_message" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="errors.final_message ? 'border-red-300' : 'border-gray-300'" v-model="form.final_message" autocomplete="none"></textarea>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="email_input" class="block text-sm text-gray-700 font-bold"> PIC Emails</label>
                        <div class="mt-1 flex rounded-md shadow-sm space-x-2">
                            <input type="email" name="email_input" id="email_input" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="errors.email_input ? 'border-red-300' : 'border-gray-300'" v-model="form.email_input" autocomplete="none"/>
                            <BreezeButton class="py-2.5 px-4" @click="addEmail()">Add</BreezeButton>
                        </div>
                        <div class="">
                            <ul class="w-full text-sm font-medium divide-dashed divide-y text-gray-900 bg-white border border-gray-200 rounded-lg">
                                <li class="w-full px-4 py-2 space-x-4" v-if="form.pic_emails.length" v-for="email, index in form.pic_emails"><span>{{ email.email }}</span><span class="text-xs cursor-pointer uppercase text-red-500 hover:underline" @click="deleteEmail(index)">Delete</span></li>
                                <li class="w-full px-4 py-2 space-x-4 bg-gray-100" v-else><span class="font-semibold text-gray-600 italic text-sm">No email has been added.</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:footer>
            <div class="flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                <BreezeButton type="button" buttonType="info" @click="form.id != '' ? update() : store() ">Save</BreezeButton>
                <BreezeButton buttonType="gray" @click="form_modal = false">Cancel</BreezeButton>
            </div>
        </template>
    </Modal>
    <ConfirmationModal 
        :show="open_delete_modal" 
        @close="open_delete_modal = false"
        confirmationAlert="danger"
        confirmationTitle="Delete Language"
        confirmationText="Are you sure want to delete this language?"
        confirmationButton="Delete"
        confirmationMethod="delete"
        :confirmationRoute="confirmation_data"
        :confirmationData="confirmation_route"
    />
</template>

<script>
import Pagination from '@/Components/Pagination.vue'
import Modal from '@/Components/Modal.vue'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import axios from 'axios'

export default {
    components: {
        Pagination, Modal, ConfirmationModal, 
    },
    data(){
        return{
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
            this.confirmation_data = 'dt.settings.languages.destroy'
            this.confirmation_route = language_id
            this.open_delete_modal = true
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