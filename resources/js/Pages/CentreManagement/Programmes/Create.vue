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
                                    <div class="grid grid-cols-2 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="programme_name" class="block text-sm text-gray-700 font-bold"> Programme Name <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="programme_name" id="programme_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.programme_name ? 'border-red-300' : 'border-gray-300'" v-model="form.programme_name" autocomplete="off"/>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="programme_country" class="block text-sm text-gray-700 font-bold"> Programme Country <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select type="text" name="programme_country" id="programme_country" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.programme_country ? 'border-red-300' : 'border-gray-300'" v-model="form.programme_country" autocomplete="none">
                                                    <option value="">Select a country</option>
                                                    <option :value="country.id" v-for="country in $page.props.countries">{{ country.name }}</option>
                                                </select>
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
                                            <BreezeButton buttonType="info" @click="showAddFee">Add Fee</BreezeButton>
                                        </div>  
                                        <div class="border-b border-dashed border-indigo-900 mt-3"></div>
                                    </div>
                                    <div class="    overflow-hidden border border-gray-800 rounded-t-sm rounded-b-none mt-3">
                                        <table class="shadow shadow-gray-500 min-w-full divide-y divide-gray-800">
                                            <thead class="bg-slate-700 text-white">
                                                <tr>
                                                    <th class="px-4 py-1 text-center border border-gray-400">Level</th>
                                                    <th class="px-4 py-1 text-center border border-gray-400">Class Type</th>
                                                    <th class="px-4 py-1 text-center border border-gray-400">Material Fee</th>
                                                    <th class="px-4 py-1 text-center border border-gray-400">Fee</th>
                                                    <th class="px-4 py-1 text-center border border-gray-400">Material</th>
                                                    <th class="px-4 py-1 text-center border border-gray-400">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-if="!form.programme_info.length">
                                                    <td colspan="8" class="py-4 text-center font-semibold text-sm italic">No Fees added.</td>
                                                </tr>
                                                <tr else class="hover:bg-gray-200" v-for="info, index in form.programme_info">
                                                    <td class="px-4 py-2 text-center border border-gray-400 text-sm text-gray-700">{{ info.level }}</td>
                                                    <td class="px-4 py-2 text-center border border-gray-400 text-sm text-gray-700">{{ $page.props.class_types[form.programme_info[index].class_type].name}}</td>
                                                    <td class="px-4 py-2 text-center border border-gray-400 text-sm text-gray-700">{{ info.material_fee }}</td>
                                                    <td class="px-4 py-2 text-center border border-gray-400 text-sm text-gray-700">
                                                        <div class="flex" v-for="fee in info.fees">
                                                            <p class="text-sm text-gray-700">{{ $page.props.class_types_detail.find((item)=>item.id === fee.class_type_detail_id)?.label }} : <span class="font-semibold">{{ fee.value }}</span></p>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-2 text-left border border-gray-400">
                                                        <div class="flex flex-col">
                                                            <p class="text-sm text-gray-700 font-normal underline"><span class="font-semibold">{{ info.product.name }}</span></p>
                                                            <p class="text-sm text-gray-700 italic">Variation : <span class="font-semibold">{{ info.product_variation.option_name ? info.product_variation.option_name : '-' }}</span></p>
                                                            <p class="text-sm text-gray-700 italic">Sub Variation : <span class="font-semibold">{{ info.product_sub_variation.option_name ? info.product_sub_variation.option_name : '-' }}</span></p>
                                                        </div>
                                                    </td>
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
                                    <label for="programme_status" class="block font-bold text-gray-700">Active</label>
                                    <Toggle v-model="form.programme_active" id="programme_status"
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
                                    <BreezeButton @click="submit()">Save</BreezeButton>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <Modal :showModal="show.add_fee" modalType="sm" @hideModal="show.add_fee = false">
            <template v-slot:header>
                <h3 class="text-gray-900 text-xl font-semibold">                
                    Add New Fee   
                </h3>                
            </template>
            <template v-slot:content>
                <div class="overflow-y-auto p-6" ref="scrollableDiv">
                    <div class="flex flex-col space-y-4">
                        <div class="">
                            <div class="mb-5">
                                <h1 class="text-indigo-800 font-bold">Fee Information</h1>
                                <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4 items-end mb-3">
                                <div class="grow">
                                    <label for="programme_level" class="block text-sm text-gray-700 font-bold"> Level <span class="text-red-500">*</span></label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <select name="programme_level" id="programme_level" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="validation.level.error ? 'border-red-300' : 'border-gray-300'" v-model="fee_form.level" autocomplete="off">
                                            <option value="">Please select a level</option>
                                            <option :value="level" v-for="level in 10">Level {{ level }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grow">
                                    <label for="programme_material_fee" class="block text-sm text-gray-700 font-bold"> Material Fee <span class="text-red-500">*</span></label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="number" min="1" name="programme_material_fee" id="programme_material_fee" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="validation.material_fee.error ? 'border-red-300' : 'border-gray-300'" v-model="fee_form.material_fee" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="grow">
                                    <label for="class_type" class="block text-sm text-gray-700 font-bold"> Class Type <span class="text-red-500">*</span></label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <select name="class_type" id="class_type" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="validation.class_type.error ? 'border-red-300' : 'border-gray-300'" v-model="fee_form.class_type" autocomplete="off">
                                            <option value="">-- Select Type --</option>
                                            <option :value="class_type.id" v-for="(class_type, index) in $page.props.class_types" :key="index">{{ class_type.name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grow" v-for="class_types_detail, index in list.class_types_detail">
                                    <label for="class_type_detail" class="block text-sm text-gray-700 font-bold"> {{ class_types_detail.label }} <span class="text-red-500">*</span></label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="number" min="1" name="class_type_detail" id="class_type_detail" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_type_detail ? 'border-red-300' : 'border-gray-300'" v-model="fee_form.fees[index].value" autocomplete="off"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="mb-5">
                                <h1 class="text-indigo-800 font-bold">Material Information</h1>
                                <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                            </div>
                            <div class="grid grid-cols-1">
                                <div class="mb-4">
                                    <label for="product_category" class="block text-sm text-gray-700 font-bold mb-2"> Product Name <span class="text-red-500">*</span></label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <Multiselect 
                                            ref="multiselect"
                                            v-debounce:1s="findProducts"
                                            v-model="search_product_form.product_id"
                                            @select="findProductVariations"
                                            @open="this.scrollToEnd()"
                                            valueProp="id"
                                            :loading="loading.products"
                                            placeholder="Please enter some keywords"
                                            :options="list.products"
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
                                                    validation.product.error ? 
                                                    'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded-md bg-white sm:text-sm leading-snug outline-none h-10':
                                                    'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white sm:text-sm leading-snug outline-none h-10',
                                                containerDisabled: 'cursor-default bg-gray-100',
                                                containerOpen: 'rounded-b-none',
                                                containerOpenTop: 'rounded-t-none',
                                                containerActive: 'border border-indigo-300',
                                                singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                search: 'w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 sm:text-sm font-sans bg-white rounded-md pl-3.5',
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
                                <div class="mb-4" v-if="show.product_variations">
                                    <label for="product_category" class="block text-sm text-gray-700 font-bold mb-2"> Variation <span class="text-red-500">*</span></label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <Multiselect 
                                            v-model="search_product_form.product_variation_id"
                                            @select="findProductSubVariations"
                                            @open="this.scrollToEnd()"
                                            valueProp="id"
                                            :loading="loading.product_variations"
                                            placeholder="Select a variation"
                                            :options="list.product_variations"
                                            :searchable="true"
                                            noOptionsText="Nothing found"
                                            noResultsText="Nothing found"
                                            :clearOnSelect="true"
                                            :canClear="false"
                                            :canDeselect="false"
                                            :internal-search="false"
                                            trackBy="option_name"
                                            label="option_name"
                                            :classes="{
                                                container: 
                                                    validation.product_variation.error ? 
                                                    'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded-md bg-white sm:text-sm leading-snug outline-none h-10':
                                                    'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white sm:text-sm leading-snug outline-none h-10',
                                                containerDisabled: 'cursor-default bg-gray-100',
                                                containerOpen: 'rounded-b-none',
                                                containerOpenTop: 'rounded-t-none',
                                                containerActive: 'border border-indigo-300',
                                                singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                search: 'w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 sm:text-sm font-sans bg-white rounded-md pl-3.5',
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
                                <div class="mb-4" v-if="show.product_sub_variations">
                                    <label for="product_category" class="block text-sm text-gray-700 font-bold mb-2"> Sub Variation <span class="text-red-500">*</span></label>
                                    <div class="mt-1 flex rounded-md shadow-sm z-50">
                                        <Multiselect 
                                            v-model="search_product_form.product_sub_variation_id"
                                            @open="this.scrollToEnd()"
                                            valueProp="id"
                                            :loading="loading.product_sub_variations"
                                            placeholder="Select a sub variation"
                                            :options="list.product_sub_variations"
                                            :searchable="true"
                                            noOptionsText="Nothing found"
                                            noResultsText="Nothing found"
                                            :clearOnSelect="true"
                                            :canClear="false"
                                            :canDeselect="false"
                                            :internal-search="false"
                                            trackBy="option_name"
                                            label="option_name"
                                            :classes="{
                                                container: 
                                                    validation.product_sub_variation.error ? 
                                                    'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded-md bg-white sm:text-sm leading-snug outline-none h-10':
                                                    'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white sm:text-sm leading-snug outline-none h-10',
                                                containerDisabled: 'cursor-default bg-gray-100',
                                                containerOpen: 'rounded-b-none',
                                                containerOpenTop: 'rounded-t-none',
                                                containerActive: 'border border-indigo-300',
                                                singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                search: 'w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 sm:text-sm font-sans bg-white rounded-md pl-3.5',
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
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:footer>
                <div class="flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                    <BreezeButton buttonType="info" @click="addFee">Add Fee</BreezeButton>
                </div>
            </template>
        </Modal>
    </BreezeAuthenticatedLayout>
</template>



<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Toggle from '@vueform/toggle';
import Modal from '@/Components/Modal.vue'
import Multiselect from '@vueform/multiselect'
import { debounce } from 'vue-debounce'

export default {
    components: {
        Head, Link, Toggle
    },
    data() {
        return {
            form: {
                programme_name: '',
                programme_country: '',
                programme_info: [],
                programme_active: true,
            },
            fee_form: {
                level: '',
                material_fee: '',
                class_type: '',
                fees: [],
            },
            show:{
                add_fee: false,
                product_variations: false,
                product_sub_variations: false,
                add_tracking_status: false
            },
            list:{
                products: [],
                product_variations: [],
                product_sub_variations: [],
                class_types_detail: [],
            },
            loading:{
                products: false,
                product_variations: false,
                product_sub_variations: false,
            },
            selected:{
                product: [],
                product_variation: [],
                product_sub_variation: []
            },
            search_product_form: {
                product_id: '',
                product_variation_id: '',
                product_sub_variation_id: '',
            },
            validation:{
                level: {
                    required: true,
                    error: false
                },
                material_fee: {
                    required: true,
                    error: false
                },
                class_type: {
                    required: true,
                    error: false
                },
                product: {
                    required: true,
                    error: false
                },
                product_variation: {
                    required: false,
                    error: false
                },
                product_sub_variation: {
                    required: false,
                    error: false
                },
            }
        }
    },
    watch: {
        // 'fee_form.class_types_detail': {
        //     handler(){
        //         this.fee_form.class_types_detail.forEach((item)=>{
        //             if(item.value == '' || item.value < 1){
        //                 item.value = 1
        //             }
        //         })
        //     },
        //     deep: true
        // },
        'fee_form.class_type': {
            handler(){
                this.list.class_types_detail = []
                this.fee_form.fees = []
                this.$page.props.class_types_detail.forEach((class_type_detail)=>{
                    if(class_type_detail.class_type_id == this.fee_form.class_type){
                        this.list.class_types_detail.push(class_type_detail)
                        this.fee_form.fees.push({class_type_detail_id: class_type_detail.id, value: 1})
                    }
                })
            },
            deep: true
        },
        'search_product_form.product_id': {
            handler(){
                if(this.search_product_form.product_id){
                    this.selected.product = this.list.products.find(item => item.id === this.search_product_form.product_id)
                    this.show.product_variations                        =   this.selected.product.has_variation == 1 ? true : false
                    this.show.product_sub_variations                    =   this.selected.product.has_sub_variation == 1 ? true : false
                    this.search_product_form.product_variation_id       =   ''
                    this.search_product_form.product_sub_variation_id   =   ''
                    this.selected.product_variation                     =   []
                    this.selected.product_sub_variation                 =   []
                }
            }
        },
        'search_product_form.product_variation_id': {
            handler(){
                if(this.search_product_form.product_variation_id){
                    this.selected.product_variation = this.list.product_variations.find(item => item.id === this.search_product_form.product_variation_id)
                    this.search_product_form.product_sub_variation_id   =   ''
                    this.selected.product_sub_variation                 =   []
                }
            }
        },
        'search_product_form.product_sub_variation_id': {
            handler(){
                if(this.search_product_form.product_sub_variation_id){
                    this.selected.product_sub_variation = this.list.product_sub_variations.find(item => item.id === this.search_product_form.product_sub_variation_id)
                }
            }
        },
    },  
    methods: {
        submit() {
            this.$inertia.post(route('programmes.store'), this.form)
        },
        showAddFee(){
            this.search_product_form.product_id                 =   ''
            this.search_product_form.product_variation_id       =   ''
            this.search_product_form.product_sub_variation_id   =   ''
            this.list.products                                  =   []
            this.list.product_variations                        =   []
            this.list.product_sub_variations                    =   []
            this.selected.product                               =   []
            this.selected.product_variation                     =   []
            this.selected.product_sub_variation                 =   []
            this.show.product_variations                        =   false
            this.show.product_sub_variations                    =   false
            this.validation.product.error                       =   false
            this.validation.product_variation.required          =   false
            this.validation.product_variation.error             =   false
            this.validation.product_sub_variation.required      =   false
            this.validation.product_sub_variation.error         =   false
            this.show.add_fee   =   true
        },
        addFee(){
            this.validation.level.error                     = this.fee_form.level == '' ? true : false
            this.validation.material_fee.error              = this.fee_form.material_fee == '' ? true : false
            this.validation.class_type.error                = this.fee_form.class_type == '' ? true : false
            this.validation.product.error                   = !Object.keys(this.selected.product).length ? true : false
            this.validation.product_variation.required      = this.selected.product.has_variation == 1 ? true : false
            this.validation.product_variation.error         = this.selected.product.has_variation == 1 && !Object.keys(this.selected.product_variation).length ? true : false
            this.validation.product_sub_variation.required  = this.selected.product.has_sub_variation == 1 ? true : false
            this.validation.product_sub_variation.error     = this.selected.product.has_sub_variation == 1 && !Object.keys(this.selected.product_sub_variation).length ? true : false

            if(this.validation.product.required && !Object.keys(this.selected.product).length || this.validation.product_variation.required && !Object.keys(this.selected.product_variation).length || this.validation.product_sub_variation.required && !Object.keys(this.selected.product_sub_variation).length){
                return
            }
            if(this.fee_form.level == '' || this.fee_form.material_fee == '' || this.fee_form.material_fee == 0 || this.fee_form.class_type == '' || this.fee_form.fees.length < 1){
                return
            }
            const fee_items =   this.fee_form.fees
            this.form.programme_info.push({
                'level': this.fee_form.level,
                'material_fee': this.fee_form.material_fee,
                'class_type': this.fee_form.class_type,
                'fees': fee_items,
                'product': this.selected.product,
                'product_variation': this.selected.product_variation,
                'product_sub_variation': this.selected.product_sub_variation,
            })
            this.form.programme_info.sort((firstItem, secondItem)=>firstItem.level - secondItem.level)
            this.clearForm()
            this.show.add_fee = false
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
            this.fee_form.level = ''
            this.fee_form.material_fee = ''
            this.fee_form.class_type = ''
            this.fee_form.fees = []
        },
        findProducts(query){
            if(query){
                this.loading.products = true
                axios.get(route('products.find_products'), {
                    params: {
                        'keyword': query
                    }
                })
                .then((res) => {
                    this.list.products = res.data
                    this.loading.products = false
                })
                .finally(()=>{
                    this.scrollToEnd()
                })
            }
        },
        findProductVariations(){
            this.loading.product_variations = true
            axios.get(route('products.find_product_variations'), {
                params: {
                    'product_id': this.search_product_form.product_id
                }
            })
            .then((res) => {
                this.list.product_variations = res.data
                this.loading.product_variations = false
            })
            .finally(()=>{
                this.scrollToEnd()
            });
        },
        findProductSubVariations(){
            this.loading.product_sub_variations = true
            axios.get(route('products.find_product_sub_variations'), {
                params: {
                    'product_variation_id': this.search_product_form.product_variation_id
                }
            })
            .then((res) => {
                this.list.product_sub_variations = res.data
                this.loading.product_sub_variations = false
            })
            .finally(()=>{
                this.scrollToEnd()
            });
        },
        scrollToEnd() {
            setTimeout(() => {
                    const div = this.$refs.scrollableDiv;
                    div.scrollTop = div.scrollHeight;
            }, 10);

        },
    }
}
</script>
