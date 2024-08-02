<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>
<style>
  input[type='number']::-webkit-inner-spin-button,
  input[type='number']::-webkit-outer-spin-button {
    margin: 0;
  }

  .custom-number-input input:focus {
    outline: none !important;
  }

  .custom-number-input button:focus {
    outline: none !important;
  }
</style>

<template>
    <Head title="Programmes" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <Card>
            <template #title>Programme Information</template>
            <template #content>
                <div class="grid grid-cols-1 2xl:grid-cols-3 gap-2">
                    <div class="mb-4">
                        <Label>Name<span class="text-red-500">*</span></Label>
                        <Input type="text" :error="$page.props.errors.programme_name" v-model="form.programme_name"></Input>
                    </div>
                    <div class="mb-4">
                        <Label>Country<span class="text-red-500">*</span></Label>
                        <ComboBox :items="$page.props.countries" label-property="name" value-property="id" :error="$page.props.errors.programme_country" v-model="form.programme_country" select-placeholder="Select Country" search-placeholder="Search country..."></ComboBox>
                    </div>
                    <div class="mb-4">
                        <Label>Progress Report Required<span class="text-red-500">*</span></Label>
                        <ComboBox :items='[{"id": 0, "name": "No"},{"id": 1, "name": "Yes"}]' label-property="name" value-property="id" :error="$page.props.errors.progress_report_required" v-model="form.progress_report_required" select-placeholder="Please Select" search-placeholder="Search..."></ComboBox>
                    </div>
                </div>
            </template>
        </Card>
        <Card>
            <template #title>
                <div class="flex justify-between items-center">
                    Programme Levels and Fees
                    <Button buttonType="info" @click="showAddFee">
                        <PlusCircle class="mr-1 h-4 w-4" />Add Fee
                    </Button>
                </div>  
            </template>
            <template #content>
                <Collapsible v-for="item, level in groupedItems">
                    <template #trigger>Level {{ level }}</template>
                    <template #content>
                        <Table class="px-4">
                            <TableHeader class="bg-gray-100">
                                <TableRow>
                                    <TableHead class="px-4">Class Type</TableHead>
                                    <TableHead>Registration Fee</TableHead>
                                    <TableHead>Material Fee</TableHead>
                                    <TableHead>Monthly Fee (Old)</TableHead>
                                    <TableHead>Monthly Fee (New)</TableHead>
                                    <TableHead>Material</TableHead>
                                    <TableHead class="text-center">Action</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-if="!item.length">
                                    <TableCell class="text-center" colspan="10">
                                        <div class="p-3">
                                            No Record Found
                                        </div>
                                    </TableCell>
                                </TableRow> 
                                <TableRow v-for="info, index in item">
                                    <TableCell class="px-4">{{ $page.props.class_types[item[index].class_type].name}}</TableCell>
                                    <TableCell>{{ info.registration_fee }}</TableCell>
                                    <TableCell>{{ info.material_fee }}</TableCell>
                                    <TableCell>
                                        <p class="text-sm text-gray-700" v-for="fee in info.fees">{{ $page.props.class_types_detail.find((item)=>item.id === fee.class_type_detail_id)?.label }} : <span class="font-bold">{{ fee.value }}</span></p>
                                    </TableCell>
                                    <TableCell>
                                        <div class="flex space-x-4 items-center">
                                            <div class="flex flex-col items-start">
                                                <p class="text-sm text-gray-700" v-for="fee in info.fees">{{ $page.props.class_types_detail.find((item)=>item.id === fee.class_type_detail_id)?.label }} : <span class="font-bold">{{ fee.new_fee_amount }}</span></p>
                                            </div>
                                            <Button variant="link" class="text-blue-500" @click="editFee(level, index, info.programme_level_id ? false : true)">Edit</Button>
                                        </div>
                                    </TableCell>
                                    <TableCell>
                                        <div class="flex flex-col">
                                            <p class="text-sm text-gray-700 font-normal underline"><span class="font-semibold">{{ info.product.name }}</span></p>
                                            <p class="text-sm text-gray-700 italic">Variation : <span class="font-semibold">{{ info.product_variation.option_name ? info.product_variation.option_name : '-' }}</span></p>
                                            <p class="text-sm text-gray-700 italic">Sub Variation : <span class="font-semibold">{{ info.product_sub_variation.option_name ? info.product_sub_variation.option_name : '-' }}</span></p>
                                        </div>
                                    </TableCell>
                                    <TableCell class="text-center">
                                        <Button variant="destructive" @click="deleteLevel(info.programme_level_id, index)">Delete</Button>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </template>
                </Collapsible>
            </template>
        </Card>
        <Card>
            <template #content>
                <div class="flex items-center justify-between">
                    <div class="flex space-x-2 items-center">
                        <Label>Active</Label>
                        <Switch v-model="form.programme_active"></Switch>
                    </div>
                    <div class="flex space-x-2">
                        <Button variant="outline" @click="$inertia.get(route('programmes'))">Cancel</Button>
                        <Button @click="submit">Save</Button>
                    </div>
                </div>
            </template>
        </Card>
        <Dialog v-model:open="show.add_fee">
            <template #title>Add Fee</template>
            <template #content>
                <Collapsible v-model="collapsible.fee">
                    <template #trigger>Fee Information</template>
                    <template #content>
                        <div class="p-1 grid grid-cols-1">
                            <div class="mb-4">
                                <Label>Level<span class="text-red-500">*</span></Label>
                                <ComboBox :items="levels" label-property="name" value-property="id" :error="validation.level.error" v-model="fee_form.level" select-placeholder="Select Level" search-placeholder="Search level..."></ComboBox>
                            </div>
                            <div class="mb-4">
                                <Label>Registration Fee<span class="text-red-500">*</span></Label>
                                <Input type="number" :error="validation.registration_fee.error" v-model="fee_form.registration_fee"></Input>
                            </div>
                            <div class="mb-4">
                                <Label>Material Fee<span class="text-red-500">*</span></Label>
                                <Input type="number" :error="validation.material_fee.error" v-model="fee_form.material_fee"></Input>
                            </div>
                            <div class="mb-4">
                                <Label>Class Type<span class="text-red-500">*</span></Label>
                                <ComboBox :items="Object.values($page.props.class_types)" label-property="name" value-property="id" :error="validation.class_type.error" v-model="fee_form.class_type" select-placeholder="Select Class Type" search-placeholder="Search class type..."></ComboBox>
                            </div>
                            <div class="mb-4" v-for="class_types_detail, index in list.class_types_detail">
                                <Label>{{ class_types_detail.label }}<span class="text-red-500">*</span></Label>
                                <Input type="number" min="1" :error="$page.props.errors.class_type_detail" v-model="fee_form.fees[index].value"></Input>
                            </div>
                        </div>
                    </template>
                </Collapsible>
                <Collapsible v-model="collapsible.material">
                    <template #trigger>Material Information</template>
                    <template #content>
                        <div class="p-1 grid grid-cols-1">
                            <div class="mb-4">
                                <Label>Material</Label>
                                <ComboBox :items="list.products" label-property="name" value-property="id" :error="validation.product.error" :loading="loading.products" @search="findProducts" @select="findProductVariations" v-model="search_product_form.product_id" select-placeholder="Select Material" search-placeholder="Search material..."></ComboBox>
                            </div>
                            <div class="mb-4" v-if="show.product_variations">
                                <Label>Variation<span class="text-red-500">*</span></Label>
                                <ComboBox :items="list.product_variations" label-property="option_name" value-property="id" :loading="loading.product_variations" :error="validation.product_variation.error" @select="findProductSubVariations" v-model="search_product_form.product_variation_id" select-placeholder="Select Variation" search-placeholder="Search variation..."></ComboBox>
                            </div>
                            <div class="mb-4" v-if="show.product_sub_variations">
                                <Label>Sub Variation<span class="text-red-500">*</span></Label>
                                <ComboBox :items="list.product_sub_variations" label-property="option_name" value-property="id" :loading="loading.product_sub_variations" :error="validation.product_sub_variation.error" v-model="search_product_form.product_sub_variation_id" select-placeholder="Select Sub Variation" search-placeholder="Search sub variation..."></ComboBox>
                            </div>
                        </div>
                    </template>
                </Collapsible>
            </template>
            <template #footer>
                <Button @click="addFee">Add</Button>
            </template>
        </Dialog>
        <Dialog v-model:open="show.edit_fee">
            <template #title>Edit Fee</template>
            <template #content>
                <div class="grid grid-cols-1 gap-2">
                    <div class="mb-4" v-for="fee in fee_edit_form.data">
                        <Label>{{ $page.props.class_types_detail.find((item)=>item.id === fee.class_type_detail_id)?.label }}<span class="text-red-500">*</span></Label>
                        <Input type="number" min="0" :error="validation.material_fee.error" v-model="fee.new_fee_amount"></Input>
                    </div>
                </div>
            </template>
            <template #footer>
                <Button @click="updateFee">Save</Button>
            </template>
        </Dialog>
        <DeleteConfirmation :open="confirmation.is_open" @close="confirmation.is_open = false" :routeName="confirmation.route_name" :id="confirmation.id">
            <template #title>Delete Data</template>
            <template #description>Are you sure want to delete this data?</template>
        </DeleteConfirmation>
    </BreezeAuthenticatedLayout>
