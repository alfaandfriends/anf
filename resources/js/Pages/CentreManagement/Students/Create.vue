<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<style>
.multiselect-assistive-text{
    display: none;
}
.student-date-picker{
    border: 1px solid #D1D5DB; /* Default border color and thickness */
    border-radius: 0.5rem;
}
:hover.student-date-picker  {
    border: 1px solid #D1D5DB; /* Highlighted border color and thickness */
}
:focus.student-date-picker  {
    border: 1px solid #D1D5DB; /* Highlighted border color and thickness */
}
.simplebar-content{
    display: flex;
    gap: 5px; 
}
</style>

<template>
    <Head title="Students" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-indigo-50 space-y-6 sm:p-6">
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="font-bold text-indigo-800">Search Information</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 sm:gap-4">
                                        <div class="mb-1">
                                            <label for="class_name" class="block text-sm font-bold text-gray-700"> Children Name <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md.shadow-sm">
                                                <Multiselect 
                                                    v-debounce="findChildren"
                                                    v-model="form.children_id"
                                                    @close="clearStudents"
                                                    valueProp="id"
                                                    :loading="searching.student"
                                                    placeholder="Please enter some keywords"
                                                    :options="list.students"
                                                    :searchable="true"
                                                    noOptionsText="Nothing found"
                                                    noResultsText="Nothing found"
                                                    :clearOnSelect="true"
                                                    :canClear="false"
                                                    :canDeselect="false"
                                                    :internal-search="false"
                                                    trackBy="name"
                                                    label="name"
                                                    :classes="{
                                                        container: 
                                                            errors.child ? 
                                                            'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded-md bg-white text-base leading-snug outline-none':
                                                            'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white text-base leading-snug outline-none',
                                                        containerDisabled: 'cursor-default bg-gray-100',
                                                        containerOpen: 'rounded-b-none',
                                                        containerOpenTop: 'rounded-t-none',
                                                        containerActive: 'border border-indigo-300',
                                                        singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                        singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                        multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                        search: 'w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded-md pl-3.5',
                                                        placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500',
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
                                                        option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3',
                                                        optionPointed: 'text-gray-800 bg-gray-100',
                                                        optionSelected: 'text-white bg-indigo-500',
                                                        optionDisabled: 'text-gray-300 cursor-not-allowed',
                                                        optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                                        optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                                        fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                                                        spacer: 'h-9 py-px box-content',
                                                    }"
                                                >
                                                </Multiselect>
                                            </div>
                                        </div>
                                        <div class="mb-1">
                                            <label for="centre" class="block text-sm font-bold text-gray-700"> Centre <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md.shadow-sm">
                                                <Multiselect 
                                                    v-model="form.centre_id"
                                                    valueProp="ID"
                                                    :searchable="true"
                                                    :options="$page.props.allowed_centres"
                                                    :clearOnSelect="true"
                                                    :canClear="false"
                                                    :canDeselect="false"
                                                    trackBy="label"
                                                    label="label"
                                                    :classes="{
                                                        container: 
                                                            errors.centre ? 
                                                            'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded-md bg-white text-base leading-snug outline-none':
                                                            'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white text-base leading-snug outline-none',
                                                        containerDisabled: 'cursor-default bg-gray-100',
                                                        containerOpen: 'rounded-b-none',
                                                        containerOpenTop: 'rounded-t-none',
                                                        containerActive: 'border border-indigo-300',
                                                        singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                        singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                        multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                        search: 'w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded-md pl-3.5',
                                                        placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500',
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
                                        <div class="mb-1">
                                            <label for="programme" class="block text-sm font-bold text-gray-700"> Start Date <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <Datepicker class="w-full rounded-lg shadow-sm" 
                                                    disabled="disabled"
                                                    :class="errors.admission_date ? '--dp-border-color: #ff6f60' : '--dp-border-color: #ff6f60'" 
                                                    input-class-name="student-date-picker focus:ring-0"
                                                    v-model="form.date_admission" 
                                                    :enable-time-picker="false"
                                                    :auto-apply="true" 
                                                    :format="'dd/MM/yyyy'"
                                                />
                                            </div>
                                        </div>
                                        <div class="mb-1">
                                            <label for="programme" class="block text-sm font-bold text-gray-700"> Programme <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="programme" id="programme" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="errors.programme ? 'border-red-300' : 'border-gray-300'" v-model="search_form.programme_id" autocomplete="off">
                                                    <option value="">-- Select Programme --</option>
                                                    <option :value="programme.id" v-for="(programme, index) in $page.props.programme_list" :key="index">{{ programme.name }} ({{ programme.country_name }})</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-1">
                                            <label for="class_type" class="block text-sm font-bold text-gray-700"> Class Type <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="class_type" id="class_type" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="[errors.class_type ? 'border-red-300' : 'border-gray-300', disable.class_type ? 'bg-gray-50' : '']" v-model="search_form.class_type" autocomplete="off" :disabled="disable.class_type">
                                                    <option value="">-- Select Type --</option>
                                                    <option :value="class_type.id" v-for="(class_type, index) in list.class_types" :key="index">{{ class_type.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-1">
                                            <label for="class_level" class="block text-sm font-bold text-gray-700"> Class Level <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="class_level" id="class_level" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="[errors.level ? 'border-red-300' : 'border-gray-300', disable.class_levels ? 'bg-gray-50' : '']" v-model="search_form.class_level" autocomplete="off" :disabled="disable.class_levels">
                                                    <option value="">-- Select Level --</option>
                                                    <option :value="i.level" v-for="i, index in list.class_levels" :key="i">{{ i.level }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-1">
                                            <label for="class_method" class="block text-sm font-bold text-gray-700"> Class Method <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="class_method" id="class_method" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="errors.class_method ? 'border-red-300' : 'border-gray-300'" v-model="search_form.class_method" autocomplete="off">
                                                    <option value="">-- Select Method --</option>
                                                    <option :value="method.id" v-for="(method, index) in $page.props.method_list" :key="index">{{ method.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-end">
                                        <div class="flex space-x-2">
                                            <BreezeButton @click="findClasses">Search Classes</BreezeButton>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4" ref="available_classes" v-if="enable_container.available_classes">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="font-bold text-indigo-800">Classes Available</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <div class="overflow-x-auto rounded-t-sm rounded-b-none">
                                                <table class="min-w-full">
                                                    <thead class="bg-indigo-200">
                                                        <tr class="px-2">
                                                            <th class="px-3 py-1 text-left">#</th>
                                                            <th class="px-3 py-1 text-left">Day</th>
                                                            <th class="px-3 py-1 text-left">Time</th>
                                                            <th class="px-3 py-1 text-left">Capacity</th>
                                                            <th class="px-3 py-1 text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-if="!list.available_classes.length">
                                                            <td colspan="10" class="py-2 text-center">
                                                                <div class="flex justify-center py-4 items-center space-x-2" v-if="searching.class">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-repeat animate-spin" viewBox="0 0 16 16">
                                                                        <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                                                        <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                                                    </svg>
                                                                    <span>Searching classes...</span>
                                                                </div>
                                                                <span v-if="!searching.class && !list.available_classes.length">No classes available</span>
                                                            </td>
                                                        </tr>
                                                        <tr v-else class="hover:bg-indigo-50" v-for="classes, index in list.available_classes">
                                                            <td class="px-3 py-2 text-left">{{ index + 1 }}</td>
                                                            <td class="px-3 py-2 text-left">{{ classes.class_day}}</td>
                                                            <td class="px-3 py-2 text-left">
                                                                <div class="text-sm font-medium text-gray-900 flex items-center">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                    </svg>
                                                                    <span class="pl-2 whitespace-nowrap">{{ moment(classes.start_time, "HH:mm:ss").format('h:mm A') }} - {{ moment(classes.end_time, "HH:mm:ss").format('h:mm A') }}</span>
                                                                </div>
                                                            </td>
                                                            <td class="px-3 py-2 text-left">{{ classes.capacity}}</td>
                                                            <td class="px-3 py-2 text-center">
                                                                <div class="flex justify-center">
                                                                    <!-- <BreezeButton v-if="classes.class_type == 1" buttonType="blue" @click="getNormalFee(classes.class_id, classes.class_type, classes.programme_id, classes.programme_level_id)">Choose</BreezeButton> -->
                                                                    <input class="h-5 w-5 border border-indigo-300 rounded-sm focus:ring-offset-0 focus:ring-0 checked:bg-gray focus:bg-white transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left cursor-pointer" 
                                                                        type="checkbox" 
                                                                        :checked="checkIfClassSelected(classes.class_id, classes.programme_id)"
                                                                        :disabled="disable_check_box"
                                                                        :class="disable_check_box ? 'bg-gray-100' : 'bg-white'"
                                                                        @click="getPlusFee($event, classes.class_id, classes.class_type, classes.programme_id, classes.programme_level_id)">
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
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4" ref="class_fee" v-if="form.fee.length">
                            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                <div class="mb-5">
                                    <h1 class="font-bold text-indigo-800">Fee Confirmation</h1>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="space-y-2">
                                    <template v-for="fee, fee_index in form.fee">
                                        <div class="grid grid-cols-1 lg:grid-cols-8 rounded-lg overflow-hidden border-2 bg-white border-indigo-500 border-dashed">
                                            <div class="col-span-3 p-6">
                                                <h3 class="flex space-x-4 items-center text-lg text-left uppercase leading-8 font-extrabold text-gray-900 sm:leading-9">
                                                    <img src="/images/school.png" class="w-16 h-16" alt="">
                                                    <span class="flex flex-col">
                                                        <span>{{ fee.fee_info.programme_name }}</span>
                                                        <span class="font-semibold text-sm">Level {{ fee.fee_info.programme_level }}</span>
                                                    </span>
                                                </h3>
                                                <div class="mt-3">
                                                    <div class="grid grid-cols-1 lg:grid-cols-2">
                                                        <ul class="grid grid-cols-1">
                                                            <li class="flex items-start col-span-1 lg:col-span-1 mb-1">
                                                                <p class="flex flex-col text-left">
                                                                    <span class="text-sm font-bold">Centre : <span class="text-sm font-normal">{{ fee.fee_info.centre_name }}</span></span>
                                                                </p>
                                                            </li>
                                                            <li class="flex items-start col-span-1 llg:col-span-1 mb-1">
                                                                <p class="flex flex-col text-left">
                                                                    <span class="text-sm font-bold">Fee : <span class="text-sm font-normal">{{ fee.fee_info.programme_type }}</span></span>
                                                                </p>
                                                            </li>
                                                            <li class="flex items-start col-span-1 llg:col-span-1 mb-2">
                                                                <p class="flex flex-col text-left">
                                                                    <span class="text-sm font-bold">Class Method : <span class="text-sm font-normal">{{ fee.fee_info.class_method }}</span></span>
                                                                </p>
                                                            </li>
                                                        </ul>
                                                        <ul class="grid grid-cols-1">
                                                            <li class="flex items-start lg:col-span-1 mb-1">
                                                                <p class="flex flex-col text-left">
                                                                    <span class="text-sm font-bold underline">Timetable</span>
                                                                    <span class="text-sm font-normal" v-for="classes in fee.classes" :key="classes.id">{{ classes.class_day }} ({{ moment(classes.start_time, "HH:mm:ss").format('h:mm A') }} - {{ moment(classes.end_time, "HH:mm:ss").format('h:mm A') }})</span>
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-5 p-3 bg-indigo-50 space-y-4">
                                                <div class="flex flex-col bg-white px-4 py-1 rounded-lg border border-gray-500">
                                                    <div class="flex flex-wrap items-center space-x-4 mt-3 pb-3 pl-2">
                                                        <h3 class="flex items-center font-semibold text-sm space-x-2 whitespace-nowrap">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="h-5 w-5">
                                                                <path d="M64 64C28.7 64 0 92.7 0 128v64c0 8.8 7.4 15.7 15.7 18.6C34.5 217.1 48 235 48 256s-13.5 38.9-32.3 45.4C7.4 304.3 0 311.2 0 320v64c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V320c0-8.8-7.4-15.7-15.7-18.6C541.5 294.9 528 277 528 256s13.5-38.9 32.3-45.4c8.3-2.9 15.7-9.8 15.7-18.6V128c0-35.3-28.7-64-64-64H64zm64 112l0 160c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16V176c0-8.8-7.2-16-16-16H144c-8.8 0-16 7.2-16 16zM96 160c0-17.7 14.3-32 32-32H448c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H128c-17.7 0-32-14.3-32-32V160z"/>
                                                            </svg>
                                                            <span>Applied Promos</span>
                                                        </h3>
                                                        <!-- <select class="text-xs rounded focus:ring-0 focus:border-indigo-300" v-model="selected_promo">
                                                            <option v-for="promo in $page.props.promos" :value="promo.id" >{{ promo.name }}</option>
                                                        </select> -->
                                                        <div @click="showPromoModal(fee_index)" class="font-semibold text-xs text-indigo-500 cursor-pointer px-2 py-1 rounded border border-dashed border-indigo-500 hover:bg-indigo-100 whitespace-nowrap">
                                                            Add Promo
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <simplebar v-if="fee.fee_info.promos.length" data-simplebar-auto-hide="true" class="mt-3 pb-3">
                                                        <span class="flex space-x-2 items-center justify-center rounded-md bg-indigo-200 px-2.5 py-1 font-semibold text-indigo-800 transform hover:scale-105 duration-200" v-for="applied_promo, promo_index in fee.fee_info.promos">
                                                            <p class="whitespace-nowrap text-xs">{{ applied_promo.promo_name }}</p>
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor" @click="deletePromo(fee_index, promo_index)" class="h-4 w-4 text-red-600 cursor-pointer">
                                                                <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/>
                                                            </svg>
                                                        </span>
                                                    </simplebar>
                                                    <div class="py-2" v-else>
                                                        <span class="text-xs font-semibold text-blue-500">No Promo applied.</span>
                                                    </div>
                                                </div>
                                                <div class="flex flex-col gap-4 justify-center text-xl leading-none font-extrabold text-gray-900 p-3">
                                                    <div class="flex justify-center">
                                                        <input :id="fee_index" type="checkbox" class="bg-white border-indigo-700 focus:ring-0 focus:ring-gray-400 h-5 w-5 rounded cursor-pointer" @click="fee.fee_info.include_material_fee = !fee.fee_info.include_material_fee" :checked="fee.fee_info.include_material_fee">
                                                        <label :for="fee_index" class="text-sm ml-3 font-medium leading-5 text-gray-800 select-none cursor-pointer">Include Material: {{ fee.fee_info.currency_symbol }}{{ fee.fee_info.material_fee }}</label>
                                                    </div>
                                                    <div class="flex justify-center items-center">
                                                        <span class="font-brown">{{ fee.fee_info.currency_symbol }}{{ total_amount }}</span>
                                                        <span class="leading-7 font-medium text-gray-700">/month</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4" ref="class_fee" v-else-if="enable_container.available_classes && !form.fee.length && !no_fee_found">
                            <div class="p-2 bg-white border border-gray-200 rounded-lg shadow-md">
                                <div id="alert-border-1" class="flex items-center p-4 text-blue-800 border-t-4 border-blue-300 bg-blue-50 dark:text-blue-400 dark:bg-gray-800 dark:border-blue-800" role="alert">
                                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <div class="ms-3 text-sm font-medium">
                                        No classes selected.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4" ref="class_fee" v-else-if="enable_container.available_classes && no_fee_found">
                            <div class="p-2 bg-white border border-gray-200 rounded-lg shadow-md">
                                <div id="alert-border-1" class="flex items-center p-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800" role="alert">
                                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <div class="ms-3 text-sm font-medium">
                                        Fee is not available for the selected classes.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4" v-if="form.fee.length">
                            <div class="sm:row-span-3" >
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="flex justify-end space-x-2">
                                        <BreezeButton buttonType="gray">Cancel</BreezeButton>
                                        <BreezeButton buttonType="info" @click="admitStudent">Admit</BreezeButton>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <Modal :showModal="open_promo_modal" @hideModal="open_promo_modal = false" :modalType="'xs'">
            <template v-slot:header>
                <div class="flex items-center justify-between py-3 px-4 border-b rounded-t font-semibold">
                    <h3 class="text-gray-900 text-xl font-semibold">                
                        Add Promos
                    </h3>        
                    <button type="button" @click="open_promo_modal = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>        
            </template>
            <template v-slot:content>
                <div class="p-6">
                    <div class="mb-4">
                        <div class="mt-1 flex rounded-md.shadow-sm">
                            <Multiselect 
                                v-model="selected_promo.promo_id"
                                valueProp="promo_id"
                                :searchable="true"
                                :options="$page.props.promos"
                                :clearOnSelect="true"
                                :canClear="false"
                                :canDeselect="false"
                                placeholder="Select a promo"
                                trackBy="promo_name"
                                label="promo_name"
                                :classes="{
                                    container: 
                                        errors.centre ? 
                                        'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded-md bg-white text-base leading-snug outline-none':
                                        'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white text-base leading-snug outline-none',
                                    containerDisabled: 'cursor-default bg-gray-100',
                                    containerOpen: 'rounded-b-none',
                                    containerOpenTop: 'rounded-t-none',
                                    containerActive: 'border border-indigo-300',
                                    singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                    singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                    multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                    search: 'w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded-md pl-3.5',
                                    placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500',
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
            </template>
            <template v-slot:footer>
                <div class="flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                    <BreezeButton buttonType="info" @click="addPromo()">Apply</BreezeButton>
                </div>
            </template>
        </Modal>
    </BreezeAuthenticatedLayout>
</template>



<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Datepicker from '@vuepic/vue-datepicker';
import Multiselect from '@vueform/multiselect'
import moment from 'moment';
import { debounce } from 'vue-debounce'
import Modal from '@/Components/Modal.vue'
import simplebar from 'simplebar-vue';
import 'simplebar-vue/dist/simplebar.min.css';


export default {
    components: {
        Head, Link, Datepicker, Multiselect, Modal, simplebar, 
    },
    props: {
        centre_id: String,
    },
    data(){
        return{
            open_promo_modal: false,
            disable_check_box: false,
            fetching_fee: false,
            no_fee_found: false,
            total_amount: 0,
            errors: {
                child: false,
                centre: false,
                admission_date: false,
                programme: false,
                class_type: false,
                programme: false,
                level: false,
                class_method: false,
            },
            disable: {
                class_type: true,
                class_levels: true,
            },
            list: {
                students: [],
                class_types: [],
                class_levels: [],
                available_classes: [],
            },
            searching: {
                student: false,
                class: false,
                fee: false
            },
            enable_container:{
                available_classes: false,
                show_fee: false,
            },
            search_form:{
                programme_id: '',
                class_type: '',
                class_level: '',
                class_method: '',
            },
            form: {
                date_admission: '',
                children_id: '',
                centre_id: '',
                fee: [],
            },
            selected_promo: {
                promo_id: '',
                fee_index: ''
            },
            selected_plus_class: {}
        }
    },
    watch: {
        'search_form.programme_id': {
            handler(){
                if(this.search_form.programme_id){
                    this.disable.class_type = true
                    this.disable.class_levels = true
                    this.search_form.class_type = ''
                    this.search_form.class_level = ''
                    axios.get(route('classes.get_class_types'), {
                        params: {
                            'programme_id': this.search_form.programme_id,
                        }
                    })
                    .then((response) => {
                        this.list.class_types = response.data
                        this.disable.class_type = false
                    })
                }
            },
            deep: true
        },
        'search_form.class_type': {
            handler(){
                if(this.search_form.programme_id && this.search_form.class_type){
                    this.disable.class_levels = true
                    this.search_form.class_level = ''
                    axios.get(route('classes.get_class_levels'), {
                        params: {
                            'programme_id': this.search_form.programme_id,
                            'class_type': this.search_form.class_type
                        }
                    })
                    .then((response) => {
                        this.list.class_levels = response.data
                        this.disable.class_levels = false
                    })
                }
            },
            deep: true
        },
        'form.fee': {
            handler(){
                this.total_amount = 0;
                for (const feeObject of this.form.fee) {
                    const { include_material_fee, material_fee, programme_fee, promos } = feeObject.fee_info;

                    // Calculate total promo values for this fee
                    const totalPercentValuePromo = promos.reduce((accumulator, currentValue) => 
                        currentValue.type_id === 1 ? accumulator + currentValue.value : accumulator, 0);
                    const totalFixedValuePromo = promos.reduce((accumulator, currentValue) => 
                        currentValue.type_id === 2 ? accumulator + currentValue.value : accumulator, 0);

                    // Calculate fee amount after applying promos
                    let fee_amount = include_material_fee ? Number(programme_fee) + Number(material_fee) : Number(programme_fee);
                    this.total_amount = fee_amount - totalFixedValuePromo - (fee_amount * totalPercentValuePromo / 100);
                }
            },
            deep: true
        },
    },
    methods: {
        submit() {
            this.$inertia.post(route('classes.store'), this.form, { preserveState: true})
        },
        findChildren(query){
            debounce(val => '400ms')(10)
            if(query){
                this.searching.student = true
                axios.get(route('children.find'), {
                    params: {
                        'keyword': query
                    }
                })
                .then((res) => {
                    this.list.students = res.data
                    this.searching.student = false
                });
            }
        },
        findClasses(){
            this.errors.child           =   !this.form.children_id ? true : false
            this.errors.centre          =   !this.form.centre_id ? true : false
            this.errors.admission_date  =   !this.form.date_admission ? true : false
            this.errors.programme       =   !this.search_form.programme_id ? true : false
            this.errors.class_type      =   !this.search_form.class_type ? true : false
            this.errors.level           =   !this.search_form.class_level ? true : false
            this.errors.class_method    =   !this.search_form.class_method ? true : false

            if(this.form.children_id && this.form.centre_id && this.search_form.programme_id && this.search_form.class_level && this.search_form.class_type && this.search_form.class_method){
                this.searching.class = true   
                this.enable_container.show_fee = false
                this.list.available_classes = []
                axios.get(route('classes.find'), {
                    'params': {
                        'centre_id': this.form.centre_id,
                        'programme_id':  this.search_form.programme_id,
                        'class_method':  this.search_form.class_method,
                        'class_level':  this.search_form.class_level,
                        'class_type':  this.search_form.class_type,
                    }
                })
                .then((res) => {
                    this.list.available_classes = res.data
                    this.enable_container.available_classes = true,
                    this.searching.class = false
                    this.scrollToElement('available_classes')
                });
            }
        },
        // getNormalFee(class_id, class_type_id, programme_id, programme_level_id){
        //     if(this.fetching_fee){
        //         return
        //     }
        //     const only_one_class_allowed   = this.form.fee.find(item => item.fee_info.class_type_id == 1 && item.fee_info.class_type_id == class_type_id && item.fee_info.programme_id == programme_id);
        //     if(only_one_class_allowed){
        //         alert('Only one class is allowed for normal class.')
        //         this.searching.fee = false
        //         return
        //     }
        //     const programme_already_added   = this.form.fee.find(item => item.fee_info.programme_id == programme_id && item.fee_info.class_type_id != class_type_id);
        //     if(programme_already_added){
        //         alert('This programme already been added. Please remove the previous one first.')
        //         this.searching.fee = false
        //         return
        //     }
        //     this.fetching_fee = true
        //     axios.get(route('programmes.get_fee'), {
        //         'params': {
        //             'class_id' : class_id,
        //             'programme_level_id' : programme_level_id,
        //         }
        //     })
        //     .then((res) => {
        //         this.form.fee.push(res.data)
        //         this.scrollToElement('class_fee')
        //         this.searching.fee = false
        //         this.fetching_fee = false
        //     });
        // },
        getPlusFee(event, class_id, class_type, programme_id, programme_level_id){
            if(this.fetching_fee){
                return
            }
            if(this.disable_check_box){
                return
            }
            // const  programme_already_added   = this.form.fee.find(item => item.fee_info.programme_id == programme_id && item.fee_info.class_type_id != class_type);
            // if(programme_already_added){
            //     alert('This programme already been added. Please remove the previous one first.')
            //     if(event.target.checked){
            //         event.target.checked = false
            //     }
            //     this.searching.fee = false
            //     return
            // }

            this.disable_check_box = true

            if(event.target.checked){
                if(!this.selected_plus_class[programme_id]){
                    this.selected_plus_class[programme_id] = []
                }
                this.selected_plus_class[programme_id].push(class_id)
            }
            else{
                if(this.selected_plus_class[programme_id].length == 1){
                    this.selected_plus_class[programme_id] = []
                    this.no_fee_found = false
                }
                this.selected_plus_class[programme_id] = this.selected_plus_class[programme_id].filter(id => id !== class_id);
            }

            // this.form.fee = []
            this.form.fee = this.form.fee.filter(item => item.fee_info.programme_id !== programme_id);
            
            if(this.selected_plus_class[programme_id].length){
                this.fetching_fee = true
                axios.get(route('programmes.get_fee'), {
                    'params': {
                        'class_type' : this.search_form.class_type,
                        'class_count': this.selected_plus_class[programme_id].length,
                        'classes': this.selected_plus_class[programme_id],
                        'programme_level_id': programme_level_id
                    }
                })
                .then((res) => {
                    if(res.data.fee_info){
                        this.form.fee.push(res.data)
                    }
                    this.scrollToElement('class_fee')
                    this.searching.fee = false
                    this.disable_check_box  = false
                    this.fetching_fee = false
                })
                .catch((error) => {
                    this.searching.fee = false
                    this.disable_check_box  = false
                    this.fetching_fee = false
                    this.no_fee_found = true
                });
            }
            else{
                this.disable_check_box  = false
            }
        },
        clearStudents(){
            this.list.students = []
        },
        scrollToElement(element) {
            const el = this.$refs[element];
            if (el) {
                el.scrollIntoView({behavior: 'smooth'});
            }
        },
        deleteFee(programme_id, class_type){
            this.form.fee           =   this.form.fee.filter(item => item.fee_info.programme_id !== programme_id);
            if(class_type == 2){
                if (this.selected_plus_class.hasOwnProperty(programme_id)) {
                    delete this.selected_plus_class[programme_id];
                }
            }
        },
        admitStudent(){
            this.$inertia.post(route('students.store'), this.form)
        },
        checkIfClassSelected(class_id, programme_id){
            const classExists = this.selected_plus_class[programme_id] ? this.selected_plus_class[programme_id].includes(class_id) : false
            return classExists
        },
        sumMaterialFee(has_material_fee, material_fee, programme_fee){
            return has_material_fee ? Number(material_fee) + Number(programme_fee) : Number(programme_fee)
        },
        showPromoModal(fee_index){
            this.selected_promo.promo_id    =   ''
            this.selected_promo.fee_index   =   fee_index   
            this.open_promo_modal           =   true
        },
        addPromo(){
            const selectedPromo = this.$page.props.promos.find(promo => promo.promo_id === this.selected_promo.promo_id);
            const promoAdded    = this.form.fee[this.selected_promo.fee_index].fee_info.promos.find(promo => promo.promo_id === this.selected_promo.promo_id);
            
            if (!promoAdded && selectedPromo) {
                this.form.fee[this.selected_promo.fee_index].fee_info.promos.push({
                    promo_id: selectedPromo.promo_id,
                    promo_name: selectedPromo.promo_name,
                    type_id: selectedPromo.type_id,
                    type_name: selectedPromo.type_name,
                    value: selectedPromo.value,
                    duration_id: selectedPromo.type_id,
                    duration_name: selectedPromo.duration_name,
                    duration_count: selectedPromo.duration_count
                });
            }

            this.open_promo_modal = false
        },
        deletePromo(fee_index, promo_index){
            this.form.fee[fee_index].fee_info.promos.splice(promo_index, 1);
        },
        calculateTotal(fee_index, fee_amount){
            const totalPercentValuePromo = this.form.fee[fee_index].fee_info.promos.reduce((accumulator, currentValue) => 
                currentValue.type_id === 1 ? accumulator + currentValue.value : accumulator
            , 0);
            const totalFixedValuePromo = this.form.fee[fee_index].fee_info.promos.reduce((accumulator, currentValue) => 
                currentValue.type_id === 2 ? accumulator + currentValue.value : accumulator
            , 0);
            console.log(fee_index, fee_amount, totalPercentValuePromo, totalFixedValuePromo)
            return fee_amount - totalFixedValuePromo - (fee_amount * totalPercentValuePromo / 100)
        }
    },
    mounted(){
        const now = new Date();
        const dateString = now.toISOString().substring(0, 10);
        this.form.date_admission = `${dateString}T05:59:00.000Z`;
    }
}
</script>

<style>
.dp__input{
    border-radius: 6px;
}
.dp__theme_light {
    --dp-border-color: rgb(209 213 219 / var(--tw-border-opacity));
 }
</style>