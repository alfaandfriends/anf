<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Users" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-indigo-50 space-y-6 sm:p-6">
                        <div class="grid grid-rows-1 grid-cols-1 gap-4">
                            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                <div class="mb-5">
                                    <h1 class="text-indigo-800 font-bold">User Information</h1>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="grid grid-cols-2 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <div class="flex justify-between">
                                            <label for="email" class="block text-sm text-gray-700 font-bold"> Email <span class="text-red-500">*</span> </label>
                                            <label for="" class="font-medium text-sm text-indigo-600" v-if="form.email != $page.props.user_info.user_email && checking_email"> Checking Email...</label>
                                            <label for="" class="font-medium text-sm text-red-600" v-if="form.email != $page.props.user_info.user_email && form.email != '' & !email_valid"> Invalid Email </label>
                                            <label for="" class="font-medium text-sm" v-if="form.email != $page.props.user_info.user_email && !checking_email && form.email !='' & email_valid" :class="email_exist ? 'text-red-700' : 'text-green-700'"> {{ email_exist ? 'Email address has been used.' : 'Email address is available.'}} </label>
                                        </div>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="email" name="username" id="username" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md" :class="email_exist || $page.props.errors.email ? 'border-red-300' : 'border-gray-300'" v-debounce:1s="checkEmailExist" @keyup="checkEmail()" v-model="form.email" autocomplete="none"/>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="flex justify-between">
                                            <label for="username" class="block text-sm text-gray-700 font-bold"> Username <span class="text-red-500">*</span> </label>
                                            <label for="" class="font-medium text-sm text-indigo-600" v-if="form.username != $page.props.user_info.user_login && checking_username"> Checking Username...</label>
                                            <label for="" class="font-medium text-sm" v-if="form.username != $page.props.user_info.user_login && !checking_username && form.username !=''" :class="username_exist ? 'text-red-700' : 'text-green-700'"> {{ username_exist ? 'Username has been taken.' : 'Username is available.'}} </label>
                                        </div>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="username" id="username" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md" :class="username_exist || $page.props.errors.email ? 'border-red-300' : 'border-gray-300'" v-debounce:1s="checkUsernameExist" @keyup="checkUsername()"  v-model="form.username" autocomplete="none"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="full_name" class="block text-sm text-gray-700 font-bold"> Full Name <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="full_name" id="full_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md" :class="$page.props.errors.full_name ? 'border-red-300' : 'border-gray-300'" v-model="form.full_name" autocomplete="none"/>
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
                                                :placeholder="$page.props.user_info.name"
                                                :canDeselect="false"
                                                v-model="form.country_id"
                                                :loading="loading.country"
                                                :min-chars="1"
                                                :delay="1"
                                                :searchable="true"
                                                :noOptionsText="'Please enter at least 1 character'"
                                                :options="$page.props.countries"
                                                trackBy="name"
                                                label="name"
                                                valueProp="id"
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
                                                    placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3',
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
                                            <input class="text-center inline-flex items-center px-2 rounded-l-md border border-r-0 border-gray-300 bg-gray-100 text-gray-500" v-model="form.calling_code" size="5" disabled>
                                            <input type="number" name="contact_number" id="contact_number" class="py-1.5 focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-none rounded-r-md" :class="$page.props.errors.contact_number ? 'border-red-300' : 'border-gray-300'" v-model="form.contact_number" autocomplete="none"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="state" class="block text-sm text-gray-700 font-bold"> State <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <Multiselect
                                                autocomplete="off"
                                                :min-chars="1"
                                                :delay="1"
                                                :searchable="true"
                                                :loading="loading.state"
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
                                                placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5',
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
                                <div class="grid grid-cols-1 gap-4">
                                    <div class="mb-4">
                                        <label for="address" class="block text-sm text-gray-700 font-bold"> Address <span class="text-red-500">*</span></label>
                                        <div class="mt-1">
                                            <textarea id="address" name="address" rows="3" class="shadow-sm focus:ring-0 focus:border-indigo-300 mt-1 block w-full border rounded-md" :class="$page.props.errors.address ? 'border-red-300' : 'border-gray-300'" v-model="form.address" autocomplete="none"/>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md" v-if="$page.props.can.manage_roles">
                                <div class="mb-5">
                                    <h1 class="text-indigo-800 font-bold">User Roles</h1>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <div class="flex py-1" v-if="$page.props.errors.selected_roles">
                                            <span class="text-sm text-red-500">{{ $page.props.errors.selected_roles }}</span>
                                        </div>
                                        <div class="block">
                                            <div class="mt-2">
                                                <div class="mb-2" v-for="role in $page.props.roles" :key="role.id">
                                                    <label class="inline-flex items-center text-gray-800 select-none text-md cursor-pointer" :for="role.id">
                                                        <input type="checkbox" class="h-5 w-5 border border-gray-300 rounded-sm bg-white focus:ring-offset-0 focus:ring-0 checked:bg-gray focus:bg-white transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left cursor-pointer"
                                                                :id="role.id" 
                                                                :value="role.id"
                                                                :checked="selected_roles.includes(role.id)"
                                                                @click="selectRole($event, role.id)"
                                                        >
                                                        <span class="ml-2">{{ role.display_name }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                <div class="mb-5">
                                    <h1 class="text-indigo-800 font-bold">Children Information</h1>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-4 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="child_name" class="block text-sm text-gray-700 font-bold"> Name <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="child_name" id="child_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.name ? 'border-red-300' : 'border-gray-300'" v-model="child_form.name" autocomplete="none"/>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="gender" class="block text-sm font-bold text-gray-700"> Gender <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <select name="gender" id="gender" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.gender ? 'border-red-300' : 'border-gray-300'" v-model="child_form.gender" autocomplete="none">
                                                <option value="">-- Select Gender --</option>
                                                <option :value="gender.id" v-for="(gender, index) in $page.props.gender_list" :key="index">{{ gender.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="end_time" class="block text-sm font-bold text-gray-700"> Date of Birth <span class="text-red-500">*</span></label>
                                        <Datepicker :class="'mt-1 rounded-md shadow-sm'" :style="$page.props.errors.dob ? '--dp-border-color: #fa9e9e' : ''" v-model="child_form.dob" :enableTimePicker="false" :noToday="true" :autoApply="true" :format="'dd/MM/yyyy'"/>
                                    </div>
                                    <div class="mb-4 self-end">
                                        <BreezeButton class="py-2.5 px-4" @click="addChild">Add Child</BreezeButton>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-0 sm:gap-4">
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-300">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Date of Birth</th>
                                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr v-if="!form.children.length">
                                                    <td class="text-center" colspan="10">
                                                        <div class="p-3">
                                                            No Record Found! 
                                                        </div>
                                                    </td>
                                                </tr> 
                                                <tr class="hover:bg-gray-200" v-for="children, index in form.children">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                        {{ children.name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                        {{ $page.props.gender_list.find((item) => item.id == children.gender_id).name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                                        {{ moment(children.date_of_birth).format('DD/MM/Y') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                        <div class="flex justify-center space-x-2">
                                                            <BreezeButton buttonType="warning" @click="!processing ? editChild(children.id) : ''">Edit</BreezeButton>
                                                            <BreezeButton buttonType="danger" @click="!processing ? deleteChild(children.id) : ''">Delete</BreezeButton>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="flex flex-row-reverse items-center justify-between">
                                        <div class="flex space-x-2">
                                            <BreezeButton :buttonType="'gray'" :route="route('users')">Cancel</BreezeButton>
                                            <BreezeButton type="submit">Save</BreezeButton>
                                        </div>
                                        <div class="flex">
                                            <BreezeButton :class="'px-4 py-2 bg-red-600 hover:bg-red-700 drop-shadow-sm'" @click="resetPassword($page.props.user_info.user_id)">Reset Password</BreezeButton>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <ConfirmationModal 
            :show="isOpen" 
            @close="isOpen = false"
            :confirmationAlert="confirmationAlert"
            :confirmationTitle="confirmationTitle"
            :confirmationText="confirmationText"
            :confirmationButton="confirmationButton"
            :confirmationMethod="confirmationMethod"
            :confirmationRoute="confirmationRoute"
            :confirmationData="confirmationData"
        >
        </ConfirmationModal>
        
        <vue-final-modal v-model="showEdit" :lock-scroll="true" :click-to-close="false">
            <div id="default-modal" data-modal-show="true" aria-hidden="true" class="overflow-x-hidden overflow-y-auto h-modal md:h-full top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center">
                <div class="absolute top-[10%] inset-x-[20%]">
                    <div class="bg-white rounded-lg shadow relative">
                        <div class="flex items-center justify-between py-3 px-6 border-b rounded-t">
                            <span class="text-lg font-semibold text-gray-700">Edit Child Details</span>
                            <button @click="showEdit = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                            </button>
                        </div>
                        <div class="p-6 space-y-2 overflow-y-auto" style="max-height: calc(100vh - 350px)">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-0 sm:gap-4">
                                <div class="mb-4">
                                    <label for="first_name" class="block text-sm text-gray-700 font-bold"> Name <span class="text-red-500">*</span></label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" name="first_name" id="first_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.edit_name ? 'border-red-300' : 'border-gray-300'" v-model="editForm.edit_name" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="gender" class="block text-sm font-bold text-gray-700"> Gender <span class="text-red-500">*</span></label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <select name="gender" id="gender" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.edit_gender ? 'border-red-300' : 'border-gray-300'" v-model="editForm.edit_gender" autocomplete="off">
                                            <option value="">-- Select Gender --</option>
                                            <option :value="gender.id" v-for="(gender, index) in $page.props.gender_list" :key="index">{{ gender.name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="end_time" class="block text-sm font-bold text-gray-700"> Date of Birth <span class="text-red-500">*</span></label>
                                    <Datepicker :class="'mt-1 rounded-md shadow-sm'" :style="$page.props.errors.edit_dob? '--dp-border-color: #fa9e9e' : ''" v-model="editForm.edit_dob" :enableTimePicker="false" :noToday="true" :autoApply="true" format="dd/mm/yyyy"/>
                                </div>
                            </div>
                            <hr class="pb-2">
                            <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                <div class="flex justify-end space-x-2">
                                    <BreezeButton buttonType="gray" @click="showEdit = false">Cancel</BreezeButton>
                                    <BreezeButton @click="updateChild">Save</BreezeButton>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </vue-final-modal>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { SearchIcon, TrashIcon, PencilIcon } from '@heroicons/vue/solid'
import { Head, Link } from '@inertiajs/inertia-vue3';
import Multiselect from '@vueform/multiselect'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import Datepicker from '@vuepic/vue-datepicker';
import moment from 'moment'
import { debounce } from 'vue-debounce'
import { $vfm, VueFinalModal, ModalsContainer } from 'vue-final-modal'

export default {
    components: {
        SearchIcon, TrashIcon, PencilIcon,
        Head, Link, Multiselect, ConfirmationModal, VueFinalModal
    },
    created(){
        var selected_roles      = this.selected_roles
        Object.keys(this.$page.props.user_roles).forEach(function(role_id){
            selected_roles.push(parseInt(role_id))
        })
    },
    data(){
        return{
            processing: false,
            showEdit: false,
            isOpen: false,
            confirmationAlert: '',
            confirmationTitle: '',
            confirmationText: '',
            confirmationButton: '',
            confirmationMethod: '',
            confirmationRoute: '',
            confirmationData: '',
            email_exist: false,
            email_valid: false,
            checking_email: false,
            username_exist: false,
            checking_username: false,
            selected_roles: [],
            state_list: [],
            form: {
                email: this.$page.props.user_info ? this.$page.props.user_info.user_email : '',
                username: this.$page.props.user_info ? this.$page.props.user_info.user_login : '',
                full_name: this.$page.props.user_info ? this.$page.props.user_info.display_name : '',
                calling_code: this.$page.props.user_info ? this.$page.props.user_info.calling_code : '',
                contact_number: this.$page.props.user_info ? this.$page.props.user_info.user_contact : '',
                address: this.$page.props.user_info ? this.$page.props.user_info.user_address : '',
                country_id: this.$page.props.user_info ? this.$page.props.user_info.user_country_id : '',
                country_state: this.$page.props.user_info ? this.$page.props.user_info.user_state : '',
                country_code: this.$page.props.user_info ? this.$page.props.user_info.country_code : '',
                children: this.$page.props.children ? this.$page.props.children : [],
                valid: {
                    email: true,
                    username: true,
                }
            },
            child_form: {
                parent_id: '',
                name: '',
                gender: '',
                dob: ''
            },
            editForm:{
                edit_child_id: '',
                edit_name: '',
                edit_gender: '',
                edit_dob: '',
            },
            loading:{
                country: false,
                state: false
            },
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
        submit(){
            this.$inertia.post(this.route('users.update'), {'user_id': this.$page.props.user_info.user_id, 'selected_roles': this.selected_roles, 'form': this.form});
        },
        checkEmail(){
            if(this.form.email){
                this.isValidEmail()
                if(this.email_valid){
                    this.checking_email = true
                }
                else{
                    this.checking_email = false
                }
            }
        },
        checkUsername(){
            if(this.form.username){
                this.checking_username = true
            }
            else{
                this.checking_username = false
            }
        },
        isValidEmail() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            this.email_valid = emailRegex.test(this.form.email);
            this.form.valid.email = emailRegex.test(this.form.email);
        },
        checkEmailExist(){
            axios.get('/api/find-email/' + this.form.email)
                .then(response => {
                    if(response.data.length != 0 && this.form.email != this.$page.props.user_info.user_email){
                        this.email_exist = true
                        this.form.valid.email = false
                    }
                    else{
                        this.email_exist = false
                        this.form.valid.email = true
                    }
                    this.checking_email = false
                })
        },
        checkUsernameExist(){
            axios.get('/api/find-username/' + this.form.username)
                .then(response => {
                    if(response.data.length != 0 && this.form.username != this.$page.props.user_info.user_login){
                        this.username_exist = true
                        this.form.valid.username = false
                    }
                    else{
                        this.username_exist = false
                        this.form.valid.username = true
                    }
                    this.checking_username = false
                })
        },
        resetPassword(userID){
            this.confirmationAlert  = 'danger',
            this.confirmationTitle  = 'Warning',
            this.confirmationText   = "This user's password will be reset and new password will be sent to their email, are you sure want to proceed?",
            this.confirmationButton = 'Reset Password',
            this.confirmationMethod = 'post',
            this.confirmationRoute  = 'users.reset_user_password'
            this.confirmationData =  userID
            this.isOpen = true
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
        selectRole(event, role_id){
            if(event.target.checked){
                this.selected_roles.push(role_id)
            }
            else{
                this.selected_roles = this.selected_roles.filter(item => item !== role_id)
            }
        },
        addChild() {
            this.child_form.parent_id = this.$page.props.user_info.user_id
            this.$inertia.post(route('children.store'), this.child_form, {
                preserveScroll: true,
                preserveState: false
            })
        },
        updateChild() {
            this.$inertia.post(route('children.update'), this.editForm, {
                preserveScroll: true,
                preserveState: false,
                onSuccess: page => {
                    this.showEdit   =   false
                }
            })
        },
        deleteChild(child_id){
            this.confirmationAlert  = 'danger',
            this.confirmationTitle  = 'Warning',
            this.confirmationText   = "This child will be deleted permanently, are you sure want to proceed?",
            this.confirmationButton = 'Delete',
            this.confirmationMethod = 'delete',
            this.confirmationRoute = 'children.destroy'
            this.confirmationData =  child_id
            this.isOpen = true
        },
        editChild(child_id){
            this.processing = true
            axios.get(route('children.edit'), {
                params: {
                    'child_id': child_id
                }
            })
            .then((res) => {
                this.editForm.edit_child_id =   child_id
                this.editForm.edit_name     =   res.data.name
                this.editForm.edit_gender   =   res.data.gender_id
                this.editForm.edit_dob      =   res.data.date_of_birth
                this.showEdit               =   true
                this.processing = false
            });
        },
    }
}
</script>
