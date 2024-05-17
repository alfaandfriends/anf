<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Diagnostic Test" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <!-- <input type="hidden" v-model="menu_id"> -->
                    <div class="px-4 py-5 bg-indigo-50 space-y-2 sm:p-6">
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="text-indigo-800 font-bold">Diagnostic Test Information</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="name" class="block text-sm text-gray-700 font-bold">Name<span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="name" id="name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.name ? 'border-red-300' : 'border-gray-300'" v-model="form.name" autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="age" class="block text-sm text-gray-700 font-bold mb-1">Age<span class="text-red-500">*</span></label>
                                            <Multiselect 
                                                id="centres"
                                                v-model="form.age"
                                                valueProp="id"
                                                :searchable="true"
                                                :options="$page.props.ages"
                                                :closeOnSelect="true"
                                                :canClear="false"
                                                :canDeselect="false"
                                                placeholder="Please select an age"
                                                trackBy="name"
                                                label="name"
                                                :classes="{
                                                    container: 
                                                        $page.props.errors.age ? 
                                                        'relative px-0 w-full flex items-center box-border cursor-pointer border border-red-300 rounded-md bg-white text-sm leading-snug outline-none h-[2.35rem]':
                                                        'relative px-0 w-full flex items-center box-border cursor-pointer border border-gray-300 rounded-md bg-white text-sm leading-snug outline-none h-[2.35rem]',
                                                    containerDisabled: 'cursor-default bg-gray-100',
                                                    containerOpen: 'rounded-b-none',
                                                    containerOpenTop: 'rounded-t-none',
                                                    containerActive: 'border border-indigo-300',
                                                    singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                    singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                    multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                    search: 'w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded-lg h-8',
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
                                    <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="language" class="block text-sm text-gray-700 font-bold mb-1">Language<span class="text-red-500">*</span></label>
                                            <Multiselect 
                                                id="centres"
                                                v-model="form.language"
                                                valueProp="id"
                                                :searchable="true"
                                                :options="$page.props.languages"
                                                :closeOnSelect="true"
                                                :canClear="false"
                                                :canDeselect="false"
                                                placeholder="Please select a language"
                                                trackBy="name"
                                                label="name"
                                                :classes="{
                                                    container: 
                                                        $page.props.errors.language ? 
                                                        'relative px-0 w-full flex items-center box-border cursor-pointer border border-red-300 rounded-md bg-white text-sm leading-snug outline-none h-[2.35rem]':
                                                        'relative px-0 w-full flex items-center box-border cursor-pointer border border-gray-300 rounded-md bg-white text-sm leading-snug outline-none h-[2.35rem]',
                                                    containerDisabled: 'cursor-default bg-gray-100',
                                                    containerOpen: 'rounded-b-none',
                                                    containerOpenTop: 'rounded-t-none',
                                                    containerActive: 'border border-indigo-300',
                                                    singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                    singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                    multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                    search: 'w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded-lg h-8',
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
                            </div>
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="text-indigo-800 font-bold">Conditions</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-2 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="lower_score" class="block text-sm text-gray-700 font-bold">If score less than</label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="number" name="lower_score" id="lower_score" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.lower_score ? 'border-red-300' : 'border-gray-300'" v-model="form.lower_score" autocomplete="off"/>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="lower_score_direction" class="block text-sm text-gray-700 font-bold mb-1">Go to</label>
                                            <Multiselect 
                                                id="centres"
                                                v-model="form.lower_score_direction"
                                                valueProp="id"
                                                :searchable="true"
                                                :options="$page.props.dt_list"
                                                :closeOnSelect="true"
                                                :canClear="false"
                                                :canDeselect="false"
                                                placeholder="Default (No Redirect)"
                                                trackBy="name"
                                                label="name"
                                                :classes="{
                                                    container: 
                                                        $page.props.errors.lower_score_direction ? 
                                                        'relative px-0 w-full flex items-center box-border cursor-pointer border border-red-300 rounded-md bg-white text-sm leading-snug outline-none h-[2.35rem]':
                                                        'relative px-0 w-full flex items-center box-border cursor-pointer border border-gray-300 rounded-md bg-white text-sm leading-snug outline-none h-[2.35rem]',
                                                    containerDisabled: 'cursor-default bg-gray-100',
                                                    containerOpen: 'rounded-b-none',
                                                    containerOpenTop: 'rounded-t-none',
                                                    containerActive: 'border border-indigo-300',
                                                    singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                    singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                    multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                    search: 'w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded-lg h-8',
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
                                    <div class="grid grid-cols-2 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="higher_score" class="block text-sm text-gray-700 font-bold">If score more than</label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="number" name="higher_score" id="higher_score" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.higher_score ? 'border-red-300' : 'border-gray-300'" v-model="form.higher_score" autocomplete="off"/>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="higher_score_direction" class="block text-sm text-gray-700 font-bold mb-1">Go to</label>
                                            <Multiselect 
                                                id="centres"
                                                v-model="form.higher_score_direction"
                                                valueProp="id"
                                                :searchable="true"
                                                :options="$page.props.dt_list"
                                                :closeOnSelect="true"
                                                :canClear="false"
                                                :canDeselect="false"
                                                placeholder="Default (No Redirect)"
                                                trackBy="name"
                                                label="name"
                                                :classes="{
                                                    container: 
                                                        $page.props.errors.higher_score_direction ? 
                                                        'relative px-0 w-full flex items-center box-border cursor-pointer border border-red-300 rounded-md bg-white text-sm leading-snug outline-none h-[2.35rem]':
                                                        'relative px-0 w-full flex items-center box-border cursor-pointer border border-gray-300 rounded-md bg-white text-sm leading-snug outline-none h-[2.35rem]',
                                                    containerDisabled: 'cursor-default bg-gray-100',
                                                    containerOpen: 'rounded-b-none',
                                                    containerOpenTop: 'rounded-t-none',
                                                    containerActive: 'border border-indigo-300',
                                                    singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                    singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                    multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                    search: 'w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded-lg h-8',
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
                            </div>
                        </div><div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="text-indigo-800 font-bold">Chart Settings</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-2 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="chart_type" class="block text-sm text-gray-700 font-bold">Chart Type</label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="chart_type" id="chart_type" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.chart_type ? 'border-red-300' : 'border-gray-300'" v-model="form.chart_type" autocomplete="off">
                                                    <option :value="chart.id" v-for="chart in $page.props.chart_types">{{ chart.name }}</option>
                                                </select>
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
                                        <BreezeButton buttonType="gray" :route="route('dt.settings')">Cancel</BreezeButton>
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
        Head, Link, 
    },
    data(){
        return{
            form: {
                name: '',
                age: '',
                language: '',
                chart_type: this.$page.props.chart_types[0].id,
                lower_score: '',
                lower_score_direction: '',
                higher_score: '',
                higher_score_direction: '',
            }
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('dt.settings.store'), this.form, { preserveState: true})
        },
    }

}
</script>
