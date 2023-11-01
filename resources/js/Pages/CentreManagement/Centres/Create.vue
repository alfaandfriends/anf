<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
    import BreezeButton from '@/Components/Button.vue';
</script>
<style>
    .image {
        display: block;

        /* This rule is very important, please don't ignore this */
        max-width: 100%;
        max-height: 20px;
    }
    .preview {
        overflow: hidden;
        width: 240px;
        height: 240px;
    }
</style>
<template>
    <Head title="Centres" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 space-y-6 sm:p-6">
                        <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="text-indigo-800 font-bold">Centre Information</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="mb-4">
                                            <label for="centre_name" class="block text-sm text-gray-700 font-bold"> Centre Name <span class="text-red-500">*</span> </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="centre_name" id="centre_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.centre_name ? 'border-red-300' : 'border-gray-300'" v-model="form.centre_name" autocomplete="none"/>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="centre_country" class="block text-sm text-gray-700 font-bold"> Centre Country <span class="text-red-500">*</span> </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select type="text" name="centre_country" id="centre_country" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.centre_country ? 'border-red-300' : 'border-gray-300'" v-model="form.centre_country" autocomplete="none">
                                                    <option value="">Select a country</option>
                                                    <option :value="country.id" v-for="country in $page.props.countries">{{ country.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <label for="centre_contact" class="block text-sm text-gray-700 font-bold"> Centre Contact Number <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="centre_contact" id="centre_contact" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.centre_contact_number ? 'border-red-300' : 'border-gray-300'" v-model="form.centre_contact_number" autocomplete="none"/>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="centre_email" class="block text-sm text-gray-700 font-bold"> Centre Email </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="email" name="centre_email" id="centre_email" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.centre_email ? 'border-red-300' : 'border-gray-300'" v-model="form.centre_email" autocomplete="none"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div class="mb-4">
                                            <label for="centre_address" class="block text-sm text-gray-700 font-bold"> Centre Address <span class="text-red-500">*</span></label>
                                            <div class="mt-1">
                                                <textarea id="centre_address" name="centre_address" rows="3" class="shadow-sm focus:ring-0 focus:border-indigo-300 mt-1 block w-full sm:text-sm border rounded-md" :class="$page.props.errors.centre_address ? 'border-red-300' : 'border-gray-300'" v-model="form.centre_address" autocomplete="none"/>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="grid grid-rows-1 grid-cols-1 sm:grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="text-indigo-800 font-bold">Principal's Information</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-0 sm:gap-4">
                                        <div class="mb-4">
                                            <div class="flex justify-between">
                                                <label for="about" class="block text-sm text-gray-700 font-bold"> Email <span class="text-red-500">*</span></label>
                                                <label for="" class="font-medium text-sm text-indigo-600" v-if="search.email && checking_email"> Checking Email...</label>
                                                <label for="about" class="font-medium text-sm" v-if="search.email && !checking_email" :class="email_exist ? 'text-green-700' : 'text-red-700'"> {{ email_exist ? 'Email found!' : 'Email not found!'}} </label>
                                            </div>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="email" 
                                                    v-debounce:1s="findUser" 
                                                    @keyup="checkEmail" 
                                                    class="focus:ring-0 focus:border-gray-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300" 
                                                    :class="[($page.props.errors.principal_user_email ? 'border-red-300' : 'border-gray-300'), ((search.email && !email_exist && !checking_email) ? 'border-red-300' : 'border-gray-300'), ((search.email && email_exist) ? 'border-green-400' : 'border-gray-300')]" 
                                                    v-model="search.email" autocomplete="none"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="mb-4">
                                            <label for="full_name" class="block text-sm text-gray-700 font-bold"> Full Name <span class="text-red-500">*</span> </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="full_name" id="full_name" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 bg-gray-100" disabled :value="email_exist != null ? email_exist.display_name : ''" autocomplete="none"/>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="principal_contact" class="block text-sm text-gray-700 font-bold"> Contact Number <span class="text-red-500">*</span></label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" name="principal_contact" id="principal_contact" class="focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300 bg-gray-100" disabled :value="email_exist != null ? email_exist.user_contact : ''" autocomplete="none"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="grid grid-rows-2 grid-cols-1 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                                    <div class="mb-5">
                                        <h1 class="text-indigo-800 font-bold">Centre View</h1>
                                        <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                                        <div class="mb-4" v-show="show_front_upload">
                                            <label class="block text-sm text-gray-700 font-bold"> Centre Front View <span class="text-red-500">*</span> (1 Image)</label>
                                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                                                @change="change_front"
                                                @dragover="dragover_front"
                                                @drop="drop_front"
                                            >
                                                <div class="space-y-1 text-center">
                                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    <div class="flex text-sm text-gray-600">
                                                        <label class="browse text-indigo-400 hover:text-indigo-800 cursor-pointer font-bold">Click here
                                                            <input ref="front_image" id="file" class="sr-only" type="file" accept="image/*">
                                                        </label>
                                                        <p class="pl-1">or drag and drop an image</p>
                                                    </div>
                                                    <p class="text-xs text-gray-500">Image Format : PNG, JPG</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-4" v-show="show_inside_upload">
                                            <label class="block text-sm text-gray-700 font-bold"> Centre Inside View <span class="text-red-500">*</span> (Max: 5 Images)</label>
                                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                                                @change="change_inside"
                                                @dragover="dragover_inside"
                                                @drop="drop_inside"
                                            >
                                                <div class="space-y-1 text-center">
                                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    <div class="flex text-sm text-gray-600">
                                                        <label class="browse text-indigo-400 hover:text-indigo-800 cursor-pointer font-bold">Click here
                                                            <input ref="inside_image" id="file" class="sr-only" type="file" accept="image/*">
                                                        </label>
                                                        <p class="pl-1">or drag and drop an image</p>
                                                    </div>
                                                    <p class="text-xs text-gray-500">Image Format : PNG, JPG</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-4" v-show="show_image">
                                            <label class="block text-sm text-gray-900 font-bold"> Crop Image</label>
                                            <div class="w-96 h-60 mt-1">
                                                <img class="image" ref="input" :src="image">
                                            </div>
                                        </div>
                                        <div class="mb-4" v-show="show_image">
                                            <div class="flex flex-row justify-end">
                                                <div class="flex-column text-center">
                                                    <label class="block text-sm text-gray-900 font-bold"> Image Preview </label>
                                                    <div class="preview h-52 w-96 mt-1"></div>
                                                </div>
                                                <div class="flex-column pl-1 pt-6">
                                                    <div class="flex flex-col space-y-1">
                                                        <BreezeButton class="py-1 px-2 bg-green-500 hover:bg-green-600 rounded text-white shadow" @click="select_cropped_image()" title="Select cropped image">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                        </BreezeButton>
                                                        <BreezeButton class="py-1 px-2 bg-blue-500 hover:bg-blue-600 rounded text-white shadow" @click="reselect_image()" title="Reselect an image">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                            </svg>
                                                        </BreezeButton>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sm:col-span-2 self-center flex flex-wrap gap-4 py-3" v-show="form.image_list.length">
                                            <div class="relative h-32 w-32 rounded mr-3 mt-3 text-center" v-for="(image_data, index) in form.image_list" :key="index">
                                                <div class="absolute bg-red-500 p-2 rounded-full text-white z-10 cursor-pointer hover:bg-red-700" style="top: -8px; right: -8px" @click="delete_cropped_image(index)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </div>
                                                <img :src="image_data.image_src" class="rounded-lg" alt="">
                                                <label for="" class="text-sm capitalize text-slate-500">{{ image_data.type }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                            <div class="flex items-center justify-between">
                                <div class="flex space-x-2">
                                    <label for="" class="block text-sm text-gray-700">Active</label>
                                    <Toggle v-model="form.centre_active" 
                                        :classes="{
                                            container: 'inline-block',
                                            toggle: 'flex w-12 h-5 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
                                            toggleOn: 'bg-green-500 border-green-500 justify-start text-white',
                                            toggleOff: 'bg-gray-400 border-gray-400 justify-end text-gray-700',
                                        }
                                    "/>
                                </div>
                                <div class="flex space-x-2">
                                    <BreezeButton buttonType="gray" :route="route('centres')">Cancel</BreezeButton>
                                    <BreezeButton type="submit">Add Centre</BreezeButton>
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
import Toggle from '@vueform/toggle';
import Cropper from 'cropperjs';    
import { debounce } from 'vue-debounce'

const URL = window.URL || window.webkitURL;
const REGEXP_MIME_TYPE_IMAGES = /^image\/\w+$/;

let cropper = null

export default {
    components: {
        Link, Toggle, Cropper
    },
    data() {
        return {
            data:  {
                type: Object,
                default: () => ({}),
            },
            checking_email: false,
            show_front_upload: true,
            show_inside_upload: true,
            show_image: false,
            image: '',
            email_exist: '',
            form: {
                centre_name: '',
                centre_country: '',
                centre_contact_number: '',
                centre_email: '',
                centre_address: '',
                centre_active: true,
                principal_user_id: '',
                image_list: [],
            },
            search: {
                email: ''
            }
        }
    },
    mounted(){
        const temp_image = this.$refs.input
        if(temp_image){
            cropper = new Cropper(temp_image, {
                aspectRatio: 1,
                cropBoxResizable: false,
                cropBoxMovable: false,
                viewMode: 1,
                dragMode: 'move',
                movable: true,
                rotatable: true,
                preview: '.preview',
                minCropBoxWidth: 500,
                minCropBoxHeight: 500,
                modal: true,
                background: false
            });
        }
    },
    watch: {
        image: {
            handler(value){ 
                if(value){
                    cropper.replace(value)
                }
            },
            deep: true
        }
    },
    methods: {
        submit() {
            const loading = this.$loading.show();
            this.$inertia.post(route('centres.store'), this.form, { 
                preserveState: true,
                onFinish: visit => {
                    loading.hide();
                },
            })
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
        change_front({ target }) {
            const { files } = target;
            if (files && files.length > 0) {
                this.read(files[0], target)
                .then((data) => {
                    this.image    =   data.url
                    this.show_front_upload = false;
                    this.show_inside_upload = false;
                    this.show_image = true;
                    this.update(data, 'front');
                })
                .catch(this.alert);
            }
        },
        dragover_front(e) {
            e.preventDefault();
        },
        drop_front(e) {
            const { files } = e.dataTransfer;
            e.preventDefault();
            if (files && files.length > 0) {
                this.read(files[0], e)
                .then((data) => {
                    this.front_image    =   data.url
                    this.show_front_upload = false;
                    this.show_inside_upload = false;
                    this.update(data);
                })
                .catch(this.alert);
            }
        },
        change_inside({ target }) {
            const { files } = target;
            if (files && files.length > 0) {
                this.read(files[0], target)
                .then((data) => {
                    this.image    =   data.url
                    this.show_front_upload = false;
                    this.show_inside_upload = false;
                    this.show_image = true;
                    this.update(data, 'inside');
                })
                .catch(this.alert);
            }
        },
        dragover_inside(e) {
            e.preventDefault();
        },
        drop_inside(e) {
            const { files } = e.dataTransfer;
            e.preventDefault();
            if (files && files.length > 0) {
                this.read(files[0], e)
                .then((data) => {
                    this.front_image    =   data.url
                    this.show_front_upload = false;
                    this.show_inside_upload = false;
                    this.update(data);
                })
                .catch(this.alert);
            }
        },
        alert(e) {
            window.alert(e && e.message ? e.message : e);
        },
        update(data, view_type) {
            Object.assign(this.data, data);
            Object.assign(this.data, {'view_type': view_type});
        },
        reselect_image(){
            this.show_front_upload = true
            this.show_inside_upload = true
            this.show_image = false
            this.$refs.front_image.value=null;
            this.$refs.inside_image.value=null;
        },
        select_cropped_image(){
            const max_front_image = this.form.image_list.filter((value) => {
                if (value.type == 'front') return true;
            });
            const max_inside_image = this.form.image_list.filter((value) => {
                if (value.type == 'inside') return true;
            });

            if(this.data.view_type == 'front'){
                if(max_front_image.length < 1){
                    cropper.getCroppedCanvas().toBlob((blob) => {
                        var link = URL.createObjectURL(blob);   
                        var image_file = this.blobToFile(blob, this.data.name)
                        this.form.image_list.unshift({'image_src': link, 'image_file': image_file, 'type': this.data.view_type})
                    }, 'image/jpeg', 0.1 );
                    this.show_front_upload = true
                    this.show_inside_upload = true
                    this.show_image = false
                    this.$refs.front_image.value=null;
                }
                else{
                    alert('Only 1 front view image is allowed!')
                    this.show_front_upload = true
                    this.show_inside_upload = true
                    this.show_image = false
                    this.$refs.front_image.value=null;
                }
            }
            else if(this.data.view_type == 'inside'){
                if(max_inside_image.length < 5){
                    cropper.getCroppedCanvas().toBlob((blob) => {
                        var link = URL.createObjectURL(blob);
                        this.form.image_list.push({'name': this.data.name, 'image_src': link, 'image_file': blob, 'type': this.data.view_type})
                    }, 'image/jpeg', 0.1 );
                    this.show_front_upload = true
                    this.show_inside_upload = true
                    this.show_image = false
                    this.$refs.inside_image.value=null;
                }
                else{
                    alert('Only 5 inside view image is allowed!')
                    this.show_front_upload = true
                    this.show_inside_upload = true
                    this.show_image = false
                    this.$refs.inside_image.value=null;
                }
            }
        },
        delete_cropped_image(index){
            this.form.image_list.splice(index, 1)
        },
        blobToFile(blob, fileName){
            blob.lastModifiedDate = new Date();
            blob.name = fileName;
            return blob;
        },
        findUser(){
            axios.get(route('centres.find_user'), {
                params: {
                    'principal_email': this.search.email
                }
            })
            .then((res) => {
                this.email_exist = res.data
                this.form.principal_user_id = res.data.ID
                this.checking_email = false
            });
        },
        checkEmail(){
            this.checking_email = true
            this.email_exist = ''
            this.form.principal_user_id = ''
        }
    },
}
</script>
