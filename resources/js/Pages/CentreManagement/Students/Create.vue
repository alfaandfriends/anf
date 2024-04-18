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
                            <div class="sm:row-span-3" >
                                
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="font-bold text-indigo-800">Fee Confirmation</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="space-y-2">
                                        <template v-for="fee, fee_index in form.fee">
                                            <div class="flex flex-col lg:flex-row justify-between max-w-lg rounded-lg overflow-hidden lg:max-w-none lg:flex border-2 bg-white border-indigo-500 border-dashed">
                                                <div class="p-6">
                                                    <h3 class="flex space-x-4 items-center text-lg text-left uppercase leading-8 font-extrabold text-gray-900 sm:leading-9">
                                                        <img src="/images/school.png" class="w-16 h-16" alt="">
                                                        <span class="flex flex-col">
                                                            <span>{{ fee.fee_info.programme_name }}</span>
                                                            <span class="font-semibold text-sm">Level {{ fee.fee_info.programme_level }}</span>
                                                        </span>
                                                    </h3>
                                                    <div class="mt-3">
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
                                                            <li class="flex items-start lg:col-span-1 mb-1">
                                                                <p class="flex flex-col text-left">
                                                                    <span class="text-sm font-bold underline">Timetable</span>
                                                                    <span class="text-sm font-normal" v-for="classes in fee.classes" :key="classes.id">{{ classes.class_day }} ({{ moment(classes.start_time, "HH:mm:ss").format('h:mm A') }} - {{ moment(classes.end_time, "HH:mm:ss").format('h:mm A') }})</span>
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="flex flex-col p-6 lg:py-8 lg:px-12 bg-indigo-50">
                                                    <div class="flex flex-col">
                                                        <!-- <div class="flex justify-center items-center space-x-4 mb-3">
                                                            <h3 class="font-semibold text-sm">Applied Promo</h3>
                                                            <select class="text-xs rounded focus:ring-0 focus:border-indigo-300" v-model="selected_promo">
                                                                <option v-for="promo in $page.props.promos" :value="promo.id" >{{ promo.name }}</option>
                                                            </select>
                                                            <div @click="viewPromo(fee_index)" class="text-sm text-indigo-500 cursor-pointer px-2 py-1 rounded border border-dashed border-indigo-500 hover:bg-indigo-200">
                                                                Add Promo
                                                            </div>
                                                        </div> -->
                                                        <div class="flex flex-col space-y-2 mb-10">
                                                            <div class="flex items-center space-x-2" v-for="applied_promo in fee.fee_info.promos">
                                                                <span class="inline-flex items-center justify-center rounded-md bg-indigo-200 px-2.5 py-0.5 text-indigo-800">
                                                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ms-1 me-1.5 h-4 w-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"></path>
                                                                  </svg>
                                                                  <p class="whitespace-nowrap text-xs">{{ applied_promo.name }}</p>
                                                                </span>
                                                                <span class="text-xs text-red-500 cursor-pointer">Remove</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col gap-4 justify-center text-xl leading-none font-extrabold text-gray-900">
                                                        <div class="flex">
                                                            <input id="registration_fee" type="checkbox" class="bg-white border-indigo-700 focus:ring-0 focus:ring-gray-400 h-5 w-5 rounded" @click="fee.fee_info.include_registration_fee = !fee.fee_info.include_registration_fee" :checked="fee.fee_info.include_registration_fee">
                                                            <label for="registration_fee" class="text-sm ml-3 font-medium leading-5 text-gray-800 select-none cursor-pointer">Registration Fee: {{ fee.fee_info.currency_symbol }}{{ fee.fee_info.registration_fee }}</label>
                                                        </div>
                                                        <div class="flex">
                                                            <input id="material_fee" type="checkbox" class="bg-white border-indigo-700 focus:ring-0 focus:ring-gray-400 h-5 w-5 rounded" @click="fee.fee_info.include_material_fee = !fee.fee_info.include_material_fee" :checked="fee.fee_info.include_material_fee">
                                                            <label for="material_fee" class="text-sm ml-3 font-medium leading-5 text-gray-800 select-none cursor-pointer">Material Fee: {{ fee.fee_info.currency_symbol }}{{ fee.fee_info.material_fee }}</label>
                                                        </div>
                                                        <div class="flex justify-center items-center">
                                                            <span class="font-brown">{{ fee.fee_info.currency_symbol }}{{ fee.fee_info.programme_fee }}</span>
                                                            <span class="leading-7 font-medium text-gray-700">/month</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
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
            <template v-slot:header v-if="!generating">
                <div class="flex items-center justify-between py-3 px-4 border-b rounded-t font-semibold">
                    <h3 class="text-gray-900 text-xl font-semibold">                
                        Apply Promotions
                    </h3>        
                    <button type="button" @click="open_promo_modal = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>        
            </template>
            <template v-slot:content>
                <div class="p-6" v-if="!generating">
                    <div class="mb-4">
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
                </div>
                <div class="p-6" v-else>
                    <div class="flex items-center text-xl">
                        <svg class="flex-shrink-0 w-6 h-6 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Info</span>
                        <h3 class="text-xl font-medium">Do not close the browser</h3>
                    </div>
                    <div class="flex items-center my-4 text-sm" >
                        <div role="status">
                            <svg aria-hidden="true" class="w-6 h-6 me-2 text-indigo-200 animate-spin fill-indigo-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                            <span class="sr-only">Loading...</span>
                        </div>
                        Kindly wait as the system is in the process of creating your art book, this might take a minute...
                    </div>
                </div>
            </template>
            <template v-slot:footer v-if="!generating">
                <div class="flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                    <BreezeButton buttonType="info" @click="generateArtBook()">Generate</BreezeButton>
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


export default {
    components: {
        Head, Link, Datepicker, Multiselect, Modal, 
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
            selected_promo: '',
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
                this.total_amount = 0
                for (const feeObject of this.form.fee) {
                    const { include_registration_fee, registration_fee, include_material_fee, material_fee, programme_fee } = feeObject.fee_info;
                    const registration_fee_amount  =    include_registration_fee ? Number(registration_fee) : 0;
                    const material_fee_amount      =    include_material_fee ? Number(material_fee) : 0;
                    this.total_amount             +=    Number(programme_fee) + registration_fee_amount + material_fee_amount;
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
        viewPromo(fee_index){
            this.open_promo_modal = true
            // this.$page.props.promos.find(promo=>{
            //     return promo.id === 
            // })
            // this.form.fee.fee_index.fee_info.promos.push({
            //     id: this.selected_promo
            // })
            console.log(fee_index)
            console.log(this.selected_promo)
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