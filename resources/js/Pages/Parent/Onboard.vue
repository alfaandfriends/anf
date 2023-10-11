<template>
    <Head title="Onboarding"></Head>

    <div class="min-h-screen flex flex-col items-center justify-center bg-indigo-100">
        <div class="flex flex-col bg-white shadow-md px-4 sm:px-6 md:px-6 py-8 rounded-md w-full max-w-xl">
            <div class="flex flex-col items-center" v-if="current_step == 1">
                <p class="text-sm md:text-base font-medium text-gray-600">Hello, {{ $page.props.auth.user.display_name }}!</p>
                <h1 class="text-md md:text-2xl font-medium text-indigo-600">Welcome to ALFA and Friends Centre</h1>
                <div class="mt-10 space-y-2 px-10 text-sm md:text-base">
                    <h1>
                        What is Lorem Ipsum?
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                    </h1>
                </div>

                <button @click="next" class="group mt-10 flex px-6 items-center space-x-2 justify-center rounded-lg bg-indigo-600 hover:bg-indigo-700 py-2 text-center font-bold text-white transition">
                    <span class="pb-0.5">Continue</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
            <div class="flex flex-col items-center" v-if="current_step == 2">
                <p class="text-sm md:text-base font-medium text-gray-600">Hello, {{ $page.props.auth.user.display_name }}!</p>
                <h1 class="text-md md:text-2xl font-medium text-indigo-600">Welcome to ALFA and Friends Centre</h1>

                <div class="mt-10 space-y-2 px-10 text-sm md:text-base">
                    <h1>
                        Why do we use it?
                        It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                    </h1>
                </div>
                <div class="flex justify-between space-x-4">
                    <button @click="previous" class="group mt-10 flex px-6 items-center space-x-2 justify-center rounded-lg bg-gray-500 py-2 text-center font-bold text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:-translate-x-1 rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                        <span class="pb-0.5">Previous</span>
                    </button>
                    <button @click="next" class="group mt-10 flex px-6 items-center space-x-2 justify-center rounded-lg bg-indigo-600 hover:bg-indigo-700 py-2 text-center font-bold text-white transition">
                        <span class="pb-0.5">Continue</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="" v-if="current_step == 3">
                <div class="flex flex-col items-center">
                    <p class="text-sm md:text-base font-medium text-gray-600">Hello, {{ $page.props.auth.user.display_name }}!</p>
                    <h1 class="text-md md:text-2xl font-medium text-indigo-600">Welcome to ALFA and Friends Centre</h1>
                </div>
                <div class="md:mt-16 my-5">
                    <p class="text-center text-lg font-medium capitalize">Update your profile</p>
                </div>
                <div class="flex flex-col px-2 sm:px-10">
                    <div class="mb-5">
                        <label for="user_name" class="font-semibold text-sm md:text-base">Full Name
                            <input type="text" id="user_name" class="mt-1 h-10 md:h-12 text-sm md:text-base focus:ring-0 focus:border-gray-300 flex-1 block w-full rounded-md" :class="errors.full_name ? 'border-red-300' : 'border-gray-300'" v-model="form.full_name" autocomplete="none"/>
                        </label>
                    </div>
                    <div class="mb-5">
                        <label for="country" class="font-semibold text-sm">Country
                            <Multiselect 
                                :id="'country'"
                                :autocomplete="'none'"
                                @change="clearState"
                                :canDeselect="false"
                                :loading="loading.country"
                                v-model="form.country_id"
                                trackBy="name"
                                label="name"
                                valueProp="id"
                                :options="$page.props.countries"
                                :classes="{
                                    container: 
                                        errors.country_code ? 
                                        'mt-1 relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded-md bg-white leading-snug outline-none h-10 md:h-12 text-sm md:text-base':
                                        'mt-1 relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white leading-snug outline-none h-10 md:h-12 text-sm md:text-base',
                                    containerDisabled: 'cursor-default bg-gray-100',
                                    containerOpen: 'rounded-b-none',
                                    containerOpenTop: 'rounded-t-none',
                                    containerActive: 'border border-gray-300',
                                    singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                    singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                    multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                    search: ' h-9 md:h-11 text-sm md:text-base w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 font-sans bg-white rounded-md pl-3.5',
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
                        </label>
                    </div>
                    <div class="mb-5">
                        <label for="country" class="font-semibold text-sm">State
                            <Multiselect
                                :id="'country'"
                                :autocomplete="'none'"
                                @change="clearState"
                                :min-chars="1"
                                :delay="1"
                                :loading="loading.state"
                                :searchable="true"
                                v-model="form.country_state"
                                :placeholder="form.country_state"
                                :noOptionsText="'Please select a state'"
                                :options="state_list"
                                :canDeselect="false"
                                :classes="{
                                    container: 
                                        errors.country_state ? 
                                        'mt-1 relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded-md bg-white leading-snug outline-none h-10 md:h-12 text-sm md:text-base':
                                        'mt-1 relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white leading-snug outline-none h-10 md:h-12 text-sm md:text-base',
                                    containerDisabled: 'cursor-default bg-gray-100',
                                    containerOpen: 'rounded-b-none',
                                    containerOpenTop: 'rounded-t-none',
                                    containerActive: 'border border-gray-300',
                                    singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                    singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                    multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                    search: 'h-9 md:h-11 text-sm md:text-base w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 font-sans bg-white rounded-md pl-3.5',
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
                        </label>
                    </div>
                    <div class="mb-5">
                        <label for="use_phone" class="font-semibold text-sm">Phone Number
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input class="h-10 md:h-12 text-sm md:text-base text-center inline-flex items-center px-2 rounded-l-md border border-r-0 border-gray-300 bg-gray-100 text-gray-500" v-model="form.calling_code" size="5" disabled>
                                <input type="number" name="use_phone" id="use_phone" class="h-10 md:h-12 text-sm md:text-base focus:ring-0 border-gray-300 focus:border-gray-300 flex-1 block w-full rounded-none rounded-r-md" :class="errors.contact_number ? 'border-red-300' : 'border-gray-300'" v-model="form.contact_number" autocomplete="none"/>
                            </div>
                        </label>
                    </div>
                    <div class="mb-5">
                        <label for="user_address" class="font-semibold text-sm">Address
                            <textarea id="user_address" rows="3" class="focus:ring-0 border-gray-300 focus:border-gray-300 flex-1 block w-full rounded-md mt-1" :class="errors.address ? 'border-red-300' : 'border-gray-300'" v-model="form.address"></textarea>
                        </label>
                    </div>

                    <button @click="saveProfile" class="block w-full rounded-lg bg-indigo-600 px-5 py-3 text-sm font-medium text-white">
                        Get Started
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Multiselect from '@vueform/multiselect'
import axios from 'axios'

