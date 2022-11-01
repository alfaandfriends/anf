<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Classes" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <div class="grid grid-rows-2 grid-cols-1 sm:grid-cols-2 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="mb-5">
                                    <h1 class="font-bold text-indigo-800">Class Information</h1>
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
                                                        $page.props.errors.centre_id ? 
                                                        'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded bg-white text-base leading-snug outline-none':
                                                        'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none h-[38px]',
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
                                    <div class="mb-4">
                                        <label for="programme" class="block text-sm font-bold text-gray-700"> Programme <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <select name="programme" id="programme" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.programme_id ? 'border-red-300' : 'border-gray-300'" v-model="form.programme_id" autocomplete="none">
                                                <option value="">-- Select Programme --</option>
                                                <option :value="programme.id" v-for="(programme, index) in programme_list" :key="index">{{ programme.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="class_type" class="block text-sm font-bold text-gray-700"> Class Type <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="class_type" id="class_type" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_type ? 'border-red-300' : 'border-gray-300'" v-model="form.class_type" autocomplete="none" :disabled="disable_class_types">
                                                    <option value="">-- Select Type --</option>
                                                    <option :value="class_type.id" v-for="(class_type, index) in class_types" :key="index">{{ class_type.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="programme_level_id" class="block text-sm font-bold text-gray-700"> Class Level <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="programme_level_id" id="programme_level_id" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.programme_level_id ? 'border-red-300' : 'border-gray-300'" v-model="form.programme_level_id" autocomplete="none" :disabled="disable_class_levels">
                                                    <option value="">-- Select Level --</option>
                                                    <option :value="i.id" v-for="i, index in class_levels" :key="i">{{ i.level }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="class_day" class="block text-sm font-bold text-gray-700"> Class Day <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="class_day" id="class_day" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_day ? 'border-red-300' : 'border-gray-300'" v-model="form.class_day" autocomplete="none">
                                                    <option value="">-- Select Day --</option>
                                                    <option :value="day.id" v-for="day in day_list" :key="day">{{ day.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="class_method" class="block text-sm font-bold text-gray-700"> Class Methods <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select name="class_method" id="class_method" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_method ? 'border-red-300' : 'border-gray-300'" v-model="form.class_method" autocomplete="none">
                                                    <option value="">-- Select Method --</option>
                                                    <option :value="class_method.id" v-for="class_method in method_list" :key="class_method">{{ class_method.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="start_time" class="block text-sm font-bold text-gray-700"> Start Time <span class="text-red-500">*</span></label>
                                        <Datepicker :class="'mt-1 rounded-md shadow-sm'" :style="$page.props.errors.start_time ? '--dp-border-color: #fa9e9e' : ''" v-model="form.start_time" :timePicker="true" :is24="false" />
                                    </div>
                                    <div class="mb-4">
                                        <label for="end_time" class="block text-sm font-bold text-gray-700"> End Time <span class="text-red-500">*</span></label>
                                        <Datepicker :class="'mt-1 rounded-md shadow-sm'" :style="$page.props.errors.end_time ? '--dp-border-color: #fa9e9e' : ''" v-model="form.end_time" :timePicker="true" :is24="false" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="class_capacity" class="block text-sm font-bold text-gray-700"> Class Capacity <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="number" name="class_capacity" id="class_capacity" class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_capacity ? 'border-red-300' : 'border-gray-300'" v-model="form.class_capacity" autocomplete="none" @keypress="numberOnly"/>
                                        </div>
                                    </div>
                                </div>
                                <div class=" border-b border-dashed border-indigo-900 mt-4 mb-5"></div>
                                <div class="flex items-center justify-between">
                                    <div class="flex space-x-2">
                                        <label for="" class="block font-bold text-gray-700">Active</label>
                                        <Toggle v-model="form.class_status" 
                                            :classes="{
                                                container: 'inline-block',
                                                toggle: 'flex w-12 h-5 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
                                                toggleOn: 'bg-green-500 border-green-500 justify-start text-white',
                                                toggleOff: 'bg-gray-400 border-gray-400 justify-end text-gray-700',
                                            }
                                        "/>
                                    </div>
                                    <div class="flex space-x-2">
                                        <BreezeButton buttonType="gray" :route="route('classes')">Cancel</BreezeButton>
                                        <BreezeButton type="submit">Save</BreezeButton>
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
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import Toggle from '@vueform/toggle';
import Multiselect from '@vueform/multiselect'
import moment from 'moment';

export default {
    components: {
        Head, Link, Datepicker, Toggle, Multiselect
    },
    props: {
        class_info: Object,
        class_types: Object,
        class_levels: Object,
        programme_list: Object,
        day_list: Object,
        type_list: Object,
        method_list: Object,
    },
    data(){
        return{
            disable_class_types: false,
            disable_class_levels: false,
            class_types: this.class_types ? this.class_types : [],
            class_levels: this.class_levels ? this.class_levels : [],
            form: {
                class_id: this.class_info ? this.class_info.class_id : '',
                centre_id: this.class_info ? this.class_info.centre_id : '',
                programme_id: this.class_info ? this.class_info.programme_id : '',
                programme_level_id: this.class_info ? this.class_info.programme_level_id : '',
                class_day: this.class_info ? this.class_info.class_day_id : '',
                start_time: {
                    'hours': new Date(new moment(this.class_info.start_time, 'HH:mm:ss')).getHours(),
                    'minutes' : new Date(new moment(this.class_info.start_time, 'HH:mm:ss')).getMinutes(),
                    'seconds' : new Date(new moment(this.class_info.start_time, 'HH:mm:ss')).getSeconds(),
                },
                end_time: {
                    'hours' : new Date(new moment(this.class_info.end_time, 'HH:mm:ss')).getHours(),
                    'minutes' : new Date(new moment(this.class_info.end_time, 'HH:mm:ss')).getMinutes(),
                    'seconds' : new Date(new moment(this.class_info.end_time, 'HH:mm:ss')).getSeconds(),
                },
                class_capacity: this.class_info ? this.class_info.capacity : '',
                class_type: this.class_info ? this.class_info.class_type_id : '',
                class_method: this.class_info ? this.class_info.class_method_id : '',
                class_status: this.class_info ? this.class_info.status: false,
            }
        }
    },
    watch: {
        'form.programme_id': {
            handler(){
                if(this.form.programme_id){
                    this.disable_class_types = true
                    this.disable_class_levels = true
                    this.form.class_type = ''
                    this.form.programme_level_id = ''
                    axios.get(route('classes.get_class_types'), {
                        params: {
                            'programme_id': this.form.programme_id,
                        }
                    })
                    .then((response) => {
                        this.class_types = response.data
                        this.disable_class_types = false
                    })
                }
            },
            deep: true
        },
        'form.class_type': {
            handler(){
                if(this.form.programme_id && this.form.class_type){
                    this.disable_class_levels = true
                    this.form.programme_level_id = ''
                    axios.get(route('classes.get_class_levels'), {
                        params: {
                            'programme_id': this.form.programme_id,
                            'class_type': this.form.class_type
                        }
                    })
                    .then((response) => {
                        this.class_levels = response.data
                        this.disable_class_levels = false
                    })
                }
            },
            deep: true
        },
    },
    methods: {
        submit() {
            this.$inertia.post(route('classes.update'), this.form, { preserveState: true})
        },
        numberOnly (evt){
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();;
            } else {
                return true;
            }
        }
    }
}
</script>
