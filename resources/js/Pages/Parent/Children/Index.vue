<template>
    <Head title="Home" />
    <Authenticated>
        <div class="flex justify-center">
            <div class="flex-1 max-w-xl space-y-4">
                <div class="relative flex flex-col items-center px-4 py-4 rounded-2xl border-2 border-gray-400 bg-white shadow-md hover:bg-indigo-50 cursor-pointer" v-if="$page.props.user_has_children.length" v-for="info in $page.props.user_has_children" @click="switchChild(info.child_id, info.child_name, info.student_id)">
                    <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400" v-if="!switching && info.child_id == $page.props.current_active_child.child_id">Currently Viewing</span>
                    <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400" v-if="switching && info.child_id == $page.props.current_active_child.child_id">Switching...</span>
                    <span class="flex items-center text-md font-extrabold mb-1 text-center space-x-2">
                        {{ info.child_name }}
                    </span>
                    <span class="text-sm">{{ moment(info.child_dob).format('Do MMMM Y') }} (<span class="text-sm">{{ getAge(moment(info.child_dob).format('DD/MM/Y')) }} years old</span>)</span>
                    <span class="text-sm mb-3">{{ info.child_gender }}</span>
                    <h3 class="text-sm text-gray-500">{{ $page.props.children_class_info[info.student_id] ? $page.props.children_class_info[info.student_id].length + ' active class' : 'No class' }}</h3>
                    <h3 class="text-sm text-gray-500 mb-3">{{ $page.props.children_class_info[info.student_id] ? $page.props.children_class_info[info.student_id][0].label : 'No centre' }}</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-6 w-6" fill="currentColor" @click="!info.student_id ? deleteChild(info.child_id) : ''" :class="!info.student_id ? 'text-red-600 hover:text-red-700 cursor-pointer' : 'text-red-300 cursor-not-allowed'">
                        <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                    </svg>
                </div>
                <div class="flex justify-center py-10 text-slate-500 text-lg" v-else>
                    No child has been added.
                </div>
                <div class="flex justify-center mb-3">
                    <BreezeButton type="button" buttonType="info" @click="showAddChild">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 448 512">
                            <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/>
                        </svg>
                        Add Child
                    </BreezeButton>
                </div>
                <!-- <div class="bg-white shadow rounded-lg border">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-gray-700 capitalize bg-gray-200">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Age
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Gender
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b" v-if="!$page.props.children_list || !$page.props.children_list.length">
                                <td class="text-center py-4" colspan="10">
                                    No record found.
                                </td>
                            </tr>
                            <tr class="bg-white border-b hover:bg-gray-50" v-else v-for="child, invoice_index in $page.props.children_list">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ child.name }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ moment(child.dob).format('DD/MM/Y') }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ child.gender }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-xs font-medium px-2 py-1 rounded-full whitespace-nowrap" :class="child.student_id ? 'text-green-500 bg-green-100' : 'text-red-500 bg-red-100'">{{ child.student_id ? 'Enrolled' : 'Not Enrolled' }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button type="button" @click="!child.student_id ? deleteChild(child.id) : ''" class="font-medium px-3 py-1 rounded whitespace-nowrap" :class="!child.student_id ? 'text-white bg-red-600 hover:bg-red-700 cursor-pointer' : 'text-white bg-red-300 cursor-not-allowed'">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> -->
                <!-- <div class="flex items-end justify-end fixed bottom-24 right-4 md:hidden lg:hidden">
                    <button class="bg-indigo-600 hover:bg-indigo-600 text-white font-semibold p-3 rounded-full shadow-lg" @click="showAddChild">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                        </svg>
                    </button>
                </div> -->
            </div>
        </div>
        <ConfirmationModal 
            :show="isOpen" 
            @close="isOpen = false"
            :confirmationAlert="confirmationAlert"
            :confirmationTitle="confirmationTitle"
            :confirmationText="confirmationText"
            :confirmationButton="confirmationButton"
            :confirmationMethod="confirmationMethod"
            :confirmationRoute="confirmationRoute"
            :confirmationData="confirmationData"
        >
        </ConfirmationModal>
        <SimpleModal :isOpen="show_add_child" @close="show_add_child = false">
            <template #header>
                Add Child
            </template>
            <div class="">
                <label class="font-medium text-gray-900 text-sm md:text-md">Name</label>
                <input type="text" class="mt-1 focus:ring-0 focus:border-gray-300 flex-1 block w-full rounded-md mb-4 text-sm md:text-md" :class="!errors.name ? 'border-gray-300' : 'border-red-300'" v-model="child_form.name">
                <label class="font-medium text-gray-900 text-sm md:text-md">Date of Birth</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <Datepicker class="w-full rounded-lg shadow-sm mb-4 " 
                        :style="errors.dob ? '--dp-border-color: #FCA5A5' : '--dp-border-color: #D1D5DB'" 
                        input-class-name="date-picker"
                        v-model="child_form.dob" 
                        :enable-time-picker="false"
                        :auto-apply="true" 
                        :format="'dd/MM/yyyy'"
                    />
                </div>
                <label class="font-medium text-gray-900 text-sm md:text-md">Gender</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <select name="gender" id="gender" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm cursor-pointer" :class="!errors.gender ? 'border-gray-300' : 'border-red-300'" v-model="child_form.gender" autocomplete="none">
                        <option value="">-- Select Gender --</option>
                        <option :value="gender.id" v-for="(gender, index) in $page.props.gender_list" :key="index">{{ gender.name }}</option>
                    </select>
                </div>
                <hr class="my-5">
                <div class="flex justify-end items-center space-x-2">
                    <BreezeButton @click="addChild" buttonType="info" class="px-4 py-2">
                        <div v-if="adding" class="flex space-x-2">
                            <svg aria-hidden="true" class="inline w-4 h-4 text-gray-200 animate-spin fill-indigo-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                            <span>Adding...</span>
                        </div>
                        <span v-else>Add</span>
                    </BreezeButton>
                    <BreezeButton type="button" buttonType="gray" @click="show_add_child = false" v-if="!adding">Cancel</BreezeButton>
                </div>
            </div>
        </SimpleModal>
    </Authenticated>
