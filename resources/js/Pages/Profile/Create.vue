<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
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
        <Card footerClass="border-t px-6 py-4 justify-end">
            <template #title>
                <h3 class="text-base">Profile Information</h3>
            </template>
            <template #content>
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 sm:grid-cols-0 gap-0">
                        <div class="mb-5 flex items-center" v-show="show_profile_photo">
                            <span class="inline-block h-20 w-20 rounded-full border overflow-hidden bg-gray-100">
                                <img class="h-full w-full" v-if="$page.props.auth.user.user_photo != '' || data.url" :src="user_image" alt="">
                                <svg v-else class="h-full w-full text-gray-300 border-2 border-gray-300 rounded-full" fill="currentColor" viewBox="0 0 24 24">
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
                                            <Button type="button" class="py-1 px-2" @click="select_cropped_image()" title="Select cropped image">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </Button>
                                        </div>
                                        <div class="flex-row">
                                            <Button type="button" buttonType="gray" class="py-1 px-2" @click="reselect_image()" title="Reselect an image">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                            </Button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex mb-4" v-if="$page.props.errors.profile_photo">
                            <span class="text-red-500 text-sm">Please upload an image</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 2xl:grid-cols-4 gap-4">
                        <div class="">
                            <Label>Full Name<span class="text-red-500">*</span></Label>
                            <Input type="text" :error="$page.props.errors.full_name" v-model="form.full_name"></Input>
                        </div>
                        <div class="">
                            <Label>Country<span class="text-red-500">*</span></Label>
                            <ComboBox :items="$page.props.countries" label-property="name" value-property="id" v-model="form.country_id" select-placeholder="Select Country" search-placeholder="Search country..."></ComboBox>
                        </div>
                        <div class="">
                            <Label>State<span class="text-red-500">*</span></Label>
                            <ComboBox :items="state_list" v-model="form.country_state" select-placeholder="Select Country" search-placeholder="Search state..." :loading="loading.state"></ComboBox>
                        </div>
                        <div class="">
                            <Label>Address<span class="text-red-500">*</span></Label>
                            <Input type="text" :error="$page.props.errors.address" v-model="form.address"></Input>
                        </div>
                    </div>
                </form>
            </template>
            <template #footer>
                <Button @click="saveProfile" variant="">Save Profile</Button>
            </template>
        </Card>
        <Card>
            <template #title>
                <h3 class="text-base">Security</h3>
            </template>
            <template #content>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-0 sm:gap-4">
                    <div class="mb-4">
                        <Label>Current Password<span class="text-red-500">*</span></Label>
                        <Input type="password" :error="$page.props.errors.current_password" v-model="security_form.current_password"></Input>
                    </div>
                    <div class="mb-4">
                        <Label>New password<span class="text-red-500">*</span></Label>
                        <Input type="password" :error="$page.props.errors.new_password" v-model="security_form.new_password"></Input>
                    </div>
                    <div class="mb-4">
                        <Label>Confirm New password<span class="text-red-500">*</span></Label>
                        <Input type="password" :error="$page.props.errors.confirm_new_password" v-model="security_form.confirm_new_password"></Input>
                    </div>
                    <div class="mb-4 self-end">
                        <Button @click="savePassword" class="py-2.5 px-4">Update Password</Button>
                    </div>
                </div>
            </template>
        </Card>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue'
import Multiselect from '@vueform/multiselect'
import Cropper from 'cropperjs';
import { CaretSortIcon, CheckIcon } from '@radix-icons/vue'
import { cn } from '@/lib/utils'
import ComboBox from '@/Components/ComboBox.vue'
import Card from '@/Components/Card.vue'

const URL = window.URL || window.webkitURL;
const REGEXP_MIME_TYPE_IMAGES = /^image\/\w+$/;

let cropper = null

export default {
    components: {
        ComboBox
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
            loading:{
                country: false,
                state: false
            },
            is_open: {
                countries: false
            },
            state_list: [],
            show_profile_photo: true,
            show_image: false,
            selected_image: '',
            user_image: this.$page.props.user_info ? '/storage/'+this.$page.props.user_info.user_photo : '',
            image_file_name: '',    
            form: {
                profile_photo: {
                    name: '',
                    file: ''
                },
                full_name: this.$page.props.user_info ? this.$page.props.user_info.display_name : '',
                calling_code: this.$page.props.user_info ? this.$page.props.user_info.user_calling_code : '',
                contact_number: this.$page.props.user_info ? this.$page.props.user_info.user_contact : '',
                address: this.$page.props.user_info ? this.$page.props.user_info.user_address : '',
                country_id: this.$page.props.user_info ? this.$page.props.user_info.user_country_id : '',
                country_name: this.$page.props.user_info ? this.$page.props.user_info.user_country : '',
                country_state: this.$page.props.user_info ? this.$page.props.user_info.user_state : '',
                country_code: this.$page.props.user_info ? this.$page.props.user_info.user_country_code : '',
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
        setCountryData(country_id){
            this.loading.state = true
            this.state_list = []
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
                    this.image_file_name    = data.name
                    this.selected_image     =   data.url
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
                this.user_image = URL.createObjectURL(blob)
                var image_file = this.blobToFile(blob, this.data.name)
                this.form.profile_photo.file = image_file;
                this.form.profile_photo.name = this.data.name;
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

