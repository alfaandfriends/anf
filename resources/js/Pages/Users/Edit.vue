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
                            <Label>Email</Label>
                        </div>
                        <Input class="mt-0.5" type="email" :error="$page.props.errors.email" v-model="form.email" disabled></Input>
                    </div>
                    <div class="flex flex-col justify-end">
                        <div class="flex justify-between">
                            <Label>Username</Label>
                        </div>
                        <Input class="mt-0.5" type="text" :error="$page.props.errors.username" v-model="form.username" disabled></Input>
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
                    <div v-for="role in $page.props.roles" :key="role.id">
                        <template v-if="hasPermission(role.permission)">
                            <Label :id="role.id" class="flex items-center space-x-1 cursor-pointer">
                                <Checkbox class="mr-1" :id="role.id" :value="role.id" :checked="verifyChecked(role.id)" v-model="selected_roles"/>
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
                            <TableCell>{{ $page.props.gender_list.find((item) => item.id == children.gender_id).name }}</TableCell>
                            <TableCell>{{ moment(children.date_of_birth).format('DD/MM/Y') }}</TableCell>
                            <TableCell class="text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <Button variant="outline" @click="!processing ? editChild(children.id) : ''" v-if="$page.props.can.edit_child">Edit</Button>
                                    <Button variant="destructive" @click="!processing ? deleteChild(children.id) : ''" v-if="$page.props.can.delete_child">Delete</Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Card>
            <template #content>
                <div class="flex items-center justify-between">
                    <Button variant="destructive" @click="resetPassword($page.props.user_info.user_id)">Reset Password</Button>
                    <div class="flex space-x-2">
                        <Button variant="outline" @click="$inertia.get(route('users'))">Cancel</Button>
                        <Button @click="submit">Save</Button>
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
                        <Input type="text" :error="!!$page.props.errors.name" v-model="child_form.name"></Input>
                    </div>
                    <div>
                        <Label>Gender<span class="text-red-500">*</span></Label>
                        <ComboBox :items="$page.props.gender_list" label-property="name" value-property="id" :error="!!$page.props.errors.gender" v-model="child_form.gender" select-placeholder="Select Gender" search-placeholder="Search gender..."></ComboBox>
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
        <Dialog v-model:open="show.edit">
            <template #title>Edit Child</template>
            <template #content>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <Label>Name<span class="text-red-500">*</span></Label>
                        <Input type="text" :error="!!$page.props.errors.edit_name" v-model="editForm.edit_name"></Input>
                    </div>
                    <div>
                        <Label>Gender<span class="text-red-500">*</span></Label>
                        <ComboBox :items="$page.props.gender_list" label-property="name" value-property="id" :error="!!$page.props.errors.edit_gender" v-model="editForm.edit_gender" select-placeholder="Select Gender" search-placeholder="Search gender..."></ComboBox>
                    </div>
                    <div>
                        <Label>Date of Birth<span class="text-red-500">*</span></Label>
                        <Datepicker mode="date" v-model="editForm.edit_dob"/>
                    </div>
                </div>
            </template>
            <template #footer>
                <Button variant="outline" @click="show.edit = false">Cancel</Button>
                <Button @click="updateChild">Save</Button>
            </template>
        </Dialog>
        <DeleteConfirmation :open="confirmation.delete_child.is_open" @close="confirmation.delete_child.is_open = false" :routeName="confirmation.delete_child.route_name" :id="confirmation.delete_child.id">
            <template #title>Delete Child</template>
            <template #description>Are you sure want to delete this child?</template>
        </DeleteConfirmation>
        <DeleteConfirmation :open="confirmation.reset_password.is_open" @close="confirmation.reset_password.is_open = false" :routeName="confirmation.reset_password.route_name" :id="confirmation.reset_password.id">
            <template #title>Reset Password</template>
            <template #description>Are you sure want to reset this user's password?</template>
        </DeleteConfirmation>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import moment from 'moment'
import Card from '@/Components/Card.vue'
import Dialog from '@/Components/DialogModal.vue'
import { PlusCircle } from 'lucide-vue-next';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import DeleteConfirmation from '@/Components/DeleteConfirmation.vue';

export default {
    components: {
        Head, Link, DeleteConfirmation
    },
    created(){
        var selected_roles      = this.selected_roles
        Object.keys(this.$page.props.user_roles).forEach(function(role_id){
            selected_roles.push(parseInt(role_id))
        })
    },
    data(){
        return{
            show: {
                add: false,
                edit: false,
                delete: false,
                reset_password: false,
            },
            confirmation: {
                delete_child: {
                    is_open: false,
                    route_name: '',
                    id: ''
                },
                reset_password: {
                    is_open: false,
                    route_name: '',
                    id: ''
                },
            },
            processing: false,
            selected_roles: [],
            state_list: [],
            form: {
                email: this.$page.props.user_info ? this.$page.props.user_info.user_email : '',
                username: this.$page.props.user_info ? this.$page.props.user_info.user_login : '',
                full_name: this.$page.props.user_info ? this.$page.props.user_info.display_name : '',
                calling_code: this.$page.props.user_info ? this.$page.props.user_info.calling_code : '',
                contact_number: this.$page.props.user_info ? this.$page.props.user_info.user_contact : '',
                address: this.$page.props.user_info ? this.$page.props.user_info.user_address : '',
                country_id: this.$page.props.user_info ? this.$page.props.user_info.user_country_id : '',
                country_state: this.$page.props.user_info ? this.$page.props.user_info.user_state : '',
                country_code: this.$page.props.user_info ? this.$page.props.user_info.country_code : '',
                children: this.$page.props.children ? this.$page.props.children : [],
            },
            child_form: {
                parent_id: '',
                name: '',
                gender: '',
                dob: ''
            },
            editForm:{
                edit_child_id: '',
                edit_name: '',
                edit_gender: '',
                edit_dob: '',
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
        submit(){
            this.$inertia.post(this.route('users.update'), {'user_id': this.$page.props.user_info.user_id, 'selected_roles': this.selected_roles, 'form': this.form});
        },
        resetPassword(userID){
            this.confirmation.reset_password.route_name    = 'users.reset_user_password'
            this.confirmation.reset_password.id            = userID
            this.confirmation.reset_password.is_open       = true
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
        addChild() {
            this.child_form.parent_id = this.$page.props.user_info.user_id
            this.$inertia.post(route('children.store'), this.child_form, {
                preserveScroll: true,
                preserveState: false
            })
        },
        updateChild() {
            this.$inertia.post(route('children.update'), this.editForm, {
                preserveScroll: true,
                preserveState: false,
                onSuccess: page => {
                    this.show.edit   =   false
                }
            })
        },
        deleteChild(child_id){
            this.confirmation.delete_child.route_name    = 'children.destroy'
            this.confirmation.delete_child.id            = child_id
            this.confirmation.delete_child.is_open       = true
        },
        editChild(child_id){
            this.processing = true
            axios.get(route('children.edit'), {
                params: {
                    'child_id': child_id
                }
            })
            .then((res) => {
                this.editForm.edit_child_id =   child_id
                this.editForm.edit_name     =   res.data.name
                this.editForm.edit_gender   =   res.data.gender_id
                this.editForm.edit_dob      =   res.data.date_of_birth
                this.show.edit              =   true
                this.processing = false
            });
        },
        hasPermission(permissionKey) {
            return this.$page.props.can.hasOwnProperty(permissionKey) && this.$page.props.can[permissionKey];
        },
        verifyChecked(role_id){
            return this.selected_roles.includes(role_id)
        }
    }
}
</script>
