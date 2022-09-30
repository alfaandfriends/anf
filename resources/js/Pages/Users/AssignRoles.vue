<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <Head title="Users" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Assign Roles to User
            </h2>
        </template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit" class="h-screen">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6 h-full">
                        <div class="grid grid-rows-2 grid-cols-1 sm:grid-cols-2 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="mb-5">
                                    <h1 class="font-bold text-indigo-800">Centre Assigments</h1>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                    <Multiselect 
                                        mode="multiple"
                                        v-model="selected_centres"
                                        valueProp="ID"
                                        :multiple="true"
                                        :searchable="true"
                                        :options="options"
                                        :closeOnSelect="false"
                                        :clearOnSelect="false"
                                        :canClear="false"
                                        :hideSelected="false"
                                        :groups="true"
                                        groupOptions="libs"
                                        groupLabel="select_all"
                                        :groupSelect="true"
                                        placeholder="Select Centres"
                                        trackBy="name"
                                        label="name"
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
                                            placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-400',
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
                                            groupLabel: 'flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                                            groupLabelPointable: 'cursor-pointer',
                                            groupLabelPointed: 'bg-gray-300 text-black-700',
                                            groupLabelSelected: 'bg-gray-100 text-black',
                                            groupLabelSelectedPointed: 'bg-gray-100 text-black opacity-90',
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
                            <div class="sm:row-span-3">
                                <div class="mb-5">
                                    <h1 class="font-bold text-indigo-800">Role Assigments</h1>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                    <div class="flex flex-col justify-left">
                                        <div class="form-check" v-for="role in roles" :key="role.id">
                                            <input :id="role.id" class="form-check-input h-5 w-5 border border-gray-300 rounded-sm bg-white hover:bg-white focus:ring-transparent text-indigo-500 transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" 
                                                    type="checkbox" 
                                                    :checked="user_roles[role.id]"
                                                    :value="role.id"
                                                    v-model="selected_roles"
                                            >
                                            <label :for="role.id" class="form-check-label inline-block text-gray-800 select-none text-lg">
                                                {{ role.display_name }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="py-1 px-4 bg-green-500 rounded text-white text-md font-bold border border-green-600 hover:bg-green-600">Save</button>
                            <Link :href="route('users')" class="py-1 px-4 bg-gray-400 rounded text-white text-md font-bold border border-gray-500 hover:bg-gray-500" as="button">Cancel</Link>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { SearchIcon, TrashIcon, PencilIcon } from '@heroicons/vue/solid'
import { Head, Link } from '@inertiajs/inertia-vue3';
import Multiselect from '@vueform/multiselect'

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon,
        Head, Link, Multiselect,
    },
    props: {
        user_id: String,
        roles: Object,
        centres: Object,
        user_roles: Object,
        user_centres: Object
    },
    created(){
        var selected_roles      = this.selected_roles
        var selected_centres    = this.selected_centres
        Object.keys(this.user_roles).forEach(function(role_id){
            selected_roles.push(parseInt(role_id))
        })
        Object.keys(this.user_centres).forEach(function(centre_id){
            selected_centres.push(parseInt(centre_id))
        })
    },
    data(){
        return{
            options: [{
                select_all: 'Select All Centres',
                libs: this.$page.props.centres
            }],
            selected_roles: [],
            selected_centres: []
        }
    },
    methods: {
        submit(){
            this.$inertia.post(this.route('users.assign_centres_roles.store'), {'user_id': this.user_id, 'selected_roles': this.selected_roles, 'selected_centres': this.selected_centres});
        },
    }
}
</script>
