<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Students" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="grid grid-cols-1 gap-2">
            <Alert class="bg-sky-200 text-slate-900 mb-3">
                <RocketIcon class="h-4 w-4" />
                <AlertTitle class="font-semibold">Heads up!</AlertTitle>
                <AlertDescription>
                    Select a different programme and choose classes after adding a new programme if you want to include multiple programmes.
                </AlertDescription>
            </Alert>
            <Collapsible class=" bg-white" v-model="open.student_info">
                <template #trigger>Admission Information</template>
                <template #content>
                    <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-4 gap-4 p-3">
                        <div>
                            <Label>Child Name<span class="text-red-500">*</span></Label>
                            <ComboBox :items="list.students" label-property="name" value-property="id" @search="findChildren" v-model="form.children_id" select-placeholder="Select Child" search-placeholder="Enter some characters to search name..." :loading="searching.student" :error="errors.child"></ComboBox>
                        </div>
                        <div>
                            <Label>Centre<span class="text-red-500">*</span></Label>
                            <ComboBox :items="$page.props.allowed_centres" label-property="label" value-property="ID" v-model="form.centre_id" select-placeholder="Select Centre" search-placeholder="Search centre..." :error="errors.centre"></ComboBox>
                        </div>
                        <div>
                            <Label>Start Date<span class="text-red-500">*</span></Label>
                            <Datepicker mode="date" :format="'dd/MM/yyyy'" v-model="form.date_admission" disabled/>
                        </div>
                        <div>
                            <Label>Programme<span class="text-red-500">*</span></Label>
                            <ComboBox :items="$page.props.programme_list" label-property="name" value-property="id" v-model="search_form.programme_id" select-placeholder="Select Programme" search-placeholder="Search programme..." :error="errors.programme">
                                <template #label="{ item }">
                                    <span class="font-normal">{{ item.name + " (" + item.country_name + ")" }}</span>
                                </template>
                            </ComboBox>
                        </div>
                        <div>
                            <Label>Class Type<span class="text-red-500">*</span></Label>
                            <ComboBox :items="list.class_types" label-property="name" value-property="id" v-model="search_form.class_type" select-placeholder="Select Class Type" search-placeholder="Search class type..." :disabled="disable.class_type" :error="errors.class_type"></ComboBox>
                        </div>
                        <div>
                            <Label>Class Level<span class="text-red-500">*</span></Label>
                            <ComboBox :items="list.class_levels" label-property="level" value-property="level" v-model="search_form.class_level" select-placeholder="Select Class Level" search-placeholder="Search class leel..." :disabled="disable.class_levels" :error="errors.level"></ComboBox>
                        </div>
                        <div>
                            <Label>Class Method<span class="text-red-500">*</span></Label>
                            <ComboBox :items="$page.props.method_list" label-property="name" value-property="id" v-model="search_form.class_method" select-placeholder="Select Class Method" search-placeholder="Search class method..." :error="errors.class_method"></ComboBox>
                        </div>
                        <div class="self-end">
                            <Button @click="findClasses">Search Classes</Button>
                        </div>
                    </div>
                </template>
            </Collapsible>
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-2">
                <div ref="available_classes">
                    <Collapsible class="bg-white" v-model="open.student_classes">
                        <template #trigger>Class Availability</template>
                        <template #content>
                            <template v-if="enable_container.available_classes">
                                <div class="max-h-[26rem] overflow-y-auto">
                                    <Table>
                                        <TableHeader class="bg-gray-100">
                                            <TableRow>
                                                <TableHead class="px-4">#</TableHead>
                                                <TableHead>Day</TableHead>
                                                <TableHead class="text-center">Time</TableHead>
                                                <TableHead class="text-center">Capacity</TableHead>
                                                <TableHead class="text-center">Action</TableHead>
                                            </TableRow>
                                        </TableHeader>
                                        <TableBody>
                                            <TableRow v-if="!searching.class && !list.available_classes.length">
                                                <TableCell class="text-center" colspan="10">
                                                    <div class="p-3">
                                                        No classes available
                                                    </div>
                                                </TableCell>
                                            </TableRow> 
                                            <TableRow v-for="classes, index in list.available_classes">
                                                <!-- <TableCell>{{ $page.props.students.from + index }}</TableCell> -->
                                                <TableCell class="px-4">{{ index + 1 }}</TableCell>
                                                <TableCell>{{ classes.class_day}}</TableCell>
                                                <TableCell class="text-center">
                                                    <span class="pl-2 whitespace-nowrap">{{ moment(classes.start_time).format('h:mm A') }} - {{ moment(classes.end_time).format('h:mm A') }}</span>
                                                </TableCell>
                                                <TableCell class="text-center">{{ classes.capacity}}</TableCell>
                                                <TableCell class="text-center">
                                                    <Checkbox :id="classes.id" :value="classes.id" :checked="checkIfClassSelected(classes.class_id, classes.programme_id)" @click.native="getPlusFee(classes.class_id, classes.class_type, classes.programme_id, classes.programme_level_id)"/>
                                                </TableCell>
                                            </TableRow>
                                        </TableBody>
                                    </Table>
                                </div>
                            </template>
                            <div class="flex justify-center py-2 text-sm" v-if="!enable_container.available_classes && !searching.class && !list.available_classes.length">
                                <span>Please search for classes.</span>
                            </div>
                        </template>
                    </Collapsible>
                </div>
                <div ref="class_fee">
                    <Collapsible class="bg-white" v-model="open.admission_confirmation">
                        <template #trigger>Admission Confirmation</template>
                        <template #content>
                            <div class="grid px-3 divide-y select-none" v-if="form.fee.length">
                                <div class="py-4" v-for="fee, fee_index in form.fee">
                                    <div class="flex justify-between mb-3 font-semibold">
                                        <span class="text-sm">{{ fee.fee_info.programme_name }}</span>
                                        <span class="text-sm">Level {{ fee.fee_info.programme_level }}</span>
                                    </div>
                                    <ul class="grid gap-2 mb-4 text-xs font-semibold">
                                        <li class="flex items-center justify-between">
                                            <span >Centre</span>
                                            <span class="text-slate-600">{{ fee.fee_info.centre_name }}</span>
                                        </li>
                                        <li class="flex items-center justify-between">
                                            <span>Fee</span>
                                            <span class="text-slate-600">{{ fee.fee_info.programme_type }}</span>
                                        </li>
                                        <li class="flex items-center justify-between">
                                            <span>Class Method</span>
                                            <span class="text-slate-600">{{ fee.fee_info.class_method }}</span>
                                        </li>
                                    </ul>
                                    <ul class="grid gap-2 mb-3 text-xs font-semibold">
                                        <li class="flex items-center">
                                            <span class="underline">Timetable</span>
                                        </li>
                                        <li class="flex flex-wrap items-center gap-4">
                                            <span class="text-slate-600 text-xs" v-for="classes in fee.classes" :key="classes.id">{{ classes.class_day }} ({{ moment(classes.start_time).format('h:mm A') }} - {{ moment(classes.end_time).format('h:mm A') }})</span>
                                        </li>
                                    </ul>
                                    <ul class="grid gap-2 mb-3 text-xs font-semibold">
                                        <li class="flex items-center space-x-2">
                                            <span class="underline">Applied Promos</span>
                                            <div @click="showPromoModal(fee_index)" class="font-medium text-indigo-500 cursor-pointer px-1.5 py-0.5 rounded border border-dashed border-indigo-500 bg-white hover:bg-indigo-50 whitespace-nowrap">
                                                Add Promo
                                            </div>
                                        </li>
                                        <li class="font-medium">
                                            <div class="flex flex-wrap gap-2" v-if="fee.fee_info.promos.length">
                                                <span class="flex space-x-2 items-center justify-center rounded-sm bg-indigo-200 px-2.5 py-1 text-indigo-800" v-for="applied_promo, promo_index in fee.fee_info.promos">
                                                    <p class="whitespace-nowrap text-xs">{{ applied_promo.promo_name }}</p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor" @click="deletePromo(fee_index, promo_index)" class="h-3.5 w-3.5 text-red-600 cursor-pointer">
                                                        <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="" v-else>
                                                <span class="text-xs font-semibold text-indigo-500">None</span>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="grid gap-2 mb-3 text-xs font-semibold" v-if="fee.fee_info.registration_fee != 0">
                                        <li class="flex flex-col">
                                            <div class="flex items-center space-x-2">
                                                <Checkbox :id="'registration_fee_' + fee_index" :value="fee.fee_info.include_registration_fee" :checked="fee.fee_info.include_registration_fee" @click.native="fee.fee_info.include_registration_fee = !fee.fee_info.include_registration_fee"/>
                                                <label :for="'registration_fee_' + fee_index" class="cursor-pointer">Registration Fee: {{ fee.fee_info.currency_symbol }}{{ fee.fee_info.registration_fee }}</label>
                                            </div>
                                            <div class="flex items-center space-x-2 pl-6" v-if="fee.fee_info.include_registration_fee">
                                                <span :for="'registration_fee_discount'+fee_index">Discount: </span>
                                                <Input min="0" :id="'registration_fee_discount'+fee_index" type="number" class="text-xs h-6" placeholder="Discount" v-if="fee.fee_info.include_registration_fee && (fee.fee_info.registration_fee && fee.fee_info.registration_fee != 0)" v-model="fee.fee_info.registration_fee_discount"></Input>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="grid gap-2 mb-3 text-xs font-semibold" v-if="fee.fee_info.material_fee != 0">
                                        <li class="flex flex-col">
                                            <div class="flex items-center space-x-2">
                                                <Checkbox :id="'material_fee_' + fee_index" :value="fee.fee_info.include_material_fee" :checked="fee.fee_info.include_material_fee" @click.native="fee.fee_info.include_material_fee = !fee.fee_info.include_material_fee"/>
                                                <label :for="'material_fee_' + fee_index" class="cursor-pointer">Material Fee: {{ fee.fee_info.currency_symbol }}{{ fee.fee_info.material_fee }}</label>
                                            </div>
                                            <div class="flex items-center space-x-2 pl-6" v-if="fee.fee_info.include_material_fee">
                                                <span :for="'material_fee_discount_'+fee_index">Discount: </span>
                                                <Input min="0" :id="'material_fee_discount_'+fee_index" type="number" class="text-xs h-6" placeholder="Discount" v-if="fee.fee_info.include_material_fee && (fee.fee_info.material_fee && fee.fee_info.material_fee != 0)" v-model="fee.fee_info.material_fee_discount"></Input>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="grid gap-2 text-xs font-semibold">
                                        <li class="flex flex-col">
                                            <div class="col-span-2 mt-3">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <Checkbox :id="'old_fee_' + fee_index" :value="fee.fee_info.use_old_fee" :checked="fee.fee_info.use_old_fee" @click.native="fee.fee_info.use_old_fee = !fee.fee_info.use_old_fee"/>
                                                    <label :for="'old_fee_' + fee_index" class="cursor-pointer">Use old fee</label>
                                                </div>
                                                <div class="flex items-center justify-end text-lg space-x-1">
                                                    <span class="font-brown">{{ fee.fee_info.currency_symbol }}{{ calculateTotal(fee_index, fee.fee_info.use_old_fee ? fee.fee_info.old_programme_fee : fee.fee_info.programme_fee) }}</span>
                                                    <span class="font-medium text-sm text-gray-700">/month</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="flex justify-center py-2 text-sm" v-if="!searching.class">
                                <span v-if="!enable_container.available_classes || (enable_container.available_classes && !form.fee.length && !no_fee_found)">No classes have been selected.</span>
                                <span v-if="enable_container.available_classes && !form.fee.length && no_fee_found">Fees are not available for the selected classes.</span>
                            </div>
                        </template>
                    </Collapsible>
                </div>
            </div>
            <Card v-if="form.fee.length">
                <template #content>
                    <div class="flex justify-end space-x-2">
                        <Button variant="outline" @click="$inertia.get(route('students'))">Cancel</Button>
                        <Button @click="admitStudent">Save</Button>
                    </div>
                </template>
            </Card>
        </div>
        <Dialog v-model:open="open_promo_modal">
            <template #title>Add Status</template>
            <template #content>
                <ComboBox :items="$page.props.promos" label-property="promo_name" value-property="promo_id" v-model="selected_promo.promo_id" select-placeholder="Select Promo" search-placeholder="Search promo..."></ComboBox>
            </template>
            <template #footer>
                <Button variant="outline" @click="open_promo_modal = false">Cancel</Button>
                <Button @click="addPromo">Add</Button>
            </template>
        </Dialog>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Collapsible from '@/Components/Collapsible.vue'