export default {
    components:{
        Multiselect, Head
    },
    data(){
        return{
            search_query: false,
            state_list: [],
            current_step: 3,
            loading:{
                country: false,
                state: false
            },
            form: {
                full_name: this.$page.props.auth.user.display_name,
                calling_code: '',
                contact_number: '',
                address: '',
                country_id: '',
                country_name: '',
                country_state: '',
                country_code: '',
            },
            errors: {
                full_name: false,
                country_code: false,
                country_state: false,
                contact_number: false,
                address: false
            }
        }
    },
    watch: {
        'form.country_id': {
            handler(){
                if(this.form.country_id){
                    /* Set calling code and state list*/
                    this.setCountryData(this.form.country_id)

                }
            },
            immediate: true
        }
    },
    methods: {
        next(){
            this.current_step += 1
        },
        previous(){
            this.current_step -= 1
        },
        setCountryData(country_id){
            this.loading.state = true
            axios
                .get(route('countries.find', country_id))
                .then(response => {
                    this.setStateList(response.data.country_code)
                    this.form.calling_code  =   response.data.calling_code
                    this.form.country_name  =   response.data.name
                    this.form.country_code  =   response.data.country_code
                })
                .catch(error => {
                    this.errored = true
                })
        },
        setStateList(country_code){
            var state_list  =   this.state_list
            state_list.splice(0)
            axios({
                method: 'post',
                url: 'https://countriesnow.space/api/v0.1/countries/states',
                headers: {
                    "Content-Type": "application/json"
                }, 
                data: {
                        "iso2": country_code, 
                }
            }).then(response => {
                response.data.data.states.forEach(function(state) {
                    state_list.push(state.name)
                });
                this.loading.state = false
            })
        },
        clearState(){
            this.form.country_state = '';
        },
        saveProfile() {
            this.errors.full_name = this.form.full_name ? false : true
            this.errors.country_code = this.form.country_code ? false : true
            this.errors.country_state = this.form.country_state ? false : true
            this.errors.contact_number = this.form.contact_number ? false : true
            this.errors.address = this.form.address ? false : true

            if(this.form.full_name && this.form.country_code && this.form.country_state && this.form.contact_number && this.form.address){
                this.$inertia.post(route('profile.store'), this.form)
            }
        },
    }
}
</script>