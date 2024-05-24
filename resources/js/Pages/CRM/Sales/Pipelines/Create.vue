<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/CRM/Authenticated.vue';
</script>

<style>
.invoices-input-date-picker{
    border: 1px solid #D1D5DB; /* Default border color and thickness */
    border-radius: 0.35rem;
    height: 40px;
}
:hover.invoices-input-date-picker  {
    border: 1px solid #D1D5DB; /* Highlighted border color and thickness */
}
:focus.invoices-input-date-picker  {
    border: 1px solid #D1D5DB; /* Highlighted border color and thickness */
}
</style>

<template>
    <BreezeAuthenticatedLayout>
        <div class="flex flex-col">
            <h1 class="block text-2xl font-bold text-indigo-600 sm:text-2xl dark:text-white underline mb-8">Add Pipeline</h1>
            <div class="bg-red-50 border border-red-200 text-sm text-red-800 rounded-lg p-4 mb-4" role="alert" v-if="$page.props.errors && Object.keys($page.props.errors).length > 0">
                <div class="flex">
                  <div class="flex-shrink-0">
                    <svg class="flex-shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <circle cx="12" cy="12" r="10"></circle>
                      <path d="m15 9-6 6"></path>
                      <path d="m9 9 6 6"></path>
                    </svg>
                  </div>
                  <div class="ms-4">
                    <h3 class="text-sm font-semibold">
                      Error
                    </h3>
                    <div class="mt-2 text-sm text-red-700">
                      <ul class="list-disc space-y-1 ps-5">
                        <li v-for="(error, index) in $page.props.errors" :key="index">
                            {{ error }}
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            <!-- Basic Information -->
            <div class="grid grid-cols-1 mb-2">
                <h2 class="text-base font-semibold leading-7 text-indigo-500 mb-3">Basic Information</h2>
                <!-- <hr class="mb-1 border-indigo-400 border-dashed"> -->
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 2xl:grid-cols-4 gap-2 mb-6">
                <div class="mb-2 col-span-2 sm:col-span-1" v-if="$page.props.can.assign_pipeline_user">
                    <label for="student_id" class="block text-sm font-semibold text-gray-700"> Assign To </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <Multiselect 
                        v-model="form.assign_to"
                        valueProp="value"
                        label="display_name"
                        placeholder="Search assignee's name"
                        noOptionsText="Nothing found"
                        noResultsText="Nothing found"
                        :clearOnSelect="true"
                        :filter-results="false"
                        :min-chars="1"
                        :resolve-on-load="false"
                        :loading="searching_username_email"
                        :searchable="true"
                        v-debounce:1s="findUsernameEmail"
                        :options="user_list.options"
                        :classes="{
                            container: 'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white sm:text-sm leading-snug outline-none h-[40px]',
                            containerDisabled: 'cursor-default bg-gray-100',
                            containerOpen: 'rounded-b-none',
                            containerOpenTop: 'rounded-t-none',
                            containerActive: 'focus:border-blue-500 ring-blue-500 ',
                            singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 pr-16 box-border',
                            singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                            multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                            search: 'w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 sm:text-sm font-sans bg-white rounded-md pl-3.5 h-8',
                            placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500',
                            clear: 'pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80',
                            clearIcon: 'bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                            dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b no-scrollbar',
                            dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                            dropdownHidden: 'hidden',
                            options: 'flex flex-col p-0 m-0 list-none w-full',
                            optionsTop: 'flex-col-reverse',
                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-slate-700 leading-snug py-2 px-3',
                            optionPointed: 'text-slate-800 bg-blue-100',
                            optionSelected: 'text-slate-800 bg-blue-100',
                            optionDisabled: 'text-gray-300 cursor-not-allowed',
                            optionSelectedPointed: 'text-slate-800 bg-blue-100',
                            optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                            fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                            spacer: 'h-9 py-px box-content',
                        }"
                        > 
                        <template #option="{ option }">
                            <span><strong>{{ option.display_name }}</strong><br><small>{{ option.user_email ? option.user_email : 'Email not available' }}</small></span>
                        </template>
                    </Multiselect>
                    </div>
                </div>
                <div class="mb-2 col-span-2 sm:col-span-1">
                    <label for="date" class="block text-sm font-semibold text-gray-700"> Start Date </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <Datepicker 
                            :class="'focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm'" 
                            :style="$page.props.errors.date ? '--dp-border-color: #fa9e9e' : ''" 
                            input-class-name="invoices-input-date-picker focus:ring-0"
                            v-model="form.date_start" 
                            :enableTimePicker="false"
                            :auto-apply="true" 
                            :format="'dd/MM/yyyy'"
                        />
                    </div>
                </div>
                <div class="mb-2 col-span-2 sm:col-span-1">
                    <label for="student_id" class="block text-sm font-semibold text-gray-700"> Lead Source </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <Multiselect 
                        v-model="form.lead_source"
                        valueProp="id"
                        :options="$page.props.lead_sources"
                        noOptionsText="Nothing found"
                        noResultsText="Nothing found"
                        :clearOnSelect="true"
                        :canClear="false"
                        :canDeselect="false"
                        :internal-search="false"
                        trackBy="name"
                        label="name"
                        :classes="{
                            container: 'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white sm:text-sm leading-snug outline-none h-10',
                            containerDisabled: 'cursor-default bg-gray-100',
                            containerOpen: 'rounded-b-none',
                            containerOpenTop: 'rounded-t-none',
                            containerActive: 'focus:border-blue-500 ring-blue-500 ',
                            singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 pr-16 box-border',
                            singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                            multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                            search: 'w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 sm:text-sm font-sans bg-white rounded-md pl-3.5',
                            placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500',
                            clear: 'pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80',
                            clearIcon: 'bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                            dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b no-scrollbar',
                            dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                            dropdownHidden: 'hidden',
                            options: 'flex flex-col p-0 m-0 list-none w-full',
                            optionsTop: 'flex-col-reverse',
                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-slate-700 leading-snug py-2 px-3',
                            optionPointed: 'text-slate-800 bg-blue-100',
                            optionSelected: 'text-slate-800 bg-blue-100',
                            optionDisabled: 'text-gray-300 cursor-not-allowed',
                            optionSelectedPointed: 'text-slate-800 bg-blue-100',
                            optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                            fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                            spacer: 'h-9 py-px box-content',
                        }"
                    />
                    </div>
                </div>
            </div>
            <!-- Basic Information -->
            <!-- School Information -->
            <div class="grid grid-cols-1 mb-2">
                <h2 class="text-base font-semibold leading-7 text-indigo-500 mb-3">School Information</h2>
                <!-- <hr class="mb-1 border-indigo-400 border-dashed"> -->
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 2xl:grid-cols-4 gap-2 mb-6">
                <div class="mb-2 col-span-2 sm:col-span-1">
                    <label for="school_name" class="block text-sm font-semibold text-gray-700"> Name </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="text" name="school_name" id="school_name" class="focus:ring-0 focus:border-gray-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 h-[40px]" v-model="form.school_name" autocomplete="off">
                    </div>
                </div>
                <div class="mb-2 col-span-2 sm:col-span-1">
                    <label for="student_id" class="block text-sm font-semibold text-gray-700"> Type </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <Multiselect 
                        v-model="form.school_type"
                        valueProp="id"
                        :options="$page.props.school_types"
                        noOptionsText="Nothing found"
                        noResultsText="Nothing found"
                        :clearOnSelect="true"
                        :canClear="false"
                        :canDeselect="false"
                        :internal-search="false"
                        trackBy="name"
                        label="name"
                        :classes="{
                            container: 'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white sm:text-sm leading-snug outline-none h-10',
                            containerDisabled: 'cursor-default bg-gray-100',
                            containerOpen: 'rounded-b-none',
                            containerOpenTop: 'rounded-t-none',
                            containerActive: 'focus:border-blue-500 ring-blue-500 ',
                            singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 pr-16 box-border',
                            singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                            multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                            search: 'w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 sm:text-sm font-sans bg-white rounded-md pl-3.5',
                            placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500',
                            clear: 'pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80',
                            clearIcon: 'bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                            dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b no-scrollbar',
                            dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                            dropdownHidden: 'hidden',
                            options: 'flex flex-col p-0 m-0 list-none w-full',
                            optionsTop: 'flex-col-reverse',
                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-slate-700 leading-snug py-2 px-3',
                            optionPointed: 'text-slate-800 bg-blue-100',
                            optionSelected: 'text-slate-800 bg-blue-100',
                            optionDisabled: 'text-gray-300 cursor-not-allowed',
                            optionSelectedPointed: 'text-slate-800 bg-blue-100',
                            optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                            fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                            spacer: 'h-9 py-px box-content',
                        }"
                    />
                    </div>
                </div>
                <div class="mb-2 col-span-2 sm:col-span-1">
                    <label for="branch_number" class="block text-sm font-semibold text-gray-700"> Branch Number </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="number" min="1" name="branch_number" id="branch_number" class="focus:ring-0 focus:border-gray-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 h-[40px]" v-model="form.branch_number" autocomplete="off">
                    </div>
                </div>
                <div class="mb-2 col-span-2 sm:col-span-1">
                    <label for="address" class="block text-sm font-semibold text-gray-700"> Address </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <textarea rows="1" name="address" class="focus:ring-0 focus:border-gray-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" v-model="form.address" autocomplete="off"></textarea>
                    </div>
                </div>
            </div>
            <!-- School Information -->
            <!-- Principal Information -->
            <div class="grid grid-cols-1 mb-2">
                <h2 class="text-base font-semibold leading-7 text-indigo-500 mb-3">Principal Information</h2>
                <!-- <hr class="mb-1 border-indigo-400 border-dashed"> -->
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 2xl:grid-cols-4 gap-2 mb-6">
                <div class="mb-2 col-span-2 sm:col-span-1">
                    <label for="principal_name" class="block text-sm font-semibold text-gray-700"> Name </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="text" name="principal_name" id="principal_name" class="focus:ring-0 focus:border-gray-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 h-[40px]" v-model="form.principal_name" autocomplete="off">
                    </div>
                </div>
                <div class="mb-2 col-span-2 sm:col-span-1">
                    <label for="principal_phone_number" class="block text-sm font-semibold text-gray-700"> Phone Number </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="text" name="principal_phone_number" id="principal_phone_number" class="focus:ring-0 focus:border-gray-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 h-[40px]" v-model="form.principal_phone_number" autocomplete="off">
                    </div>
                </div>
            </div>
            <!-- Principal Information -->
            <!-- PIC Information -->
            <div class="grid grid-cols-1 mb-2">
                <h2 class="text-base font-semibold leading-7 text-indigo-500 mb-3">Person-in-Charge Information</h2>
                <!-- <hr class="mb-1 border-indigo-400 border-dashed"> -->
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 2xl:grid-cols-4 gap-2 mb-6">
                <div class="mb-2 col-span-2 sm:col-span-1">
                    <label for="pic_name" class="block text-sm font-semibold text-gray-700"> Name </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="text" name="pic_name" id="pic_name" class="focus:ring-0 focus:border-gray-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 h-[40px]" v-model="form.pic_name" autocomplete="off">
                    </div>
                </div>
                <div class="mb-2 col-span-2 sm:col-span-1">
                    <label for="pic_phone_number" class="block text-sm font-semibold text-gray-700"> Phone Number </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="number" name="pic_phone_number" id="pic_phone_number" class="focus:ring-0 focus:border-gray-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 h-[40px]" v-model="form.pic_phone_number" autocomplete="off">
                    </div>
                </div>
                <div class="mb-2 col-span-2 sm:col-span-1">
                    <label for="pic_position" class="block text-sm font-semibold text-gray-700"> Position </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <Multiselect 
                        v-model="form.pic_position"
                        valueProp="id"
                        :options="$page.props.pic_positions"
                        noOptionsText="Nothing found"
                        noResultsText="Nothing found"
                        :clearOnSelect="true"
                        :canClear="false"
                        :canDeselect="false"
                        :internal-search="false"
                        trackBy="name"
                        label="name"
                        :classes="{
                            container: 'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white sm:text-sm leading-snug outline-none h-10',
                            containerDisabled: 'cursor-default bg-gray-100',
                            containerOpen: 'rounded-b-none',
                            containerOpenTop: 'rounded-t-none',
                            containerActive: 'focus:border-blue-500 ring-blue-500 ',
                            singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 pr-16 box-border',
                            singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                            multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                            search: 'w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 sm:text-sm font-sans bg-white rounded-md pl-3.5',
                            placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500',
                            clear: 'pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80',
                            clearIcon: 'bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                            dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b no-scrollbar',
                            dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                            dropdownHidden: 'hidden',
                            options: 'flex flex-col p-0 m-0 list-none w-full',
                            optionsTop: 'flex-col-reverse',
                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-slate-700 leading-snug py-2 px-3',
                            optionPointed: 'text-slate-800 bg-blue-100',
                            optionSelected: 'text-slate-800 bg-blue-100',
                            optionDisabled: 'text-gray-300 cursor-not-allowed',
                            optionSelectedPointed: 'text-slate-800 bg-blue-100',
                            optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                            fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                            spacer: 'h-9 py-px box-content',
                        }"
                    />
                    </div>
                </div>
                <div class="mb-2 col-span-2 sm:col-span-1">
                    <label for="pic_email" class="block text-sm font-semibold text-gray-700"> Email </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="email" name="pic_email" id="pic_email" class="focus:ring-0 focus:border-gray-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 h-[40px]" v-model="form.pic_email" autocomplete="off">
                    </div>
                </div>
            </div>
            <!-- PIC Information -->
            <!-- Status Information -->
            <div class="grid grid-cols-1 mb-2">
                <h2 class="text-base font-semibold leading-7 text-indigo-500 mb-3">Status</h2>
                <!-- <hr class="mb-1 border-indigo-400 border-dashed"> -->
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 2xl:grid-cols-4 gap-2 mb-6">
                <div class="mb-4">
                    <label for="principal_name" class="block text-sm font-semibold text-gray-700"> Progress Percentage</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <Multiselect 
                        v-model="form.progress_percentage"
                        valueProp="id"
                        :options="$page.props.progress_percentage"
                        noOptionsText="Nothing found"
                        noResultsText="Nothing found"
                        :clearOnSelect="true"
                        :canClear="false"
                        :canDeselect="false"
                        :internal-search="false"
                        trackBy="name"
                        label="name"
                        :classes="{
                            container: 'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white sm:text-sm leading-snug outline-none h-10',
                            containerDisabled: 'cursor-default bg-gray-100',
                            containerOpen: 'rounded-b-none',
                            containerOpenTop: 'rounded-t-none',
                            containerActive: 'focus:border-blue-500 ring-blue-500 ',
                            singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3 pr-16 box-border',
                            singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                            multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                            search: 'w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 sm:text-sm font-sans bg-white rounded-md pl-3.5',
                            placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500',
                            clear: 'pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80',
                            clearIcon: 'bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                            dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b no-scrollbar',
                            dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                            dropdownHidden: 'hidden',
                            options: 'flex flex-col p-0 m-0 list-none w-full',
                            optionsTop: 'flex-col-reverse',
                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-slate-700 leading-snug py-2 px-3',
                            optionPointed: 'text-slate-800 bg-blue-100',
                            optionSelected: 'text-slate-800 bg-blue-100',
                            optionDisabled: 'text-gray-300 cursor-not-allowed',
                            optionSelectedPointed: 'text-slate-800 bg-blue-100',
                            optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                            fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                            spacer: 'h-9 py-px box-content',
                        }"
                    />
                    </div>
                </div>
            </div>
            <!-- Status Information -->
            <!-- Case Status Information -->
            <div class="grid grid-cols-1">
                <h2 class="text-base font-semibold leading-7 text-indigo-500 mb-3">Case Status</h2>
                <!-- <hr class="mb-3 border-indigo-400 border-dashed"> -->
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 2xl:grid-cols-4 gap-2 mb-6">
                <div class="mb-2 col-span-4">
                    <ul class="mt-1 flex flex-col sm:flex-row sm:flex-wrap">
                        <li class="inline-flex items-center gap-x-2.5 py-3 px-4 text-sm font-medium bg-white border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg sm:-ms-px sm:mt-0 sm:first:rounded-se-none sm:first:rounded-es-lg sm:last:rounded-es-none sm:last:rounded-se-lg" v-for="case_status, case_status_index in $page.props.case_status" @change="triggerCaseStatus($event, case_status.id)">
                            <div class="relative flex items-start w-full">
                                <label :for="'case_status_'+case_status.id" class="cursor-pointer select-none flex space-x-2 w-full text-sm text-gray-600">
                                    <div class="flex items-center h-5">
                                        <input :id="'case_status_'+case_status.id" type="checkbox" class="border-gray-200 rounded disabled:opacity-50">
                                    </div>
                                    <span>{{ case_status.name }}</span>
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="mb-2 col-span-4">
                    <div class="flex flex-col">
                        <div class="-m-1.5 overflow-x-auto">
                            <div class="p-1.5 min-w-full inline-block align-middle">
                                <div class="border rounded-lg overflow-hidden dark:border-neutral-700">
                                    <table class="w-full divide-y divide-gray-200">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase bg-gray-100">Case Status</th>
                                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase bg-gray-100">Date</th>
                                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase bg-gray-100">Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            <tr v-for="case_status in form.case_status" v-if="form.case_status.length">
                                                <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ case_status.name }}</td>
                                                <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-800">
                                                    <Datepicker 
                                                        :class="'focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm min-w-52'" 
                                                        :style="$page.props.errors.date ? '--dp-border-color: #fa9e9e' : ''" 
                                                        input-class-name="invoices-input-date-picker focus:ring-0"
                                                        v-model="case_status.date" 
                                                        :enableTimePicker="false"
                                                        :auto-apply="true" 
                                                        :format="'dd/MM/yyyy'"
                                                    />
                                                </td>
                                                <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-800">
                                                    <input type="text" class="min-w-96 focus:ring-0 w-full focus:border-gray-300 flex-1 whitespace-nowrap block rounded-md sm:text-sm border-gray-300 h-[40px]" v-model="case_status.remark" autocomplete="off">
                                                </td>
                                            </tr>
                                            <tr v-else>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center" colspan="3">No case status added</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Case Status Information -->
            <!-- Signed Up Program Information -->
            <div class="grid grid-cols-1">
                <h2 class="text-base font-semibold leading-7 text-indigo-500 mb-3">Signed Up Program</h2>
                <!-- <hr class="mb-3 border-indigo-400 border-dashed"> -->
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 2xl:grid-cols-4 gap-2 mb-6">
                <div class="mb-2 col-span-4">
                    <ul class="mt-1 flex flex-col sm:flex-row sm:flex-wrap">
                        <li class="inline-flex items-center gap-x-2.5 py-3 px-4 text-sm font-medium bg-white border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg sm:-ms-px sm:mt-0 sm:first:rounded-se-none sm:first:rounded-es-lg sm:last:rounded-es-none sm:last:rounded-se-lg" v-for="program, program_index in $page.props.programs" @change="triggerProgram($event, program.id)">
                            <div class="relative flex items-start w-full">
                                <label :for="'program_'+program.id" class="cursor-pointer select-none flex space-x-2 w-full text-sm text-gray-600">
                                    <div class="flex items-center h-5">
                                        <input :id="'program_'+program.id" type="checkbox" class="border-gray-200 rounded disabled:opacity-50">
                                    </div>
                                    <span>{{ program.name }}</span>
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="mb-2 col-span-4">
                    <div class="flex flex-col">
                        <div class="-m-1.5 overflow-x-auto">
                            <div class="p-1.5 min-w-full inline-block align-middle">
                                <div class="border rounded-lg overflow-hidden dark:border-neutral-700">
                                    <table class="w-full divide-y divide-gray-200">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase bg-gray-100">Program Name</th>
                                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase bg-gray-100">Student Numbers</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            <tr v-for="program in form.signed_up_programs" v-if="form.signed_up_programs.length">
                                                <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-800">{{ program.name }}</td>
                                                <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-800">
                                                    <input type="number" class="min-w-96 focus:ring-0 w-full focus:border-gray-300 flex-1 whitespace-nowrap block rounded-md sm:text-sm border-gray-300 h-[40px]" v-model="program.student_numbers" autocomplete="off">
                                                </td>
                                            </tr>
                                            <tr v-else>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center" colspan="3">No signed up program added</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Signed Up Program Information -->
            <!-- Attachments -->
            <div class="grid grid-cols-1">
                <h2 class="text-base font-semibold leading-7 text-indigo-500 mb-3">Attachments</h2>
                <!-- <hr class="mb-3 border-indigo-400 border-dashed"> -->
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 2xl:grid-cols-4 gap-2 mb-6">
                <div class="mb-4" v-if="!form.quotation">
                    <label for="principal_name" class="block text-sm font-semibold text-gray-700"> Quotation </label>
                    <form class="mt-1 max-w-sm">
                        <label for="file-input" class="sr-only">Choose file</label>
                        <input type="file" name="file-input" id="file-input" class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-gray-300    focus:ring-0 disabled:opacity-50 disabled:pointer-events-none
                            file:bg-gray-50 file:border-0
                            file:me-4
                            file:py-3 file:px-4
                            " @change="handleQuotationFileUpload">
                    </form>
                </div> 
                <div v-else>
                    <label for="principal_name" class="mb-1 block text-sm font-semibold text-gray-700"> Quotation </label>
                    <div class="mb-2 flex justify-between items-center shadow-border shadow rounded-lg shadow-gray-300 px-6 py-3">
                        <div class="flex items-center">
                            <div>
                                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ form.quotation.name }}</p>
                            </div>
                        </div>
                        <div class="items-center">
                            <a class="text-gray-500 hover:text-gray-800 cursor-pointer" @click="form.quotation = ''">
                                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18"></path>
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                    <line x1="10" x2="10" y1="11" y2="17"></line>
                                    <line x1="14" x2="14" y1="11" y2="17"></line>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mb-4" v-if="!form.contract">
                    <label for="principal_name" class="block text-sm font-semibold text-gray-700"> Contract </label>
                    <form class="mt-1 max-w-sm">
                        <label for="file-input" class="sr-only">Choose file</label>
                        <input type="file" name="file-input" id="file-input" class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-gray-300    focus:ring-0 disabled:opacity-50 disabled:pointer-events-none
                            file:bg-gray-50 file:border-0
                            file:me-4
                            file:py-3 file:px-4
                            " @change="handleContractFileUpload">
                        </form>
                </div>
                <div v-else>
                    <label for="principal_name" class="mb-1 block text-sm font-semibold text-gray-700"> Contract </label>
                    <div class="mb-2 flex justify-between items-center shadow-border shadow rounded-lg shadow-gray-300 px-6 py-3">
                        <div class="flex items-center">
                            <div>
                                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ form.contract.name }}</p>
                            </div>
                        </div>
                        <div class="items-center">
                            <a class="text-gray-500 hover:text-gray-800 cursor-pointer" @click="form.contract = ''">
                                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18"></path>
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                    <line x1="10" x2="10" y1="11" y2="17"></line>
                                    <line x1="14" x2="14" y1="11" y2="17"></line>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="mb-3"></hr>
            <div class="flex justify-end space-x-2">
                <button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-white/10 dark:hover:bg-white/20 dark:text-white dark:hover:text-white" @click="$inertia.get(route('crm.sales.pipelines'))">
                    Cancel
                </button>
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50 disabled:pointer-events-none" @click="submit">
                    Save
                </button>
            </div>
            <!-- Attachments -->
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import Datepicker from '@vuepic/vue-datepicker';
import Multiselect from '@vueform/multiselect'
import { debounce } from 'vue-debounce'

