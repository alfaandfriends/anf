<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Diagnostic Test" />
    <div class="flex flex-col h-screen">
        <div class="flex-grow flex flex-col items-center justify-center py-6 bg-indigo-50">
            <div class="mb-5">
                <img class="h-20 w-24" :src="'/images/anf-logo-main-2x.png'">
            </div>
            <div class="mb-8 mx-4 text-center flex justify-center">
                <h1 class="font-semibold text-2xl font-noto">Diagnostic Test</h1>
            </div>
            <Card class="w-full max-w-md" v-if="current_page == 1">
                <template #content>
                    <div class="grid grid-cols-1 gap-4">
                        <div class="">
                            <Label>Name</Label>
                            <Input :error="error.name" v-model="form.name" autocomplete="off"></Input>
                        </div>
                        <div class="">
                            <Label>Age</Label>
                            <ComboBox :items="$page.props.ages" label-property="name" value-property="id" v-model="form.age" :error="!!error.age" search-placeholder="Search age..."></ComboBox>
                        </div>
                        <div class="">
                            <Label>School</Label>
                            <Input :error="error.school" v-model="form.school" autocomplete="off"></Input>
                        </div>
                        <Button type="submit" @click="goToLanguage()">Next</Button>
                    </div>
                </template>
            </Card>
            <Card class="w-full max-w-md" v-if="current_page == 2">
                <template #content>
                    <div class="">
                        <Label>Language</Label>
                        <ComboBox :items="$page.props.languages" label-property="name" value-property="id" v-model="form.language" :error="!!error.age" search-placeholder="Search age..."></ComboBox>
                    </div>
                    <Button @click="canGoNext ? goToGuidelines() : ''" :class="!canGoNext ? 'bg-gray-300 hover:bg-gray-300 cursor-not-allowed' : ''">Next</Button>
                </template>
            </Card>
            <Card class="w-full max-w-2xl" v-if="current_page == 3">
                <template #content>
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
                    <Button @click="startTest()">Start Now</Button>
                </template>
            </Card>
            <!-- <div class="min-w-[90%] md:min-w-[50%] lg:min-w-[35%] xl:min-w-[30%] rounded bg-indigo-100 p-3 shadow-md shadow-gray-600 mx-4 max-w-2xl" v-if="current_page == 3">
                <div class="flex flex-col space-y-4">
                </div>
            </div> -->
        </div>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Card from '@/Components/Card.vue'

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
