<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>

<template>
    <Head title="Diagnostic Test" />
    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <!-- <input type="hidden" v-model="menu_id"> -->
                    <div class="px-4 py-5 bg-indigo-50 space-y-2 sm:p-6">
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="items-center justify-center p-6 bg-white border border-gray-200 rounded-lg shadow-md h-fit">
                                    <div class="flex justify-center">
                                        <div class="mb-5">
                                            <img class="h-24 w-24" :src="'/images/anf-logo-main-2x.png'" alt="Workflow logo">
                                        </div>
                                    </div>
                                    <div class="mb-8 flex justify-center">
                                        <h1 class="font-semibold font-mono text-lg sm:text-2xl">ALFA and Friends Diagnostic Test</h1>
                                    </div>
                                    <div class="flex-col px-6 py-14 rounded-[4px] min-w-[80%] lg:min-w-[25%] space-y-4" v-if="showMain">
                                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="border px-6 py-4 font-medium text-gray-900">Name</th>
                                                <th scope="col" class="border px-6 py-4 font-medium text-gray-900">Age</th>
                                                <th scope="col" class="border px-6 py-4 font-medium text-gray-900">Date of Birth</th>
                                                <th scope="col" class="border px-6 py-4 font-medium text-gray-900 text-center">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100">
                                                <tr class="hover:bg-gray-50" v-if="$page.props.children.length" v-for="(child, index) in $page.props.children">
                                                    <td class="border px-6 py-4 text-slate-700">{{ child.name }}</td>
                                                    <td class="border px-6 py-4 text-slate-700">{{ moment().diff(child.date_of_birth, 'years')  }} Years Old</td>
                                                    <td class="border px-6 py-4 text-slate-700">{{ moment(child.date_of_birth, 'YYYY.MM.DD').format('DD-MM-YYYY')  }}</td>
                                                    <td class="border px-6 py-4">
                                                        <div class="flex justify-center gap-4">
                                                            <BreezeButton buttonType="blue" @click="selectChild(child.id, moment().diff(child.date_of_birth, 'years'))">Select Student</BreezeButton>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="flex px-6 py-14 justify-center" v-if="showSelectLanguage">
                                        <div class="flex flex-col w-1/2 p-6">
                                            <div class="flex flex-col text-sm rounded-md space-y-2">
                                                <label class="block text-sm text-gray-700 font-bold" for="">Language</label>
                                                <select class="mb-5 border rounded-[4px] p-3 hover:outline-none focus:outline-none focus:ring-0 focus:border-gray-500" v-model="form.language">
                                                    <option value="">Please select</option>
                                                    <option :value="language.id" v-for="language in $page.props.languages">{{ language.name }}</option>
                                                </select>
                                            </div>
                                            <div class="flex flex-col space-y-2">
                                                <button type="button" class="mt-5 w-full border p-2 text-white rounded-[4px] bg-gray-700 hover:bg-gray-600" :class="canStartTest ? 'opacity-100' : 'cursor-not-allowed opacity-50'" @click="canStartTest ? startTest() : ''">Start Now</button>
                                                <button type="button" class="rounded py-2 px-4 bg-gray-300 hover:bg-gray-200" @click="back()">Back</button>  
                                            </div>
                                        </div>
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
import axios from 'axios';
import moment from 'moment';

const age_list = [4, 5, 6, 7, 8, 9, 10, 11, 12]

export default {
    components: {
        Head, Link, 
    },
    data(){
        return{
            showMain: true,
            showSelectLanguage: false,
            canStartTest: false,
            dt_list: [],
            form:{
                child_id: '',
                child_age: '',
                language: '',
            },
            error:{
                name: false,
                age: false,
                language: false,
            }
        }
    },
    watch: {
        'form.language': {
            handler(){
                if(this.form.language != ''){
                    this.canStartTest = true
                }
                else{
                    this.canStartTest = false
                }
            }
        }
    },
    methods: {
        startTest(){
            this.$inertia.post(route('diagnostic_test.run'), {'form_data': this.form})
        },
        selectChild(child_id, dob){
            this.form.child_id      = child_id,
            this.form.child_age     = dob
            this.showMain           = false
            this.showSelectLanguage = true
        },
        back(){
            this.showMain           = true
            this.showSelectLanguage = false
        }
    }

}
</script>