export default {
    components: {
        Datepicker,Multiselect,
    },
    data(){
        return {
            selected_program: '',
            searching_username_email: false,
            user_list: {
                value: [],
                options: []
            },
            form: {
                assign_to: this.$page.props.can.assign_pipeline_user ? '' : this.$page.props.auth.user.ID,
                date_start: '',
                lead_source: '',
                school_name: '',
                school_type: '',
                branch_number: '',
                address: '',
                principal_name: '',
                principal_phone_number: '',
                pic_name: '',
                pic_position: '',
                pic_phone_number: '',
                pic_email: '',
                progress_percentage: '',
                case_status: [],
                signed_up_programs: [],
                quotation: '',
                contract: ''
            }
        }
    },
    methods: {
        triggerCaseStatus(evt, case_status_id){
            if(evt.target.checked){
                this.form.case_status.push({
                    'id': case_status_id,
                    'name': this.$page.props.case_status.find(case_status => case_status.id === case_status_id).name,
                    'date': '',
                    'remark': '',
                })
            }
            else{
                const index = this.form.case_status.findIndex(case_status => case_status.id === case_status_id)
                this.form.case_status.splice(index, 1)
            }
            this.form.case_status.sort((a, b) => a.id - b.id);

        },
        triggerProgram(evt, program_id){
            if(evt.target.checked){
                this.form.signed_up_programs.push({
                    'id': program_id,
                    'name': this.$page.props.programs.find(program => program.id === program_id).name,
                    'student_numbers': '',
                })
            }
            else{
                const index = this.form.signed_up_programs.findIndex(program => program.id === program_id)
                this.form.signed_up_programs.splice(index, 1)
            }
            this.form.signed_up_programs.sort((a, b) => a.id - b.id);

        },
        handleQuotationFileUpload(event) {
            const file = event.target.files[0];
            if (file && file.type === 'application/pdf') {
                this.form.quotation = file
            } else {
                alert('Please select a PDF file.');
                event.target.value = '';
            }
        },
        handleContractFileUpload(event) {
            const file = event.target.files[0];
            if (file && file.type === 'application/pdf') {
                this.form.contract = file
            } else {
                alert('Please select a PDF file.');
                event.target.value = '';
            }
        },
        findUsernameEmail(query){
            if(query){
                this.searching_username_email = true
                axios.get(route('users.find_username_email'), {
                    params: {
                        'keyword': query
                    }
                })
                .then((res) => {
                    this.user_list.options = res.data
                    this.searching_username_email = false
                });
            }
        },
        submit(){
            this.$inertia.post(route('crm.sales.pipelines.store'), this.form)
        }
    },
}
</script>