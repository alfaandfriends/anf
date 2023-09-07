<template>
    <Head title="Home" />
    <Authenticated>
        <div class="overflow-y-auto">
            <div class="flex flex-col bg-white rounded-md shadow shadow-gray-300 border py-5">
                <div class="flex justify-center">
                    <div class="bg-white shadow-lg rounded-2xl w-80 dark:bg-gray-800">
                        <div class="w-full mb-4 rounded-t-lg h-28 bg-indigo-100"/>
                        <div class="flex flex-col items-center justify-center p-4 -mt-16">
                            <a href="#" class="relative block">
                                <img alt="profil" src="https://picsum.photos/200" class="mx-auto object-cover rounded-full h-16 w-16  border-2 border-white dark:border-gray-800"/>
                            </a>
                            <p class="mt-2 text-xl font-medium text-gray-800 dark:text-white">
                                {{ $page.props.auth.user.display_name }}
                            </p>
                            <div class="w-full p-2 mt-4 rounded-lg">
                                <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-200">
                                    <p class="flex flex-col">
                                        Articles
                                        <span class="font-bold text-black dark:text-white">
                                            34
                                        </span>
                                    </p>
                                    <p class="flex flex-col">
                                        Followers
                                        <span class="font-bold text-black dark:text-white">
                                            455
                                        </span>
                                    </p>
                                    <p class="flex flex-col">
                                        Rating
                                        <span class="font-bold text-black dark:text-white">
                                            9.3
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="grid divide-y divide-neutral-200 max-w-xl mt-8 px-4 md:hidden">
                    <details class="group">
                        <summary class="flex justify-between items-center font-medium cursor-pointer list-none bg-indigo-100 px-5 py-3">
                            <span> Profile</span>
                            <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <div class="text-neutral-600 py-4 px-2">
                            <div class="grid gap-4">
                                <label for="Fullname" class="relative block rounded-md border focus:ring-0 border-gray-300 focus:border-gray-300">
                                    <input type="text" id="Fullname" class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0 text-slate-900 w-full" placeholder="Full Name" v-model="form.full_name"/>
                                    <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">
                                        Full Name
                                    </span>
                                </label>
                                
                        <label for="country" class="font-semibold text-sm">Country
                            <Multiselect 
                                :id="'country'"
                                :autocomplete="'none'"
                                @change="clearState"
                                :canDeselect="false"
                                :loading="loading.country"
                                v-model="form.country_code"
                                :min-chars="1"
                                :delay="1"
                                :searchable="true"
                                :noOptionsText="'Please enter at least 1 character'"
                                :options="async function(query) {
                                    return await fetchCountries(query) 
                                }"
                                :classes="{
                                    container: 
                                        $page.props.errors.country_code ? 
                                        'mt-1 relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white leading-snug outline-none h-12':
                                        'mt-1 relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white leading-snug outline-none h-12',
                                    containerDisabled: 'cursor-default bg-gray-100',
                                    containerOpen: 'rounded-b-none',
                                    containerOpenTop: 'rounded-t-none',
                                    containerActive: 'border border-gray-300',
                                    singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                    singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                    multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                    search: 'h-10 w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 font-sans bg-white rounded-md pl-3.5',
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
                                <label for="Fullname" class="relative block rounded-md border focus:ring-0 border-gray-300 focus:border-gray-300">
                                    <input type="text" id="Fullname" class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0 text-slate-900 w-full" placeholder="Full Name" v-model="form.full_name"/>
                                    <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">
                                        Full Name
                                    </span>
                                </label>
                                <label for="Address" class="relative block rounded-md border focus:ring-0 border-gray-300 focus:border-gray-300">
                                    <textarea type="text" id="Address" class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0 text-slate-900 w-full" placeholder="Full Name" v-model="form.full_name"></textarea>
                                    <span class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">
                                        Address
                                    </span>
                                </label>
                            </div>
                        </div>
                    </details>
                    <details class="group">
                        <summary class="flex justify-between items-center font-medium cursor-pointer list-none bg-indigo-100 px-5 py-3">
                            <span> Security</span>
                            <span class="transition group-open:rotate-180">
                        <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path>
        </svg>
                    </span>
                        </summary>
                        <p class="text-neutral-600 mt-3 group-open:animate-fadeIn">
                            We offers a variety of billing options, including monthly and annual subscription plans,
                            as well as pay-as-you-go pricing for certain services. Payment is typically made through a credit
                            card or other secure online payment method.
                        </p>
                    </details>
                </div>
                <div class="hidden md:flex">
                    <ul class="flex flex-col space-y-2">
                      <li>
                        <strong class="block text-xs font-medium uppercase text-gray-400">
                          General
                        </strong>
                  
                        <ul class="mt-2 space-y-1">
                          <li>
                            <a
                              href=""
                              class="block rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700"
                            >
                              Profile
                            </a>
                          </li>
                  
                          <li>
                            <a
                              href=""
                              class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                            >
                              Team
                            </a>
                          </li>
                  
                          <li>
                            <a
                              href=""
                              class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                            >
                              Projects
                            </a>
                          </li>
                  
                          <li>
                            <a
                              href=""
                              class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                            >
                              Meetings
                            </a>
                          </li>
                  
                          <li>
                            <a
                              href=""
                              class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                            >
                              Calendar
                            </a>
                          </li>
                        </ul>
                      </li>
                  
                      <li>
                        <strong class="block text-xs font-medium uppercase text-gray-400">
                          Support
                        </strong>
                  
                        <ul class="mt-2 space-y-1">
                          <li>
                            <a
                              href=""
                              class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                            >
                              Update
                            </a>
                          </li>
                  
                          <li>
                            <a
                              href=""
                              class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                            >
                              Help
                            </a>
                          </li>
                  
                          <li>
                            <a
                              href=""
                              class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                            >
                              Settings
                            </a>
                          </li>
                        </ul>
                      </li>
                  
                      <li>
                        <strong class="block text-xs font-medium uppercase text-gray-400">
                          Profile
                        </strong>
                  
                        <ul class="mt-2 space-y-1">
                          <li>
                            <a
                              href=""
                              class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                            >
                              Details
                            </a>
                          </li>
                  
                          <li>
                            <a
                              href=""
                              class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                            >
                              Subscription
                            </a>
                          </li>
                  
                          <li>
                            <form action="/logout">
                              <button
                                type="submit"
                                class="block w-full rounded-lg px-4 py-2 text-sm font-medium text-gray-500 [text-align:_inherit] hover:bg-gray-100 hover:text-gray-700"
                              >
                                Logout
                              </button>
                            </form>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </div>
            </div>
        </div>
    </Authenticated>
