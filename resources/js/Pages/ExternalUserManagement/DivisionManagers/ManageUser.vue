<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Division Managers" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-indigo-50 space-y-6 sm:p-6">
                        <div class="grid grid-rows-2 grid-cols-1 sm:grid-cols-2 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="font-bold text-indigo-800">Centre Assigments</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                        <div class="">
                                            <label for="name" class="block text-sm font-bold text-gray-700">Name</label>
                                            <input id="name" type="text" class="mt-1 focus:ring-0 focus:border-gray-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 bg-gray-200" readonly v-model="$page.props.user_info.display_name"/>
                                        </div>
                                        <div class="">
                                            <label for="email" class="block text-sm font-bold text-gray-700">Email</label>
                                            <input id="email" type="text" class="mt-1 focus:ring-0 focus:border-gray-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 bg-gray-200" readonly v-model="$page.props.user_info.user_email"/>
                                        </div>
                                        <div class="">
                                            <label for="country" class="block text-sm text-gray-700 font-bold"> Country <span class="text-red-500">*</span> </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <Multiselect 
                                                    id="centres"
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
                                                    placeholder="Select centres"
                                                    trackBy="label"
                                                    label="label"
                                                    :classes="{
                                                        container: 
                                                            $page.props.errors.centre_id ? 
                                                            'relative px-0 w-full flex items-center box-border cursor-pointer border border-red-300 rounded-md bg-white text-sm leading-snug outline-none h-[2.35rem]':
                                                            'relative px-0 w-full flex items-center box-border cursor-pointer border border-gray-300 rounded-md bg-white text-sm leading-snug outline-none h-[2.35rem]',
                                                        containerDisabled: 'cursor-default bg-gray-100',
                                                        containerOpen: 'rounded-b-none',
                                                        containerOpenTop: 'rounded-t-none',
                                                        containerActive: 'border border-indigo-300',
                                                        singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                        singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                        multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                        search: 'w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded-lg h-9',
                                                        tags: 'flex-grow flex-shrink flex flex-wrap items-center mt-1 pl-2',
                                                        tag: 'bg-green-500 text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap',
                                                        tagDisabled: 'pr-2 opacity-50',
                                                        tagRemove: 'flex items-center justify-center p-1 mx-0.5 rounded-sm hover:bg-black hover:bg-opacity-10 group',
                                                        tagRemoveIcon: 'bg-multiselect-remove bg-center bg-no-repeat opacity-30 inline-block w-3 h-3 group-hover:opacity-60',
                                                        tagsSearchWrapper: 'inline-block relative mx-1 mb-1 flex-grow flex-shrink h-full',
                                                        tagsSearch: 'absolute inset-0 border-0 outline-none focus:ring-0 appearance-none p-0 text-base font-sans box-border w-full',
                                                        tagsSearchCopy: 'invisible whitespace-pre-wrap inline-block h-px',
                                                        placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-black',
                                                        clear: 'pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80',
                                                        clearIcon: 'bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
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
                                                        noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                                        option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3',
                                                        optionPointed: 'text-gray-800 bg-gray-100',
                                                        optionSelected: 'text-white bg-indigo-500',
                                                        optionDisabled: 'text-gray-300 cursor-not-allowed',
                                                        optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                                        optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                                        fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                                                        spacer: 'h-9 py-px box-content',
                                                        
                                                    }"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" border-b border-dashed border-indigo-900 mt-4 mb-5"></div>
                                    <div class="flex flex-row-reverse items-center">
                                        <div class="flex space-x-2">
                                            <BreezeButton :buttonType="'gray'" :url="route('division_manager')">Cancel</BreezeButton>
                                            <BreezeButton type="submit">Save</BreezeButton>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        centres: Object,
        user_centres: Object
    },
    created(){
        var selected_centres    = this.selected_centres
        Object.keys(this.user_centres).forEach(function(centre_id){
            selected_centres.push(parseInt(centre_id))
        })
    },
    data(){
        return{
            options: [{
                select_all: 'Select All Centres',
                libs: this.$page.props.allowed_centres
            }],
            selected_centres: []
        }
    },
    methods: {
        submit(){
            this.$inertia.post(this.route('division_manager.store'), {'user_id': this.user_id, 'selected_centres': this.selected_centres});
        },
    }
}
</script>
