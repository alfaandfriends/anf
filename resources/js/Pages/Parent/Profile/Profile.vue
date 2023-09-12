<template>
    <Head title="Home" />
    <Authenticated>
        <div class="overflow-y-auto">
            <!-- Mobile View -->
            <div class="">
                <div class="grid divide-y divide-neutral-200 max-w-xl md:hidden">
                    <details class="group" open>
                        <summary class="flex justify-between items-center font-medium cursor-pointer list-none bg-indigo-100 px-5 py-3">
                            <span class="text-sm md:text-base"> Profile</span>
                            <span class="transition rotate-0 group-open:rotate-180">
                                <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <div class="bg-white text-neutral-600 p-4">
                            <div class="grid divide-y divide-neutral-200 max-w-xl">
                                <div class="flex flex-col">
                                    <div class="flex items-center justify-center p-4">
                                        <div class="relative inline-block cursor-pointer">
                                            <img :src="form.profile_photo.value" alt="Avatar" class="rounded-full w-28 h-28"/>
                                            <div class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 bg-black bg-opacity-50 rounded-full transition-opacity">
                                                <input type="file" id="profilePhotoInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" @change="handleFileChange($event)"/>
                                                <span class="text-white text-xs font-semibold">Change Photo</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <label for="user_name" class="font-semibold text-sm text-gray-700">Full Name
                                            <input type="text" id="user_name" class="mt-1 h-10 text-sm focus:ring-0 focus:border-gray-300 flex-1 block w-full rounded-md" :class="errors.full_name ? 'border-red-300' : 'border-gray-300'" v-model="form.full_name" autocomplete="none"/>
                                        </label>
                                    </div>
                                    <div class="mb-5">
                                        <label for="country" class="font-semibold text-sm text-gray-700">Country
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
                                                :placeholder="form.country"
                                                :options="async function(query) {
                                                    return await fetchCountries(query) 
                                                }"
                                                :classes="{
                                                    container: 
                                                    errors.country_code ? 
                                                        'mt-1 relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded-md bg-white leading-snug outline-none h-10 text-sm':
                                                        'mt-1 relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white leading-snug outline-none h-10 text-sm',
                                                    containerDisabled: 'cursor-default bg-gray-100',
                                                    containerOpen: 'rounded-b-none',
                                                    containerOpenTop: 'rounded-t-none',
                                                    containerActive: 'border border-gray-300',
                                                    singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border ',
                                                    singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                    multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                    search: ' h-9 text-sm w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 font-sans bg-white rounded-md pl-3.5',
                                                    placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-700',
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
                                        <label for="country" class="font-semibold text-sm text-gray-700">State
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
                                                        'mt-1 relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded-md bg-white leading-snug outline-none h-10 text-sm':
                                                        'mt-1 relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white leading-snug outline-none h-10 text-sm',
                                                    containerDisabled: 'cursor-default bg-gray-100',
                                                    containerOpen: 'rounded-b-none',
                                                    containerOpenTop: 'rounded-t-none',
                                                    containerActive: 'border border-gray-300',
                                                    singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                    singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                    multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                    search: 'h-9 text-sm w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 font-sans bg-white rounded-md pl-3.5',
                                                    placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-700',
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
                                        <label for="use_phone" class="font-semibold text-sm text-gray-700">Phone Number
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input class="h-10 text-sm text-center inline-flex items-center px-2 rounded-l-md border border-r-0 border-gray-300 bg-gray-100 text-gray-500" v-model="form.calling_code" size="5" disabled>
                                                <input type="number" name="use_phone" id="use_phone" class="h-10 text-sm focus:ring-0 border-gray-300 focus:border-gray-300 flex-1 block w-full rounded-none rounded-r-md" :class="errors.contact_number ? 'border-red-300' : 'border-gray-300'" v-model="form.contact_number" autocomplete="none"/>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="mb-5">
                                        <label for="user_address" class="font-semibold text-sm text-gray-700">Address
                                            <textarea id="user_address" rows="3" class="text-sm focus:ring-0 border-gray-300 focus:border-gray-300 flex-1 block w-full rounded-md mt-1" :class="errors.address ? 'border-red-300' : 'border-gray-300'" v-model="form.address"></textarea>
                                        </label>
                                    </div>
                
                                    <button @click="saveProfile" class="block w-full rounded-lg bg-indigo-600 px-5 py-3 text-sm font-medium text-white">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </details>
                    <a :href="route('parent.profile.security')" class="flex justify-between items-center font-medium cursor-pointer list-none bg-indigo-100 px-5 py-3">
                        <span class="text-sm md:text-base"> Security</span>
                        <span class="transition rotate-0 group-open:rotate-180">
                            <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                        </span>
                    </a>
                </div>  
            </div>

            <!-- Desktop View -->
            <div class="hidden md:grid grid-cols-6 gap-2">
                <div class="col-span-2">
                    <ProfileNavigation></ProfileNavigation>
                </div>
                <div class="col-span-4">
                    <div class="bg-white p-6 border border-gray-300 shadow rounded-lg">
                        <p class="tracking-normal antialiased mb-4 block text-xs font-semibold uppercase text-gray-500 font-[Roboto]">Profile Photo</p>
                        <div class="flex items-center justify-start">
                            <div class="relative inline-block cursor-pointer">
                                <img :src="form.profile_photo.value" alt="Avatar" class="rounded-full w-28 h-28"/>
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 bg-black bg-opacity-50 rounded-full transition-opacity">
                                    <input type="file" id="profilePhotoInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" @change="handleFileChange($event)"/>
                                    <span class="text-white text-xs font-semibold">Change Photo</span>
                                </div>
                            </div>
                        </div>
                        <hr class="my-5">
                        <p class="tracking-normal antialiased mb-4 block text-xs font-semibold uppercase text-gray-500 font-[Roboto]">Personal Details</p>
                        <div class="grid divide-y divide-neutral-200 max-w-xl">
                            <div class="flex flex-col">
                                <div class="mb-5">
                                    <label for="user_name" class="font-semibold text-sm text-gray-700">Full Name
                                        <input type="text" id="user_name" class="mt-1 h-10 text-sm focus:ring-0 focus:border-gray-300 flex-1 block w-full rounded-md" :class="errors.full_name ? 'border-red-300' : 'border-gray-300'" v-model="form.full_name" autocomplete="none"/>
                                    </label>
                                </div>
                                <div class="mb-5">
                                    <label for="country" class="font-semibold text-sm text-gray-700">Country
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
                                            :placeholder="form.country"
                                            :options="async function(query) {
                                                return await fetchCountries(query) 
                                            }"
                                            :classes="{
                                                container: 
                                                errors.country_code ? 
                                                    'mt-1 relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded-md bg-white leading-snug outline-none h-10 text-sm':
                                                    'mt-1 relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white leading-snug outline-none h-10 text-sm',
                                                containerDisabled: 'cursor-default bg-gray-100',
                                                containerOpen: 'rounded-b-none',
                                                containerOpenTop: 'rounded-t-none',
                                                containerActive: 'border border-gray-300',
                                                singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border ',
                                                singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                search: ' h-9 text-sm w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 font-sans bg-white rounded-md pl-3.5',
                                                placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-700',
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
                                    <label for="country" class="font-semibold text-sm text-gray-700">State
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
                                                    'mt-1 relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded-md bg-white leading-snug outline-none h-10 text-sm':
                                                    'mt-1 relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded-md bg-white leading-snug outline-none h-10 text-sm',
                                                containerDisabled: 'cursor-default bg-gray-100',
                                                containerOpen: 'rounded-b-none',
                                                containerOpenTop: 'rounded-t-none',
                                                containerActive: 'border border-gray-300',
                                                singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                search: 'h-9 text-sm w-full inset-0 outline-none focus:ring-0 appearance-none box-border border-0 font-sans bg-white rounded-md pl-3.5',
                                                placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-700',
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
                                    <label for="use_phone" class="font-semibold text-sm text-gray-700">Phone Number
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input class="h-10 text-sm text-center inline-flex items-center px-2 rounded-l-md border border-r-0 border-gray-300 bg-gray-100 text-gray-500" v-model="form.calling_code" size="5" disabled>
                                            <input type="number" name="use_phone" id="use_phone" class="h-10 text-sm focus:ring-0 border-gray-300 focus:border-gray-300 flex-1 block w-full rounded-none rounded-r-md" :class="errors.contact_number ? 'border-red-300' : 'border-gray-300'" v-model="form.contact_number" autocomplete="none"/>
                                        </div>
                                    </label>
                                </div>
                                <div class="mb-5">
                                    <label for="user_address" class="font-semibold text-sm text-gray-700">Address
                                        <textarea id="user_address" rows="3" class="text-sm focus:ring-0 border-gray-300 focus:border-gray-300 flex-1 block w-full rounded-md mt-1" :class="errors.address ? 'border-red-300' : 'border-gray-300'" v-model="form.address"></textarea>
                                    </label>
                                </div>
            
                                <button @click="saveProfile" class="block w-full rounded-lg bg-indigo-600 px-5 py-3 text-sm font-medium text-white">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
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
import ProfileNavigation from '@/Pages/Parent/Profile/Navigation.vue';
import Multiselect from '@vueform/multiselect'
import axios from 'axios'
import Compressor from 'compressorjs';

