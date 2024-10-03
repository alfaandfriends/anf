<script setup>
import UploadPreview from '@/Components/UploadPreview.vue';
import { PlusCircle } from 'lucide-vue-next';
</script>

<script>
import Compressor from 'compressorjs';
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import Card from '@/Components/Card.vue'
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'

function blobToFile(blob, filename) {
  const file = new File([blob], filename, { type: blob.type });
  return file;
}

export default {
    components: [
        Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow
    ],
    props: {
        detailed_info: Object,
        sub_variation_prop: Object
    },
    data(){
        return{
            sub_variations: this.sub_variation_prop ? this.sub_variation_prop : {
                options: [{
                    name: ''
                }],
            },
            confirmation_modal: {
                is_open: false,
                alert: '',
                title: '',
                text: '',
                button: '',
                method: '',
                route: '',
                data: '',
                preserveScroll: true,
            }
        }
    },
    watch:{
        'detailed_info.has_sub_variation': {
            handler(){
                const info = this.detailed_info
                if(!info.has_sub_variation){
                    this.sub_variations.options = [{
                        name: ''
                    }]
                    info.sub_variation_name = ''
                    info.variations.options.map((variation)=>{
                        variation.sub_variations.options = [{
                            id: '',
                            name: '',
                            price: 0,
                            stock: 0,
                        }]
                    })
                }
            },
        },
        sub_variations: {
            handler(){
                if(this.detailed_info.has_sub_variation == 1){
                    this.constructTable()
                }
            },
            deep: true
        },
        'detailed_info.variations.options': {
            handler(){
                this.detailed_info.variations.options.forEach(item => {
                    !item.price ? item.price = 0 : ''
                    !item.stock ? item.stock = 0 : ''
                    item.sub_variations.options.forEach(sub_item => {
                        !sub_item.price ? sub_item.price = 0 : ''
                        !sub_item.stock ? sub_item.stock = 0 : ''
                    });
                })
            },
            deep: true
        },
    },
    methods: {
        constructTable(){
            this.detailed_info.variations.options.forEach((variation, variation_index) => {
                if(variation.sub_variations.options.length){
                    variation.sub_variations.options.forEach((sub_variation, sub_variation_index) => {
                        sub_variation.name = this.sub_variations.options[sub_variation_index] ? this.sub_variations.options[sub_variation_index].name : ''
                    });
                }
            });
        },
        addVariation(){
            const has_sub_variations = this.sub_variations.options.some(option => option.name !== '');
            if(!has_sub_variations){
                this.detailed_info.variations.options.push({
                    id: '',
                    name: '',
                    images: {
                        file: null,
                        value: null
                    },
                    price: 0,
                    stock: 0,
                    sub_variations: {
                        options: [{
                            id: '',
                            name: '',
                            price: 0,
                            stock: 0,
                        }]
                    }
                })
            }
            else{
                const new_item    =   {
                    id: '',
                    name: '',
                    images: {
                        file: null, 
                        value: null
                    },
                    price: 0,
                    stock: 0,
                    sub_variations: {
                        options: []
                    }
                }
                this.detailed_info.variations.options.push(new_item)
                const newIndex = this.detailed_info.variations.options.indexOf(new_item);
                this.sub_variations.options.forEach(item=>{
                    this.detailed_info.variations.options[newIndex].sub_variations.options.push({
                        id: '',
                        name: item.name,
                        price: 0,
                        stock: 0
                    })
                })
            }
        },
        addSubVariation(){
            this.sub_variations.options.push({
                name: '',
            })
            this.detailed_info.variations.options.forEach((element, index) => {
                element.sub_variations.options.push({
                    id: '',
                    name: '',
                    price: 0,
                    stock: 0,
                })
            });
        },
        removeVariation(index, variation_id){
            if(variation_id){
                this.confirmation_modal.is_open = true
                this.confirmation_modal.alert = 'danger'
                this.confirmation_modal.title = 'Are you sure?'
                this.confirmation_modal.text = 'This will delete the variation along with the sub variations. This action will be executed once you click the DELETE button. This action is <span class="text-red-600">IRREVERSIBLE</span>. Are you confirm?'
                this.confirmation_modal.button = 'DELETE'
                this.confirmation_modal.method = 'delete'
                this.confirmation_modal.route = 'products.delete_variation'
                this.confirmation_modal.data = variation_id
            }
            else{
                this.detailed_info.variations.options.splice(index, 1)
            }
        },
        removeSubVariation(index){
            const to_delete  =   []
            this.detailed_info.variations.options.forEach(element => {
                const sub_variation_id    =   element.sub_variations.options[index].id
                if(sub_variation_id){
                    to_delete.push(element.sub_variations.options[index].id)
                }
            })
            if(to_delete.length){
                this.confirmation_modal.is_open = true
                this.confirmation_modal.alert = 'danger'
                this.confirmation_modal.title = 'Are you sure?'
                this.confirmation_modal.text = 'This will delete this sub variation for all variation in this product. This action will be executed once you click the DELETE button. This action is IRREVERSIBLE. Are you confirm?'
                this.confirmation_modal.button = 'DELETE'
                this.confirmation_modal.method = 'delete'
                this.confirmation_modal.route = 'products.delete_sub_variation'
                this.confirmation_modal.data = {'to_delete': to_delete}
            }
            else{
                this.detailed_info.variations.options.forEach(element => {
                    element.sub_variations.options.splice(index, 1)
                })
                this.sub_variations.options.splice(index, 1)
            }
        },
        handleFileChange(file, index, ){
            if (file) {
                this.compress(file, index)
            }
        },
        compress(file, index){
            const detailed_info =   this.detailed_info
            new Compressor(file, {
                quality: 0.2,
                maxWidth: 400,
                maxHeight: 400,
                success(result) {
                    const blobUrl = URL.createObjectURL(result);
                    const new_file   =   blobToFile(result, Date.now()+'.jpg')
                    detailed_info.variations.options[index].images.file = new_file
                    detailed_info.variations.options[index].images.value = blobUrl
                },
            });
        },
        deleteImage(index){
            this.detailed_info.variations.options[index].images.file = null
            this.detailed_info.variations.options[index].images.value = null
        }, 
        blobToFile(blob, filename) {
            const file = new File([blob], filename, { type: blob.type });
            return file;
        },
        numbersOnly (evt, index){
            evt = evt ? evt : window.event;
            var charCode = evt.which ? evt.which : evt.keyCode;
            
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();
            } else {
                // Get the input value
                let inputValue = evt.target.value.trim();
                
                if (inputValue === '') {
                inputValue = '0'; // Set default value as 0
                } else if (inputValue !== '0' && inputValue.startsWith('0')) {
                // Remove leading zero if it exists
                inputValue = inputValue.replace(/^0+/, '');
                }
                
                evt.target.value = inputValue !== '' ? inputValue : '0'; // Keep '0' if value is empty
                
                return true;
            }
        },
    }
}
</script>

