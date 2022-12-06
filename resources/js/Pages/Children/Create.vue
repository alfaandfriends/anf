<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Children"></Head>

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6 h-full">
                        <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                            <div class="sm:row-span-3">
                                <div class="mb-5 border-b-indigo-500 border-b border-dashed">
                                    <h2 class="font-display font-bold text-indigo-600">Children Information</h2>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-4 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="first_name" class="block text-sm text-gray-700 font-bold"> Name <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="first_name" id="first_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.name ? 'border-red-300' : 'border-gray-300'" v-model="form.name" autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="gender" class="block text-sm font-bold text-gray-700"> Gender <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <select name="gender" id="gender" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.gender ? 'border-red-300' : 'border-gray-300'" v-model="form.gender" autocomplete="off">
                                                <option value="">-- Select Gender --</option>
                                                <option :value="gender.id" v-for="(gender, index) in $page.props.gender_list" :key="index">{{ gender.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="end_time" class="block text-sm font-bold text-gray-700"> Date of Birth <span class="text-red-500">*</span></label>
                                        <Datepicker :class="'mt-1 rounded-md shadow-sm'" :style="$page.props.errors.dob ? '--dp-border-color: #fa9e9e' : ''" v-model="form.dob" :enableTimePicker="false" :noToday="true" :autoApply="true" :format="dateFormat"/>
                                    </div>
                                    <div class="mb-4 self-end">
                                        <BreezeButton class="py-2.5" @click="addChild">Add Child</BreezeButton>
                                    </div>
                                </div>
                                <hr class="mb-5">
                                <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                    <div class="flex flex-col">
                                        <div class="-m-1.5 overflow-x-auto">
                                        <div class="p-1.5 min-w-full inline-block align-middle">
                                            <div class="border rounded-lg shadow overflow-hidden">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead>
                                                <tr class="divide-x divide-gray-200 bg-gray-100">
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Name</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Gender</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date of Birth</th>
                                                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200">
                                                    <tr v-if="!$page.props.children_list.length">
                                                        <td colspan="10" class="text-center py-4 text-gray-400 text-sm">
                                                            No children added
                                                        </td>
                                                    </tr>
                                                    <tr v-else v-for="child in $page.props.children_list">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ child.name }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ child.gender }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ moment(child.dob).format('DD/MM/Y') }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                            <div class="flex space-x-2 justify-center">
                                                                <BreezeButton buttonType="warning" @click="editChild(child.id)">Edit</BreezeButton>
                                                                <BreezeButton buttonType="danger" @click="deleteChild(child.id)">Delete</BreezeButton>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <ConfirmationModal 
            :show="isOpen" 
            @close="isOpen = false"
            confirmationAlert="danger"
            confirmationTitle="Delete Class"
            confirmationText="Are you sure want to delete this class?"
            confirmationButton="Delete"
            confirmationMethod="delete"
            :confirmationRoute="confirmationRoute"
            :confirmationData="confirmationData"
        >
        </ConfirmationModal>
        <vue-final-modal v-model="showEdit" :lock-scroll="true" :click-to-close="false">
        <div id="default-modal" data-modal-show="true" aria-hidden="true" class="overflow-x-hidden overflow-y-auto h-modal md:h-full top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center">
            <div class="absolute top-[10%] inset-x-[20%]">
                <div class="bg-white rounded-lg shadow relative">
                    <div class="flex items-center justify-between py-3 px-6 border-b rounded-t">
                        <span class="text-lg font-semibold text-gray-700">Edit Child Details</span>
                        <button @click="showEdit = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <div class="p-6 space-y-2 overflow-y-auto" style="max-height: calc(100vh - 350px)">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-0 sm:gap-4">
                            <div class="mb-4">
                                <label for="first_name" class="block text-sm text-gray-700 font-bold"> Name <span class="text-red-500">*</span></label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="first_name" id="first_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.edit_name ? 'border-red-300' : 'border-gray-300'" v-model="editForm.edit_name" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="gender" class="block text-sm font-bold text-gray-700"> Gender <span class="text-red-500">*</span></label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <select name="gender" id="gender" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.edit_gender ? 'border-red-300' : 'border-gray-300'" v-model="editForm.edit_gender" autocomplete="off">
                                        <option value="">-- Select Gender --</option>
                                        <option :value="gender.id" v-for="(gender, index) in $page.props.gender_list" :key="index">{{ gender.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="end_time" class="block text-sm font-bold text-gray-700"> Date of Birth <span class="text-red-500">*</span></label>
                                <Datepicker :class="'mt-1 rounded-md shadow-sm'" :style="$page.props.errors.edit_dob? '--dp-border-color: #fa9e9e' : ''" v-model="editForm.edit_dob" :enableTimePicker="false" :noToday="true" :autoApply="true" :format="dateFormat"/>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                            <div class="flex justify-end space-x-2">
                                <BreezeButton buttonType="gray" class="py-2.5" @click="showEdit = false">Cancel</BreezeButton>
                                <BreezeButton class="py-2.5" @click="updateChild">Save</BreezeButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </vue-final-modal>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import { $vfm, VueFinalModal, ModalsContainer } from 'vue-final-modal'
import moment from 'moment';

export default {
    components: {
        Head, Link, Datepicker, ConfirmationModal, VueFinalModal
    },
    data() {
        return{
            showEdit: false,
            isOpen: false,
            confirmationRoute: '',
            confirmationData: '',
            form: {
                name: '',
                gender: '',
                dob: '',
            },
            editForm:{
                edit_child_id: '',
                edit_name: '',
                edit_gender: '',
                edit_dob: '',
            }
        }
    },
    methods: {
        addChild() {
            this.$inertia.post(route('children.store'), this.form)
        },
        editChild(child_id){
            axios.get(route('children.edit'), {
                params: {
                    'child_id': child_id
                }
            })
            .then((res) => {
                this.editForm.edit_child_id =   child_id
                this.editForm.edit_name     =   res.data.name
                this.editForm.edit_gender   =   res.data.gender_id
                this.editForm.edit_dob      =   res.data.date_of_birth
                this.showEdit               =   true
            });
        },
        updateChild() {
            this.$inertia.post(route('children.update'), this.editForm, {
                onSuccess: page => {
                    this.showEdit   =   false
                }
            })
        },
        dateFormat(date){
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();

            return `${day}/${month}/${year}`;
        }
    }
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
