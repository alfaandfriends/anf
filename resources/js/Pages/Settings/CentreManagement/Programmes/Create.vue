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
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Class
            </h2>
        </template>
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
                                <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="programme_name" class="block text-gray-700 font-bold"> Programme Level <span class="text-red-500">*</span></label>
                                        <div class="custom-number-input h-10 w-32">
                                            <div class="flex flex-row h-10 w-full rounded-lg relative bg-transparent mt-1">
                                                <button type="button" @click="decrement" class=" bg-indigo-400 text-white hover:bg-indigo-500 h-full w-20 rounded-l cursor-pointer outline-none">
                                                    <span class="m-auto text-2xl font-thin">−</span>
                                                </button>
                                                <input type="number" class="focus:outline-none text-end w-full bg-indigo-100 font-semibold text-md hover:text-black focus:text-black  md:text-basecursor-default flex items-center text-gray-700  outline-none border-0 ring-0 focus:ring-0" name="custom-input-number" v-model="form.programme_level" disabled>
                                                <button type="button" @click="increment" class="bg-indigo-400 text-white hover:bg-indigo-500 h-full w-20 rounded-r cursor-pointer">
                                                    <span class="m-auto text-2xl font-thin">+</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-5">
                                    <h1 class="text-indigo-800 font-bold">Programme Fees</h1>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                    <div class="mb-4 space-y-1">
                                        <div class="flex flex-row border-2 p-2 border-indigo-300 space-x-3" v-for="(fee_types, fee_types_index) in fee_types" :key="fee_types_index">
                                            <div class="flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill mt-1 text-indigo-600" viewBox="0 0 16 16">
                                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                </svg>
                                            </div>
                                            <div class="flex flex-col">
                                                <label for="" class="block text-md text-gray-700 font-bold underline"> {{ fee_types.label }} </label>
                                                <div class="my-3 space-y-2">
                                                    <div class="flex space-x-3 items-center" v-for="(fee_details) in fee_types_detail[fee_types.id]" :key="fee_details">
                                                        <label for="" class="block text-gray-700 font-semibold">{{ fee_details.label }}</label>
                                                        <input type="text" class="py-1 rounded ring-0 border-gray-400 focus:ring-0 focus:border-indigo-500" placeholder="0" v-model="form.programme_fees[fee_details.id]" @keypress="numberOnly">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" border-b border-dashed border-indigo-900 mt-4 mb-5"></div>
                                <div class="flex items-end justify-between items-center">
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
        Head, Link, Toggle
    },
    props:{
        fee_types: Object,
        fee_types_detail: Object,
    },
    data() {
        return {
            fee_input: [],
            form: {
                programme_id: '',
                programme_level: 1,
                programme_name: '',
                programme_active: '',
                programme_fees: [],
            },
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('settings.programmes.store'), this.form, { preserveState: true})
        },
        increment(){
            if(this.form.programme_level < 5){
                this.form.programme_level += 1;
            }
        },
        decrement(){
            if(this.form.programme_level > 1){
                this.form.programme_level -= 1;
            }
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
