<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<style>
    .image {
        display: block;

        /* This rule is very important, please don't ignore this */
        max-width: 100%;
    }
    .preview {
        overflow: hidden;
        width: 240px;
        height: 240px;
    }
</style>

<template>
    <Head title="Profile"></Head>

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-indigo-100 space-y-6 sm:p-6 h-full">
                        <!-- <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5 border-b-indigo-500 border-b border-dashed">
                                        <h2 class="font-display font-bold text-indigo-600">Profile Picture</h2>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-0 gap-0">
                                        <div class="mb-5 flex items-center" v-show="show_profile_photo">
                                            <span class="inline-block h-20 w-20 rounded-full border overflow-hidden bg-gray-100">
                                                <img v-if="info || user_image" :src="user_image" alt="">
                                                <svg v-else class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                            </span>
                                            <label for="profile_photo" class=" ml-5 bg-white py-2 px-3 border border-gray-300 rounded shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">Change Photo <span class="text-red-500">*</span></label>
                                            <input type="file" id="profile_photo" ref="upload_photo" class="hidden" @change="selectImage">
                                            <div class="p-3">
                                                <span class="text-slate-600" v-if="image_file_name">{{ image_file_name }}</span>
                                            </div>
                                        </div>
                                        <div class="flex space-x-5">
                                            <div v-show="show_image">
                                                <label class="block text-sm text-gray-900 font-bold"> Crop Image</label>
                                                <div class="w-96 h-60 my-3">
                                                    <img class="image" ref="input" :src="selected_image">
                                                </div>
                                            </div>
                                            <div v-show="show_image">
                                                <div class="flex flex-row justify-end">
                                                    <div class="flex-column text-center">
                                                        <label class="block text-sm text-gray-900 font-bold"> Image Preview </label>
                                                        <div class="preview h-52 w-96 mt-3 rounded-full"></div>
                                                    </div>
                                                    <div class="flex-column pl-1 pt-6">
                                                        <div class="flex-row pb-1">
                                                            <BreezeButton type="button" class="py-1 px-2 bg-green-500 hover:bg-green-600 rounded text-white shadow" @click="select_cropped_image()" title="Select cropped image">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                                </svg>
                                                            </BreezeButton>
                                                        </div>
                                                        <div class="flex-row">
                                                            <BreezeButton type="button" class="py-1 px-2 bg-blue-500 hover:bg-blue-600 rounded text-white shadow" @click="reselect_image()" title="Reselect an image">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                                </svg>
                                                            </BreezeButton>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex mb-4" v-if="$page.props.errors.profile_photo">
                                            <span class="text-red-500 text-sm">Please upload an image</span>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div> -->
                        <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                <div class="mb-5 border-b border-dashed border-b-indigo-500">
                                    <h2 class="font-display font-bold text-indigo-600">Security</h2>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-4 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="current_password" class="block text-sm text-gray-700 font-bold"> Current Password <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="password" name="current_password" id="current_password" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.current_password ? 'border-red-300' : 'border-gray-300'" v-model="security_form.current_password" autocomplete="off"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-4 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="new_password" class="block text-sm text-gray-700 font-bold"> New password <span class="text-red-500">*</span> </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="password" name="new_password" id="new_password" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.new_password ? 'border-red-300' : 'border-gray-300'" v-model="security_form.new_password" autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="confirm_new_password" class="block text-sm text-gray-700 font-bold"> Confirm New password <span class="text-red-500">*</span> </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="password" name="confirm_new_password" id="confirm_new_password" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.confirm_new_password ? 'border-red-300' : 'border-gray-300'" v-model="security_form.confirm_new_password" autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="mb-4 self-end">
                                        <BreezeButton @click="savePassword" class="py-2.5 px-4">Update Password</BreezeButton>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5 border-b-indigo-500 border-b border-dashed">
                                        <h2 class="font-display font-bold text-indigo-600">Profile Information</h2>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                            <div class="mb-4">
                                                <label for="first_name" class="block text-sm text-gray-700 font-bold"> First Name <span class="text-red-500">*</span></label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <input type="text" name="first_name" id="first_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.first_name ? 'border-red-300' : 'border-gray-300'" v-model="form.first_name" autocomplete="off"/>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label for="last_name" class="block text-sm text-gray-700 font-bold"> Last Name <span class="text-red-500">*</span> </label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <input type="text" name="last_name" id="last_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.last_name ? 'border-red-300' : 'border-gray-300'" v-model="form.last_name" autocomplete="off"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                            <div class="mb-4">
                                                <label for="country" class="block text-sm text-gray-700 font-bold"> Country <span class="text-red-500">*</span> </label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <Multiselect 
                                                        autocomplete="off"
                                                        @change="clearState"
                                                        :placeholder="form.country"
                                                        :canDeselect="false"
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
                                                                $page.props.errors.country ? 
                                                                'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded bg-white text-base leading-snug outline-none':
                                                                'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none',
                                                            containerDisabled: 'cursor-default bg-gray-100',
                                                            containerOpen: 'rounded-b-none',
                                                            containerOpenTop: 'rounded-t-none',
                                                            containerActive: 'border border-indigo-300',
                                                            singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                            singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                            multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                            search: 'w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded pl-3.5',
                                                            tags: 'flex-grow flex-shrink flex flex-wrap items-center mt-1 pl-2',
                                                            tag: 'bg-green-500 text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap',
                                                            tagDisabled: 'pr-2 opacity-50',
                                                            tagRemove: 'flex items-center justify-center p-1 mx-0.5 rounded-sm hover:bg-black hover:bg-opacity-10 group',
                                                            tagRemoveIcon: 'bg-multiselect-remove bg-center bg-no-repeat opacity-30 inline-block w-3 h-3 group-hover:opacity-60',
                                                            tagsSearchWrapper: 'inline-block relative mx-1 mb-1 flex-grow flex-shrink h-full',
                                                            tagsSearch: 'absolute inset-0 border-0 outline-none focus:ring-0 appearance-none p-0 text-base font-sans box-border w-full',
                                                            tagsSearchCopy: 'invisible whitespace-pre-wrap inline-block h-px',
                                                            placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-black',
                                                            caret: 'bg-multiselect-caret bg-center bg-no-repeat w-2.5 h-4 py-px box-content mr-3.5 relative z-10 opacity-40 flex-shrink-0 flex-grow-0 transition-transform transform pointer-events-none',
                                                            caretOpen: 'rotate-180 pointer-events-auto',
                                                            clear: 'pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80',
                                                            clearIcon: 'bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                                                            spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0',
                                                            dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                                            dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                                            dropdownHidden: 'hidden',
                                                            options: 'flex flex-col p-0 m-0 list-none w-full',
                                                            optionsTop: 'flex-col-reverse',
                                                            group: 'p-0 m-0',
                                                            groupLabel: 'flex text-sm box-border items-center justify-start text-left py-1 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                                                            groupLabelPointable: 'cursor-pointer',
                                                            groupLabelPointed: 'bg-gray-300 text-gray-700',
                                                            groupLabelSelected: 'bg-green-600 text-white',
                                                            groupLabelDisabled: 'bg-gray-100 text-gray-300 cursor-not-allowed',
                                                            groupLabelSelectedPointed: 'bg-green-600 text-white opacity-90',
                                                            groupLabelSelectedDisabled: 'text-green-100 bg-green-600 bg-opacity-50 cursor-not-allowed',
                                                            groupOptions: 'p-0 m-0',
                                                            option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3',
                                                            optionPointed: 'text-gray-800 bg-gray-100',
                                                            optionSelected: 'text-white bg-indigo-500',
                                                            optionDisabled: 'text-gray-300 cursor-not-allowed',
                                                            optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                                            optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                                            noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                                            noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                                            fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                                                            spacer: 'h-9 py-px box-content',
                                                        }"
                                                    />
                                                    <input type="hidden" v-model="form.country">
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label for="contact_number" class="block text-sm text-gray-700 font-bold"> Contact Number <span class="text-red-500">*</span> </label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <input class="text-center inline-flex items-center px-2 rounded-l-md border border-r-0 border-gray-300 bg-gray-100 text-gray-500 text-sm" v-model="form.calling_code" size="5" disabled>
                                                    <input type="number" name="contact_number" id="contact_number" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-none rounded-r-md sm:text-sm" :class="$page.props.errors.contact_number ? 'border-red-300' : 'border-gray-300'" v-model="form.contact_number" autocomplete="off"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="address" class="block text-sm text-gray-700 font-bold"> Address <span class="text-red-500">*</span></label>
                                            <div class="mt-1">
                                                <textarea id="address" name="address" rows="3" class="capitalize shadow-sm focus:ring-0 focus:border-indigo-300 mt-1 block w-full sm:text-sm border rounded-md" :class="$page.props.errors.address ? 'border-red-300' : 'border-gray-300'" v-model="form.address" autocomplete="off"/>
                                            </div>  
                                        </div>
                                        <div class="mb-4">
                                            <label for="state" class="block text-sm text-gray-700 font-bold"> State <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <Multiselect
                                                autocomplete="off"
                                                @change="clearState"
                                                :min-chars="1"
                                                :delay="1"
                                                :searchable="true"
                                                v-model="form.country_state"
                                                :placeholder="form.country_state"
                                                :noOptionsText="'Please select a state'"
                                                :options="state_list"
                                                :canDeselect="false"
                                                :classes="{
                                                    container: 
                                                        $page.props.errors.country ? 
                                                        'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-red-300 rounded bg-white text-base leading-snug outline-none':
                                                        'relative mx-auto w-full flex items-center justify-end box-border cursor-pointer border border-gray-300 rounded bg-white text-base leading-snug outline-none',
                                                    containerDisabled: 'cursor-default bg-gray-100',
                                                    containerOpen: 'rounded-b-none',
                                                    containerOpenTop: 'rounded-t-none',
                                                    containerActive: 'border border-indigo-300',
                                                    singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                                    singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                                    multipleLabel: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
                                                    search: 'w-full absolute inset-0 outline-none focus:ring-0 appearance-none box-border border-0 text-base font-sans bg-white rounded pl-3.5',
                                                    tags: 'flex-grow flex-shrink flex flex-wrap items-center mt-1 pl-2',
                                                    tag: 'bg-green-500 text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap',
                                                    tagDisabled: 'pr-2 opacity-50',
                                                    tagRemove: 'flex items-center justify-center p-1 mx-0.5 rounded-sm hover:bg-black hover:bg-opacity-10 group',
                                                    tagRemoveIcon: 'bg-multiselect-remove bg-center bg-no-repeat opacity-30 inline-block w-3 h-3 group-hover:opacity-60',
                                                    tagsSearchWrapper: 'inline-block relative mx-1 mb-1 flex-grow flex-shrink h-full',
                                                    tagsSearch: 'absolute inset-0 border-0 outline-none focus:ring-0 appearance-none p-0 text-base font-sans box-border w-full',
                                                    tagsSearchCopy: 'invisible whitespace-pre-wrap inline-block h-px',
                                                    placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-black',
                                                    caret: 'bg-multiselect-caret bg-center bg-no-repeat w-2.5 h-4 py-px box-content mr-3.5 relative z-10 opacity-40 flex-shrink-0 flex-grow-0 transition-transform transform pointer-events-none',
                                                    caretOpen: 'rotate-180 pointer-events-auto',
                                                    clear: 'pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80',
                                                    clearIcon: 'bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                                                    spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0',
                                                    dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                                    dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                                    dropdownHidden: 'hidden',
                                                    options: 'flex flex-col p-0 m-0 list-none w-full',
                                                    optionsTop: 'flex-col-reverse',
                                                    group: 'p-0 m-0',
                                                    groupLabel: 'flex text-sm box-border items-center justify-start text-left py-1 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                                                    groupLabelPointable: 'cursor-pointer',
                                                    groupLabelPointed: 'bg-gray-300 text-gray-700',
                                                    groupLabelSelected: 'bg-green-600 text-white',
                                                    groupLabelDisabled: 'bg-gray-100 text-gray-300 cursor-not-allowed',
                                                    groupLabelSelectedPointed: 'bg-green-600 text-white opacity-90',
                                                    groupLabelSelectedDisabled: 'text-green-100 bg-green-600 bg-opacity-50 cursor-not-allowed',
                                                    groupOptions: 'p-0 m-0',
                                                    option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3',
                                                    optionPointed: 'text-gray-800 bg-gray-100',
                                                    optionSelected: 'text-white bg-indigo-500',
                                                    optionDisabled: 'text-gray-300 cursor-not-allowed',
                                                    optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                                    optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                                    noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                                    noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                                    fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                                                    spacer: 'h-9 py-px box-content',
                                                }"
                                            />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-end">
                                        <BreezeButton @click="saveProfile">Save Profile</BreezeButton>
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
import Multiselect from '@vueform/multiselect'

