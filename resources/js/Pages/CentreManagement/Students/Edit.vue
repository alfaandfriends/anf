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
                    <div class="px-4 py-5 bg-indigo-100 space-y-6 sm:p-6">
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                            <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                                <div class="sm:row-span-3">
                                    <div class="mb-5">
                                        <h1 class="font-bold text-indigo-800">Student Information</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="centre" class="block text-sm font-bold text-gray-700"> Name <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.name ? 'border-red-300' : 'border-gray-300'" v-model="form.basic_info.name" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                            <div class="mb-4">
                                                <label for="gender" class="block text-sm font-bold text-gray-700"> Gender <span class="text-red-500">*</span></label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <select name="gender" id="gender" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.gender ? 'border-red-300' : 'border-gray-300'" v-model="form.basic_info.gender" autocomplete="off">
                                                        <option value="">-- Select Gender --</option>
                                                        <option :value="gender.id" v-for="(gender, index) in $page.props.gender_list" :key="index">{{ gender.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label for="end_time" class="block text-sm font-bold text-gray-700"> Date of Birth <span class="text-red-500">*</span></label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <Datepicker class="w-full rounded-lg shadow-sm" 
                                                        :class="errors.dob ? '--dp-border-color: #ff6f60' : '--dp-border-color: #ff6f60'" 
                                                        input-class-name="student-date-picker focus:ring-0"
                                                        v-model="form.basic_info.dob" 
                                                        :enable-time-picker="false"
                                                        :auto-apply="true" 
                                                        :format="'dd/MM/yyyy'"
                                                    />
                                                </div>
                                                <!-- <Datepicker class="mt-1 rounded-md shadow-sm" :class="errors.dob ? '--dp-border-color: #ff6f60' : '--dp-border-color: #ff6f60'"  v-model="form.basic_info.dob" :enableTimePicker="false" :noToday="true" :autoApply="true" format="dd/MM/yyyy"/> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                            <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                                <div class="sm:row-span-3">
                                    <div class="mb-5">
                                        <h1 class="font-bold text-indigo-800">Parent's Information</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="centre" class="block text-sm font-bold text-gray-700"> Name <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" class="focus:ring-0 focus:border-gray-300 border-gray-300 flex-1 block w-full rounded-md sm:text-sm bg-gray-100" v-model="form.parent_info.name" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="centre" class="block text-sm font-bold text-gray-700"> Email <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" class="focus:ring-0 focus:border-gray-300 border-gray-300 flex-1 block w-full rounded-md sm:text-sm bg-gray-100" v-model="form.parent_info.email" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="centre" class="block text-sm font-bold text-gray-700"> Phone <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" class="focus:ring-0 focus:border-gray-300 border-gray-300 flex-1 block w-full rounded-md sm:text-sm bg-gray-100" v-model="form.parent_info.phone" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="centre" class="block text-sm font-bold text-gray-700"> Address <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" class="focus:ring-0 focus:border-gray-300 border-gray-300 flex-1 block w-full rounded-md sm:text-sm bg-gray-100" v-model="form.parent_info.address" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-0 sm:gap-4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                            <div class="mb-5">
                                <div class="flex items-center justify-between mb-3">
                                    <h1 class="font-bold text-indigo-800">Academic Information</h1>
                                    <BreezeButton @click="showAddClass">Add New Class</BreezeButton>
                                </div>
                                <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                            </div>
                            <div class="space-y-2">
                                <template v-if="current_fee.length" v-for="fee, fee_index in current_fee">
                                    <details class="rounded border border-gray-300 [&_summary::-webkit-details-marker]:hidden">
                                        <summary class="flex cursor-pointer items-center justify-between gap-2 bg-indigo-100 p-4 text-gray-900 transition">
                                            <span class="text-sm font-medium">
                                                <div class="flex items-center space-x-4 text-gray-800">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 640 512" fill="currentColor">
                                                        <path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"/>
                                                    </svg>
                                                    <span class="font-bold">{{ fee.fee_info.programme_name }} (Level {{ fee.fee_info.programme_level }})</span>
                                                    <span class="text-red-500 hover:underline cursor-pointer font-semibold" @click="deleteClass(fee.fee_info.student_fee_id, fee.fee_info.fee_id, fee.fee_info.invoice_id, fee.fee_info.admission_date)">Delete</span>
                                                </div>
                                            </span>
                                            <span class="transition group-open:-rotate-180">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                                </svg>
                                            </span>
                                        </summary>
                                        <div class="p-6 space-y-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex space-x-4 font-medium text-gray-900">
                                                    <div class="flex items-center space-x-2 text-gray-600 text-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 512 512">
                                                            <path d="M243.4 2.6l-224 96c-14 6-21.8 21-18.7 35.8S16.8 160 32 160v8c0 13.3 10.7 24 24 24H456c13.3 0 24-10.7 24-24v-8c15.2 0 28.3-10.7 31.3-25.6s-4.8-29.9-18.7-35.8l-224-96c-8-3.4-17.2-3.4-25.2 0zM128 224H64V420.3c-.6 .3-1.2 .7-1.8 1.1l-48 32c-11.7 7.8-17 22.4-12.9 35.9S17.9 512 32 512H480c14.1 0 26.5-9.2 30.6-22.7s-1.1-28.1-12.9-35.9l-48-32c-.6-.4-1.2-.7-1.8-1.1V224H384V416H344V224H280V416H232V224H168V416H128V224zM256 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/>
                                                        </svg>
                                                        <span>{{ fee.fee_info.centre_name }}</span>
                                                    </div>
                                                </div>
                                                <div class="flex space-x-4 font-medium text-gray-900">
                                                    <div class="flex items-center space-x-2 text-gray-600 text-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 384 512">
                                                            <path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8V488c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488V24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16H288c8.8 0 16-7.2 16-16s-7.2-16-16-16H96zM80 352c0 8.8 7.2 16 16 16H288c8.8 0 16-7.2 16-16s-7.2-16-16-16H96c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16H288c8.8 0 16-7.2 16-16s-7.2-16-16-16H96z"/>
                                                        </svg>
                                                        <span>{{ fee.fee_info.programme_type }}</span>
                                                    </div>
                                                </div>
                                                <div class="flex space-x-4 font-medium text-gray-900">
                                                    <div class="flex items-center space-x-2 text-gray-600 text-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 448 512">
                                                            <path d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                                                        </svg>
                                                        <span>{{ fee.fee_info.class_method }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex space-x-4">
                                                <div class="flex space-x-4 text-sm border border-indigo-600 px-2 py-1 rounded text-indigo-600 font-semibold" v-for="classes in fee.classes" :key="classes.id">
                                                    <div class="flex items-center space-x-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 448 512">
                                                            <path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/>
                                                        </svg>
                                                        <span>{{ classes.class_day }}</span>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 512 512">
                                                            <path d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/>
                                                        </svg>
                                                        <span>{{ moment(classes.start_time, "HH:mm:ss").format('h:mm A') }} - {{ moment(classes.end_time, "HH:mm:ss").format('h:mm A') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </details>
                                </template>
                                <template v-else>
                                    <div class="space-y-2 text-left">
                                        <span class="font-semibold text-gray-500">No classes added.</span>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                            <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                                <div class="sm:row-span-3">
                                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                        <div class="flex justify-between items-center">
                                            <div class="flex space-x-2">
                                                <label for="" class="block font-bold text-gray-700">Active</label>
                                                <Toggle v-model="form.student_status" 
                                                    :classes="{
                                                        container: 'inline-block',
                                                        toggle: 'flex w-12 h-5 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
                                                        toggleOn: 'bg-green-500 border-green-500 justify-start text-white',
                                                        toggleOff: 'bg-gray-400 border-gray-400 justify-end text-gray-700',
                                                    }
                                                "/>
                                            </div>
                                            <BreezeButton buttonType="info" @click="saveStudentDetails">Save</BreezeButton>
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
            :show="confirmation_modal.isOpen" 
            @close="confirmation_modal.isOpen = false"
            :confirmationAlert="confirmation_modal.confirmationAlert"
            :confirmationTitle="confirmation_modal.confirmationTitle"
            :confirmationText="confirmation_modal.confirmationText"
            :confirmationButton="confirmation_modal.confirmationButton"
            :confirmationMethod="confirmation_modal.confirmationMethod"
            :confirmationRoute="confirmation_modal.confirmationRoute"
            :confirmationData="confirmation_modal.confirmationData"
        >
        </ConfirmationModal>
        
        <vue-final-modal v-model="show_add_class" :lock-scroll="true" :click-to-close="false">
            <div id="default-modal" data-modal-show="true" aria-hidden="true" class="overflow-x-hidden overflow-y-auto h-modal md:h-full top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center">
                <div class="absolute top-[10%] inset-x-[20%]">
                    <div class="bg-white rounded-lg shadow relative">
                        <div class="flex items-center justify-between py-3 px-6 border-b rounded-t">
                            <span class="text-lg font-semibold text-gray-700">Add New Class</span>
                            <button @click="show_add_class = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                            </button>
                        </div>
                        <div class="p-6 space-y-2 overflow-y-auto" style="max-height: calc(100vh - 350px)">
                            <div class="px-2">
                                <div class="mb-5">
                                    <h1 class="font-bold text-indigo-800">Add New Class</h1>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                    <div class="mb-4">
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
                                    <div class="mb-4">
                                        <label for="programme" class="block text-sm font-bold text-gray-700"> Programme <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <select name="programme" id="programme" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="errors.programme ? 'border-red-300' : 'border-gray-300'" v-model="search_form.programme_id" autocomplete="off">
                                                <option value="">-- Select Programme --</option>
                                                <option :value="programme.id" v-for="(programme, index) in $page.props.programme_list" :key="index">{{ programme.name }} ({{ programme.country_name }})</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="programme" class="block text-sm font-bold text-gray-700"> Start Date <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <Datepicker class="w-full rounded-lg shadow-sm focus:border-indigo-300"
                                                    :class="errors.admission_date ? 'border-red-300' : ' border-gray-300'"
                                                    input-class-name="student-date-picker focus:ring-0"
                                                    v-model="form.date_admission"
                                                    :enable-time-picker="false"
                                                    :auto-apply="true" 
                                                    :format="'dd/MM/yyyy'"
                                                />
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="class_method" class="block text-sm font-bold text-gray-700"> Class Method <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="class_method" id="class_method" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="errors.class_method ? 'border-red-300' : 'border-gray-300'" v-model="search_form.class_method" autocomplete="off">
                                                    <option value="">-- Select Method --</option>
                                                    <option :value="method.id" v-for="(method, index) in $page.props.method_list" :key="index">{{ method.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="class_type" class="block text-sm font-bold text-gray-700"> Class Type <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="class_type" id="class_type" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="[errors.class_type ? 'border-red-300' : 'border-gray-300', disable.class_type ? 'bg-gray-50' : '']" v-model="search_form.class_type" autocomplete="off" :disabled="disable.class_type">
                                                    <option value="">-- Select Type --</option>
                                                    <option :value="class_type.id" v-for="(class_type, index) in list.class_types" :key="index">{{ class_type.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="class_level" class="block text-sm font-bold text-gray-700"> Class Level <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="class_level" id="class_level" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="[errors.level ? 'border-red-300' : 'border-gray-300', disable.class_levels ? 'bg-gray-50' : '']" v-model="search_form.class_level" autocomplete="off" :disabled="disable.class_levels">
                                                    <option value="">-- Select Level --</option>
                                                    <option :value="i.level" v-for="i, index in list.class_levels" :key="i">{{ i.level }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-end">
                                    <div class="flex space-x-2">
                                        <BreezeButton @click="findClasses">Search Classes</BreezeButton>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2">
                                <div class="mb-5">
                                    <h1 class="font-bold text-indigo-800">Classes Available</h1>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <div class="shadow overflow-hidden border-b border-gray-200 rounded-t-sm rounded-b-none">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-300">
                                                    <tr class="px-2">
                                                        <th class="px-2 py-1 text-left">#</th>
                                                        <th class="px-2 py-1 text-left">Day</th>
                                                        <th class="px-2 py-1 text-left">Time</th>
                                                        <th class="px-2 py-1 text-left">Capacity</th>
                                                        <th class="px-2 py-1 text-center">Action</th>
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
                                                    <tr v-else class="hover:bg-gray-200" v-for="classes, index in list.available_classes">
                                                        <td class="px-2 py-2 text-left">{{ index + 1 }}</td>
                                                        <td class="px-2 py-2 text-left">{{ classes.class_day}}</td>
                                                        <td class="px-2 py-2 text-left">
                                                            <div class="text-sm font-medium text-gray-900 flex items-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                                <span class="pl-2">{{ moment(classes.start_time, "HH:mm:ss").format('h:mm A') }} - {{ moment(classes.end_time, "HH:mm:ss").format('h:mm A') }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="px-2 py-2 text-left">{{ classes.capacity}}</td>
                                                        <td class="px-2 py-2 text-center">
                                                            <div class="flex justify-center">
                                                                <BreezeButton v-if="classes.class_type == 1" buttonType="blue" @click="getNormalFee(classes.class_id, classes.class_type, classes.programme_id, classes.programme_level_id)">Choose</BreezeButton>
                                                                <input v-else class="h-5 w-5 border border-indigo-300 rounded-sm focus:ring-offset-0 focus:ring-0 checked:bg-gray focus:bg-white transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left cursor-pointer" 
                                                                        type="checkbox" 
                                                                        :checked="checkIfClassSelected(classes.class_id, classes.programme_id)"
                                                                        :disabled="disable_check_box"
                                                                        :class="disable_check_box ? 'bg-gray-100' : 'bg-white'"
                                                                        @click="getPlusFee($event, classes.class_id, classes.class_type, classes.programme_id)">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                </div>
                            </div>
                            <div class="px-2">
                                <div class="mb-5">
                                    <h1 class="font-bold text-indigo-800">Fee Information</h1>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="space-y-2 text-left" v-if="!form.fee.length">
                                    <span class="font-semibold text-gray-500">No classes added.</span>
                                </div>
                                <div class="space-y-2" v-else>
                                    <details class="overflow-hidden rounded border border-gray-300 [&_summary::-webkit-details-marker]:hidden" v-for="fee, fee_index in form.fee">
                                        <summary class="flex cursor-pointer items-center justify-between gap-2 bg-indigo-100 p-4 text-gray-900 transition">
                                            <span class="text-sm font-medium">
                                                <div class="flex items-center space-x-4 text-gray-800">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 640 512" fill="currentColor">
                                                        <path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"/>
                                                    </svg>
                                                    <span class="font-bold">{{ fee.fee_info.programme_name }} (Level {{ fee.fee_info.programme_level }})</span>
                                                    <span class="text-red-500 hover:underline cursor-pointer font-semibold" @click="deleteFee(fee.fee_info.programme_id, fee.fee_info.class_type_id)">Delete</span>
                                                </div>
                                            </span>
                                            <span class="transition group-open:-rotate-180">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                                </svg>
                                            </span>
                                        </summary>
                                        <div class="border-t border-gray-200 bg-white">
                                            <div class="flex px-6 py-3 ">
                                                <div class="flex items-center justify-center divide-x divide-gray-400">
                                                    <div class="flex space-x-4 font-medium text-gray-900 px-4">
                                                        <span>Centre: </span>
                                                        <dd class="text-indigo-600 sm:col-span-2">{{ fee.fee_info.centre_name }}</dd>
                                                    </div>
                                                    <div class="flex space-x-4 font-medium text-gray-900 px-4">
                                                        <span>Fee Type: </span>
                                                        <dd class="text-indigo-600 sm:col-span-2">{{ fee.fee_info.programme_type }}</dd>
                                                    </div>
                                                    <div class="flex space-x-4 font-medium text-gray-900 px-4">
                                                        <span>Class Method: </span>
                                                        <dd class="text-indigo-600 sm:col-span-2">{{ fee.fee_info.class_method }}</dd>
                                                    </div>
                                                </div>
                                            </div>
                                    
                                            <div class="relative overflow-x-auto px-6 pb-4 w-full">
                                                <table class="text-sm text-left text-gray-500 border w-1/2">
                                                    <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                                                        <tr>
                                                            <th scope="col" class="px-6 py-3">Day</th>
                                                            <th scope="col" class="px-6 py-3">Time</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="bg-white border-b" v-for="classes in fee.classes">
                                                            <td class="px-6 py-4 text-gray-800 font-semibold">{{ classes.class_day}}</td>
                                                            <td class="px-6 py-4 text-gray-800 font-semibold">{{ moment(classes.start_time, "HH:mm:ss").format('h:mm A') }} - {{ moment(classes.end_time, "HH:mm:ss").format('h:mm A') }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="flex p-6 border-t justify-between">
                                                <div class="flex">
                                                    <input :id="fee_index" type="checkbox" class="bg-gray-50 border-gray-300 focus:ring-0 focus:ring-gray-400 h-5 w-5 rounded" @click="fee.fee_info.include_material_fee = !fee.fee_info.include_material_fee" :checked="fee.fee_info.include_material_fee">
                                                    <label :for="fee_index" class="text-sm ml-3 font-medium leading-5 text-gray-700 select-none cursor-pointer">Material Fee : {{ fee.fee_info.material_fee }}</label>
                                                </div>
                                                <span class="ml-3 text-gray-900 select-none font-semibold">Fee: {{ sumMaterialFee(fee.fee_info.include_material_fee, fee.fee_info.material_fee, fee.fee_info.programme_fee) }}</span>
                                            </div>
                                        </div>
                                    </details>
                                </div>
                                <div class="flex justify-end p-6" v-if="form.fee.length">
                                    <span class="text-right ml-3 text-gray-900 cursor-text font-bold">Total Amount: {{ total_amount }}</span>
                                </div>
                            </div>
                            <hr class="pb-2">
                            <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                <div class="flex justify-end space-x-2">
                                    <BreezeButton buttonType="gray" @click="show_add_class = false">Cancel</BreezeButton>
                                    <BreezeButton @click="addClass" v-if="form.fee.length">Save</BreezeButton>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </vue-final-modal>
        
        <vue-final-modal v-model="show_transfer_student" :lock-scroll="true" :click-to-close="false">
            <div id="default-modal" data-modal-show="true" aria-hidden="true" class="overflow-x-hidden overflow-y-auto h-modal md:h-full top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center">
                <div class="absolute top-[10%] inset-x-[20%]">
                    <div class="bg-white rounded-lg shadow relative">
                        <div class="flex items-center justify-between py-3 px-6 border-b rounded-t">
                            <span class="text-lg font-semibold text-gray-700">Transfer Student</span>
                            <button @click="show_transfer_student = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                            </button>
                        </div>
                        <div class="p-6 space-y-2 overflow-y-auto" style="max-height: calc(100vh - 350px)">
                            <div class="px-2">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="centre" class="block text-sm font-bold text-gray-700"> Centre <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md.shadow-sm">
                                            <Multiselect 
                                                v-model="form.centre_id"
                                                valueProp="ID"
                                                :searchable="true"
                                                :options="$page.props.allowed_centres"
                                                :clearOnSelect="false"
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
                                    <div class="mb-4">
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
                            <div class="px-2">
                                <div class="mb-5">
                                    <h1 class="font-bold text-indigo-800">Classes Available</h1>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <div class="shadow overflow-hidden border-b border-gray-200 rounded-t-sm rounded-b-none">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-300">
                                                    <tr class="px-2">
                                                        <th class="px-2 py-1 text-left">#</th>
                                                        <th class="px-2 py-1 text-left">Day</th>
                                                        <th class="px-2 py-1 text-left">Time</th>
                                                        <th class="px-2 py-1 text-left">Capacity</th>
                                                        <th class="px-2 py-1 text-center">Action</th>
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
                                                    <tr v-else class="hover:bg-gray-200" v-for="classes, index in list.available_classes">
                                                        <td class="px-2 py-2 text-left">{{ index + 1 }}</td>
                                                        <td class="px-2 py-2 text-left">{{ classes.class_day}}</td>
                                                        <td class="px-2 py-2 text-left">
                                                            <div class="text-sm font-medium text-gray-900 flex items-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                                <span class="pl-2">{{ moment(classes.start_time, "HH:mm:ss").format('h:mm A') }} - {{ moment(classes.end_time, "HH:mm:ss").format('h:mm A') }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="px-2 py-2 text-left">{{ classes.capacity}}</td>
                                                        <td class="px-2 py-2 text-center">
                                                            <div class="flex justify-center">
                                                                <BreezeButton v-if="classes.class_type == 1" buttonType="blue" @click="getNormalFee(classes.class_id, classes.class_type, classes.programme_id, classes.programme_level_id, true)">Choose</BreezeButton>
                                                                <input v-else class="h-5 w-5 border border-indigo-300 rounded-sm focus:ring-offset-0 focus:ring-0 checked:bg-gray focus:bg-white transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left cursor-pointer" 
                                                                        type="checkbox" 
                                                                        :checked="checkIfClassSelected(classes.class_id, classes.programme_id)"
                                                                        :disabled="disable_check_box"
                                                                        :class="disable_check_box ? 'bg-gray-100' : 'bg-white'"
                                                                        @click="getPlusFee($event, classes.class_id, classes.class_type, classes.programme_id, true)">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                </div>
                            </div>
                            <div class="px-2">
                                <div class="mb-5">
                                    <h1 class="font-bold text-indigo-800">Fee Information</h1>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="space-y-2 text-left" v-if="!form.fee.length">
                                    <span class="font-semibold text-gray-500">No classes added.</span>
                                </div>
                                <div class="space-y-2" v-else>
                                    <details class="overflow-hidden rounded border border-gray-300 [&_summary::-webkit-details-marker]:hidden" v-for="fee, fee_index in form.fee">
                                        <summary class="flex cursor-pointer items-center justify-between gap-2 bg-indigo-100 p-4 text-gray-900 transition">
                                            <span class="text-sm font-medium">
                                                <div class="flex items-center space-x-4 text-gray-800">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 640 512" fill="currentColor">
                                                        <path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"/>
                                                    </svg>
                                                    <span class="font-bold">{{ fee.fee_info.programme_name }} (Level {{ fee.fee_info.programme_level }})</span>
                                                    <span class="text-red-500 hover:underline cursor-pointer font-semibold" @click="deleteFee(fee.fee_info.programme_id, fee.fee_info.class_type_id)">Delete</span>
                                                </div>
                                            </span>
                                            <span class="transition group-open:-rotate-180">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                                </svg>
                                            </span>
                                        </summary>
                                        <div class="border-t border-gray-200 bg-white">
                                            <div class="flex px-6 py-3 ">
                                                <div class="flex items-center justify-center divide-x divide-gray-400">
                                                    <div class="flex space-x-4 font-medium text-gray-900 px-4">
                                                        <span>Centre: </span>
                                                        <dd class="text-indigo-600 sm:col-span-2">{{ fee.fee_info.centre_name }}</dd>
                                                    </div>
                                                    <div class="flex space-x-4 font-medium text-gray-900 px-4">
                                                        <span>Fee Type: </span>
                                                        <dd class="text-indigo-600 sm:col-span-2">{{ fee.fee_info.programme_type }}</dd>
                                                    </div>
                                                    <div class="flex space-x-4 font-medium text-gray-900 px-4">
                                                        <span>Class Method: </span>
                                                        <dd class="text-indigo-600 sm:col-span-2">{{ fee.fee_info.class_method }}</dd>
                                                    </div>
                                                </div>
                                            </div>
                                    
                                            <div class="relative overflow-x-auto px-6 pb-4 w-full">
                                                <table class="text-sm text-left text-gray-500 border w-1/2">
                                                    <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                                                        <tr>
                                                            <th scope="col" class="px-6 py-3">Day</th>
                                                            <th scope="col" class="px-6 py-3">Time</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="bg-white border-b" v-for="classes in fee.classes">
                                                            <td class="px-6 py-4 text-gray-800 font-semibold">{{ classes.class_day}}</td>
                                                            <td class="px-6 py-4 text-gray-800 font-semibold">{{ moment(classes.start_time, "HH:mm:ss").format('h:mm A') }} - {{ moment(classes.end_time, "HH:mm:ss").format('h:mm A') }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </details>
                                </div>
                            </div>
                            <hr class="pb-2">
                            <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                <div class="flex justify-end space-x-2">
                                    <BreezeButton buttonType="gray" @click="show_transfer_student = false">Cancel</BreezeButton>
                                    <BreezeButton @click="transferStudent()" v-if="form.fee.length">Save</BreezeButton>
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
import Toggle from '@vueform/toggle';
import Multiselect from '@vueform/multiselect'
import moment from 'moment';
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import { $vfm, VueFinalModal, ModalsContainer } from 'vue-final-modal'

export default {
    components: {
        Head, Link, Datepicker, Toggle, Multiselect, ConfirmationModal, VueFinalModal
    },
    data(){
        return{
            status_centre: {
                value: '',
                error: false
            },
            show_add_class: false,
            show_transfer_student: false,
            disable_check_box: false,
            fetching_fee: false,
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
            confirmation_modal: {
                isOpen: false,
                confirmationAlert: '',
                confirmationTitle: '',
                confirmationText: '',
                confirmationButton: '',
                confirmationMethod: '',
                confirmationData: '',
                confirmationRoute: '',
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
                children_id: this.$page.props.student_info ? this.$page.props.student_info.children_id  : '',
                student_id: this.$page.props.student_info ? this.$page.props.student_info.id  : '',
                centre_id: '',
                fee: [],
                basic_info: {
                    name: this.$page.props.student_info ? this.$page.props.student_info.name : '',
                    gender: this.$page.props.student_info ? this.$page.props.student_info.gender : '',
                    dob: this.$page.props.student_info ? this.$page.props.student_info.dob : '',
                },
                parent_info: {
                    name: this.$page.props.student_info ? this.$page.props.student_info.parent_full_name  : '',
                    email: this.$page.props.student_info ? this.$page.props.student_info.parent_email : '',
                    phone: this.$page.props.student_info ? this.$page.props.student_info.parent_calling_code + this.$page.props.student_info.parent_contact: '',
                    address: this.$page.props.student_info ? this.$page.props.student_info.parent_address : '',
                },
                student_status: this.$page.props.student_info ? this.$page.props.student_info.status : '',
            },
            current_fee: this.$page.props.student_academics ? this.$page.props.student_academics.filter((item) => item.fee_info.student_fee_status === '' || item.fee_info.student_fee_status === 2) : [],
            selected_plus_class: {},
            transfer_student_form: {
                centre_id: '',
            },
        }
    },
    watch: {
        'search_form.programme_id': {
            handler(){
                if(this.search_form.programme_id && this.show_add_class){
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
                if(this.search_form.programme_id && this.search_form.class_type && this.show_add_class){
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
                    const { include_material_fee, material_fee, programme_fee } = feeObject.fee_info;
                    this.total_amount += include_material_fee ? Number(programme_fee) + Number(material_fee) : Number(programme_fee);
                }
            },
            deep: true
        }
    },
    methods: {
        saveStudentDetails(){
            this.$inertia.post(route('students.update'), this.form, { preserveState: true})
        },
        showAddClass(){
            this.clearSearchForm()
            this.show_add_class = true
        },
        findClasses(){
            this.errors.centre          =   !this.form.centre_id ? true : false
            this.errors.admission_date  =   !this.form.date_admission ? true : false
            this.errors.programme       =   !this.search_form.programme_id ? true : false
            this.errors.class_type      =   !this.search_form.class_type ? true : false
            this.errors.level           =   !this.search_form.class_level ? true : false
            this.errors.class_method    =   !this.search_form.class_method ? true : false

            if(this.form.centre_id && this.search_form.programme_id && this.search_form.class_level && this.search_form.class_type && this.search_form.class_method){
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
        getNormalFee(class_id, class_type_id, programme_id, programme_level_id, is_transfer_student = false){
            if(this.fetching_fee){
                return
            }
            if(!is_transfer_student){
                const  only_one_class_allowed_form      = this.form.fee.find(item => item.fee_info.class_type_id === 1 && item.fee_info.class_type_id === class_type_id && item.fee_info.programme_id === programme_id);
                const  only_one_class_allowed_current   = this.current_fee.find(item => item.fee_info.class_type_id === 1 && item.fee_info.class_type_id === class_type_id && item.fee_info.programme_id === programme_id);
                if(only_one_class_allowed_form || only_one_class_allowed_current){
                    alert('Only one class is allowed for normal class.')
                    this.searching.fee = false
                    return
                }

                const  programme_already_added_form     = this.form.fee.find(item => item.fee_info.programme_id === programme_id && item.fee_info.class_type_id !== class_type_id);
                const  programme_already_added_current  = this.current_fee.find(item => item.fee_info.programme_id === programme_id && item.fee_info.class_type_id !== class_type_id);
                if(programme_already_added_form || programme_already_added_current){
                    alert('This programme already been added. Please remove the previous one first.')
                    this.searching.fee = false
                    return
                }
            }else{
                if(this.form.fee.length > 0){
                    alert('You can only select 1 class to transfer student.')
                    return
                }
            }
            
            this.fetching_fee = true
            axios.get(route('programmes.get_fee'), {
                'params': {
                    'class_id' : class_id,
                    'programme_level_id' : programme_level_id,
                }
            })
            .then((res) => {
                this.form.fee.push(res.data)
                this.pushMaterialFee(programme_id)
                this.scrollToElement('class_fee')
                this.searching.fee = false
                this.fetching_fee = false
            });
        },
        getPlusFee(event, class_id, class_type, programme_id, is_transfer_student = false){
            if(this.fetching_fee){
                return
            }
            if(this.disable_check_box){
                return
            }
            if(!is_transfer_student){
                const  programme_already_added_form   = this.form.fee.find(item => item.fee_info.programme_id === programme_id && item.fee_info.class_type_id !== class_type);
                const  programme_already_added_current   = this.current_fee.find(item => item.fee_info.programme_id === programme_id);
                if(programme_already_added_form || programme_already_added_current){
                    alert('This programme already been added. Please remove the previous one first.')
                    if(event.target.checked){
                        event.target.checked = false
                    }
                    this.searching.fee = false
                    return
                }
            }

            this.disable_check_box = true

            if(event.target.checked){
                if(!this.selected_plus_class[programme_id]){
                    this.selected_plus_class[programme_id] = []
                }
                this.selected_plus_class[programme_id].push(class_id)
            }
            else{
                this.selected_plus_class[programme_id] = this.selected_plus_class[programme_id].filter(id => id !== class_id);
            }

            this.form.fee = this.form.fee.filter(item => item.fee_info.programme_id !== programme_id);
            
            if(this.selected_plus_class[programme_id].length){
                this.fetching_fee = true
                axios.get(route('programmes.get_fee'), {
                    'params': {
                        'class_type' : this.search_form.class_type,
                        'class_count': this.selected_plus_class[programme_id].length,
                        'classes': this.selected_plus_class[programme_id]
                    }
                })
                .then((res) => {
                    if(res.data.fee_info){
                        this.form.fee.push(res.data)
                        this.pushMaterialFee(programme_id)
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
                });
            }
            else{
                this.disable_check_box  = false
            }
        },
        clearStudents(){
            this.students = []
        },
        scrollToElement(element) {
            const el = this.$refs[element];
            if (el) {
                el.scrollIntoView({behavior: 'smooth'});
            }
        },
        addClass(){
            this.$inertia.post(route('students.add_student_class'), this.form, { preserveState: false, preserveScroll: true})
        },
        deleteClass(student_fee_id, fee_to_delete, invoice_id, admission_date){
            this.confirmation_modal.confirmationAlert="danger"
            this.confirmation_modal.confirmationTitle="Are you sure? "
            this.confirmation_modal.confirmationText="This action is irreversible, are you sure?"
            this.confirmation_modal.confirmationButton="Delete"
            this.confirmation_modal.confirmationMethod="delete"
            this.confirmation_modal.confirmationRoute = 'students.destroy'
            this.confirmation_modal.confirmationData = {'student_fee_id' : student_fee_id, 'fee_to_delete' : fee_to_delete, 'invoice_id' : invoice_id, 'admission_date' : admission_date}
            this.confirmation_modal.isOpen = true
        },
        deleteFee(programme_id, class_type){
            this.form.fee           =   this.form.fee.filter(item => item.fee_info.programme_id !== programme_id);
            if(class_type == 2){
                if (this.selected_plus_class.hasOwnProperty(programme_id)) {
                    delete this.selected_plus_class[programme_id];
                }
            }
        },
        checkIfClassSelected(class_id, programme_id){
            const classExists = this.selected_plus_class[programme_id] ? this.selected_plus_class[programme_id].includes(class_id) : false
            return classExists
        },
        pushMaterialFee(programme_id){
            for (const feeObject of this.form.fee) {
                const classObject = feeObject.fee_info;
                if (classObject.programme_id === programme_id) {
                    classObject.include_material_fee = true;
                    classObject.material_fee_discount = 0;
                    classObject.programme_fee_discount = 0;
                    break;
                }
                
            }
        },
        changeFeeStatus(student_fee_id, student_fee_status){
            if(student_fee_status == 2 && this.status_centre.value == ''){
                this.status_centre.error = true
                return
            }
            this.confirmation_modal.confirmationAlert="info"
            this.confirmation_modal.confirmationTitle="Are you sure?"
            this.confirmation_modal.confirmationText="This action is permanent and cannot be undone. The status of this student's program will be updated. Are you certain you wish to proceed?"
            this.confirmation_modal.confirmationButton="Confirm"
            this.confirmation_modal.confirmationMethod="post"
            this.confirmation_modal.confirmationRoute = 'students.set_fee_status'
            this.confirmation_modal.confirmationData = {student_fee_id:student_fee_id, student_fee_status:student_fee_status, centre_id: this.status_centre.value}
            this.confirmation_modal.isOpen = true
        },
        showTransferStudent(fee_id, student_fee_id, programme_id, class_type_id, programme_level){
            this.clearSearchForm()
            this.form.fee_id                    = fee_id
            this.form.student_fee_id            = student_fee_id
            this.search_form.programme_id       = programme_id
            this.search_form.class_type         = class_type_id
            this.search_form.class_level        = programme_level
            this.show_transfer_student = true
        },
        transferStudent(){
            if(this.selected_plus_class.length && this.selected_plus_class[this.search_form.programme_id].length){
                const class_count   = this.current_fee
                                        .filter(fee => fee.fee_info.programme_id === this.search_form.programme_id)
                                        .map(fee => fee.classes.length)
                                        .reduce((accumulator, currentValue) => accumulator + currentValue, 0);
                if(this.selected_plus_class[this.search_form.programme_id].length != class_count){
                    alert('You will have to select ' + class_count + ' classes to proceed.')
                    return
                }
            }
            this.$inertia.post(route('students.transfer'), this.form, { preserveState: false, preserveScroll: true})
        },
        clearSearchForm(){
            this.form.centre_id                     = ''
            this.search_form.programme_id           = ''
            this.search_form.class_type             = ''
            this.search_form.class_level            = ''
            this.search_form.class_method           = ''
            this.list.class_types                   = []
            this.list.class_levels                  = []
            this.list.available_classes             = []
            this.form.fee                           = []
            this.selected_plus_class                = {}
        },
        sumMaterialFee(has_material_fee, material_fee, programme_fee){
            return has_material_fee ? Number(material_fee) + Number(programme_fee) : Number(programme_fee)
        }
    },
    created(){
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