<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>
<style>
  input[type='number']::-webkit-inner-spin-button,
  input[type='number']::-webkit-outer-spin-button {
    margin: 0;
  }

  .custom-number-input input:focus {
    outline: none !important;
  }

  .custom-number-input button:focus {
    outline: none !important;
  }
</style>

<template>
    <Head title="Programmes" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <div class="grid grid-rows-2 grid-cols-1 sm:grid-cols-2 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="mb-5">
                                    <h1 class="text-indigo-800 font-bold">Programme Information</h1>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="programme_name" class="block text-gray-700 font-bold"> Programme Name <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="programme_name" id="programme_name" class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm" :class="$page.props.errors.programme_name ? 'border-red-300' : 'border-gray-300'" v-model="form.programme_name" autocomplete="none"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                            <div class="mb-5">
                                <h1 class="text-indigo-800 font-bold">Programme Levels & Fees</h1>
                                <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                            </div>
                            <div class="grid grid-cols-8 sm:grid-cols-0 gap-0 sm:gap-4 items-end">
                                <div class="grow">
                                    <label for="programme_level" class="block text-gray-700 font-bold"> Level <span class="text-red-500">*</span></label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" name="programme_level" id="programme_level" class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm" :class="$page.props.errors.programme_level ? 'border-red-300' : 'border-gray-300'" v-model="level" autocomplete="none" @keypress="numbersOnly"/>
                                    </div>
                                </div>
                                <div class="grow">
                                    <label for="programme_material_fee" class="block text-gray-700 font-bold"> Material Fee <span class="text-red-500">*</span></label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" name="programme_material_fee" id="programme_material_fee" class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm" :class="$page.props.errors.programme_material_fee ? 'border-red-300' : 'border-gray-300'" v-model="material_fee" autocomplete="none" @keypress="numbersOnly"/>
                                    </div>
                                </div>
                                <div class="grow">
                                    <label for="class_type" class="block text-gray-700 font-bold"> Class Type <span class="text-red-500">*</span></label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <select name="class_type" id="class_type" class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm" :class="$page.props.errors.class_type ? 'border-red-300' : 'border-gray-300'" v-model="class_type" autocomplete="none">
                                            <option value="">-- Select Type --</option>
                                            <option :value="class_type.id" v-for="(class_type, index) in $page.props.class_types" :key="index">{{ class_type.name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grow" v-for="class_type in class_types_detail">
                                    <label for="class_type_detail" class="block text-gray-700 font-bold"> {{ class_type.label }} <span class="text-red-500">*</span></label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" name="class_type_detail" id="class_type_detail" class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm" :class="$page.props.errors.class_type_detail ? 'border-red-300' : 'border-gray-300'" v-model="fee[class_type.id]" autocomplete="none" @keypress="numbersOnly"/>
                                    </div>
                                </div>
                                <div class="grow" v-if="class_types_detail.length">
                                    <BreezeButton buttonType="blue" :class="'px-6 py-3'" @click="addLevel">Add Level & Fee</BreezeButton>
                                </div>  
                            </div>
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                <div class="shadow overflow-hidden border-b border-gray-200 rounded-t-sm rounded-b-none">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-blue-200">
                                            <tr>
                                                <th class="px-4 py-1 text-center border border-gray-400">Level</th>
                                                <th class="px-4 py-1 text-center border border-gray-400">Class Type</th>
                                                <th class="px-4 py-1 text-center border border-gray-400">Material Fee</th>
                                                <th class="px-4 py-1 text-center border border-gray-400" v-for="class_type_detail in this.$page.props.class_types_detail">{{ class_type_detail.label }} </th>
                                                <th class="px-4 py-1 text-center border border-gray-400">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-if="!form.programme_info.length">
                                                <td colspan="8" class="py-4 text-center">No levels added.</td>
                                            </tr>
                                            <tr else class="hover:bg-gray-200" v-for="info, index in form.programme_info">
                                                <td class="px-4 py-2 text-center border border-gray-400">{{ info.level }}</td>
                                                <td class="px-4 py-2 text-center border border-gray-400">{{ $page.props.class_types[form.programme_info[index].class_type].name}}</td>
                                                <td class="px-4 py-2 text-center border border-gray-400">{{ info.material_fee }}</td>
                                                <td class="px-4 py-2 text-center border border-gray-400" v-for="class_type_detail, class_type_detail_index in this.$page.props.class_types_detail">{{ form.programme_info[index].fee[class_type_detail.id] }}</td>
                                                <td class="px-4 py-2 text-center border border-gray-400">
                                                    <BreezeButton buttonType="danger" @click="deleteLevel(index)">Delete</BreezeButton>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class=" border-b border-dashed border-indigo-900 mt-4 mb-5"></div>
                        <div class="flex justify-between items-center">
                            <div class="flex space-x-2">
                                <label for="" class="block font-bold text-gray-700">Active</label>
                                <Toggle v-model="form.programme_active" 
                                    :classes="{
                                        container: 'inline-block',
                                        toggle: 'flex w-12 h-5 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
                                        toggleOn: 'bg-green-500 border-green-500 justify-start text-white',
                                        toggleOff: 'bg-gray-400 border-gray-400 justify-end text-gray-700',
                                    }
                                "/>
                            </div>
                            <div class="flex space-x-2">
                                <BreezeButton buttonType="gray" :route="route('settings.programmes')">Cancel</BreezeButton>
                                <BreezeButton type="submit" >Save</BreezeButton>
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
import Toggle from '@vueform/toggle';

export default {
    components: {
        Link, Toggle
    },
    data() {
        return {
            tempObj: {},
            class_types_detail: [],
            level: '',
            material_fee: '',
            class_type: '',
            fee: [],
            form: {
                programme_id: this.$page.props.programme_id ? this.$page.props.programme_id : '',
                programme_name: this.$page.props.programme_name ? this.$page.props.programme_name : '',
                programme_info: this.$page.props.programme_info ? this.$page.props.programme_info : [],
                programme_active: true,
            },
        }
    },
    watch: {
        'class_type': {
            handler(){
                this.class_types_detail = []
                this.$page.props.class_types_detail.forEach((class_type_detail)=>{
                    if(class_type_detail.class_type_id == this.class_type){
                        this.class_types_detail.push(class_type_detail)
                    }
                })
            }
        }
    },  
    methods: {
        submit() {
            this.$inertia.post(route('settings.programmes.update'), this.form, { preserveState: true})
        },
        addLevel(){
            if(this.level && this.level != 0 && this.material_fee && this.material_fee != 0     && this.class_type && this.fee.length > 0 ){
                var fee_list = {}
                this.fee.forEach((fee, class_type_detail_id)=>{
                    Object.assign(fee_list, {[class_type_detail_id] : fee})
                })
                console.log(fee_list)

                
                this.form.programme_info.push({
                    'level': this.level,
                    'material_fee': this.material_fee,
                    'class_type': this.class_type,
                    'fee': fee_list,
                })
                this.form.programme_info.sort((firstItem, secondItem)=>firstItem.level - secondItem.level)
                this.clearForm()
            }
        },
        deleteLevel(index){
            this.form.programme_info.splice(index, 1)
        },
        numbersOnly (evt){
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();;
            } else {
                return true;
            }
        },
        clearForm(){
            this.level = ''
            this.material_fee = ''
            this.class_type = ''
            this.fee = []
        }
    },
}
</script>