const URL = window.URL || window.webkitURL;
const REGEXP_MIME_TYPE_IMAGES = /^image\/\w+$/;

let cropper = null

const fetchCountries = async (query) => {

    if(query){
        const response = await fetch(
            'https://restcountries.com/v2/name/' + query
        );

        const data = await response.json(); 
        
        return data.map((item) => {
            return { 
                value: item.alpha2Code, 
                label: item.name 
            }
        })
    }
}

export default {
    components: {
        Head, Link, Multiselect
    },
    props: {
        info: Object
    },
    mounted(){
        const selected_image = this.$refs.input 
        cropper = new Cropper(selected_image, {
            aspectRatio: 1,
            cropBoxResizable: false,
            cropBoxMovable: true,
            viewMode: 1,
            dragMode: 'none',
            movable: true,
            rotatable: true,
            preview: '.preview',
            zoomable: false
        });
    },
    data() {
        return{
            data:  {
                type: Object,
                default: () => ({}),
            },
            state_list: [],
            show_profile_photo: true,
            show_image: false,
            selected_image: '',
            user_image: this.info ? '/storage/'+this.info.user_photo : '',
            image_file_name: '',
            form: {
                profile_photo: '',
                first_name: this.info ? this.info.user_first_name : '',
                last_name: this.info ? this.info.user_last_name : '',
                calling_code: this.info ? this.info.user_calling_code : '',
                contact_number: this.info ? this.info.user_contact : '',
                address: this.info ? this.info.user_address : '',
                country: this.info ? this.info.user_country : '',
                country_state: this.info ? this.info.user_state : '',
                country_code: this.info ? this.info.user_country_code : '',
            },
            security_form: {
                current_password: '',
                new_password: '',
                confirm_new_password: '',
            }
        }
    },
    watch: {
        selected_image: {
            handler(value){ 
                cropper.replace(value)
            },
            deep: true
        },
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
        saveProfile() {
            this.$inertia.post(route('profile.store'), this.form)
        },
        savePassword(){
            this.$inertia.post(route('profile.security.store'), this.security_form, {
                onSuccess: () => {
                    this.security_form.confirm_new_password = ''
                    this.security_form.current_password = ''
                    this.security_form.new_password = ''
                }
            })
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
            })
        },
        clearState(){
            this.form.country_state = '';
        },
        read(file, event) {
            return new Promise((resolve, reject) => {
                if (!file) {
                    resolve();
                    return;
                }
                if (REGEXP_MIME_TYPE_IMAGES.test(file.type)) {
                    if (URL) {
                        resolve({
                            loaded: true,
                            name: file.name,
                            type: file.type,
                            url: URL.createObjectURL(file),
                        });
                    } else {
                        reject(new Error('Your browser is not supported.'));
                    }
                } else {
                    reject(new Error(`Please select a valid image file.`));
                    // reject(new Error(`Please ${event ? event.type : 'choose'} an image file.`));
                }
            });
        },
        selectImage({ target }) {
            const { files } = target;
            if (files && files.length > 0) {
                this.read(files[0], target)
                .then((data) => {
                    this.image_file_name = data.name
                    this.selected_image    =   data.url
                    this.show_profile_photo = false
                    this.show_image = true
                    this.update(data)
                })
                .catch(this.alert);
            }
        },
        update(data) {
            Object.assign(this.data, data);
        },
        reselect_image(){
            this.show_profile_photo = true
            this.show_image = false
            this.$refs.upload_photo.value=null;
            this.image_file_name = ''
        },
        select_cropped_image(){
            cropper.getCroppedCanvas().toBlob((blob) => {
                var image_file = this.blobToFile(blob, this.data.name)
                this.form.profile_photo = image_file;
                this.user_image = URL.createObjectURL(blob)
            }, 'image/jpeg', 0.1 );
            this.show_profile_photo = true
            this.show_image = false
            this.$refs.upload_photo.value=null;
            this.image_file_name = ''
        },
        blobToFile(blob, fileName){
            blob.lastModifiedDate = new Date();
            blob.name = fileName;
            return blob;
        }   
    }
}
</script>
