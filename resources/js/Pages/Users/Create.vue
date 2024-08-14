<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Users" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <Card>
            <template #title>User Information</template>
            <template #content>
                <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-4 gap-4">
                    <div class="flex flex-col justify-end">
                        <div class="flex justify-between">
                            <Label>Email<span class="text-red-500">*</span></Label>
                            <Label class="text-xs font-medium text-indigo-600" v-if="checking_email"> Checking Email...</Label>
                            <Label class="text-xs font-medium text-red-600" v-if="form.email != '' & !email_valid"> Invalid Email </Label>
                            <Label class="text-xs font-medium" v-if="!checking_email && form.email !='' & email_valid" :class="email_exist ? 'text-red-700' : 'text-green-700'"> {{ email_exist ? 'Email address has been used.' : 'Email address is available.'}} </Label>
                        </div>
                        <Input class="mt-0.5" type="email" :error="$page.props.errors.email" v-model="form.email" v-debounce:800ms="checkEmailExist" @keyup="checkEmail()"></Input>
                    </div>
                    <div class="flex flex-col justify-end">
                        <div class="flex justify-between">
                            <Label>Username<span class="text-red-500">*</span></Label>
                            <Label class="text-xs font-medium text-indigo-600" v-if="checking_username"> Checking Username...</Label>
                            <Label class="text-xs font-medium" v-if="!checking_username && form.username !=''" :class="username_exist ? 'text-red-700' : 'text-green-700'"> {{ username_exist ? 'Username has been taken.' : 'Username is available.'}} </Label>
                        </div>
                        <Input class="mt-0.5" type="text" :error="$page.props.errors.username" v-model="form.username" v-debounce:800ms="checkUsernameExist" @keyup="checkUsername()"></Input>
                    </div>
                    <div>
                        <Label>Full Name<span class="text-red-500">*</span></Label>
                        <Input type="text" :error="$page.props.errors.full_name" v-model="form.full_name"></Input>
                    </div>
                    <div>
                        <Label>Country<span class="text-red-500">*</span></Label>
                        <ComboBox :items="$page.props.countries" label-property="name" value-property="id" :error="$page.props.errors.country_id" v-model="form.country_id" select-placeholder="Select Country" search-placeholder="Search country..." @select="clearState()"></ComboBox>
                        <input type="hidden" v-model="form.country">
                    </div>
                    <div>
                        <Label>State<span class="text-red-500">*</span></Label>
                        <ComboBox :items="state_list" label-property="name" value-property="id" :error="$page.props.errors.country_state" v-model="form.country_state" select-placeholder="Select State" search-placeholder="Search state..." :loading="loading.state"></ComboBox>
                    </div>
                    <div class="xl:col-span-2 2xl:col-span-2">
                        <Label>Address<span class="text-red-500">*</span></Label>
                        <Input type="text" :error="$page.props.errors.address" v-model="form.address"></Input>
                    </div>
                    <div>
                        <Label>Contact Number<span class="text-red-500">*</span></Label>
                        <Input type="number" :inputGroup="form.calling_code" :error="$page.props.errors.contact_number" v-model="form.contact_number"/>
                    </div>
                </div>
            </template>
        </Card>
        <Card v-if="$page.props.can.view_user_roles">
            <template #title>Roles Information</template>
            <template #content>
                <div class="flex flex-col 2xl:flex-row 2xl:flex-wrap gap-4">
                    <div v-for="role in roles" :key="role.id">
                        <template v-if="hasPermission(role.permission)">
                            <Label :id="role.id" class="flex items-center space-x-1 cursor-pointer">
                                <Checkbox class="mr-1" :id="role.id" :value="role.id" :checked="verifyChecked(role.id)" v-model="form.selected_roles"/>
                                {{ role.display_name }}
                            </Label>
                        </template>
                    </div>
                </div>
            </template>
        </Card>
        <Card v-if="$page.props.can.create_child || $page.props.can.view_child">
            <template #title>
                <div class="flex justify-between items-center">
                    Children Information
                    <Button @click="show.add = true" v-if="$page.props.can.create_child">
                        <PlusCircle class="h-4 w-4" />
                        <span class="ml-1 hidden sm:block">Add Child</span>
                    </Button>
                </div>
            </template>
            <template #content>
                <Table class="px-4" v-if="$page.props.can.view_child">
                    <TableHeader class="bg-gray-100">
                        <TableRow>
                            <TableHead class="px-4">Name</TableHead>
                            <TableHead>Gender</TableHead>
                            <TableHead>Date of Birth</TableHead>
                            <TableHead class="text-center">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!form.children.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="children, index in form.children">
                            <TableCell class="px-4">{{ children.name }}</TableCell>
                            <TableCell>{{ $page.props.gender_list.find((item) => item.id == children.gender).name }}</TableCell>
                            <TableCell>{{ moment(children.dob).format('DD/MM/Y') }}</TableCell>
                            <TableCell class="text-center">
                                <Button variant="destructive" @click="deleteChild(index)">Delete</Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Card>
            <template #content>
                <div class="flex items-center justify-end">
                    <div class="flex space-x-2">
                        <Button variant="outline" @click="$inertia.get(route('users'))">Cancel</Button>
                        <Button @click="submit">Register</Button>
                    </div>
                </div>
            </template>
        </Card>
        <Dialog v-model:open="show.add">
            <template #title>Add Child</template>
            <template #content>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <Label>Full Name<span class="text-red-500">*</span></Label>
                        <Input type="text" :error="$page.props.errors.child_name" v-model="child_form.name"></Input>
                    </div>
                    <div>
                        <Label>Gender<span class="text-red-500">*</span></Label>
                        <ComboBox :items="$page.props.gender_list" label-property="name" value-property="id" :error="$page.props.errors.gender" v-model="child_form.gender" select-placeholder="Select Gender" search-placeholder="Search gender..."></ComboBox>
                    </div>
                    <div>
                        <Label>Date of Birth<span class="text-red-500">*</span></Label>
                        <Datepicker mode="date" v-model="child_form.dob"/>
                    </div>
                </div>
            </template>
            <template #footer>
                <Button variant="outline" @click="show.add = false">Cancel</Button>
                <Button @click="addChild">Add</Button>
            </template>
        </Dialog>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import moment from 'moment'