</template>

<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import BreezeButton from '@/Components/Button.vue'
import SimpleModal from '@/Components/Parent/SimpleModal.vue';
</script>

<script>
import moment from 'moment';
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import Datepicker from '@vuepic/vue-datepicker';

export default {
    components: {
        ConfirmationModal, Datepicker
    },
    data(){
        return{
            isOpen: false,
            switching: false,
            confirmationAlert: '',
            confirmationTitle: '',
            confirmationText: '',
            confirmationButton: '',
            confirmationMethod: '',
            confirmationRoute: '',
            confirmationData: '',
            show_add_child: false,
            adding: false,
            disable_overlay: false,
            child_form: {
                name: '',
                gender: '',
                dob: ''
            },
            errors: []
        }
    },
    methods: {
        deleteChild(child_id){
            console.log(child_id)
            this.confirmationAlert  = 'danger',
            this.confirmationTitle  = 'Warning',
            this.confirmationText   = "This child will be deleted permanently, are you sure want to proceed?",
            this.confirmationButton = 'Delete',
            this.confirmationMethod = 'delete',
            this.confirmationRoute = 'children.destroy'
            this.confirmationData =  child_id
            this.isOpen = true
        },
        showAddChild(){
            for (let key in this.child_form) {
                if (this.child_form.hasOwnProperty(key)) {
                    this.child_form[key] = '';
                }
            }
            this.errors = []
            this.show_add_child = true
        },
        addChild(){
            if(this.adding){
                return
            }
            for (let key in this.child_form) {
                if (this.child_form[key] == '' || !this.child_form[key]) {
                    this.errors[key] = true
                }
                else{
                    this.errors[key] = false
                }
            }
            const proceed = Object.values(this.child_form).every(value => value !== null && value !== '');
            
            if (proceed) {
                this.child_form.parent_id   =  this.$page.props.auth.user.ID,
                this.$inertia.post(route('children.store'), this.child_form, {
                    preserveState: false,
                    preserveScroll: true,
                    onBefore: (visit) => {
                        this.adding = true
                        this.disable_overlay = true
                    },
                    onFinish: (visit) => {
                        this.disable_overlay = false
                        this.show_add_child = false
                        this.adding = false
                    },
                })
            }
        },
        getAge(dob){
            const birthDate = moment(dob, 'YYYY-MM-DD');
            const today = moment();
            return today.diff(birthDate, 'years');
        },
        switchChild(child_id, child_name, student_id){
            if(this.switching || child_id == this.$page.props.current_active_child.child_id){
                return
            }
            this.switching = true
            axios.post(route('parent.switch_child', {child_id: child_id, child_name: child_name, student_id: student_id}))
            .then(response => {
                if(response.data){
                    location.reload()
                }
            });
        },
    }
}
</script>