function blobToFile(blob, filename) {
  const file = new File([blob], filename, { type: blob.type });
  return file;
}

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
                profile_photo:{
                    file: '',
                    value: this.$page.props.auth.profile_photo != '' ? '/storage/'+this.$page.props.auth.profile_photo : 'http://www.gravatar.com/avatar/?d=mp'
                },
                full_name: this.$page.props.auth.user.display_name ? this.$page.props.auth.user.display_name : '',
                country_code: this.$page.props.auth.user.user_country_code ? this.$page.props.auth.user.user_country_code : '',
                country: this.$page.props.auth.user.user_country ? this.$page.props.auth.user.user_country : '',
                calling_code: this.$page.props.auth.user.user_calling_code ? this.$page.props.auth.user.user_calling_code : '',
                country_state: this.$page.props.auth.user.user_state ? this.$page.props.auth.user.user_state : '',
                contact_number: this.$page.props.auth.user.user_contact ? this.$page.props.auth.user.user_contact : '',
                address: this.$page.props.auth.user.user_address ? this.$page.props.auth.user.user_address : ''
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
            this.errors.full_name = this.form.full_name ? false : true
            this.errors.country_code = this.form.country_code ? false : true
            this.errors.country_state = this.form.country_state ? false : true
            this.errors.contact_number = this.form.contact_number ? false : true
            this.errors.address = this.form.address ? false : true

            if(this.form.full_name && this.form.country_code && this.form.country_state && this.form.contact_number && this.form.address){
                this.$inertia.post(route('profile.store'), this.form)
            }
        },
        handleFileChange(event){
            const file = event.target.files[0]
            const profile_photo_data = this.form.profile_photo
            if (file) {
                this.compress(file, profile_photo_data)
            }
        },
        compress(file, profile_photo_data){
            new Compressor(file, {
                quality: 0.2,
                maxWidth: 400,
                maxHeight: 400,
                success(result) {
                    const blobUrl = URL.createObjectURL(result);
                    const new_file   =   blobToFile(result, Date.now()+'.jpg')
                    profile_photo_data.value = blobUrl
                    profile_photo_data.file = new_file
                },
            });
        },
    }
}
</script>