<template>
    <div class="grid grid-cols-1 2xl:grid-cols-2 gap-4">
        <Card>
            <template #content>
                <div class="mb-3">
                    <Label class="text-base"> Variation </Label>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div class="">
                        <Label>Name<span class="text-red-500">*</span></Label>
                        <Input type="text" placeholder="Example: Level" v-model="detailed_info.main_variation_name"></Input>
                    </div>
                    <div class="grid grid-cols-1 gap-2">
                        <div class="flex items-center space-x-4">
                            <Label>Options<span class="text-red-500">*</span></Label>
                            <Button @click="addVariation" class="text-xs px-2 h-0 py-4">
                                <PlusCircle class="h-4 w-4" />
                                <span class="ml-1 hidden sm:block">Add</span>
                            </Button>
                        </div>
                        <div v-for="(option, index) in detailed_info.variations.options" :key="index" class="flex space-x-2">
                            <Input type="text" class="2xl:w-screen 2xl:max-w-96" placeholder="Example: Level 1" v-model="option.name"></Input>
                            <Button variant="destructive" class="text-xs px-2 h-0 py-4" @click="detailed_info.variations.options.length > 1 ? removeVariation(index, option.id) : ''">Remove</Button>
                        </div>
                    </div>
                </div>
            </template>
        </Card>
        <Card :class="{'hidden': detailed_info.has_sub_variation == 0}">
            <template #content>
                <div class="mb-3">
                    <Label class="text-base"> Sub Variation </Label>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div class="">
                        <Label>Name<span class="text-red-500">*</span></Label>
                        <Input type="text" placeholder="Example: Level" v-model="detailed_info.sub_variation_name"></Input>
                    </div>
                    <div class="grid grid-cols-1 gap-2">
                        <div class="flex items-center space-x-4">
                            <Label>Options<span class="text-red-500">*</span></Label>
                            <Button @click="addSubVariation" class="text-xs px-2 h-0 py-4">
                                <PlusCircle class="h-4 w-4" />
                                <span class="ml-1 hidden sm:block">Add</span>
                            </Button>
                        </div>
                        <div v-for="(option, index) in sub_variations.options" :key="index" class="flex space-x-2">
                            <Input type="text" class="2xl:w-screen 2xl:max-w-96" placeholder="Example: Level 1" v-model="option.name"></Input>
                            <Button variant="destructive" class="text-xs px-2 h-0 py-4" @click="sub_variations.options.length > 1 ? removeSubVariation(index) : ''">Remove</Button>
                        </div>
                    </div>
                </div>
            </template>
        </Card>
    </div>
    <Card class="mt-4" v-if="detailed_info.main_variation_name">
        <template #content>
            <Table>
                <TableHeader class="bg-gray-100">
                    <TableRow>
                        <TableHead class="text-center">{{ detailed_info.main_variation_name}}</TableHead>
                        <TableHead class="text-center" v-if="detailed_info.has_sub_variation == 1 && detailed_info.sub_variation_name && sub_variations.options.some(option => option.name !== '')">{{ detailed_info.sub_variation_name}}</TableHead>
                        <TableHead class="text-center">Price</TableHead>
                        <TableHead class="text-center">Stock</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-for="(variation, variation_index) in detailed_info.variations.options">
                        <TableRow v-if="variation.name.trim() !== ''">
                            <TableCell>
                                <div class="flex flex-col items-center p-2 m-2">
                                    <UploadPreview :previewUrl="variation.images.value" @update:value="handleFileChange($event, variation_index)" />
                                    <Label class="mt-1" :for="variation.name"> {{ variation.name }} </Label>
                                </div>
                            </TableCell>
                            <TableCell v-if="detailed_info.has_sub_variation == 1 && detailed_info.sub_variation_name && sub_variations.options.some(option => option.name !== '')">
                                <div class="flex flex-col items-center space-y-2" v-for="(sub_variation, sub_variation_index) in variation.sub_variations.options">
                                    <Label class="my-3" v-if="sub_variation.name" :for="sub_variation.name"> {{ sub_variation.name }} </Label>
                                </div>
                            </TableCell>
                            <template v-if="detailed_info.has_sub_variation == 1 && detailed_info.sub_variation_name && sub_variations.options.some(option => option.name !== '')">
                                <TableCell>
                                    <div class="flex flex-col justify-center items-center space-y-2">
                                        <template v-for="(sub_variation, sub_variation_index) in variation.sub_variations.options">
                                            <Input v-if="sub_variation.name" type="number" min="0" @input="numbersOnly($event)" class="focus:ring-0 border-gray-300 focus:border-gray-400 rounded-md flex-1 block min-w-14" v-model="sub_variation.price"></Input>
                                        </template>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="flex flex-col justify-center items-center space-y-2">
                                        <template v-for="(sub_variation, sub_variation_index) in variation.sub_variations.options">
                                            <Input v-if="sub_variation.name" type="number" min="0" @input="numbersOnly($event)" class="focus:ring-0 border-gray-300 focus:border-gray-400 rounded-md flex-1 block min-w-14"  v-model="sub_variation.stock"></Input>
                                        </template>
                                    </div>
                                </TableCell>
                            </template>
                            <template v-else>
                                <TableCell>
                                    <div class="flex flex-col justify-center items-center space-y-2">
                                        <Input type="number" min="0" @input="numbersOnly($event)" class="focus:ring-0 border-gray-300 focus:border-gray-400 rounded-md flex-1 block min-w-14" v-model="variation.price"/>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="flex flex-col justify-center items-center space-y-2">
                                        <Input type="number" min="0" @input="numbersOnly($event)" class="focus:ring-0 border-gray-300 focus:border-gray-400 rounded-md flex-1 block min-w-14" v-model="variation.stock"/>
                                    </div>
                                </TableCell>
                            </template>
                        </TableRow>
                    </template>
                </TableBody>
            </Table>
        </template>
    </Card>
    <ConfirmationModal 
        :show="confirmation_modal.is_open" 
        @close="confirmation_modal.is_open = false"
        :confirmationAlert="confirmation_modal.alert"
        :confirmationTitle="confirmation_modal.title"
        :confirmationText="confirmation_modal.text"
        :confirmationButton="confirmation_modal.button"
        :confirmationMethod="confirmation_modal.method"
        :confirmationRoute="confirmation_modal.route"
        :confirmationData="confirmation_modal.data"
        :preserveScroll="confirmation_modal.preserveScroll"
        :preserveState="confirmation_modal.preserveState"
    />
</template>
