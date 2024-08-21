<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Orders" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <Card>
            <template #title>Order Information</template>
            <template #content>
                <div class="grid grid-cols-1 2xl:grid-cols-3 gap-4">
                    <div>
                        <Label>Student's Name<span class="text-red-500">*</span></Label>
                        <ComboBox :items="list.students" label-property="name" value-property="id" :error="!!$page.props.errors.student_id" v-model="form.student_id" :select-placeholder="$page.props.order_info.student_name" search-placeholder="Search student..." disabled/>
                    </div>
                    <div>
                        <Label>Address<span class="text-red-500">*</span></Label>
                        <Textarea v-model="form.address" disabled></Textarea>
                    </div>
                    <div>
                        <Label>Status<span class="text-red-500">*</span></Label>
                        <ComboBox :items="$page.props.status" label-property="name" value-property="id" v-model="form.status" search-placeholder="Search status..."></ComboBox>
                    </div>
                </div>
            </template>
        </Card>
        <Card>
            <template #title>
                <div class="flex justify-between items-center">
                    Product Information
                    <Button @click="showAddOrder">
                        <PlusCircle class="h-4 w-4" />
                        <span class="ml-1 hidden sm:block">Add Product</span>
                    </Button>
                </div>  
            </template>
            <template #content>
                <Table class="px-4">
                    <TableHeader class="bg-gray-100">
                        <TableRow>
                            <TableHead class="px-4">#</TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead>Variation</TableHead>
                            <TableHead>Sub Variation</TableHead>
                            <TableHead class="text-center">Quantity</TableHead>
                            <TableHead class="text-center">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!form.products.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="product, index in form.products">
                            <TableCell class="px-4">{{ index+1 }}</TableCell>
                            <TableCell>{{ product.product.name }}</TableCell>
                            <TableCell>{{ product.product_variation.option_name ? product.product_variation.option_name : '-' }}</TableCell>
                            <TableCell>{{ product.product_sub_variation.option_name ? product.product_sub_variation.option_name : '-' }}</TableCell>
                            <TableCell>
                                <div class="flex justify-center">
                                    <NumberField v-model="product.quantity"></NumberField>
                                </div>
                            </TableCell>
                            <TableCell class="text-center">
                                <Button variant="destructive" @click="deleteItem(index)">Delete</Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Card>
            <template #title>Tracking Information</template>
            <template #content>
                <div class="grid grid-cols-1 2xl:grid-cols-2 gap-4">
                    <div>
                        <Label>Shipping Provider</Label>
                        <ComboBox :items="$page.props.shipping_providers" label-property="name" value-property="id" v-model="form.shipping_provider" select-placeholder="Select Shipping Provider" search-placeholder="Search shipping provider..."></ComboBox>
                    </div>
                    <div>
                        <Label>Tracking Number</Label>
                        <Input type="text" v-model="form.tracking_number" placeholder="e.g. AA987654321BB"></Input>
                    </div>
                </div>
            </template>
        </Card>
        <Card>
            <template #title>
                <div class="flex justify-between items-center">
                    Delivery Status
                    <Button @click="showTrackingStatus">
                        <PlusCircle class="h-4 w-4" />
                        <span class="ml-1 hidden sm:block">Add Status</span>
                    </Button>
                </div>  
            </template>
            <template #content>
                <Table class="px-4">
                    <TableHeader class="bg-gray-100">
                        <TableRow>
                            <TableHead class="px-4">#</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead class="text-center">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!form.tracking_status.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="status, index in form.tracking_status">
                            <TableCell class="px-4">{{ index+1 }}</TableCell>
                            <TableCell>{{ status.name }}</TableCell>
                            <TableCell class="text-center">
                                <Button variant="destructive" @click="deleteStatus(index)">Delete</Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Card>
            <template #content>
                <div class="flex justify-end space-x-2">
                    <Button variant="outline" @click="$inertia.get(route('orders'))">Cancel</Button>
                    <Button @click="storeOrder">Save</Button>
                </div>
            </template>
        </Card>
        <Dialog v-model:open="show.add_order">
            <template #title>Add Product</template>
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
            <template #footer>
                <Button variant="outline" @click="show.add_order = false">Cancel</Button>
                <Button @click="addProduct">Add</Button>
            </template>
        </Dialog>
        <Dialog v-model:open="show.add_tracking_status">
            <template #title>Add Status</template>
            <template #content>
                <div class="py-0.5">
                    <Textarea v-model="tracking_status_input" rows="3" placeholder="E.g. Order status changed from Processing to Shipped."></Textarea>
                </div>
            </template>
            <template #footer>
                <Button variant="outline" @click="show.add_tracking_status = false">Cancel</Button>
                <Button @click="addStatus">Add</Button>
            </template>
        </Dialog>
    </BreezeAuthenticatedLayout>
