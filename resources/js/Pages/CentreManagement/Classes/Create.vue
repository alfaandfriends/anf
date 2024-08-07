<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Classes" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <Card>
            <template #title>Class Information</template>
            <template #content>
                <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-4 gap-4">
                    <div>
                        <Label>Centre<span class="text-red-500">*</span></Label>
                        <ComboBox :items="$page.props.allowed_centres" label-property="label" value-property="ID" :error="$page.props.errors.centre_id" v-model="form.centre_id" select-placeholder="Select Centre" search-placeholder="Search centre..."></ComboBox>
                    </div>
                    <div>
                        <Label>Programme<span class="text-red-500">*</span></Label>
                        <ComboBox :items="programme_list" label-property="name" value-property="id" :error="$page.props.errors.programme" v-model="form.programme_id" select-placeholder="Select Programme" search-placeholder="Search programme..."></ComboBox>
                    </div>
                    <div>
                        <Label>Class Type<span class="text-red-500">*</span></Label>
                        <ComboBox :items="class_types" label-property="name" value-property="id" :error="$page.props.errors.class_type" v-model="form.class_type" select-placeholder="Select Class Type" search-placeholder="Search class type..." :disabled="disable_class_types"></ComboBox>
                    </div>
                    <div>
                        <Label>Class Level<span class="text-red-500">*</span></Label>
                        <ComboBox :items="class_levels" label-property="level" value-property="id" :error="$page.props.errors.programme_level_id" v-model="form.programme_level_id" select-placeholder="Select Class Level" search-placeholder="Search class level..." :disabled="disable_class_levels"></ComboBox>
                    </div>
                    <div>
                        <label for="class_day" class="block text-sm font-bold text-gray-700"> Class Day <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <select name="class_day" id="class_day" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_day ? 'border-red-300' : 'border-gray-300'" v-model="form.class_day" autocomplete="off">
                                <option value="">-- Select Day --</option>
                                <option :value="day.id" v-for="day in day_list" :key="day">{{ day.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="class_method" class="block text-sm font-bold text-gray-700"> Class Methods <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <select name="class_method" id="class_method" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_method ? 'border-red-300' : 'border-gray-300'" v-model="form.class_method" autocomplete="off">
                                <option value="">-- Select Method --</option>
                                <option :value="class_method.id" v-for="class_method in method_list" :key="class_method">{{ class_method.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="start_time" class="block text-sm font-bold text-gray-700"> Start Time <span class="text-red-500">*</span></label>
                        <Datepicker :class="'mt-1 rounded-md shadow-sm'" :style="$page.props.errors.start_time ? '--dp-border-color: #fa9e9e' : ''" v-model="form.start_time" :timePicker="true" :is24="false" />
                    </div>
                    <div>
                        <label for="end_time" class="block text-sm font-bold text-gray-700"> End Time <span class="text-red-500">*</span></label>
                        <Datepicker :class="'mt-1 rounded-md shadow-sm'" :style="$page.props.errors.end_time ? '--dp-border-color: #fa9e9e' : ''" v-model="form.end_time" :timePicker="true" :is24="false" />
                    </div>
                    <div>
                        <label for="class_capacity" class="block text-sm font-bold text-gray-700"> Class Capacity <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="number" name="class_capacity" id="class_capacity" class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_capacity ? 'border-red-300' : 'border-gray-300'" v-model="form.class_capacity" autocomplete="off" @keypress="numberOnly"/>
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
                            <BreezeButton buttonType="gray" :url="route('classes')">Cancel</BreezeButton>
                            <BreezeButton type="submit">Save</BreezeButton>
                        </div>
                    </div>
                </div>
            </template>
        </Card>
    </BreezeAuthenticatedLayout>
</template>



<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Card from '@/Components/Card.vue'
import Dialog from '@/Components/DialogModal.vue'
import Datepicker from '@vuepic/vue-datepicker';
import Toggle from '@vueform/toggle';
import Multiselect from '@vueform/multiselect'

export default {
    components: {
        Head, Link, Datepicker, Toggle, Multiselect,
        Card, Dialog
    },
    props: {
        programme_list: Object,
        day_list: Object,
        method_list: Object,
        centre_id: String,
    },
    data(){
        return{
            disable_class_types: true,
            disable_class_levels: true,
            class_types: [],
            class_levels: [],
            form: {
                centre_id: this.centre_id ? this.centre_id : '',
                programme_id: '',
                programme_level_id: '',
                class_day: '',
                start_time: '',
                end_time: '',
                class_capacity: '',
                class_type: '',
                class_method: '',
                class_status: true,
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
            this.$inertia.post(route('classes.store'), this.form, { preserveState: true})
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
