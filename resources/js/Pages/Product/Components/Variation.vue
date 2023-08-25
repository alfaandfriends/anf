<script setup>
import { ref, onMounted, watch, computed } from 'vue';
import BreezeButton from '@/Components/Button.vue';
import VariationOption from './VariationOption.vue';
import UploadPreview from '@/Components/UploadPreview.vue';
</script>

<script>
import Compressor from 'compressorjs';
import ConfirmationModal from '@/Components/ConfirmationModal.vue'

function blobToFile(blob, filename) {
  const file = new File([blob], filename, { type: blob.type });
  return file;
}

export default {
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
        sub_variations: {
            handler(){
                if(this.detailed_info.has_sub_variation == true){
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
                variation.sub_variations.options.forEach((sub_variation, sub_variation_index) => {
                    sub_variation.name = this.sub_variations.options[sub_variation_index] ? this.sub_variations.options[sub_variation_index].name : ''
                });
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
    <div class="w-full">
        <div class="flex flex-col mb-10">
            <div class="mb-3">
                <label class="block text-sm text-gray-700 font-bold"> Main Variation </label>
            </div>
            <div class="w-full bg-white shadow-md shadow-gray-400 border border-gray-400 rounded-md overflow-hidden">
                <div class="border-b border-gray-200 px-8 py-6">
                    <div class="mb-4">
                        <label for="variation_name" class="block text-sm text-gray-700 font-bold"> Name <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" placeholder="E.g. Level, " id="variation_name" v-model="detailed_info.main_variation_name" class="focus:ring-0 border-gray-300 focus:border-gray-400 flex-1 block w-full rounded-md sm:text-sm"/>
                        </div>
                    </div>
                    <div class="mb-4"><div>
                        <div class="flex items-center justify-between py-2">
                            <label class="block text-sm text-gray-700 font-bold"> Options <span class="text-red-500">*</span></label>
                            <BreezeButton @click="addVariation" buttonType="info" class="text-sm py-2 px-3">Add more option</BreezeButton>
                        </div>
                        <div v-for="(option, index) in detailed_info.variations.options" :key="index" class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" placeholder="E.g. Level 1" class="focus:ring-0 border-gray-300 focus:border-gray-400 flex-1 block rounded-tl-md rounded-bl-md sm:text-sm" v-model="option.name" autocomplete="off"/>
                            <BreezeButton buttonType="danger" class="h-full px-4 rounded-r rounded-l-none" @click="removeVariation(index, option.id)">Remove</BreezeButton>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col mb-10" :class="{'hidden': !detailed_info.has_sub_variation}">
            <div class="mb-3">
                <label class="block text-sm text-gray-700 font-bold"> Sub Variation </label>
            </div>
            <div class="w-full bg-white shadow-md shadow-gray-500 border border-gray-400 rounded-md overflow-hidden">
                <div class="border-b border-gray-200 px-8 py-6">
                    <div class="mb-4">
                        <label for="sub_variation_name" class="block text-sm text-gray-700 font-bold"> Name <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" id="sub_variation_name" v-model="detailed_info.sub_variation_name" class="focus:ring-0 border-gray-300 focus:border-gray-400 flex-1 block w-full rounded-md sm:text-sm"/>
                        </div>
                    </div>
                    <div class="mb-4"><div>
                        <div class="flex items-center justify-between py-2">
                            <label class="block text-sm text-gray-700 font-bold"> Options <span class="text-red-500">*</span></label>
                            <BreezeButton @click="addSubVariation" buttonType="info" class="text-sm py-2 px-3">Add more option</BreezeButton>
                        </div>
                        <div v-for="(option, index) in sub_variations.options" :key="index" class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" placeholder="option" class="focus:ring-0 border-gray-300 focus:border-gray-400 flex-1 block rounded-tl-md rounded-bl-md sm:text-sm" v-model="option.name" autocomplete="off"/>
                            <BreezeButton buttonType="danger" class="h-full px-4 rounded-r rounded-l-none" @click="removeSubVariation(index)">Remove</BreezeButton>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col mb-3" v-if="detailed_info.main_variation_name">
            <div class="overflow-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">{{ detailed_info.main_variation_name}}</th>
                            <th v-if="detailed_info.has_sub_variation && detailed_info.sub_variation_name && sub_variations.options.some(option => option.name !== '')" scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">{{ sub_variations.name}}</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Price</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Stock</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <template v-for="(variation, variation_index) in detailed_info.variations.options">
                            <tr class="" v-if="variation.name.trim() !== ''">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col items-center p-2 m-2">
                                        <UploadPreview :previewUrl="variation.images.value" @update:value="handleFileChange($event, variation_index)" />
                                        <label :for="variation.name" class="text-sm text-gray-500 text-center"> {{ variation.name }} </label>
                                    </div>
                                </td>
                                <td v-if="detailed_info.has_sub_variation && detailed_info.sub_variation_name && sub_variations.options.some(option => option.name !== '')" class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col items-center space-y-2" v-for="(sub_variation, sub_variation_index) in variation.sub_variations.options">
                                        <label v-if="sub_variation.name" :for="sub_variation.name" class="py-3 text-sm text-gray-500 text-center"> {{ sub_variation.name }} </label>
                                    </div>
                                </td>
                                <template v-if="detailed_info.has_sub_variation && detailed_info.sub_variation_name && sub_variations.options.some(option => option.name !== '')">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col justify-center items-center space-y-2">
                                            <template v-for="(sub_variation, sub_variation_index) in variation.sub_variations.options">
                                                <input v-if="sub_variation.name" type="number" min="0" @input="numbersOnly($event)" class="focus:ring-0 border-gray-300 focus:border-gray-400 rounded-md flex-1 block sm:text-sm" v-model="sub_variation.price" autocomplete="off"/>
                                            </template>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col justify-center items-center space-y-2">
                                            <template v-for="(sub_variation, sub_variation_index) in variation.sub_variations.options">
                                                <input v-if="sub_variation.name" type="number" min="0" @input="numbersOnly($event)" class="focus:ring-0 border-gray-300 focus:border-gray-400 rounded-md flex-1 block sm:text-sm"  v-model="sub_variation.stock" autocomplete="off"/>
                                            </template>
                                        </div>
                                    </td>
                                </template>
                                <template v-else>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col justify-center items-center space-y-2">
                                            <input type="number" min="0" @input="numbersOnly($event)" class="focus:ring-0 border-gray-300 focus:border-gray-400 rounded-md flex-1 block sm:text-sm" v-model="variation.price" autocomplete="off"/>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col justify-center items-center space-y-2">
                                            <input type="number" min="0" @input="numbersOnly($event)" class="focus:ring-0 border-gray-300 focus:border-gray-400 rounded-md flex-1 block sm:text-sm" v-model="variation.stock" autocomplete="off"/>
                                        </div>
                                    </td>
                                </template>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