</template>


<script>
import moment from 'moment'
import { Head, Link } from '@inertiajs/inertia-vue3';
import { debounce } from 'vue-debounce'
import Card from '@/Components/Card.vue'
import Dialog from '@/Components/DialogModal.vue'
import { PlusCircle } from 'lucide-vue-next';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import NumberField from '@/Components/NumberField.vue';

export default {
    components: {
        Head, Link, Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow,
    },
    data(){
        return{
            tracking_status_input: '',
            show:{
                add_order: false,
                product_variations: false,
                product_sub_variations: false
            },
            list:{
                students: [],
                products: [],
                product_variations: [],
                product_sub_variations: [],
            },
            loading:{
                students: false,
                products: false,
                product_variations: false,
                product_sub_variations: false,
            },
            form:{
                order_id: this.$page.props.order_info ? this.$page.props.order_info.order_id : '',
                student_id: this.$page.props.order_info ? this.$page.props.order_info.student_id : '',
                address: this.$page.props.order_info ? this.$page.props.order_info.address : '',
                shipping_provider: this.$page.props.order_info && this.$page.props.order_info.shipping_provider_id ? this.$page.props.order_info.shipping_provider_id : '',
                tracking_number: this.$page.props.order_info ? this.$page.props.order_info.tracking_number : '',
                status: this.$page.props.order_info ? this.$page.props.order_info.status_id : '',
                products: this.$page.props.order_info ? JSON.parse(this.$page.props.order_info.products) : [],
                tracking_status: this.$page.props.order_info.tracking_status ? JSON.parse(this.$page.props.order_info.tracking_status) : []
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
                product: {
                    required: true,
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
        'form.products': {
            handler(){
                this.form.products.forEach(item=>{
                    if(item.quantity < 1){
                        item.quantity = 1
                    }
                })
            },
            deep: true
        }
    },
    methods: {
        showAddOrder(){
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
            this.show.add_order = true
        },
        showTrackingStatus(){
            this.tracking_status_input = ''
            this.show.add_tracking_status = true
        },
        clearStudents(){
            this.list.students = []
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
                });
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
            });
        },
        addProduct(){
            this.validation.product.error       = !Object.keys(this.selected.product).length ? true : false

            this.validation.product_variation.required      = this.selected.product.has_variation == 1 ? true : false
            this.validation.product_variation.error         = this.selected.product.has_variation == 1 && !Object.keys(this.selected.product_variation).length ? true : false
            this.validation.product_sub_variation.required  = this.selected.product.has_sub_variation == 1 ? true : false
            this.validation.product_sub_variation.error     = this.selected.product.has_sub_variation == 1 && !Object.keys(this.selected.product_sub_variation).length ? true : false

            if(this.validation.product.required && !Object.keys(this.selected.product).length || this.validation.product_variation.required && !Object.keys(this.selected.product_variation).length || this.validation.product_sub_variation.required && !Object.keys(this.selected.product_sub_variation).length){
                return
            }
            this.form.products.push({
                product: this.selected.product,
                product_variation: this.selected.product_variation,
                product_sub_variation: this.selected.product_sub_variation,
                quantity: 1,
            })
            this.show.add_order = false
        },
        addStatus(){
            this.form.tracking_status.push({
                name: this.tracking_status_input,
                datetime: moment(),
            })
            this.show.add_tracking_status = false
        },
        increaseQuantity(index){
            if(this.form.products[index].quantity < 1000){
                this.form.products[index].quantity+=1
            }
        },
        decreaseQuantity(index){
            if(this.form.products[index].quantity > 1){
                this.form.products[index].quantity-=1
            }
        },
        deleteItem(index){
            this.form.products.splice(index, 1)
        },
        deleteStatus(index){
            this.form.tracking_status.splice(index, 1)
        },
        storeOrder(){
            this.$inertia.post(route('orders.update'), this.form)
        }
    }
}
</script>
