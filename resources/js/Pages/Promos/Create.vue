<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<style>
.multiselect-assistive-text{
    display: none;
}

</style>

<template>
    <Head title="Promotions" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 space-y-6 sm:p-6">
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="text-indigo-800 font-bold">Promotion Information</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="mb-4 col-span-2">
                                            <label for="promo_name" class="block text-sm text-gray-700 font-bold">Name<span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="promo_name" id="promo_name" class="bg-white focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.promo_name ? 'border-red-300' : 'border-gray-300'" v-model="form.promo_name" autocomplete="off"/>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="promo_duration" class="block text-sm text-gray-700 font-bold">Country<span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex">
                                                <Multiselect 
                                                    autocomplete="off"
                                                    :placeholder="form.country_id"
                                                    :canDeselect="false"
                                                    v-model="form.country_id"
                                                    :searchable="true"
                                                    :canClear="false"
                                                    :noResultsText="'No result found'"
                                                    :options="$page.props.countries"
                                                    valueProp="id"
                                                    trackBy="name"
                                                    label="name"
                                                    :classes="{
                                                        container: 
                                                            $page.props.errors.country_id ? 
                                                            'relative mx-auto w-full flex flex-col items-center cursor-pointer border border-red-300 rounded-lg bg-white h-[2.35rem] rounded-md text-sm':
                                                            'relative mx-auto w-full flex flex-col items-center cursor-pointer border border-gray-300 rounded-lg bg-white h-[2.35rem] rounded-md text-sm',
                                                        containerDisabled: 'cursor-default bg-gray-100',
                                                        containerOpen: 'rounded-b-none',
                                                        containerOpenTop: 'rounded-t-none',
                                                        containerActive: 'border border-indigo-300',
                                                        singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                        singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full mb-1',
                                                        multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                        search: 'w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base text-sm font-sans bg-white rounded-md pl-3.5 h-8',
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
                                                        option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3 text-sm',
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
                                        <div class="mb-4">
                                            <label for="promo_duration" class="block text-sm text-gray-700 font-bold">Duration<span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex">
                                                <Multiselect 
                                                    autocomplete="off"
                                                    :placeholder="form.duration_id"
                                                    :canDeselect="false"
                                                    v-model="form.duration_id"
                                                    :searchable="true"
                                                    :canClear="false"
                                                    :noResultsText="'No result found'"
                                                    :options="$page.props.durations"
                                                    valueProp="id"
                                                    trackBy="name"
                                                    label="name"
                                                    :classes="{
                                                        container: 
                                                            $page.props.errors.duration_id ? 
                                                            'relative mx-auto w-full flex flex-col items-center cursor-pointer border border-red-300 rounded-lg bg-white h-[2.35rem] rounded-md text-sm':
                                                            'relative mx-auto w-full flex flex-col items-center cursor-pointer border border-gray-300 rounded-lg bg-white h-[2.35rem] rounded-md text-sm',
                                                        containerDisabled: 'cursor-default bg-gray-100',
                                                        containerOpen: 'rounded-b-none',
                                                        containerOpenTop: 'rounded-t-none',
                                                        containerActive: 'border border-indigo-300',
                                                        singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                        singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full mb-1',
                                                        multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                        search: 'w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base text-sm font-sans bg-white rounded-md pl-3.5 h-8',
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
                                                        option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3 text-sm',
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
                                        <div class="mb-4">
                                            <label for="promo_duration" class="block text-sm text-gray-700 font-bold">Type of Value<span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex">
                                                <Multiselect 
                                                    autocomplete="off"
                                                    :placeholder="form.type_id"
                                                    :canDeselect="false"
                                                    v-model="form.type_id"
                                                    :searchable="true"
                                                    :canClear="false"
                                                    :noResultsText="'No result found'"
                                                    :options="$page.props.types"
                                                    valueProp="id"
                                                    trackBy="name"
                                                    label="name"
                                                    :classes="{
                                                        container: 
                                                            $page.props.errors.type_id ? 
                                                            'relative mx-auto w-full flex flex-col items-center cursor-pointer border border-red-300 rounded-lg bg-white h-[2.35rem] rounded-md text-sm':
                                                            'relative mx-auto w-full flex flex-col items-center cursor-pointer border border-gray-300 rounded-lg bg-white h-[2.35rem] rounded-md text-sm',
                                                        containerDisabled: 'cursor-default bg-gray-100',
                                                        containerOpen: 'rounded-b-none',
                                                        containerOpenTop: 'rounded-t-none',
                                                        containerActive: 'border border-indigo-300',
                                                        singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                        singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full mb-1',
                                                        multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                        search: 'w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base text-sm font-sans bg-white rounded-md pl-3.5 h-8',
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
                                                        option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3 text-sm',
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
                                        <div class="mb-4">
                                            <label for="promo_value" class="block text-sm text-gray-700 font-bold">Value<span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="promo_value" id="promo_value" class="bg-white focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.promo_value ? 'border-red-300' : 'border-gray-300'" v-model="form.promo_value" autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="flex items-end justify-end space-x-2">
                                        <BreezeButton buttonType="gray" :route="route('fee.promos')">Cancel</BreezeButton>
                                        <BreezeButton type="submit">Save </BreezeButton>
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
import { Head, Link } from '@inertiajs/inertia-vue3';
import Multiselect from '@vueform/multiselect'

export default {
    components: {
        Head, Link, Multiselect
    },
    data(){
        return{
            form: {
                promo_name: '',
                country_id: '',
                duration_id: '',
                type_id: '',
                promo_value: '',
            }
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('fee.promos.store'), this.form, { preserveState: true})
        },
    }

}
</script>
