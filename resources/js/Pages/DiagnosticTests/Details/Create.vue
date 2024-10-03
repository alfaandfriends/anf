<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Diagnostic Test" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <Card>
            <template #title>Basic Information</template>
            <template #content>
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
                    <div>
                        <Label>Category<span class="text-red-500">*</span></Label>
                        <ComboBox :items="$page.props.diagnostic_test_categories" label-property="name" value-property="id" :error="$page.props.errors.category_id" v-model="form.category_id" select-placeholder="Select Category" search-placeholder="Search category..."></ComboBox>
                    </div>
                    <div>
                        <Label>Redirection (Correct)<span class="text-red-500">*</span></Label>
                        <ComboBox :items="$page.props.diagnostic_test_list" label-property="question" value-property="id" :error="$page.props.errors.redirect_yes" v-model="form.redirect_yes" select-placeholder="Default (No Redirection)" search-placeholder="Search redirection..."></ComboBox>
                    </div>
                    <div>
                        <Label>Redirection (Wrong)<span class="text-red-500">*</span></Label>
                        <!-- <Input type="text" :error="$page.props.errors.category_name" v-model="form.category_name"></Input> -->
                        <ComboBox :items="$page.props.diagnostic_test_list" label-property="question" value-property="id" :error="$page.props.errors.redirect_no" v-model="form.redirect_no" select-placeholder="Default (No Redirection)" search-placeholder="Search redirection..."></ComboBox>
                    </div>
                </div>
            </template>
        </Card>
        <Card>
            <template #title>Question Details</template>
            <template #content>
                <Alert class="bg-sky-200 text-slate-900 mb-3" v-if="form.question_type == 4">
                    <RocketIcon class="h-4 w-4" />
                    <AlertTitle class="font-bold mb-3 underline">Notes</AlertTitle>
                    <AlertDescription>
                        <div class="flex flex-col space-y-2">
                            <Label >Please wrap the answer with [ ] for the system to automatically replace it with blank spaces, but only in the question field.</Label>
                            <Label class="font-semibold text-sky-900">ALFA like to [play] football.</Label>
                            <br>
                            <Label>Use | to set multiple correct answers.</Label>
                            <Label class="font-semibold text-sky-900">ALFA like to [eat|drink|sleep].</Label>
                        </div>
                    </AlertDescription>
                </Alert>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <Label>Type<span class="text-red-500">*</span></Label>
                        <ComboBox :items="question_types" label-property="name" value-property="id" :error="$page.props.errors.question_type" v-model="form.question_type" select-placeholder="Select Type" search-placeholder="Search type..."></ComboBox>
                    </div>
                    <div>
                        <Label>Question<span class="text-red-500">*</span></Label>
                        <Textarea rows="3" :error="$page.props.errors.question" v-model="form.question"></Textarea>
                    </div>
                    <div>
                        <Label>Remarks / Additional Notes<span class="text-red-500">*</span></Label>
                        <Textarea rows="3" :error="$page.props.errors.remarks" v-model="form.remarks"></Textarea>
                    </div>
                    <div>
                        <Label>Question Image<span class="text-red-500">*</span></Label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                            @change="change"
                            @dragover="dragover"
                            @drop="drop"
                            v-if="showUpload"
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
                        <div class="w-1/4 relative group mt-2" v-if="showImage">
                            <div class="absolute w-full h-full hover:bg-black hover:opacity-75 hidden group-hover:block">
                                <div class="absolute cursor-pointer top-1/2 left-1/2 -translate-y-2/4 -translate-x-2/4 h-16 w-16 hover:text-red-500 text-red-600 transition ease-in-out hover:-translate-1 hover:scale-110 duration-100" alt="Remove Image" @click="removeImage">
                                    <div class="pl-[0.65rem]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </div>
                                    <span class="text-white">Remove</span>
                                </div>
                            </div>
                            <img class="rounded w-full" :src="form.image_url" alt="">
                        </div>
                    </div>
                </div>
            </template>
        </Card>
        <SingleChoice v-if="form.question_type == 1" @receivedData="appendToForm" :prop_answers="[]" action="create"></SingleChoice>
        <MultipleChoices v-if="form.question_type == 2" @receivedData="appendToForm" :prop_answers="[]" action="create"></MultipleChoices>
        <MatrixSorting v-if="form.question_type == 3" @receivedData="appendToForm" :prop_answers="[]" action="create"></MatrixSorting>
        <Card>
            <template #footer>
                <Button variant="outline" @click="$inertia.get($page.props.redirect_url)">Cancel</Button>
                <Button @click="submit">Save</Button>
            </template>
        </Card>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Card from '@/Components/Card.vue'
import { RocketIcon } from '@radix-icons/vue'
import { Alert, AlertDescription, AlertTitle } from '@/Components/ui/alert'
import SingleChoice from '@/Pages/DiagnosticTests/AnswerTemplates/SingleChoice.vue'
import MultipleChoices from '@/Pages/DiagnosticTests/AnswerTemplates/MultipleChoices.vue'
import MatrixSorting from '@/Pages/DiagnosticTests/AnswerTemplates/MatrixSorting.vue'

const URL = window.URL || window.webkitURL;
const REGEXP_MIME_TYPE_IMAGES = /^image\/\w+$/;

export default {
    components: {
        Head, Link
    },
    data() {
        return {
            data:  {
                type: Object,
                default: () => ({}),
            },
            showUpload: true,
            showImage: false,
            question_types: [{
                id: 1,
                name: 'Single Choice'
            },{
                id: 2,
                name: 'Multiple Choices'
            },{
                id: 4,
                name: 'Fill in the Blank'
            }],
            form: {
                dt_id: this.$page.props.diagnostic_test_id || '',
                redirect_url: this.$page.props.redirect_url || '',
                category_id: '',
                redirect_yes: '',
                redirect_no: '',
                question_type: '',
                question: '',
                remarks: '',
                image_url: '',
                image_file: '',
                question_answer_data: []
            }
        };
    },
    methods: {
        submit() {
            this.$inertia.post(route('dt.settings.details.store'), this.form, { preserveState: true})
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
        change({ target }) {
            const { files } = target;
            if (files && files.length > 0) {
                this.read(files[0], target)
                .then((data) => {
                    this.form.image_url     =   data.url
                    this.form.image_file     =   files
                    this.showUpload     =   false;
                    this.showImage      =   true;
                    this.update(data);
                })
                .catch(this.alert);
            }
        },
        dragover(e) {
            e.preventDefault();
        },
        drop(e) {
            const { files } = e.dataTransfer;
            e.preventDefault();
            if (files && files.length > 0) {
                this.read(files[0], e)
                .then((data) => {
                    this.form.image_url     =   data.url
                    this.form.image_file     =   files
                    this.showUpload     =   false;
                    this.showImage      =   true;
                    this.update(data);
                })
                .catch(this.alert);
            }
        },
        alert(e) {
            window.alert(e && e.message ? e.message : e);
        },
        update(data) {
            Object.assign(this.data, data);
        },
        removeImage(){
            this.form.image_url = ''
            this.showImage      =   false;
            this.showUpload     =   true;
        },
        appendToForm(data){
            this.form.question_answer_data = data
        }
    }

}
</script>
                                