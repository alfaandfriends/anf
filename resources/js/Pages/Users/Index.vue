<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Users" />

    <BreezeAuthenticatedLayout>
        <!-- <template #header></template> -->
        <div class="flex items-center justify-between">
            <div class="relative">
                <MagnifyingGlassIcon class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
                <Input type="text" placeholder="Search" class="w-full rounded-lg bg-background pl-8 md:w-[200px] lg:w-[336px]" v-debounce:800ms="search" v-model="params.search"/>
            </div>
            <Button @click="$inertia.get(route('users.create'))" v-if="$page.props.can.create_users">
                <PlusCircle class="h-4 w-4" />
                <span class="ml-1 hidden sm:block">New User</span>
            </Button>
        </div>
        <Card>
            <template #content>
                <Table>
                    <TableHeader class="bg-gray-100">
                        <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Username</TableHead>
                        <TableHead>Date Joined</TableHead>
                        <TableHead class="text-center" v-if="$page.props.can.edit_users || $page.props.can.delete_users">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!$page.props.user_list.data.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="user, index in $page.props.user_list.data">
                            <TableCell class="cursor-pointer" @click="manageUser(user.ID)">{{ $page.props.user_list.from + index }}</TableCell>
                            <TableCell class="cursor-pointer" @click="manageUser(user.ID)">
                                <div class="flex flex-col">
                                    <div>{{ user.display_name }}</div>
                                    <small>{{ user.user_email }}</small> 
                                </div>
                            </TableCell>
                            <TableCell class="cursor-pointer" @click="manageUser(user.ID)">{{ user.user_login }}</TableCell>
                            <TableCell class="cursor-pointer" @click="manageUser(user.ID)">{{ moment(user.user_registered).format('DD/MM/YYYY') }}</TableCell>
                            <TableCell class="text-center">
                                <DropdownMenu>
                                    <DropdownMenuTrigger as-child>
                                    <Button size="icon" variant="outline" class="h-8 w-8">
                                        <MoreVertical class="h-3.5 w-3.5" />
                                        <span class="sr-only">More</span>
                                    </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent align="end">
                                        <DropdownMenuItem v-if="$page.props.can.edit_users" @click="manageUser(user.ID)">Edit</DropdownMenuItem>
                                        <DropdownMenuItem v-if="$page.props.can.delete_users" @click="deleteUser(user.ID)">Delete</DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Pagination :page_data="$page.props.user_list" :params="params"></Pagination>
        <DeleteConfirmation :open="confirmation.is_open" @close="confirmation.is_open = false" :routeName="confirmation.route_name" :id="confirmation.id">
            <template #title>Delete Programme</template>
            <template #description>Are you sure want to delete this programme?</template>
        </DeleteConfirmation>
    </BreezeAuthenticatedLayout>
</template>

<script>
import moment from 'moment';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue'
import { debounce } from 'vue-debounce'
import { MagnifyingGlassIcon } from '@radix-icons/vue'
import { MoreVertical, PlusCircle } from 'lucide-vue-next';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import DropdownMenu from '@/Components/ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuTrigger from '@/Components/ui/dropdown-menu/DropdownMenuTrigger.vue';
import DropdownMenuContent from '@/Components/ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '@/Components/ui/dropdown-menu/DropdownMenuItem.vue';
import Card from '@/Components/Card.vue'
import DeleteConfirmation from '@/Components/DeleteConfirmation.vue';

export default {
    components: {
        Pagination, DeleteConfirmation, Head, Link, Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow,
    },
    props: {
        filter: Object,
    },
    data(){
        return{
            confirmation: {
                is_open: false,
                route_name: '',
                id: ''
            },
            isOpen: false,
            userID: '',
            confirmationTitle: '',
            confirmationText: '',
            confirmationAlert: '',
            confirmationButton: '',
            confirmationMethod: '',
            confirmationData: '',
            confirmationRoute: '',
            params: {
                search: this.filter.search ? this.filter.search : '',
            }
        }
    },
    methods: {
        manageUser(UserId){
            this.$inertia.get(this.route('users.edit'), {'user_id': UserId});
        },
        deleteUser(UserId){
            this.confirmation.route_name    = 'users.destroy'
            this.confirmation.id            = UserId
            this.confirmation.is_open       = true
        },
        search(){
            this.$inertia.get(this.route('users'), this.params, { replace: true, preserveState: true});
        }
    }
}
</script>
