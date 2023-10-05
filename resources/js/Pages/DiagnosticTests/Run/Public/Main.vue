<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<style>
/* Add extra margin-bottom to p elements following a <br> tag */
.content p + br + p {
  margin-top: 1em; /* Adjust the value to control the spacing */
}

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
    <div class="flex flex-col h-screen">
        <div class="flex-grow flex flex-col items-center justify-center py-6 bg-indigo-500">
            <div class="mb-5">
                <img class="h-20 w-24" :src="'/images/anf-logo-main-2x.png'">
            </div>
            <div class="mb-8 mx-4 text-center flex justify-center">
                <h1 class="font-semibold font-mono tracking-wider text-lg text-white">ALFA and Friends Diagnostic Test</h1>
            </div>
            <div class="min-w-[90%] md:min-w-[50%] lg:min-w-[35%] xl:min-w-[30%] rounded bg-indigo-100 px-6 py-10 shadow-md shadow-gray-600" v-if="current_page == 1">
                <div class="flex flex-col space-y-4">
                    <div class="flex flex-col text-sm rounded-md space-y-2">
                        <label class="block text-sm text-gray-700 font-bold" for="">Name</label>
                        <input class="w-full mb-5 rounded-[4px] border p-3 hover:outline-none focus:outline-none focus:ring-0 focus:border-gray-500" :class="error.name ? 'border-red-500' : 'border-gray-500'" v-model="form.name" autocomplete="off"/>
                    </div>
                    <div class="flex flex-col text-sm rounded-md space-y-2">
                        <label class="block text-sm text-gray-700 font-bold" for="">Age</label>
                        <select class="w-full mb-5 border rounded-[4px] p-3 hover:outline-none focus:outline-none focus:ring-0 focus:border-gray-500" :class="error.age ? 'border-red-500' : 'border-gray-500'" v-model="form.age" autocomplete="off">
                            <option :value="age.id" v-for="age in $page.props.ages">{{ age.name }}</option>
                        </select>
                    </div>
                    <div class="flex flex-col text-sm rounded-md space-y-2">    
                        <label class="block text-sm text-gray-700 font-bold" for="">School</label>
                        <input class="w-full border rounded-[4px] p-3 hover:outline-none focus:outline-none focus:ring-0 focus:border-gray-500" :class="error.school ? 'border-red-500' : 'border-gray-500'" v-model="form.school" autocomplete="off"/>
                    </div>
                    <button type="submit" class="mt-5 w-full border p-2 bg-gray-800 text-white rounded-[4px] hover:bg-gray-700" @click="goToLanguage()">Next</button>
                </div>
            </div>
            <div class="min-w-[90%] md:min-w-[50%] lg:min-w-[35%] xl:min-w-[30%] rounded bg-indigo-100 px-6 py-10 shadow-md shadow-gray-600" v-if="current_page == 2">
                <div class="flex flex-col space-y-4">
                    <div class="flex flex-col text-sm rounded-md space-y-2">
                        <label class="block text-sm text-gray-700 font-bold" for="">Language</label>
                        <select class="mb-5 border rounded-[4px] p-3 hover:outline-none focus:outline-none focus:ring-0 focus:border-gray-500" v-model="form.language">
                            <option value="">Please select</option>
                            <option :value="language.id" v-for="language in $page.props.languages">{{ language.name }}</option>
                        </select>
                    </div>
                    <button type="button" class="mt-5 w-full border p-2 text-white rounded-[4px] bg-gray-700 hover:bg-gray-600" :class="canGoNext ? 'opacity-100' : 'cursor-not-allowed opacity-50'" @click="canGoNext ? goToGuidelines() : ''">Next</button>
                </div>
            </div>
            <div class="min-w-[90%] md:min-w-[50%] lg:min-w-[35%] xl:min-w-[30%] rounded bg-indigo-100 p-3 shadow-md shadow-gray-600 mx-4 max-w-2xl" v-if="current_page == 3">
                <div class="flex flex-col space-y-4">
                    <div class="px-4 py-6 border-2 border-dashed border-indigo-400 rounded-l">
                        <div class="flex items-start">
                            <div class="flex-grow truncate">
                                <div class="sm:flex justify-center items-center mb-3">
                                    <h2 class="text-2xl text-center leading-snug font-bold text-gray-800 truncate mb-1 sm:mb-0 uppercase">{{ $page.props.languages.find(item => item.id == form.language)?.guideline_header }}</h2>
                                </div>
                                <div class="flex items-end justify-between whitespace-normal">
                                    <div class="text-gray-900">
                                        <ul class="list-disc mb-2 whitespace-pre-wrap list-inside list-circle">
                                            <li class="my-5" v-for="(line, index) in $page.props.languages.find(item => item.id == form.language)?.guideline_body.split('\n')" v-html="line"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="mt-5 border p-2 bg-gray-800 text-white rounded-[4px] hover:bg-gray-700" @click="canGoNext ? startTest() : ''">Start Now</button>
                </div>
            </div>
        </div>
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
            current_page: 1,
            canGoNext: false,
            dt_list: [],
            form:{
                name: '',
                age: this.$page.props.ages ? this.$page.props.ages[0].id : '',
                school: '',
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
                if(this.form.language == ''){
                    this.canGoNext = false
                }
                else{
                    this.canGoNext = true
                }
            },
            deep: true
        }
    },
    methods: {
        login(){
            this.$inertia.get(route('diagnostic_test'))
        },
        startTest(){
            this.$inertia.post(route('diagnostic_test.run'), {'form_data': this.form})
        },
        goToLanguage(){
            if(!this.form.name){
                this.error.name = this.form.name === ''
                return
            }
            this.current_page += 1
        },
        goToGuidelines(){
            this.current_page += 1
        }
    }

}
</script>