</template>



<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { debounce } from 'vue-debounce'
import Card from '@/Components/Card.vue'
import Dialog from '@/Components/DialogModal.vue'
import Collapsible from '@/Components/Collapsible.vue'
import { PlusCircle } from 'lucide-vue-next';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import DeleteConfirmation from '@/Components/DeleteConfirmation.vue';

export default {
    components: {
        Head, Link, Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow, DeleteConfirmation
    },
    mounted(){
        this.$page.props.programme_info.forEach((item)=>{
            this.form.programme_info.push(item)
        })
    },
    data() {
        return {
            levels: Array.from({ length: 10 }, (_, index) => ({
                id: index + 1,
                name: `Level ${index + 1}`
            })),
            collapsible: {
                fee: true,
                material: false,
            },
            confirmation: {
                is_open: false,
                route_name: '',
                id: ''
            },
            form: {
                programme_id: this.$page.props.programme_data ? this.$page.props.programme_data.id  : '',
                programme_country: this.$page.props.programme_data ? this.$page.props.programme_data.country_id : '',
                programme_name: this.$page.props.programme_data ? this.$page.props.programme_data.name  : '',
                progress_report_required: this.$page.props.programme_data ? this.$page.props.programme_data.progress_report_required  : '',
                programme_info: [],
                programme_active: this.$page.props.programme_data ? !!this.$page.props.programme_data.status  : false,
            },
            fee_form: {
                level: '',
                registration_fee: 0,
                material_fee: 0,
                class_type: '',
                fees: [],
            },
            fee_edit_form: {
                new_item: false,
                programme_info_index: '',
                data: [],
            },
            show:{
                add_fee: false,
                edit_fee: false,
                product_variations: false,
                product_sub_variations: false,
                add_tracking_status: false
            },
            list:{
                products: [],
                product_variations: [],
                product_sub_variations: [],
                class_types_detail: [],
            },
            loading:{
                products: false,
                product_variations: false,
                product_sub_variations: false,
            },
            selected:{
                product: [],
                product_variation: [],
                product_sub_variation: []
            },
            search_product_form: {
                product_id: '',
                product_variation_id: '',
                product_sub_variation_id: '',
            },
            validation:{
                level: {
                    required: true,
                    error: false
                },
                registration_fee: {
                    required: true,
                    error: false
                },
                material_fee: {
                    required: true,
                    error: false
                },
                class_type: {
                    required: true,
                    error: false
                },
                product: {
                    required: false,
                    error: false
                },
                product_variation: {
                    required: false,
                    error: false
                },
                product_sub_variation: {
                    required: false,
                    error: false
                },
            }
        }
    },
    watch: {
        'fee_form.class_type': {
            handler(){
                this.list.class_types_detail = []
                this.fee_form.fees = []
                this.$page.props.class_types_detail.forEach((class_type_detail)=>{
                    if(class_type_detail.class_type_id == this.fee_form.class_type){
                        this.list.class_types_detail.push(class_type_detail)
                        this.fee_form.fees.push({class_type_detail_id: class_type_detail.id, value: 1, new_fee_amount: 1})
                    }
                })
            },
            deep: true
        },
        'search_product_form.product_id': {
            handler(){
                if(this.search_product_form.product_id){
                    this.selected.product = this.list.products.find(item => item.id === this.search_product_form.product_id)
                    this.show.product_variations                        =   this.selected.product.has_variation == 1 ? true : false
                    this.show.product_sub_variations                    =   this.selected.product.has_sub_variation == 1 ? true : false
                    this.search_product_form.product_variation_id       =   ''
                    this.search_product_form.product_sub_variation_id   =   ''
                    this.selected.product_variation                     =   []
                    this.selected.product_sub_variation                 =   []
                }
            }
        },
        'search_product_form.product_variation_id': {
            handler(){
                if(this.search_product_form.product_variation_id){
                    this.selected.product_variation = this.list.product_variations.find(item => item.id === this.search_product_form.product_variation_id)
                    this.search_product_form.product_sub_variation_id   =   ''
                    this.selected.product_sub_variation                 =   []
                }
            }
        },
        'search_product_form.product_sub_variation_id': {
            handler(){
                if(this.search_product_form.product_sub_variation_id){
                    this.selected.product_sub_variation = this.list.product_sub_variations.find(item => item.id === this.search_product_form.product_sub_variation_id)
                }
            }
        },
    },  
    computed: {
        groupedItems(){
            return this.form.programme_info.reduce((acc, item) => {
                if (!acc[item.level]) {
                    acc[item.level] = [];
                }
                acc[item.level].push(item);
                return acc;
            }, {}); 
        },
    },
    methods: {
        submit() {
            this.$inertia.post(route('programmes.update'), this.form)
        },
        showAddFee(){
            this.search_product_form.product_id                 =   ''
            this.search_product_form.product_variation_id       =   ''
            this.search_product_form.product_sub_variation_id   =   ''
            this.list.products                                  =   []
            this.list.product_variations                        =   []
            this.list.product_sub_variations                    =   []
            this.selected.product                               =   []
            this.selected.product_variation                     =   []
            this.selected.product_sub_variation                 =   []
            this.show.product_variations                        =   false
            this.show.product_sub_variations                    =   false
            this.validation.product.error                       =   false
            this.validation.product_variation.required          =   false
            this.validation.product_variation.error             =   false
            this.validation.product_sub_variation.required      =   false
            this.validation.product_sub_variation.error         =   false
            this.show.add_fee   =   true
        },
        addFee(){
            this.validation.level.error                     = this.fee_form.level == '' ? true : false
            this.validation.registration_fee.error          = this.fee_form.registration_fee === ''
            this.validation.material_fee.error              = this.fee_form.material_fee === ''
            this.validation.class_type.error                = this.fee_form.class_type == '' ? true : false
            this.validation.product.error                   = this.validation.product.required && !Object.keys(this.selected.product).length ? true : false
            this.validation.product_variation.required      = this.selected.product.has_variation == 1 ? true : false
            this.validation.product_variation.error         = this.selected.product.has_variation == 1 && !Object.keys(this.selected.product_variation).length ? true : false
            this.validation.product_sub_variation.required  = this.selected.product.has_sub_variation == 1 ? true : false
            this.validation.product_sub_variation.error     = this.selected.product.has_sub_variation == 1 && !Object.keys(this.selected.product_sub_variation).length ? true : false

            if(this.validation.product.required && !Object.keys(this.selected.product).length || this.validation.product_variation.required && !Object.keys(this.selected.product_variation).length || this.validation.product_sub_variation.required && !Object.keys(this.selected.product_sub_variation).length){
                return
            }
            if(this.fee_form.level == '' || this.fee_form.registration_fee === ''  || this.fee_form.material_fee === '' || this.fee_form.class_type == '' || this.fee_form.fees.length < 1){
                return
            }
            const fee_items =   this.fee_form.fees
            this.form.programme_info.push({
                'level': this.fee_form.level,
                'registration_fee': this.fee_form.registration_fee,
                'material_fee': this.fee_form.material_fee,
                'class_type': this.fee_form.class_type,
                'fees': fee_items,
                'product': this.selected.product,
                'product_variation': this.selected.product_variation,
                'product_sub_variation': this.selected.product_sub_variation,
            })
            this.form.programme_info.sort((firstItem, secondItem)=>firstItem.level - secondItem.level)
            this.clearForm()
            this.show.add_fee = false
        },
        deleteLevel(programme_level_id, index){
            if(!programme_level_id){
                this.form.programme_info.splice(index, 1)
                return
            }
            this.confirmation.route_name    = 'programmes.fee.destroy'
            this.confirmation.id            = programme_level_id
            this.confirmation.is_open       = true
        },
        numbersOnly (evt){
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();;
            } else {
                return true;
            }
        },
        clearForm(){
            this.fee_form.level = ''
            this.fee_form.registration_fee = 0
            this.fee_form.material_fee = 0
            this.fee_form.class_type = ''
            this.fee_form.fees = []
        },
        findProducts(query){
            if(query){
                this.loading.products = true
                axios.get(route('products.find_products'), {
                    params: {
                        'keyword': query
                    }
                })
                .then((res) => {
                    this.list.products = res.data
                    this.loading.products = false
                })
                .finally(()=>{
                    this.scrollToEnd()
                })
            }
        },
        findProductVariations(){
            this.loading.product_variations = true
            axios.get(route('products.find_product_variations'), {
                params: {
                    'product_id': this.search_product_form.product_id
                }
            })
            .then((res) => {
                this.list.product_variations = res.data
                this.loading.product_variations = false
            })
            .finally(()=>{
                this.scrollToEnd()
            });
        },
        findProductSubVariations(){
            this.loading.product_sub_variations = true
            axios.get(route('products.find_product_sub_variations'), {
                params: {
                    'product_variation_id': this.search_product_form.product_variation_id
                }
            })
            .then((res) => {
                this.list.product_sub_variations = res.data
                this.loading.product_sub_variations = false
            })
            .finally(()=>{
                this.scrollToEnd()
            });
        },
        scrollToEnd() {
            setTimeout(() => {
                    const div = this.$refs.scrollableDiv;
                    div.scrollTop = div.scrollHeight;
            }, 10);

        },
        editFee(level, index, new_item){
            this.fee_edit_form.new_item             = new_item
            this.fee_edit_form.programme_info_index = index
            this.fee_edit_form.data                 = []
            this.fee_edit_form.data                 = this.groupedItems[level][index].fees
            this.show.edit_fee                      = true
        },
        updateFee(){
            if(!this.fee_edit_form.new_item){
                this.$inertia.patch(route('programmes.fee.update'), {'fee_edit_form': this.fee_edit_form}, {preserveState: false});
            }
            else{
                this.form.programme_info[this.fee_edit_form.programme_info_index].fees = []
                this.form.programme_info[this.fee_edit_form.programme_info_index].fees = this.fee_edit_form.data
                this.show.edit_fee  = false
            }
        }
    },
}
</script>
