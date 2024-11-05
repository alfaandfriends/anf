<template>
    <Head title="Home" />
    <Authenticated>
        <div class="flex justify-center">
            <div class="flex-1 max-w-4xl">
                <!-- Mobile View -->
                <div class="">
                    <div class="grid divide-y divide-neutral-200 max-w-xl md:hidden">
                        <details class="group" open>
                            <summary class="flex justify-between items-center font-semibold cursor-pointer list-none bg-indigo-100 px-5 py-3">
                                <span class="text-sm md:text-base"> Profile</span>
                                <span class="transition rotate-0 group-open:rotate-180">
                                    <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                                </span>
                            </summary>
                            <div class="bg-white text-neutral-600 p-4">
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <Label for="user_name">Full Name</Label>
                                        <Input type="text" id="user_name" :error="errors.full_name" v-model="form.full_name" autocomplete="none"></Input>
                                    </div>
                                    <div>
                                        <Label>Country</Label>
                                        <ComboBox
                                            :items="$page.props.countries"
                                            label-property="name"
                                            value-property="id"
                                            v-model="form.country_id"
                                            :select-placeholder="form.country_name ?? 'Select Country'"
                                            search-placeholder="Search state..."
                                            :loading="loading.state"
                                            @select="clearState"
                                        ></ComboBox>
                                    </div>
                                    <div>
                                        <Label>State</Label>
                                        <ComboBox
                                            :items="state_list"
                                            label-property="name"
                                            value-property="id"
                                            v-model="form.country_state"
                                            :select-placeholder="form.country_state ?? 'Select State'"
                                            search-placeholder="Search state..."
                                            :loading="loading.state"
                                        ></ComboBox>
                                    </div>
                                    <div>
                                        <Label for="use_phone">Phone Number</Label>
                                        <Input :inputGroup="form.calling_code" type="number" name="use_phone" id="use_phone" :error="errors.contact_number" v-model="form.contact_number" autocomplete="none"></Input>
                                    </div>
                                    <div>
                                        <Label for="user_address">Address</Label>
                                        <Textarea id="user_address" rows="3" class="text-sm focus:ring-0 border-gray-300 focus:border-gray-300 flex-1 block w-full rounded-md mt-1" :class="errors.address ? 'border-red-300' : 'border-gray-300'" v-model="form.address"></Textarea>
                                    </div>
                                    <Button @click="saveProfile">Save</Button>
                                </div>
                            </div>
                        </details>
                        <Link :href="route('parent.profile.security')" class="flex justify-between items-center font-semibold cursor-pointer list-none bg-indigo-100 px-5 py-3">
                            <span class="text-sm md:text-base"> Security</span>
                            <span class="transition rotate-0 group-open:rotate-180">
                                <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </Link>
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
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <Label for="user_name">Full Name</Label>
                                    <Input type="text" id="user_name" :error="errors.full_name" v-model="form.full_name" autocomplete="none"></Input>
                                </div>
                                <div>
                                    <Label>Country</Label>
                                    <ComboBox
                                        :items="$page.props.countries"
                                        label-property="name"
                                        value-property="id"
                                        v-model="form.country_id"
                                        :select-placeholder="form.country_name ?? 'Select Country'"
                                        search-placeholder="Search state..."
                                        :loading="loading.state"
                                        @select="clearState"
                                    ></ComboBox>
                                </div>
                                <div>
                                    <Label>State</Label>
                                    <ComboBox
                                        :items="state_list"
                                        label-property="name"
                                        value-property="id"
                                        v-model="form.country_state"
                                        :select-placeholder="form.country_state ?? 'Select State'"
                                        search-placeholder="Search state..."
                                        :loading="loading.state"
                                    ></ComboBox>
                                </div>
                                <div>
                                    <Label for="use_phone">Phone Number</Label>
                                    <Input :inputGroup="form.calling_code" type="number" name="use_phone" id="use_phone" :error="errors.contact_number" v-model="form.contact_number" autocomplete="none"></Input>
                                </div>
                                <div>
                                    <Label for="user_address">Address</Label>
                                    <Textarea id="user_address" rows="3" class="text-sm focus:ring-0 border-gray-300 focus:border-gray-300 flex-1 block w-full rounded-md mt-1" :class="errors.address ? 'border-red-300' : 'border-gray-300'" v-model="form.address"></Textarea>
                                </div>
                                <Button @click="saveProfile">Save</Button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Authenticated>
</template>


<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
</script>

<script>
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
                    value: this.$page.props.auth.profile_photo != '' ? '/storage/'+this.$page.props.auth.profile_photo : 'https://img.icons8.com/office/16/person-male-skin-type-4.png'
                },
                full_name: this.$page.props.user_info ? this.$page.props.user_info.display_name : '',
                calling_code: this.$page.props.user_info ? this.$page.props.user_info.user_calling_code : '',
                contact_number: this.$page.props.user_info ? this.$page.props.user_info.user_contact : '',
                address: this.$page.props.user_info ? this.$page.props.user_info.user_address : '',
                country_id: this.$page.props.user_info ? this.$page.props.user_info.user_country_id : '',
                country_name: this.$page.props.user_info ? this.$page.props.user_info.name : '',
                country_state: this.$page.props.user_info ? this.$page.props.user_info.user_state : '',
                country_code: this.$page.props.user_info ? this.$page.props.user_info.user_country_code : '',
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
                    this.setCountryData(this.form.country_id)

                }
            },
            immediate: true
        }
    },
    methods: {
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