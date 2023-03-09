<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
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
        <div class="flex flex-col items-center justify-center h-screen bg-blue-100">
            <div class="mb-5">
                <img class="h-24 w-24" :src="'/images/anf-logo-main-2x.png'" alt="Workflow logo">
            </div>
            <div class="mb-8 flex justify-center">
                <h1 class="font-semibold font-mono text-lg sm:text-2xl">ALFA and Friends Diagnostic Test</h1>
            </div>
            <div class="flex-col border bg-white px-6 py-14 shadow-md rounded-[4px] min-w-[80%] lg:min-w-[25%] space-y-4" v-if="showMain">
                <div class="flex flex-col text-sm rounded-md space-y-1">
                    <label class="block text-sm text-gray-700 font-bold" for="">Name</label>
                    <input class="mb-5 rounded-[4px] border p-3 hover:outline-none focus:outline-none focus:ring-0 focus:border-gray-500" :class="error.name ? 'border-red-500' : 'border-gray-500'" v-model="form.name" autocomplete="off"/>
                </div>
                <div class="flex flex-col text-sm rounded-md space-y-1">
                    <label class="block text-sm text-gray-700 font-bold" for="">Age</label>
                    <select class="mb-5 border rounded-[4px] p-3 hover:outline-none focus:outline-none focus:ring-0 focus:border-gray-500" :class="error.age ? 'border-red-500' : 'border-gray-500'" v-model="form.age" autocomplete="off">
                        <option :value="age.id" v-for="age in $page.props.ages">{{ age.name }}</option>
                    </select>
                </div>
                <div class="flex flex-col text-sm rounded-md space-y-1">    
                    <label class="block text-sm text-gray-700 font-bold" for="">School</label>
                    <input class="border rounded-[4px] p-3 hover:outline-none focus:outline-none focus:ring-0 focus:border-gray-500" :class="error.school ? 'border-red-500' : 'border-gray-500'" v-model="form.school" autocomplete="off"/>
                </div>
                <button type="submit" class="mt-5 w-full border p-2 bg-gray-800 text-white rounded-[4px] hover:bg-gray-700" @click="nextPage()">Next</button>
                <div class="flex justify-center mt-5 text-sm">
                    <p class="text-gray-500">Have an account?</p>
                </div>
                <button class="mt-5 w-full border p-2 bg-blue-500 text-white rounded-[4px] hover:bg-blue-400" @click="login()">Sign in</button>
            </div>
            <transition name="fade">
                <div class="flex-col border bg-white px-6 py-14 shadow-md rounded-[4px] min-w-[25%] space-y-4" v-if="showSelectLanguage">
                    <div class="flex flex-col text-sm rounded-md space-y-2">
                        <label class="block text-sm text-gray-700 font-bold" for="">Language</label>
                        <select class="mb-5 border rounded-[4px] p-3 hover:outline-none focus:outline-none focus:ring-0 focus:border-gray-500" v-model="form.language">
                            <option value="">Please select</option>
                            <option :value="language.id" v-for="language in $page.props.languages">{{ language.name }}</option>
                        </select>
                    </div>
                    <button type="button" class="mt-5 w-full border p-2 text-white rounded-[4px] bg-gray-700 hover:bg-gray-600" :class="canStartTest ? 'opacity-100' : 'cursor-not-allowed opacity-50'" @click="canStartTest ? startTest() : ''">Start Now</button>
                </div>
            </transition>
        </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';

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
                name: 'asd',
                age: this.$page.props.ages[0].id,
                school: 'asd',
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
        login(){
            this.$inertia.get(route('diagnostic_test'))
        },
        startTest(){
            this.$inertia.post(route('diagnostic_test.run'), {'form_data': this.form})
        },
        nextPage(){
            if(!this.form.name){
                this.error.name = this.form.name === ''
            }
            else{
                this.showMain = false
                this.showSelectLanguage = true
            }
        }
    }

}
</script>
