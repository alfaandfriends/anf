<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
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
        <Card>
            <template #title>Centre Information</template>
            <template #content>
                <div class="grid grid-cols-1 2xl:grid-cols-2 gap-2">
                    <div class="mb-4">
                        <Label>Name<span class="text-red-500">*</span></Label>
                        <Input type="text" :error="$page.props.errors.name" v-model="form.name"></Input>
                    </div>
                    <div class="mb-4">
                        <Label>Country<span class="text-red-500">*</span></Label>
                        <ComboBox :items="$page.props.countries" label-property="name" value-property="id" :error="$page.props.errors.country" v-model="form.country" select-placeholder="Select Country" search-placeholder="Search country..."></ComboBox>
                    </div>
                    <div class="mb-4">
                        <Label>Contact Number<span class="text-red-500">*</span></Label>
                        <Input type="text" :error="$page.props.errors.contact_number" v-model="form.contact_number"></Input>
                    </div>
                    <div class="mb-4">
                        <Label>Email<span class="text-red-500">*</span></Label>
                        <Input type="text" :error="$page.props.errors.email" v-model="form.email"></Input>
                    </div>
                    <div class="mb-4 2xl:col-span-2">
                        <Label>Address<span class="text-red-500">*</span></Label>
                        <Textarea :error="$page.props.errors.address" v-model="form.address"></Textarea>
                    </div>
                </div>
            </template>
        </Card>
        <Card>
            <template #title>Centre Photos</template>
            <template #content>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="mb-4" v-show="show_front_upload">
                        <Label>Centre Front View  (1 Image)</Label>
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
                        <Label>Centre Inside View  (Max: 5 Images)</Label>
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
                </div>
                <div class="flex flex-wrap space-y-4 2xl:space-y-0 2xl:space-x-6">
                    <div class="overflow-x-auto" v-show="show_image">
                        <Label>Crop Image</Label>
                        <div class="w-96 h-60 mt-1">
                            <img class="image" ref="input" :src="image">
                        </div>
                    </div>
                    <div class="" v-show="show_image">
                        <div class="flex flex-row justify-center">
                            <div class="flex-column text-center">
                                <Label>Image Preview</Label>
                                <div class="preview h-52 w-96 mt-1"></div>
                            </div>
                            <div class="flex-column pl-1 pt-6">
                                <div class="flex flex-col space-y-1">
                                    <Button class="py-1 px-2 rounded shadow" @click="select_cropped_image()" title="Select cropped image">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </Button>
                                    <Button class="py-1 px-2 rounded shadow" @click="reselect_image()" title="Reselect an image">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </Button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap space-y-4 2xl:space-y-0 2xl:space-x-6">
                    <div class="sm:col-span-2 self-center flex flex-wrap gap-4 py-3" v-show="form.image_list.length">
                        <div class="relative h-32 w-32 mr-3 mt-3 text-center shadow-sm" v-for="(image_data, index) in form.image_list" :key="index">
                            <div class="absolute bg-red-500 p-2 shadow rounded-full text-white z-10 cursor-pointer hover:bg-red-700" style="top: -8px; right: -8px" @click="delete_cropped_image(index)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </div>
                            <img :src="image_data.image_path" class="rounded-lg" alt="">
                            <Label>{{ image_data.image_type }}</Label>
                        </div>
                    </div>
                </div>
            </template>
        </Card>
        <Card>
            <template #content>
                <div class="flex items-center justify-between">
                    <div class="flex space-x-2 items-center">
                        <Label>Active</Label>
                        <Switch v-model="form.active"></Switch>
                    </div>
                    <div class="flex space-x-2">
                        <Button variant="outline" @click="$inertia.get(route('centres'))">Cancel</Button>
                        <Button @click="submit">Save</Button>
                    </div>
                </div>
            </template>
        </Card>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Toggle from '@vueform/toggle';
import Cropper from 'cropperjs';    
import { debounce } from 'vue-debounce'
import Card from '@/Components/Card.vue'

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
            email_exist: this.$page.props.email_exist ? this.$page.props.email_exist : '',
            form: {
                id: this.$page.props.centre_info ? this.$page.props.centre_info.ID : '',
                country: this.$page.props.centre_info.country_id != 0 ? this.$page.props.centre_info.country_id : '',
                name: this.$page.props.centre_info ? this.$page.props.centre_info.label : '',
                contact_number: this.$page.props.centre_info ? this.$page.props.centre_info.phone : '',
                email: this.$page.props.centre_info ? this.$page.props.centre_info.email : '',
                address: this.$page.props.centre_info ? this.$page.props.centre_info.address : '',
                active: this.$page.props.centre_info ? !!this.$page.props.centre_info.is_active : false,
                principal_user_id: this.$page.props.centre_info ? this.$page.props.centre_info.principal_user_id : '',
                image_list: this.$page.props.centre_images ? this.$page.props.centre_images : [],
                images_to_delete: []
            },
            search: {
                email: this.$page.props.email_exist ? this.$page.props.email_exist.user_email : '',
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
        },
    },
    methods: {
        submit() {
            this.$inertia.post(route('centres.update'), this.form, { preserveState: true })
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
                if (value.image_type == 'front') return true;
            });
            const max_inside_image = this.form.image_list.filter((value) => {
                if (value.image_type == 'inside') return true;
            });

            if(this.data.view_type == 'front'){
                if(max_front_image.length < 1){
                    cropper.getCroppedCanvas().toBlob((blob) => {
                        var link = URL.createObjectURL(blob);   
                        var image_file = this.blobToFile(blob, this.data.name)
                        this.form.image_list.unshift({'image_path': link, 'image_file': image_file, 'image_type': this.data.view_type})
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
                        this.form.image_list.push({'name': this.data.name, 'image_path': link, 'image_file': blob, 'image_type': this.data.view_type})
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
            if(this.form.image_list[index].id){
                this.form.images_to_delete.push({'image_id' : this.form.image_list[index].id})
                // this.$inertia.delete('/centres/image/destroy/' + this.form.image_list[index].ID, { preserveState: true, preserveScroll: true,})
            }
            this.form.image_list.splice(index, 1)
        },
        blobToFile(blob, fileName){
            blob.lastModifiedDate = new Date();
            blob.name = fileName;
            return blob;
        },
    },
}
</script>
