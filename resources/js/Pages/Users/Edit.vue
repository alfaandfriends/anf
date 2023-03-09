<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Users" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-indigo-50 space-y-6 sm:p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5 border-b-indigo-500 border-b border-dashed">
                                        <h2 class="font-display font-bold text-indigo-600">Profile Information</h2>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                            <div class="mb-4">
                                                <label for="first_name" class="block text-sm text-gray-700 font-bold"> First Name <span class="text-red-500">*</span></label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <input type="text" name="first_name" id="first_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.first_name ? 'border-red-300' : 'border-gray-300'" v-model="form.first_name" autocomplete="off"/>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label for="last_name" class="block text-sm text-gray-700 font-bold"> Last Name <span class="text-red-500">*</span> </label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <input type="text" name="last_name" id="last_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.last_name ? 'border-red-300' : 'border-gray-300'" v-model="form.last_name" autocomplete="off"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                            <div class="mb-4">
                                                <label for="country" class="block text-sm text-gray-700 font-bold"> Country <span class="text-red-500">*</span> </label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <Multiselect 
                                                        autocomplete="off"
                                                        @change="clearState"
                                                        :placeholder="form.country"
                                                        :canDeselect="false"
                                                        v-model="form.country_code"
                                                        :min-chars="1"
                                                        :delay="1"
                                                        :searchable="true"
                                                        :noOptionsText="'Please enter at least 1 character'"
                                                        :options="async function(query) {
                                                            return await fetchCountries(query) 
                                                        }"
                                                        :classes="{
                                                            container: 
                                                                $page.props.errors.country ? 
                                                                'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded bg-white text-base leading-snug outline-none':
                                                                'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none',
                                                            containerDisabled: 'cursor-default bg-gray-100',
                                                            containerOpen: 'rounded-b-none',
                                                            containerOpenTop: 'rounded-t-none',
                                                            containerActive: 'border border-indigo-300',
                                                            singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                            singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                            multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                            search: 'w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded pl-3.5',
                                                            tags: 'flex-grow flex-shrink flex flex-wrap items-center mt-1 pl-2',
                                                            tag: 'bg-green-500 text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap',
                                                            tagDisabled: 'pr-2 opacity-50',
                                                            tagRemove: 'flex items-center justify-center p-1 mx-0.5 rounded-sm hover:bg-black hover:bg-opacity-10 group',
                                                            tagRemoveIcon: 'bg-multiselect-remove bg-center bg-no-repeat opacity-30 inline-block w-3 h-3 group-hover:opacity-60',
                                                            tagsSearchWrapper: 'inline-block relative mx-1 mb-1 flex-grow flex-shrink h-full',
                                                            tagsSearch: 'absolute inset-0 border-0 outline-none focus:ring-0 appearance-none p-0 text-base font-sans box-border w-full',
                                                            tagsSearchCopy: 'invisible whitespace-pre-wrap inline-block h-px',
                                                            placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-black',
                                                            caret: 'bg-multiselect-caret bg-center bg-no-repeat w-2.5 h-4 py-px box-content mr-3.5 relative z-10 opacity-40 flex-shrink-0 flex-grow-0 transition-transform transform pointer-events-none',
                                                            caretOpen: 'rotate-180 pointer-events-auto',
                                                            clear: 'pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80',
                                                            clearIcon: 'bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                                                            spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0',
                                                            dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                                            dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                                            dropdownHidden: 'hidden',
                                                            options: 'flex flex-col p-0 m-0 list-none w-full',
                                                            optionsTop: 'flex-col-reverse',
                                                            group: 'p-0 m-0',
                                                            groupLabel: 'flex text-sm box-border items-center justify-start text-left py-1 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                                                            groupLabelPointable: 'cursor-pointer',
                                                            groupLabelPointed: 'bg-gray-300 text-gray-700',
                                                            groupLabelSelected: 'bg-green-600 text-white',
                                                            groupLabelDisabled: 'bg-gray-100 text-gray-300 cursor-not-allowed',
                                                            groupLabelSelectedPointed: 'bg-green-600 text-white opacity-90',
                                                            groupLabelSelectedDisabled: 'text-green-100 bg-green-600 bg-opacity-50 cursor-not-allowed',
                                                            groupOptions: 'p-0 m-0',
                                                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3',
                                                            optionPointed: 'text-gray-800 bg-gray-100',
                                                            optionSelected: 'text-white bg-indigo-500',
                                                            optionDisabled: 'text-gray-300 cursor-not-allowed',
                                                            optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                                            optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                                            noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                                            noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                                            fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                                                            spacer: 'h-9 py-px box-content',
                                                        }"
                                                    />
                                                    <input type="hidden" v-model="form.country">
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label for="contact_number" class="block text-sm text-gray-700 font-bold"> Contact Number <span class="text-red-500">*</span> </label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <input class="text-center inline-flex items-center px-2 rounded-l-md border border-r-0 border-gray-300 bg-gray-100 text-gray-500 text-sm" v-model="form.calling_code" size="5" disabled>
                                                    <input type="number" name="contact_number" id="contact_number" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-none rounded-r-md sm:text-sm" :class="$page.props.errors.contact_number ? 'border-red-300' : 'border-gray-300'" v-model="form.contact_number" autocomplete="off"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                        <div class="">
                                            <label for="address" class="block text-sm text-gray-700 font-bold"> Address <span class="text-red-500">*</span></label>
                                            <div class="mt-1">
                                                <textarea id="address" name="address" rows="3" class="capitalize shadow-sm focus:ring-0 focus:border-indigo-300 mt-1 block w-full sm:text-sm border rounded-md" :class="$page.props.errors.address ? 'border-red-300' : 'border-gray-300'" v-model="form.address" autocomplete="off"/>
                                            </div>  
                                        </div>
                                        <div class="">
                                            <label for="state" class="block text-sm text-gray-700 font-bold"> State <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm"><Multiselect
                                                v-model="form.country_state"
                                                :placeholder="form.country_state"
                                                :noOptionsText="'Please select a state'"
                                                :options="state_list"
                                                :canDeselect="false"
                                                :classes="{
                                                    container:
                                                        $page.props.errors.country_state ? 
                                                        'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded bg-white text-base leading-snug outline-none':
                                                        'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none',
                                                    containerDisabled: 'cursor-default bg-gray-100',
                                                    containerOpen: 'rounded-b-none',
                                                    containerOpenTop: 'rounded-t-none',
                                                    containerActive: 'border border-indigo-300',
                                                    singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                    singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                    multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                    search: 'w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded pl-3.5',
                                                    tags: 'flex-grow flex-shrink flex flex-wrap items-center mt-1 pl-2',
                                                    tag: 'bg-green-500 text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap',
                                                    tagDisabled: 'pr-2 opacity-50',
                                                    tagRemove: 'flex items-center justify-center p-1 mx-0.5 rounded-sm hover:bg-black hover:bg-opacity-10 group',
                                                    tagRemoveIcon: 'bg-multiselect-remove bg-center bg-no-repeat opacity-30 inline-block w-3 h-3 group-hover:opacity-60',
                                                    tagsSearchWrapper: 'inline-block relative mx-1 mb-1 flex-grow flex-shrink h-full',
                                                    tagsSearch: 'absolute inset-0 border-0 outline-none focus:ring-0 appearance-none p-0 text-base font-sans box-border w-full',
                                                    tagsSearchCopy: 'invisible whitespace-pre-wrap inline-block h-px',
                                                    placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-black',
                                                    caret: 'bg-multiselect-caret bg-center bg-no-repeat w-2.5 h-4 py-px box-content mr-3.5 relative z-10 opacity-40 flex-shrink-0 flex-grow-0 transition-transform transform pointer-events-none',
                                                    caretOpen: 'rotate-180 pointer-events-auto',
                                                    clear: 'pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80',
                                                    clearIcon: 'bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                                                    spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0',
                                                    dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                                    dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                                    dropdownHidden: 'hidden',
                                                    options: 'flex flex-col p-0 m-0 list-none w-full',
                                                    optionsTop: 'flex-col-reverse',
                                                    group: 'p-0 m-0',
                                                    groupLabel: 'flex text-sm box-border items-center justify-start text-left py-1 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                                                    groupLabelPointable: 'cursor-pointer',
                                                    groupLabelPointed: 'bg-gray-300 text-gray-700',
                                                    groupLabelSelected: 'bg-green-600 text-white',
                                                    groupLabelDisabled: 'bg-gray-100 text-gray-300 cursor-not-allowed',
                                                    groupLabelSelectedPointed: 'bg-green-600 text-white opacity-90',
                                                    groupLabelSelectedDisabled: 'text-green-100 bg-green-600 bg-opacity-50 cursor-not-allowed',
                                                    groupOptions: 'p-0 m-0',
                                                    option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3',
                                                    optionPointed: 'text-gray-800 bg-gray-100',
                                                    optionSelected: 'text-white bg-indigo-500',
                                                    optionDisabled: 'text-gray-300 cursor-not-allowed',
                                                    optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                                    optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                                    noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                                    noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                                    fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                                                    spacer: 'h-9 py-px box-content',
                                                }"
                                            />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="font-bold text-indigo-800">Role Assigments</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="grid grid-cols-1 sm:grid-cols-5 gap-2">
                                                <label :for="role.id" class="rounded bg-indigo-100 hover:bg-indigo-200 drop-shadow-sm hover:drop-shadow-md px-2 py-1 w-full inline-block text-gray-800 select-none text-lg" v-for="role in roles" :key="role.id">
                                                    <input :id="role.id" class="form-check-input h-5 w-5 border border-gray-300 rounded-sm bg-white hover:bg-white focus:ring-transparent text-indigo-500 transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" 
                                                            type="checkbox" 
                                                            :checked="user_roles[role.id]"
                                                            :value="role.id"
                                                            v-model="selected_roles"
                                                    >
                                                    {{ role.display_name }}
                                                </label>
                                            <!-- <div class="form-check "> -->
                                            <!-- </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="flex flex-row-reverse items-center justify-between">
                                        <div class="flex space-x-2">
                                            <BreezeButton :buttonType="'gray'" :route="route('users')">Cancel</BreezeButton>
                                            <BreezeButton type="submit">Save</BreezeButton>
                                        </div>
                                        <div class="flex">
                                            <BreezeButton :class="'px-4 py-2 bg-red-600 hover:bg-red-700 drop-shadow-sm'" @click="resetPassword(info.user_id)">Reset Password</BreezeButton>
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
            confirmationTitle="Warning"
            confirmationText="This user's password will be reset and new password will be sent to their email, are you sure want to proceed?"
            confirmationButton="Reset Password"
            confirmationMethod="post"
            :confirmationRoute="confirmationRoute"
            :confirmationData="confirmationData"
        >
        </ConfirmationModal>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { SearchIcon, TrashIcon, PencilIcon } from '@heroicons/vue/solid'
