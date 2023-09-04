<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Orders" />

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
                                        <h1 class="font-bold text-indigo-800">Order Information </h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                            <div class="">
                                                <label class="block text-sm text-gray-700 font-bold mb-2"> Student's Name <span class="text-red-500">*</span></label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <Multiselect 
                                                        v-debounce:1s="findStudents"
                                                        v-model="form.student_id"
                                                        @close="clearUsers"
                                                        valueProp="id"
                                                        :loading="loading.students"
                                                        placeholder="Please enter some characters"
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
                                                                $page.props.errors.student_id ? 
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
                                            <div class="flex justify-end items-end">
                                                <BreezeButton type="info" @click="showAddOrder">Add Product</BreezeButton>
                                            </div>
                                        </div>
                                        <div class="overflow-x-auto">
                                            <table class="table-auto w-full">
                                                <thead class="text-xs font-semibold uppercase text-white bg-gray-700">
                                                    <tr>
                                                        <th class="py-2 px-4 whitespace-nowrap" width="1">
                                                            <div class="font-semibold text-left">#</div>
                                                        </th>
                                                        <th class="py-2 px-4 whitespace-nowrap">
                                                            <div class="font-semibold text-left">Name</div>
                                                        </th>
                                                        <th class="py-2 px-4 whitespace-nowrap">
                                                            <div class="font-semibold text-left">Variation</div>
                                                        </th>
                                                        <th class="py-2 px-4 whitespace-nowrap">
                                                            <div class="font-semibold text-left">Sub Variation</div>
                                                        </th>
                                                        <th class="py-2 px-4 whitespace-nowrap" width="1">
                                                            <div class="font-semibold text-center">Quantity</div>
                                                        </th>
                                                        <th class="py-2 px-4 whitespace-nowrap" width="1">
                                                            <div class="font-semibold text-center">Action</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-sm divide-y divide-gray-100">
                                                    <tr class="border" v-if="!form.products.length">
                                                        <td colspan="10" class="border border-gray-400 py-6 px-4 whitespace-nowrap text-center">
                                                            No products added.
                                                        </td>
                                                    </tr>
                                                    <tr class="border" v-for="product, index in form.products">
                                                        <td class="border border-gray-400 py-2 px-4 whitespace-nowrap">
                                                            <div class="text-left">{{ index+1 }}</div>
                                                        </td>
                                                        <td class="border border-gray-400 py-2 px-4 whitespace-nowrap">
                                                            <div class="flex items-center">
                                                                <div class="font-medium text-gray-800">{{ product.product.name }}</div>
                                                            </div>
                                                        </td>
                                                        <td class="border border-gray-400 py-2 px-4 whitespace-nowrap">
                                                            <div class="text-left">{{ product.product_variation.option_name ? product.product_variation.option_name : '-' }}</div>
                                                        </td>
                                                        <td class="border border-gray-400 py-2 px-4 whitespace-nowrap">
                                                            <div class="text-left">{{ product.product_sub_variation.option_name ? product.product_sub_variation.option_name : '-' }}</div>
                                                        </td>
                                                        <td class="border border-gray-400 py-2 px-4 whitespace-nowrap">
                                                            <div>
                                                                <div class="flex items-center border border-gray-200 rounded">
                                                                    <button @click="decreaseQuantity(index)" type="button" class="font-semibold text-lg flex items-center justify-center w-8 h-8 leading-10 text-white bg-indigo-500">
                                                                        &minus;
                                                                    </button>
                                                                    <input type="number" min="0" max="999" v-model="product.quantity" class="h-8 w-16 border-gray-200 focus:border-gray-200 focus:ring-gray-200 text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none"/>
                                                                    <button @click="increaseQuantity(index)" type="button" class="font-semibold text-lg flex items-center justify-center w-8 h-8 leading-10 text-white bg-indigo-500">
                                                                        &plus;
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="border border-gray-400 py-2 px-4 whitespace-nowrap">
                                                            <div class="text-center hover:underline text-red-500 hover:text-red-600 cursor-pointer font-semibold" @click="deleteItem(index)">Delete</div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="font-bold text-indigo-800">Tracking Information </h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-2 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="shipping_provider" class="block text-sm text-gray-700 font-bold mb-2"> Shipping Provider </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select id="shipping_provider" class="focus:ring-0 border-gray-300 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.shipping_provider">
                                                    <option value="">Select a provider</option>
                                                    <option v-for="(provider, index) in $page.props.shipping_providers" :value="provider.id"> {{ provider.name }} </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="tracking_number" class="block text-sm text-gray-700 font-bold mb-2"> Tracking No </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" id="tracking_number" class="focus:ring-0 border-gray-300 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.tracking_number" autocomplete="off" placeholder="e.g. AA987654321BB"/>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="mb-5">
                                    <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4 mb-5">
                                        <div class="flex justify-end items-end">
                                            <BreezeButton type="info" @click="showTrackingStatus">Add Tracking Status</BreezeButton>
                                        </div>
                                        <div class="overflow-x-auto">
                                            <table class="table-auto w-full">
                                                <thead class="text-xs font-semibold uppercase text-white bg-gray-700">
                                                    <tr>
                                                        <th class="py-2 px-4 whitespace-nowrap" width="1">
                                                            <div class="font-semibold text-left">#</div>
                                                        </th>
                                                        <th class="py-2 px-4 whitespace-nowrap">
                                                            <div class="font-semibold text-left">Status</div>
                                                        </th>
                                                        <th class="py-2 px-4 whitespace-nowrap" width="1">
                                                            <div class="font-semibold text-center">Action</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-sm divide-y divide-gray-100">
                                                    <tr class="border" v-if="!form.tracking_status.length">
                                                        <td colspan="10" class="border border-gray-400 py-6 px-4 whitespace-nowrap text-center">
                                                            No status added.
                                                        </td>
                                                    </tr>
                                                    <tr class="border" v-for="status, index in form.tracking_status">
                                                        <td class="border border-gray-400 py-2 px-4 whitespace-nowrap">
                                                            <div class="text-left">{{ index+1 }}</div>
                                                        </td>
                                                        <td class="border border-gray-400 py-2 px-4 whitespace-nowrap">
                                                            <div class="flex items-center">
                                                                <div class="font-medium text-gray-800">{{ status.name }}</div>
                                                            </div>
                                                        </td>
                                                        <td class="border border-gray-400 py-2 px-4 whitespace-nowrap">
                                                            <div class="text-center hover:underline text-red-500 hover:text-red-600 cursor-pointer font-semibold" @click="deleteStatus(index)">Delete</div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 sm:grid-cols-0 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="status" class="block text-sm text-gray-700 font-bold mb-2"> Status <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select id="status" class="focus:ring-0 border-gray-300 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="form.status">
                                                    <option v-for="(status, index) in $page.props.status" :value="status.id"> {{ status.name }} </option>
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
                                    <div class="flex items-center justify-end space-x-2">
                                        <BreezeButton :route="route('orders')" buttonType="gray">Cancel</BreezeButton>
                                        <BreezeButton @click="storeOrder">Create Order</BreezeButton>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <Modal :modalType="'md'" :showModal="show.add_order" @hideModal="show.add_order = false">
            <template v-slot:header>
                <h3 class="text-gray-900 text-xl font-semibold">                
                    Add Product
                </h3>                
            </template>
            <template v-slot:content>
                <div class="p-4 md:p-6 overflow-y-auto no-scrollbar">
                    <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                        <div class="mb-4">
                            <label for="product_category" class="block text-sm text-gray-700 font-bold mb-2"> Product Name <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <Multiselect 
                                    ref="multiselect"
                                    v-debounce:1s="findProducts"
                                    v-model="search_product_form.product_id"
                                    @select="findProductVariations"
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
            </template>
            <template v-slot:footer>
                <div class="flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                    <BreezeButton buttonType="gray" @click="show.add_order = false">Cancel</BreezeButton>
                    <BreezeButton buttonType="info" @click="addProduct">Add Product</BreezeButton>
                </div>
            </template>
        </Modal>
        <Modal :modalType="'md'" :showModal="show.add_tracking_status" @hideModal="show.add_tracking_status = false">
            <template v-slot:header>
                <h3 class="text-gray-900 text-xl font-semibold">                
                    Add Status
                </h3>                
            </template>
            <template v-slot:content>
                <div class="p-4 md:p-6 overflow-y-auto no-scrollbar">
                    <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                        <div class="mb-4">
                            <label for="product_category" class="block text-sm text-gray-700 font-bold mb-2"> Status <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <textarea id="tracking_number" class="focus:ring-0 border-gray-300 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" v-model="tracking_status_input" autocomplete="off" placeholder="E.g. Order status changed from Processing to Shipped."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:footer>
                <div class="flex justify-end space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                    <BreezeButton buttonType="gray" @click="show.add_tracking_status = false">Cancel</BreezeButton>
                    <BreezeButton buttonType="info" @click="addStatus">Save</BreezeButton>
                </div>
            </template>
        </Modal>
    </BreezeAuthenticatedLayout>