</template>
<style src="@vueform/multiselect/themes/default.css"></style>

<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
</script>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Multiselect from '@vueform/multiselect'
import axios from 'axios'

export default {
    data(){
        return{
            search_query: '',
            state_list: [],
            current_step: 1,
            loading:{
                country: false,
                state: false
            },
            form: {
                full_name: this.$page.props.auth.user.display_name,
                country_code: '',
                country: '',
                calling_code: '',
                country_state: '',
                contact_number: '',
                address: ''
            }
        }
    },
    watch: {
        'form.country_code': {
            handler(country_code){
                if(country_code){
                    /* Set calling code and state list*/
                    this.setCallingCode(country_code)
                    this.setStateList(country_code)

                }
            },
            immediate: true
        }
    },
    methods: {
        async fetchCountries(query){
            if(query){
                this.loading.country = true
                const response = await fetch(
                    'https://restcountries.com/v2/name/' + query
                );

                if (response.status === 200) {
                    const data = await response.json(); 
                    this.loading.country = false
                    return data.map((item) => {
                        return { 
                            value: item.alpha2Code, 
                            label: item.name 
                        }
                    })
                } else {
                    throw new Error('Failed to fetch data');
                }
            }
        },
        setCallingCode(country_code){
            axios
                .get('https://restcountries.com/v3.1/alpha/' + country_code)
                .then(response => {
                    this.form.country       =   response.data[0].name.official
                    this.form.calling_code  =   response.data[0].idd.root + response.data[0].idd.suffixes[0]
                })
                .catch(error => {
                    this.errored = true
                })
        },
        setStateList(country_code){
            this.loading.state = true
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
            this.$inertia.post(route('profile.store'), this.form)
        },
    }
}
</script>