import { Head, Link } from '@inertiajs/inertia-vue3';
import Multiselect from '@vueform/multiselect'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'

const fetchCountries = async (query) => {
    if(query){
        const response = await fetch(
            'https://restcountries.com/v2/name/' + query
        );

        const data = await response.json(); 
        
        return data.map((item) => {
            return { 
                value: item.alpha2Code, 
                label: item.name 
            }
        })
    }
}
export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon,
        Head, Link, Multiselect, ConfirmationModal
    },
    props: {
        info: Object,
        user_id: String,
        roles: Object,
        user_roles: Object,
    },
    created(){
        var selected_roles      = this.selected_roles
        Object.keys(this.user_roles).forEach(function(role_id){
            selected_roles.push(parseInt(role_id))
        })
    },
    data(){
        return{
            isOpen: false,
            confirmationTitle: '',
            confirmationText: '',
            confirmationAlert: '',
            confirmationButton: '',
            confirmationMethod: '',
            confirmationData: {},
            confirmationRoute: '',
            selected_roles: [],
            state_list: [],
            form: {
                first_name: this.info ? this.info.user_first_name : '',
                last_name: this.info ? this.info.user_last_name : '',
                calling_code: this.info ? this.info.user_calling_code : '',
                contact_number: this.info ? this.info.user_contact : '',
                address: this.info ? this.info.user_address : '',
                country: this.info ? this.info.user_country : '',
                country_state: this.info ? this.info.user_state : '',
                country_code: this.info ? this.info.user_country_code : '',
            },
        }
    },
    watch: {
        'form.country_code': {
            handler(country_code){
                if(country_code){
                    /* Set calling code and state list*/
                    this.setCallingCode(country_code)
                    this.setStateList(country_code)

                }
            },
            immediate: true
        }
    },
    methods: {
        submit(){
            this.$inertia.post(this.route('users.manage_roles.store'), {'user_id': this.user_id, 'selected_roles': this.selected_roles, 'form': this.form});
        },
        resetPassword(userID){
            this.confirmationRoute = 'users.reset_user_password'
            this.confirmationData['user_id'] =  userID
            this.isOpen = true
        },
        setCallingCode(country_code){
            axios
                .get('https://restcountries.com/v3.1/alpha/' + country_code)
                .then(response => {
                    this.form.country       =   response.data[0].name.official
                    this.form.calling_code  =   response.data[0].idd.root + response.data[0].idd.suffixes[0]
                })
                .catch(error => {
                    this.errored = true
                })
        },
        setStateList(country_code){
            var state_list  =   this.state_list
            state_list.splice(0)
            axios({
                method: 'post',
                url: 'https://countriesnow.space/api/v0.1/countries/states',
                headers: {
                    "Content-Type": "application/json"
                }, 
                data: {
                        "iso2": country_code, 
                }
            }).then(response => {
                response.data.data.states.forEach(function(state) {
                    state_list.push(state.name)
                });
            })
        },
        clearState(){
            this.form.country_state = '';
        },
    }
}
</script>
