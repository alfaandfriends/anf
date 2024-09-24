<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Teacher Resources" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <Card>
            <template #title>Resource Information</template>
            <template #content>
                <div class="grid grid-cols-1 gap-4 mb-3">
                    <div>
                        <Label>Title<span class="text-red-500">*</span></Label>
                        <Input type="text" :error="$page.props.errors.title" v-model="form.title"></Input>
                    </div>
                    <div>
                        <Label>Programme<span class="text-red-500">*</span></Label>
                        <ComboBox :items="$page.props.programmes" label-property="name" value-property="id" :error="$page.props.errors.programme_id" v-model="form.programme_id" select-placeholder="Select Programme" search-placeholder="Search programme..."></ComboBox>
                    </div>
                    <div>
                        <Label>Level<span class="text-red-500">*</span></Label>
                        <ComboBox :items="$page.props.levels" label-property="name" value-property="id" :error="$page.props.errors.level_id" v-model="form.level_id" select-placeholder="Select Level" search-placeholder="Search level..."></ComboBox>
                    </div>
                    <div>
                        <Label>Language<span class="text-red-500">*</span></Label>
                        <ComboBox :items="$page.props.languages" label-property="name" value-property="id" :error="$page.props.errors.language_id" v-model="form.language_id" select-placeholder="Select Language" search-placeholder="Search language..."></ComboBox>
                    </div>
                    <div>
                        <Label>Media Type<span class="text-red-500">*</span></Label>
                        <ComboBox :items="$page.props.media_types" label-property="name" value-property="id" :error="$page.props.errors.media_type_id" v-model="form.media_type_id" select-placeholder="Select Media Type" search-placeholder="Search media type..."></ComboBox>
                    </div>
                    <div v-if="form.media_type_id == 1">
                        <Label>Embed Link<span class="text-red-500">*</span></Label>
                        <Textarea rows="3" :error="$page.props.errors.embed_link" v-model="form.embed_link"></Textarea>
                    </div>
                    <div v-if="form.media_type_id == 2 || form.media_type_id == 3"> 
                        <label for="" class="block text-sm font-bold text-gray-700"> File <span class="text-red-500">*</span></label>
                        <label class="block focus:ring-0 focus:border-gray-300">
                            <span class="sr-only">Browse File</span>
                            <input type="file" ref="file_input" class="focus:ring-0 border rounded-md block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-700 focus:outline-none" :class="$page.props.errors.embed_file ? 'border-red-300' : 'border-gray-300'" @change="uploadFile"/>
                        </label>
                    </div>
                </div>
            </template>
        </Card>
        <Card>
            <template #content>
                <div class="flex justify-end">
                    <div class="flex space-x-2">
                        <Button variant="outline" @click="$inertia.get(route('teacher_resources'))">Cancel</Button>
                        <Button @click="submit">Save</Button>
                    </div>
                </div>
            </template>
        </Card>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Card from '@/Components/Card.vue'

export default {
    components: {
        Head, Link
    },
    data(){
        return{
            list: {
                levels: [],
            },
            form: {
                title: '',
                programme_id: '',
                level_id: '',
                language_id: '',
                media_type_id: 1,
                embed_link: '',
                embed_file: ''
            }
        }
    },
    watch: {
        'form.media_type_id': {
            handler(){
                this.form.embed_link = ''
                this.form.embed_file = ''
            }
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('teacher_resources.store'), this.form, { preserveState: true})
        },
        uploadFile($event){
            const file  =   $event.target.files[0]
            if(this.form.media_type_id  ==  2){
                if(file.type == 'application/pdf' || file.name.toLowerCase().endsWith('.pdf')){
                    this.form.embed_file  =   file
                }
                else{
                    alert('Only PDF File allowed!')
                    this.$refs.file_input.value = ''
                    this.form.embed_file = ''
                }
            }
            
            if(this.form.media_type_id  ==  3){
                if(file.type === 'application/vnd.ms-powerpoint' || file.type === 'application/vnd.openxmlformats-officedocument.presentationml.presentation' || file.name.toLowerCase().endsWith('.ppt') || file.name.toLowerCase().endsWith('.pptx')){
                    this.form.embed_file  =   file
                }
                else{
                    alert('Only PowerPoint Sildeshow File allowed!')
                    this.$refs.file_input.value = ''
                    this.form.embed_file = ''
                }
            }
        }
    }
}
</script>