import Card from '@/Components/Card.vue'
import { RocketIcon } from '@radix-icons/vue'
import { Alert, AlertDescription, AlertTitle } from '@/Components/ui/alert'
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import Dialog from '@/Components/DialogModal.vue'
import moment from 'moment';
import { debounce } from 'vue-debounce'
import axios from 'axios';


export default {
    components: {
        Head, Link, 
    },
    data(){
        return{
            open_promo_modal: false,
            disable_check_box: false,
            fetching_fee: false,
            no_fee_found: false,
            total_amount: 0,
            open: {
                student_info: true,
                student_classes: false,
                admission_confirmation: false
            },
            errors: {
                child: false,
                centre: false,
                admission_date: false,
                programme: false,
                class_type: false,
                programme: false,
                level: false,
                class_method: false,
            },
            disable: {
                class_type: true,
                class_levels: true,
            },
            list: {
                students: [],
                class_types: [],
                class_levels: [],
                available_classes: [],
            },
            searching: {
                student: false,
                class: false,
                fee: false
            },
            enable_container:{
                available_classes: false,
                show_fee: false,
            },
            search_form:{
                programme_id: '',
                class_type: '',
                class_level: '',
                class_method: '',
            },
            form: {
                date_admission: '',
                children_id: '',
                centre_id: '',
                fee: [],
            },
            selected_promo: {
                promo_id: '',
                fee_index: ''
            },
            selected_plus_class: {}
        }
    },
    watch: {
        'search_form.programme_id': {
            handler(){
                if(this.search_form.programme_id){
                    this.disable.class_type = true
                    this.disable.class_levels = true
                    this.search_form.class_type = ''
                    this.search_form.class_level = ''
                    axios.get(route('classes.get_class_types'), {
                        params: {
                            'programme_id': this.search_form.programme_id,
                        }
                    })
                    .then((response) => {
                        this.list.class_types = response.data
                        this.disable.class_type = false
                    })
                }
            },
            deep: true
        },
        'search_form.class_type': {
            handler(){
                if(this.search_form.programme_id && this.search_form.class_type){
                    this.disable.class_levels = true
                    this.search_form.class_level = ''
                    axios.get(route('classes.get_class_levels'), {
                        params: {
                            'programme_id': this.search_form.programme_id,
                            'class_type': this.search_form.class_type
                        }
                    })
                    .then((response) => {
                        this.list.class_levels = response.data
                        this.disable.class_levels = false
                    })
                }
            },
            deep: true
        },
        'form.fee': {
            handler(){
                this.total_amount = 0;
                this.form.fee.forEach((feeObject) => {
                    const { 
                        include_registration_fee, 
                        registration_fee, 
                        registration_fee_discount, 
                        include_material_fee, 
                        material_fee, 
                        material_fee_discount, 
                        programme_fee, 
                        promos 
                    } = feeObject.fee_info;

                    const registration_fee_amount = include_registration_fee ? Number(registration_fee) : 0;
                    const registration_discount = registration_fee_discount != "" && registration_fee_discount > 0 ? Number(registration_fee_discount) : 0;
                    const material_fee_amount = include_material_fee ? Number(material_fee) : 0;
                    const material_discount = material_fee_discount != "" && material_fee_discount > 0 ? Number(material_fee_discount) : 0;

                    const totalPercentValuePromo = promos.reduce((accumulator, currentValue) => 
                        currentValue.type_id === 1 ? accumulator + currentValue.value : accumulator, 0
                    );
                    const totalFixedValuePromo = promos.reduce((accumulator, currentValue) => 
                        currentValue.type_id === 2 ? accumulator + currentValue.value : accumulator, 0
                    );

                    this.total_amount += Number(programme_fee) - totalFixedValuePromo - (this.total_amount * totalPercentValuePromo / 100) + (Number(registration_fee_amount) - Number(registration_discount)) + (Number(material_fee_amount) - Number(material_discount));
                });
            },
            deep: true
        },
    },
    methods: {
        submit() {
            this.$inertia.post(route('classes.store'), this.form, { preserveState: true})
        },
        findChildren: debounce(function(query) {
            debounce(val => '400ms')(10)
            if(query){
                this.searching.student = true
                axios.get(route('children.find'), {
                    params: {
                        'keyword': query
                    }
                })
                .then((res) => {
                    this.list.students = res.data
                    this.searching.student = false
                });
            }
        }, 1000),
        findClasses(){
            this.errors.child           =   !this.form.children_id ? true : false
            this.errors.centre          =   !this.form.centre_id ? true : false
            this.errors.admission_date  =   !this.form.date_admission ? true : false
            this.errors.programme       =   !this.search_form.programme_id ? true : false
            this.errors.class_type      =   !this.search_form.class_type ? true : false
            this.errors.level           =   !this.search_form.class_level ? true : false
            this.errors.class_method    =   !this.search_form.class_method ? true : false

            if(this.form.children_id && this.form.centre_id && this.search_form.programme_id && this.search_form.class_level && this.search_form.class_type && this.search_form.class_method){
                this.searching.class = true   
                this.enable_container.show_fee = false
                this.list.available_classes = []

                /* If found same programme, delete the old fee */
                this.selected_plus_class[this.search_form.programme_id] = []
                const fee_index =   this.form.fee.findIndex(fee => fee.fee_info.programme_id === this.search_form.programme_id)
                if(fee_index != -1){
                    this.form.fee.splice(fee_index, 1);
                }
                
                axios.get(route('classes.find'), {
                    'params': {
                        'centre_id': this.form.centre_id,
                        'programme_id':  this.search_form.programme_id,
                        'class_method':  this.search_form.class_method,
                        'class_level':  this.search_form.class_level,
                        'class_type':  this.search_form.class_type,
                    }
                })
                .then((res) => {
                    this.list.available_classes = res.data  
                    this.enable_container.available_classes = true,
                    this.searching.class = false
                    this.open.student_info = false
                    this.open.student_classes = true
                    setTimeout(() => {
                        this.scrollToElement('available_classes')
                    }, 300);
                });
            }
        },
        getPlusFee(class_id, class_type, programme_id, programme_level_id){
            if(this.fetching_fee){
                return
            }
            if(this.disable_check_box){
                return
            }

            this.disable_check_box = true

            const checked = this.checkIfClassSelected(class_id, programme_id)

            if(!checked){
                if(!this.selected_plus_class[programme_id]){
                    this.selected_plus_class[programme_id] = []
                }
                this.selected_plus_class[programme_id].push(class_id)
            }
            else{
                if(this.selected_plus_class[programme_id].length == 1){
                    this.selected_plus_class[programme_id] = []
                    this.no_fee_found = false
                }
                this.selected_plus_class[programme_id] = this.selected_plus_class[programme_id].filter(id => id !== class_id);
            }

            // this.form.fee = []
            this.form.fee = this.form.fee.filter(item => item.fee_info.programme_id != programme_id);
            
            if(this.selected_plus_class[programme_id].length){
                this.fetching_fee = true
                axios.get(route('programmes.get_fee'), {
                    'params': {
                        'class_type' : this.search_form.class_type,
                        'class_count': this.selected_plus_class[programme_id].length,
                        'classes': this.selected_plus_class[programme_id],
                        'programme_level_id': programme_level_id
                    }
                })
                .then((res) => {
                    if(res.data.fee_info){
                        this.form.fee.push(res.data)
                    }
                    setTimeout(() => {
                        this.scrollToElement('class_fee')
                    }, 300);
                    this.searching.fee = false
                    this.disable_check_box  = false
                    this.fetching_fee = false
                    this.open.admission_confirmation = true
                })
                .catch((error) => {
                    this.searching.fee = false
                    this.disable_check_box  = false
                    this.fetching_fee = false
                    this.no_fee_found = true
                });
            }
            else{
                this.disable_check_box  = false
            }
        },
        clearStudents(){
            this.list.students = []
        },
        scrollToElement(element) {
            const el = this.$refs[element];
            if (el) {
                el.scrollIntoView({
                    behavior: 'smooth',
                    block: "center",      // Align to the top of the viewport
                    inline: "nearest"    // Horizontal scroll (optional)
                });
            }
        },
        deleteFee(programme_id, class_type){
            this.form.fee           =   this.form.fee.filter(item => item.fee_info.programme_id !== programme_id);
            if(class_type == 2){
                if (this.selected_plus_class.hasOwnProperty(programme_id)) {
                    delete this.selected_plus_class[programme_id];
                }
            }
        },
        admitStudent(){
            this.$inertia.post(route('students.store'), this.form)
        },
        checkIfClassSelected(class_id, programme_id){
            const classExists = this.selected_plus_class[programme_id] ? this.selected_plus_class[programme_id].includes(class_id) : false
            return classExists
        },
        sumMaterialFee(has_material_fee, material_fee, programme_fee){
            return has_material_fee ? Number(material_fee) + Number(programme_fee) : Number(programme_fee)
        },
        showPromoModal(fee_index){
            this.selected_promo.promo_id    =   ''
            this.selected_promo.fee_index   =   fee_index   
            this.open_promo_modal           =   true
        },
        addPromo(){
            const selectedPromo = this.$page.props.promos.find(promo => promo.promo_id === this.selected_promo.promo_id);
            const promoAdded    = this.form.fee[this.selected_promo.fee_index].fee_info.promos.find(promo => promo.promo_id === this.selected_promo.promo_id);
            
            if (!promoAdded && selectedPromo) {
                this.form.fee[this.selected_promo.fee_index].fee_info.promos.push({
                    promo_id: parseInt(selectedPromo.promo_id),
                    promo_name: selectedPromo.promo_name,
                    type_id: parseInt(selectedPromo.type_id),
                    type_name: selectedPromo.type_name,
                    value: parseInt(selectedPromo.value),
                    duration_id: parseInt(selectedPromo.type_id),
                    duration_name: selectedPromo.duration_name,
                    duration_count: parseInt(selectedPromo.duration_count),
                    duration_remaining: parseInt(selectedPromo.duration_count)
                });
            }

            this.open_promo_modal = false
        },
        deletePromo(fee_index, promo_index){
            this.form.fee[fee_index].fee_info.promos.splice(promo_index, 1);
        },
        calculateTotal(fee_index, fee_amount){
            const totalPercentValuePromo = this.form.fee[fee_index].fee_info.promos.reduce((accumulator, currentValue) => 
                currentValue.type_id === 1 ? accumulator + currentValue.value : accumulator
            , 0);
            const totalFixedValuePromo = this.form.fee[fee_index].fee_info.promos.reduce((accumulator, currentValue) => 
                currentValue.type_id === 2 ? accumulator + currentValue.value : accumulator
            , 0);
            return fee_amount - totalFixedValuePromo - (fee_amount * totalPercentValuePromo / 100)
        },
    },
    mounted(){
        const now = new Date();
        const dateString = now.toISOString().substring(0, 10);
        this.form.date_admission = `${dateString}T05:59:00.000Z`;
    }
}
</script>