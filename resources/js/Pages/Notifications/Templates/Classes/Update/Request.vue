<script setup>
    import NotificationLayout from '@/Pages/Notifications/Layout.vue';
    import BreezeButton from '@/Components/Button.vue';
    import Multiselect from '@vueform/multiselect'
    import Datepicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css';
    import moment from 'moment';
</script>
<template>
    <Head title="Notifications" />
    <NotificationLayout>
        <div class="flex-col w-full pt-4 px-4 space-y-3">
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                <div class="mb-5">
                    <h1 class="font-bold text-indigo-800">Class Information</h1>
                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                    <div class="mb-4">
                        <label for="centre" class="block text-sm font-bold text-gray-700"> Centre <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md.shadow-sm">
                            <Multiselect 
                                v-model="$page.props.request_data.centre_id"
                                valueProp="ID"
                                :searchable="true"
                                :options="$page.props.allowed_centres"
                                :clearOnSelect="true"
                                :canClear="false"
                                :canDeselect="false"
                                :disabled="true"
                                trackBy="label"
                                label="label"
                                :classes="{
                                    container: 
                                        !record_matched.centre_id ? 
                                        'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-green-500 rounded bg-white text-base leading-snug outline-none':
                                        'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none h-[38px]',
                                    containerDisabled: 'cursor-default bg-gray-100',
                                    containerOpen: 'rounded-b-none',
                                    containerOpenTop: 'rounded-t-none',
                                    containerActive: 'border border-indigo-300',
                                    singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                    singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                    multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                    search: 'w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded pl-3.5',
                                    placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500',
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
                    <div class="mb-4">
                        <label for="programme" class="block text-sm font-bold text-gray-700"> Programme <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <select name="programme" id="programme" class="bg-gray-100 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="!record_matched.programme_id ? 'border-green-500' : 'border-gray-300'" v-model="form.programme_id" autocomplete="off" :disabled="true">
                                <option value="">-- Select Programme --</option>
                                <option :value="programme.id" v-for="(programme, index) in $page.props.request_data.programme_list" :key="index">{{ programme.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                        <div class="mb-4">
                            <label for="class_type" class="block text-sm font-bold text-gray-700"> Class Type <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <select name="class_type" id="class_type" class="bg-gray-100 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="!record_matched.class_type ? 'border-green-500' : 'border-gray-300'" v-model="$page.props.request_data.class_type" autocomplete="off" :disabled="true">
                                    <option value="">-- Select Type --</option>
                                    <option :value="class_type.id" v-for="(class_type, index) in $page.props.request_data.class_types" :key="index">{{ class_type.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="programme_level_id" class="block text-sm font-bold text-gray-700"> Class Level <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <select name="programme_level_id" id="programme_level_id" class="bg-gray-100 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="!record_matched.programme_level_id ? 'border-green-500' : 'border-gray-300'" v-model="$page.props.request_data.programme_level_id" autocomplete="off" :disabled="true">
                                    <option value="">-- Select Level --</option>
                                    <option :value="i.id" v-for="i, index in $page.props.request_data.class_levels" :key="i">{{ i.level }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                        <div class="mb-4">
                            <label for="class_day" class="block text-sm font-bold text-gray-700"> Class Day <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <select :disabled="true" name="class_day" id="class_day" class="bg-gray-100 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="!record_matched.class_day ? 'border-green-500' : 'border-gray-300'" v-model="$page.props.request_data.class_day" autocomplete="off">
                                    <option value="">-- Select Day --</option>
                                    <option :value="day.id" v-for="day in $page.props.request_data.day_list" :key="day">{{ day.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="class_method" class="block text-sm font-bold text-gray-700"> Class Methods <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <select :disabled="true" name="class_method" id="class_method" class="bg-gray-100 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="!record_matched.class_method ? 'border-green-500' : 'border-gray-300'" v-model="$page.props.request_data.class_method" autocomplete="off">
                                    <option value="">-- Select Method --</option>
                                    <option :value="class_method.id" v-for="class_method in $page.props.request_data.method_list" :key="class_method">{{ class_method.name }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                    <div class="mb-4">
                        <label for="start_time" class="block text-sm font-bold text-gray-700"> Start Time <span class="text-red-500">*</span></label>
                        <Datepicker :disabled="true" :class="'mt-1 rounded-md shadow-sm'" :style="!record_matched.start_time ? '--dp-border-color: #28c762' : ''" v-model="form.start_time" :timePicker="true" :is24="false" />
                    </div>
                    <div class="mb-4">
                        <label for="end_time" class="block text-sm font-bold text-gray-700"> End Time <span class="text-red-500">*</span></label>
                        <Datepicker :disabled="true" :class="'mt-1 rounded-md shadow-sm'" :style="!record_matched.end_time ? '--dp-border-color: #28c762' : ''" v-model="form.end_time" :timePicker="true" :is24="false" />
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                    <div class="mb-4">
                        <label for="class_capacity" class="block text-sm font-bold text-gray-700"> Class Capacity <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input :disabled="true" type="number" name="class_capacity" id="class_capacity" class="bg-gray-100 capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="!record_matched.class_capacity ? 'border-green-500' : 'border-gray-300'" v-model="$page.props.request_data.class_capacity" autocomplete="off" @keypress="numberOnly"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-xl p-4">
                <div class="flex space-x-5">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:col-start-2 sm:text-sm" @click="approve">Approve</button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:col-start-1 sm:text-sm" @click="reject">Reject</button>
                </div>
            </div>
        </div>
    </NotificationLayout>
</template>
<script>
    export default{
        props:{
            request_data: Object,
            created_by: String,
            notification_data: Object
        },
        data(){
            return{
                form: {
                    notification_id: this.notification_data.id,
                    class_id: this.request_data.class_id ? this.request_data.class_id : '',
                    centre_id: this.request_data.centre_id ? this.request_data.centre_id : '',
                    programme_id: this.request_data.programme_id ? this.request_data.programme_id : '',
                    programme_level_id: this.request_data.programme_level_id ? this.request_data.programme_level_id : '',
                    class_day: this.request_data.class_day ? this.request_data.class_day : '',
                    start_time: this.request_data.start_time,
                    end_time: this.request_data.end_time,
                    class_capacity: this.request_data.class_capacity ? this.request_data.class_capacity : '',
                    class_type: this.request_data.class_type ? this.request_data.class_type : '',
                    class_method: this.request_data.class_method ? this.request_data.class_method : '',
                    created_by: this.created_by ? this.created_by : '',
                },
                record_matched: {
                    class_id: this.checkMatch(this.request_data.class_id, this.request_data.class_info.class_id),
                    centre_id: this.checkMatch(this.request_data.centre_id, this.request_data.class_info.centre_id),
                    programme_id: this.checkMatch(this.request_data.programme_id, this.request_data.class_info.programme_id),
                    programme_level_id: this.checkMatch(this.request_data.programme_level_id, this.request_data.class_info.programme_level_id),
                    class_day: this.checkMatch(this.request_data.class_day, this.request_data.class_info.class_day_id),
                    start_time: this.checkMatch(this.joinArrayTime(this.request_data.start_time), this.request_data.class_info.start_time),
                    end_time: this.checkMatch(this.joinArrayTime(this.request_data.end_time), this.request_data.class_info.end_time),
                    class_capacity: this.checkMatch(this.request_data.class_capacity, this.request_data.class_info.capacity),
                    class_type: this.checkMatch(this.request_data.class_type, this.request_data.class_info.class_type_id),
                    class_method: this.checkMatch(this.request_data.class_method, this.request_data.class_info.class_method_id),
                }
            }
        },
        methods: {
            approve() {
                this.$inertia.post(route('approve_class_update'), this.form, { preserveScroll: true})
            },
            reject() {
                this.$inertia.post(route('reject_programme_update'), this.form, { preserveScroll: true})
            },
            zeroPad(number) {
                return String(number).padStart(2, "0");
            },
            joinArrayTime(timeArray){
                return this.zeroPad(timeArray.hours) + ':' + this.zeroPad(timeArray.minutes) + ':' + this.zeroPad(timeArray.seconds)
            },
            checkMatch(value_1, value_2){
                return value_1 === value_2
            }

        }
    }
</script>