</template>
<style src="@vueform/multiselect/themes/default.css"></style>

<script>
import Multiselect from '@vueform/multiselect'
import { debounce } from 'vue-debounce'
import Modal from '@/Components/Modal.vue'
import moment from 'moment'

export default {
    mounted(){
        this.form.status            = this.$page.props.status[0].id
    },
    data(){
        return{
            tracking_status_input: '',
            show:{
                add_order: false,
                product_variations: false,
                product_sub_variations: false,
                add_tracking_status: false
            },
            list:{
                students: [],
                products: [],
                product_variations: [],
                product_sub_variations: [],
            },
            loading:{
                students: false,
                products: false,
                product_variations: false,
                product_sub_variations: false,
            },
            form:{
                student_id: '',
                shipping_provider: '',
                tracking_number: '',
                status: '',
                products: [],
                tracking_status: []
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
        'search_product_form.product_id': {
            handler(){
                if(this.search_product_form.product_id){
                    this.selected.product = this.list.products.find(item => item.id === this.search_product_form.product_id)
                    this.show.product_variations                        =   this.selected.product.has_variation ? true : false
                    this.show.product_sub_variations                    =   this.selected.product.has_sub_variation ? true : false
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
        'form.products': {
            handler(){
                this.form.products.forEach(item=>{
                    if(item.quantity < 1){
                        item.quantity = 1
                    }
                })
            },
            deep: true
        }
    },
    methods: {
        showAddOrder(){
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
            this.show.add_order = true
        },
        showTrackingStatus(){
            this.tracking_status_input = ''
            this.show.add_tracking_status = true
        },
        findStudents(query){
            if(query){
                this.loading.students = true
                axios.get(route('students.find'), {
                    params: {
                        'keyword': query
                    }
                })
                .then((res) => {
                    this.list.students = res.data
                    this.loading.students = false
                });
            }
        },
        clearUsers(){
            this.list.students = []
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
                });
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
            });
        },
        addProduct(){
            this.validation.product.error       = !Object.keys(this.selected.product).length ? true : false

            this.validation.product_variation.required      = this.selected.product.has_variation ? true : false
            this.validation.product_variation.error         = this.selected.product.has_variation && !Object.keys(this.selected.product_variation).length ? true : false
            this.validation.product_sub_variation.required  = this.selected.product.has_sub_variation ? true : false
            this.validation.product_sub_variation.error     = this.selected.product.has_sub_variation && !Object.keys(this.selected.product_sub_variation).length ? true : false

            if(this.validation.product.required && !Object.keys(this.selected.product).length || this.validation.product_variation.required && !Object.keys(this.selected.product_variation).length || this.validation.product_sub_variation.required && !Object.keys(this.selected.product_sub_variation).length){
                return
            }
            this.form.products.push({
                product: this.selected.product,
                product_variation: this.selected.product_variation,
                product_sub_variation: this.selected.product_sub_variation,
                quantity: 1,
            })
            this.show.add_order = false
        },
        addStatus(){
            this.form.tracking_status.push({
                name: this.tracking_status_input,
                datetime: moment(),
            })
            this.show.add_tracking_status = false
        },
        increaseQuantity(index){
            if(this.form.products[index].quantity < 1000){
                this.form.products[index].quantity+=1
            }
        },
        decreaseQuantity(index){
            if(this.form.products[index].quantity > 1){
                this.form.products[index].quantity-=1
            }
        },
        deleteItem(index){
            this.form.products.splice(index, 1)
        },
        deleteStatus(index){
            this.form.tracking_status.splice(index, 1)
        },
        storeOrder(){
            this.$inertia.post(route('orders.store'), this.form)
        }
    }
}
</script>
