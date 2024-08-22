<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<style>
.multiselect-assistive-text{
    display: none;
}
.coding-report-date-picker{
    border: 1px solid #D1D5DB; /* Default border color and thickness */
    border-radius: 0.35rem;
}
:hover.coding-report-date-picker  {
    border: 1px solid #D1D5DB; /* Highlighted border color and thickness */
}
:focus.coding-report-date-picker  {
    border: 1px solid #D1D5DB; /* Highlighted border color and thickness */
}
</style>

<template>
    <Head title="Progress Report" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-indigo-50 space-y-6 sm:p-6">
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <StudentInformation></StudentInformation>
                            </div>
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="font-bold text-indigo-800 self-end">Progress Report Listing</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="overflow-x-auto">
                                            <table class="table-auto min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-300">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Date</th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Teacher Name</th>
                                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Status</th>
                                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    <tr v-if="!$page.props.progress_reports.length">
                                                        <td class="text-center" colspan="10">
                                                            <div class="p-3">
                                                                No Record Found! 
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="hover:bg-gray-200" v-for="(result, index) in $page.props.progress_reports" :key="result.report_id">
                                                        <td class="px-6 py-2 whitespace-nowrap">
                                                            <div class="text-sm font-medium text-gray-700">
                                                                {{ moment(result.date).format('DD/MM/Y') }}
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-2 whitespace-nowrap">
                                                            {{ result.display_name }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                            <span class="inline-flex items-center justify-center px-2 py-1 text-xs rounded" :class="result.attendance_status_class_name">{{ result.attendance_status_name }}</span>
                                                            
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                            <BreezeButton buttonType="blue" @click="viewProgressReport(index)">View / Update</BreezeButton>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <FeedbackSummary :report_details="$page.props.report_details"/>
                    </div>
                </form>
            </div>
        </div>
        <Modal :showModal="show_progress_report" :modalType="'lg'" @hideModal="show_progress_report = false">
            <template v-slot:header>
                <div class="flex items-center justify-between py-3 px-4 border-b rounded-t font-semibold">            
                    <h3 class="text-gray-900 text-xl font-semibold">                
                        Update Progress Report
                    </h3>    
                    <button type="button" @click="show_progress_report = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>                 
            </template>
            <template v-slot:content>
                <div class="p-6 overflow-y-auto scrollbar">
                    <div class="grid grid-rows-1">
                        <div class="grid grid-cols-1 2xl:grid-cols-3 gap-4">
                            <div class="">
                                <span for="date" class="block text-sm font-bold text-gray-700"> Date<span class="text-red-500">*</span> </span>
                                <div class="mt-1 flex rounded-md.shadow-sm">
                                    <Datepicker :class="'w-full rounded-lg shadow-sm'" 
                                                id="date"
                                                input-class-name="math-report-date-picker focus:ring-0"
                                                :style="$page.props.errors.date ? '--dp-border-color: #fa9e9e' : '--dp-border-color: #cccccc'" 
                                                :enableTimePicker="false"
                                                :auto-apply="true" 
                                                :placeholder="'Select Date'" 
                                                :format="'dd/MM/yyyy'"
                                                v-model="form.date" 
                                    />
                                </div>
                                <small class="text-red-500 font-semibold" v-if="!form.date">This field is required.</small>
                            </div>
                            <div class="">
                                <label for="class_name" class="block text-sm font-bold text-gray-700"> Teacher's Name <span class="text-red-500">*</span></label>
                                <div class="mt-1 flex rounded-md.shadow-sm">
                                    <Multiselect 
                                        v-debounce="findTeachers"
                                        v-model="form.teacher_user_id"
                                        valueProp="ID"
                                        :loading="loading.teachers"
                                        :placeholder="form.teacher_name"
                                        :options="list.teachers"
                                        :searchable="true"
                                        noOptionsText="Nothing found"
                                        noResultsText="Nothing found"
                                        :clearOnSelect="true"
                                        :canClear="false"
                                        :canDeselect="false"
                                        :internal-search="false"
                                        trackBy="display_name"
                                        label="display_name"
                                        :classes="{
                                            container: 'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white text-base leading-snug outline-none h-[38px]',
                                            containerDisabled: 'cursor-default bg-gray-100',
                                            containerOpen: 'rounded-b-none',
                                            containerOpenTop: 'rounded-t-none',
                                            containerActive: 'border border-indigo-300',
                                            singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                            singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                            multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                            search: 'w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded-md pl-3.5 mt-0.5 h-[36px]',
                                            placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-700',
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
                                <small class="text-red-500 font-semibold" v-if="!form.teacher_user_id">This field is required.</small>
                            </div>
                                <div class="">
                                <div class="flex items-center 2xl:mt-5">
                                    <input id="revision" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-300 focus:ring-0" v-model="form.revision">
                                    <label for="revision" class="select-none w-full py-3 ml-2 text-sm font-medium text-gray-900 cursor-pointer">Revision</label>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1">
                            <hr class="my-4">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-3">
                                <label for="title" class="block text-sm font-bold text-gray-700"> Lesson </label>
                                <div class="mt-1 flex rounded-md.shadow-sm">
                                    <Multiselect 
                                        @select="getTopics(search.lesson_id)"
                                        v-model="search.lesson_id"
                                        valueProp="id"
                                        :appendNewOption="false"
                                        :searchable="true"
                                        :options="$page.props.coding_lessons"
                                        :clearOnSelect="false"
                                        :canClear="false"
                                        :canDeselect="false"
                                        trackBy="name"
                                        label="name"
                                        placeholder="Please Select"
                                        :classes="{
                                            container: 'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer rounded-sm bg-white text-base leading-snug border-gray-300' ,
                                            containerDisabled: 'cursor-not_allowed bg-gray-100 border focus:border-gray-200 h-10',
                                            containerOpen: 'rounded-b-none',
                                            containerOpenTop: 'rounded-t-none',
                                            containerActive: 'border border-gray-300',
                                            search: 'w-full absolute inset-0 border-gray-300 focus:outline-none focus:border-transparent focus:ring-0 appearance-none text-base font-sans bg-white rounded-sm',
                                            dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                            dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                            dropdownHidden: 'hidden',
                                            options: 'flex flex-col p-0 m-0 list-none w-full',
                                            optionsTop: 'flex-col-reverse',
                                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3 text-sm',
                                            optionPointed: 'text-gray-800 bg-gray-100',
                                            optionSelected: 'text-white bg-indigo-500',
                                            optionDisabled: 'text-gray-300 cursor-not-allowed',
                                            optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                            optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                            noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                            noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                        }"
                                    />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="block text-sm font-bold text-gray-700"> Topic </label>
                                <div class="mt-1 flex rounded-md.shadow-sm">
                                    <Multiselect 
                                        @select="getObjectives(search.topic_id)"
                                        v-model="search.topic_id"
                                        valueProp="id"
                                        :appendNewOption="false"
                                        :searchable="true"
                                        :options="options.topics"
                                        :disabled="disabled.topics"
                                        :clearOnSelect="false"
                                        :canClear="false"
                                        :canDeselect="false"
                                        trackBy="name"
                                        label="name"
                                        :loading="loading.topics"
                                        placeholder="Please Select"
                                        :classes="{
                                            container: 'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer rounded-sm bg-white text-base leading-snug border-gray-300' ,
                                            containerDisabled: 'cursor-not_allowed bg-gray-100 border focus:border-gray-200 h-10',
                                            containerOpen: 'rounded-b-none',
                                            containerOpenTop: 'rounded-t-none',
                                            containerActive: 'border border-gray-300',
                                            search: 'w-full absolute inset-0 border-gray-300 focus:outline-none focus:border-transparent focus:ring-0 appearance-none text-base font-sans bg-white rounded-sm',
                                            dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                            dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                            dropdownHidden: 'hidden',
                                            options: 'flex flex-col p-0 m-0 list-none w-full',
                                            optionsTop: 'flex-col-reverse',
                                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3 text-sm',
                                            optionPointed: 'text-gray-800 bg-gray-100',
                                            optionSelected: 'text-white bg-indigo-500',
                                            optionDisabled: 'text-gray-300 cursor-not-allowed',
                                            optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                            optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                            noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                            noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                        }"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-11">
                                <div class="mb-3">
                                    <label for="title" class="block text-sm font-bold text-gray-700"> Learning Objective </label>
                                    <div class="mt-1 flex rounded-md.shadow-sm">
                                        <Multiselect 
                                            :option-height="104" :custom-label="customLabel"
                                            v-model="search.objective_id"
                                            valueProp="id"
                                            :appendNewOption="false"
                                            :searchable="true"
                                            :options="options.objectives"
                                            :clearOnSelect="false"
                                            :canClear="false"
                                            :canDeselect="false"
                                            trackBy="name"
                                            label="name"
                                            :disabled="disabled.objectives"
                                            placeholder="Please Select"
                                            :loading="loading.objectives"
                                            :classes="{
                                                container: 'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer rounded-sm bg-white text-base leading-snug border-gray-300' ,
                                                containerDisabled: 'cursor-not-allowed bg-gray-100 border focus:border-gray-200 h-10',
                                                containerOpen: 'rounded-b-none',
                                                containerOpenTop: 'rounded-t-none',
                                                containerActive: 'border border-gray-300',
                                                search: 'w-full absolute inset-0 border-gray-300 focus:outline-none focus:border-transparent focus:ring-0 appearance-none text-base font-sans bg-white rounded-sm',
                                                dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                                dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                                dropdownHidden: 'hidden',
                                                options: 'flex flex-col p-0 m-0 list-none w-full',
                                                optionsTop: 'flex-col-reverse',
                                                option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3 text-sm',
                                                optionPointed: 'text-gray-800 bg-gray-100',
                                                optionSelected: 'text-white bg-indigo-500',
                                                optionDisabled: 'text-gray-300 cursor-not-allowed',
                                                optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                                optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                                noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                                noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                            }"
                                        >
                                        </Multiselect>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-1 self-end">
                                <div class="mb-3">
                                    <label for="" class="block text-sm font-bold text-gray-700"> </label>
                                    <div class="mt-1 flex rounded-md.shadow-sm">
                                        <BreezeButton class="py-3 px-4" buttonType="info" @click="addItem">
                                            <div class="flex items-center">
                                                <svg v-if="searching" aria-hidden="true" class="w-4 h-4 text-white animate-spin fill-indigo-600" viewBox="0 0 100 101" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                                </svg>
                                                {{ searching ? '' : 'Add' }}
                                            </div>
                                        </BreezeButton>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 py-3">
                            <div class="mb-3">
                                <label for="title" class="block text-sm font-bold text-gray-700"> Objectives<span class="text-red-500">*</span> </label>
                            </div>
                            <div class="grid grid-cols-1 divide-y divide-neutral-200 border-x border-t border-b mb-3" v-if="!form.report_data">
                                <div class="p-3 bg-gray-50">No objectives found.</div>
                            </div>
                            <div class="grid grid-cols-1 divide-y divide-gray-400 divide-dashed border-x border-t border-b border-gray-300 mb-3" v-else>
                                <div class="p-3 bg-gray-50" v-if="!form.report_data.length">No objectives found.</div>
                                <div class="p-5 bg-gray-50 hover:bg-gray-100" v-for="data, index in form.report_data">
                                    <!-- <details class="group space-y-4">
                                        <summary class="flex justify-between items-center font-medium cursor-pointer list-none"> -->
                                            <div class="space-y-2 ml-2 text-sm">
                                                <div class="flex space-x-4 items-center justify-between">
                                                    <div class="flex items-center space-x-2">
                                                        <span class="text-slate-800 uppercase font-sans font-bold">{{ data.lesson_name }} : </span>
                                                        <span class="text-slate-800 font-bold font-sans">{{ data.topic_name }}</span>
                                                    </div>
                                                    <label class="text-red-500 hover:text-red-600 cursor-pointer uppercase font-bold" @click="deleteItem(index)">Delete</label>
                                                </div>
                                                <div class="border border-b-black"></div>
                                                <div class="flex flex-col space-y-1">
                                                    <span class="bg-gray-300 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded border border-gray-400 uppercase font-sans">{{ data.objective_name }}</span>
                                                </div>
                                                <!-- <p id="helper-checkbox-text" class="text-xs font-normal text-gray-500">Lesson {{ data.lesson_name }}</p> -->
                                            </div>
                                            <!-- <span class="transition group-open:rotate-180">
                                                <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path>
                                                </svg>
                                            </span> -->
                                        <!-- </summary> -->
                                        <!-- <ul class="text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg divide-y">
                                            <li class="w-full" v-for="activitiy_procedure, activity_procedure_index in data.activities_procedures">
                                                <div class="flex items-center pl-3">
                                                    <input :id="activitiy_procedure.id" type="checkbox" :value="activitiy_procedure.id" v-model="form.report_data[index].activities_procedures[activity_procedure_index].achieved" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-300 focus:ring-0">
                                                    <label :for="activitiy_procedure.id" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 cursor-pointer">{{ activitiy_procedure.name }}</label>
                                                </div>
                                            </li>
                                        </ul> -->
                                    <!-- </details> -->
                                </div>
                            </div>
                            <small class="text-red-500 font-semibold" v-if="!form.report_data.length && form.attendance_status == 1">At least one (1) objective is required.</small>
                        </div>
                        <div class="grid grid-cols-1">
                            <div class="mb-3">
                                <label for="title" class="block text-sm font-bold text-gray-700"> Comments </label>
                                <div class="mt-1 flex rounded-md.shadow-sm">
                                    <textarea class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" rows="4" v-model.lazy="form.comments"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-3">
                                <label for="title" class="block text-sm font-bold text-gray-700"> Status<span class="text-red-500">*</span> </label>
                                <div class="mt-1 flex rounded-md.shadow-sm">
                                    <select name="attendance_status" id="attendance_status" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.attendance_status ? 'border-red-300' : 'border-gray-300'" v-model="form.attendance_status" autocomplete="off">
                                        <option :value="attendance_status.id" v-for="attendance_status, index in $page.props.attendance_status">{{ attendance_status.name }}</option>
                                    </select>
                                </div>
                                <small class="text-red-500 font-semibold" v-if="form.attendance_status == 3">This field is required.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:footer>
                <div class="flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                    <BreezeButton buttonType="gray" @click="show_progress_report = false">Cancel</BreezeButton>
                    <BreezeButton @click="updateProgressReport">Save</BreezeButton>
                </div>
            </template>
        </Modal>
    </BreezeAuthenticatedLayout>