import { debounce } from 'vue-debounce'
import Card from '@/Components/Card.vue'
import Dialog from '@/Components/DialogModal.vue'
import { PlusCircle } from 'lucide-vue-next';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'

export default {
    components: {
        Head, Link, Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow,
    },
    props: {
        roles: Object
    },
    data(){
        return{
            show: {
                add: false,
            },
            state_list: [],
            email_exist: false,
            email_valid: false,
            checking_email: false,
            username_exist: false,
            checking_username: false,
            form: {
                email: '',
                username: '',
                full_name: '',
                country_id: '',
                country_code: '',
                calling_code: '',
                contact_number: '',
                state: '',
                address: '',
                selected_roles: [],
                children: []
            },
            child_form: {
                name: '',
                gender: '',
                dob: ''
            },
            loading:{
                country: false,
                state: false
            },
        }
    },
    watch: {
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
        checkEmail(){
            this.checking_email = false
            if(this.form.email){
                this.isValidEmail()
                if(this.email_valid){
                    this.checking_email = true
                }
            }
        },
        checkUsername(){
            this.checking_username = false
            if(this.form.username){
                this.checking_username = true
            }
        },
        isValidEmail() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            this.email_valid = emailRegex.test(this.form.email);
        },
        checkEmailExist(){
            axios.get('/api/find-email/' + this.form.email)
                .then(response => {
                    if(response.data.length != 0){
                        this.email_exist = true
                    }
                    else{
                        this.email_exist = false
                    }
                    this.checking_email = false
                })
        },
        checkUsernameExist(){
            axios.get('/api/find-username/' + this.form.username)
                .then(response => {
                    if(response.data.length != 0){
                        this.username_exist = true
                    }
                    else{
                        this.username_exist = false
                    }
                    this.checking_username = false
                })
        },
        setCountryData(country_id){
            this.loading.state = true
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
        submit() {
            this.$inertia.post(route('users.store'), this.form, { preserveState: true})
        },
        addChild(){
            this.form.children.push({
                name: this.child_form.name,
                gender: this.child_form.gender,
                dob: this.child_form.dob
            })
            this.child_form.name = ''
            this.child_form.gender = ''
            this.child_form.dob = ''
            this.show.add = false
        },
        deleteChild(index){
            this.form.children.splice(index, 1)
        },
        hasPermission(permissionKey) {
            return this.$page.props.can.hasOwnProperty(permissionKey) && this.$page.props.can[permissionKey];
        },
        verifyChecked(role_id){
            return this.form.selected_roles.includes(role_id)
        }
    }

}
</script>
