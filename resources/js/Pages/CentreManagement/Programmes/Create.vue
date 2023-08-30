<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
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
                    <div class="px-4 py-5 space-y-6 sm:p-6">
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="text-indigo-800 font-bold">Programme Information</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="programme_name" class="block text-sm text-gray-700 font-bold"> Programme Name <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="programme_name" id="programme_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.programme_name ? 'border-red-300' : 'border-gray-300'" v-model="form.programme_name" autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <div class="flex justify-between items-end">
                                            <h1 class="text-indigo-800 font-bold">Programme Levels and Fees</h1>
                                            <BreezeButton buttonType="info" @click="showAddFee">Add Level & Fee</BreezeButton>
                                        </div>  
                                        <div class="border-b border-dashed border-indigo-900 mt-3"></div>
                                    </div>
                                    <div class="shadow overflow-hidden border-b border-gray-200 rounded-t-sm rounded-b-none mt-3">
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
                                                    <td class="px-4 py-2 text-center border border-gray-400" v-for="class_type_detail, class_type_detail_index in this.$page.props.class_types_detail">{{ form.programme_info[index].fees[class_type_detail.id] }}</td>
                                                    <td class="px-4 py-2 text-center border border-gray-400">
                                                        <BreezeButton buttonType="danger" @click="deleteLevel(index)">Delete</BreezeButton>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
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
                                    <BreezeButton buttonType="gray" :route="route('programmes')">Cancel</BreezeButton>
                                    <BreezeButton type="submit" >Save</BreezeButton>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <Modal :showModal="show_add_fee" modalType="sm" @hideModal="show_add_fee = false">
            <template v-slot:header>
                <h3 class="text-gray-900 text-xl font-semibold">                
                    Add new level and fee   
                </h3>                
            </template>
            <template v-slot:content>
                <div class="overflow-y-auto p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4 items-end mb-3">
                        <div class="grow">
                            <label for="programme_level" class="block text-sm text-gray-700 font-bold"> Level <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <select name="" id="" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.programme_level ? 'border-red-300' : 'border-gray-300'" v-model="level" autocomplete="off">
                                    <option value="">Please select a level</option>
                                    <option :value="level" v-for="level in 10">Level {{ level }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="grow">
                            <label for="programme_material_fee" class="block text-sm text-gray-700 font-bold"> Material Fee <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="number" min="1" name="programme_material_fee" id="programme_material_fee" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.programme_material_fee ? 'border-red-300' : 'border-gray-300'" v-model="material_fee" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="grow">
                            <label for="class_type" class="block text-sm text-gray-700 font-bold"> Class Type <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <select name="class_type" id="class_type" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_type ? 'border-red-300' : 'border-gray-300'" v-model="class_type" autocomplete="off">
                                    <option value="">-- Select Type --</option>
                                    <option :value="class_type.id" v-for="(class_type, index) in $page.props.class_types" :key="index">{{ class_type.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="grow" v-for="class_type in class_types_detail">
                            <label for="class_type_detail" class="block text-sm text-gray-700 font-bold"> {{ class_type.label }} <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="number" min="1" name="class_type_detail" id="class_type_detail" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_type_detail ? 'border-red-300' : 'border-gray-300'" v-model="fee[class_type.id]" autocomplete="off"/>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:footer>
                <div class="flex justify-between space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                    <BreezeButton buttonType="gray" @click="addFee">Add Fee</BreezeButton>
                </div>
            </template>
        </Modal>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Toggle from '@vueform/toggle';
import Modal from '@/Components/Modal.vue'

export default {
    components: {
        Head, Link, Toggle
    },
    data() {
        return {
            show_add_fee: false,
            class_types_detail: [],
            level: '',
            material_fee: '',
            class_type: '',
            fee: [],
            form: {
                programme_name: '',
                programme_info: [],
                programme_active: true,
            },
            selected: {
                product: [],
                product_variation: [],
                product_sub_variation: []
            }
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
            this.$inertia.post(route('programmes.store'), this.form, { preserveState: true})
        },
        showAddFee(){
            this.show_add_fee   =   true
        },
        addFee(){
            if(this.level && this.level != 0 && this.material_fee && this.material_fee != 0 && this.class_type && this.fee.length > 0 ){
                this.form.programme_info.push({
                    'level': this.level,
                    'material_fee': this.material_fee,
                    'class_type': this.class_type,
                    'fees': this.fee,
                    'product': this.selected.product,
                    'product_variation': this.selected.product_variation,
                    'product_sub_variation': this.selected.product_sub_variation,
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
    }
}
</script>