</template>

<script>

import { Head, Link } from '@inertiajs/inertia-vue3';
import StudentInformation from '@/Pages/ProgressReport/Templates/StudentInformation.vue';
import Datepicker from '@vuepic/vue-datepicker';
import Modal from '@/Components/Modal.vue'
import moment from 'moment';
import axios from 'axios';
import Multiselect from '@vueform/multiselect'
import FeedbackSummary from './FeedbackSummary.vue'
import { debounce } from 'vue-debounce'

export default {
    components: {
        Head, Link, Datepicker, Modal, Multiselect, 
    },
    data(){
        return{
            show_progress_report: false,
            searching: false,
            progress_report_list: {},
            disabled:{
                lessons: true,
                topics: true,
                objectives: true,
            },
            list: {
                teachers: [],
            },
            options: {
                lessons: [],
                topics: [],
                objectives: [],
                activities_procedures: [],
            },
            loading: {
                topics: false,
                objectives: false,
                lessons: false,
                teachers: false,
            },
            search: {
                lesson_id: '',
                topic_id: '',
                objective_id: '',
            },
            form: {
                teacher_user_id: '',
                revision: false,
                date: '',
                report_data: [],
                comments: '',
                attendance_status: '',
            }
        }
    },
    methods: {
        viewProgressReport(index) {
            this.clearSearch()
            this.form.report_id             =   this.$page.props.progress_reports[index].id
            this.form.teacher_user_id       =   this.$page.props.progress_reports[index].teacher_user_id
            this.form.teacher_name          =   this.$page.props.progress_reports[index].display_name
            this.form.date                  =   this.$page.props.progress_reports[index].date
            this.form.report_data           =   JSON.parse(this.$page.props.progress_reports[index].report_data) ? JSON.parse(this.$page.props.progress_reports[index].report_data) : []
            this.form.attendance_status     =   this.$page.props.progress_reports[index].attendance_status
            this.form.comments              =   this.$page.props.progress_reports[index].comments
            this.form.revision              =   String(this.$page.props.progress_reports[index].revision);
            this.show_progress_report       =   true;
        },
        updateProgressReport() {
            if(!this.form.date || !this.form.teacher_user_id || !this.form.attendance_status || (this.form.attendance_status == 3 && !this.form.report_data.length)){
                return
            }
            this.$inertia.post(route('progress_report.store'), this.form, {
                preserveScroll: true,
                preserveState: false,
            });
        },
        findTeachers(query){
            debounce(val => '400ms')(10)
            if(query){
                this.loading.teachers = true
                axios.get(route('teachers.find'), {
                    params: {
                        'keyword': query
                    }
                })
                .then((res) => {
                    this.list.teachers = res.data
                    this.loading.teachers = false
                });
            }
        },
        getTopics(lesson_id) {
            this.loading.topics = true;

            this.disabled.topics = true;
            this.disabled.objectives = true;

            this.options.topics = [];
            this.options.objectives = [];
            
            this.search.topic_id = '';
            this.search.objective_id = '';

            axios.get(route('progress_report.get_coding_topics', lesson_id))
            .then(response => {
                this.options.topics  =   response.data
                this.disabled.topics = false;
                this.loading.topics = false;
            });
        },
        getObjectives(topic_id) {
            this.loading.objectives = true;
            
            this.disabled.objectives = true;

            this.options.objectives = [];

            this.search.objective_id = '';

            axios.get(route('progress_report.get_coding_objectives', topic_id))
            .then(response => {
                this.options.objectives = response.data;
                this.disabled.objectives = false;
                this.loading.objectives = false;
            });
        },
        addItem() {
            if(this.searching){
                return
            }
            if(this.search.lesson_id && this.search.topic_id && this.search.objective_id) {
                const dataExist = this.form.report_data.some(item => item.objective_id === this.search.objective_id);
                if(dataExist){
                    alert('Item Exists!')
                }
                else{
                    this.searching = true
                    axios.get(route('progress_report.get_coding_activities_procedures', this.search.objective_id))
                    .then(response => {
                        const new_item  =   {
                            lesson_id: this.search.lesson_id,
                            lesson_name: this.$page.props.coding_lessons.find(item => item.id === this.search.lesson_id)?.name,
                            topic_id: this.search.topic_id,
                            topic_name: this.options.topics.find(item => item.id === this.search.topic_id)?.name,
                            objective_id: this.search.objective_id,
                            objective_name: this.options.objectives.find(item => item.id === this.search.objective_id)?.name,
                            activities_procedures: []
                        }
                        const initialLength     =   this.form.report_data.length
                        const test              =   this.form.report_data.push(new_item)
                        const addedItemIndex    =   initialLength;
                        const addedItem         =   this.form.report_data[addedItemIndex];
                                
                        response.data.forEach(data => {
                            addedItem.activities_procedures.push({
                                id: data.id,
                                name: data.name,
                                achieved: false
                            })
                        })
                        this.searching = false
                    });
                }
            }
        },
        deleteItem(index) {
            this.form.report_data.splice(index, 1);
        },
        clearSearch(){
            this.search.term_book_id = ''
            this.search.topic_id = ''
            this.search.lesson_id = ''
        }
    },
}
</script>
