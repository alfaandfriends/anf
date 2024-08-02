<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Centre Managers" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="relative">
            <MagnifyingGlassIcon class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
            <Input type="text" placeholder="Search" class="w-full rounded-lg bg-background pl-8 md:w-[200px] lg:w-[336px]" v-debounce:800ms="search" v-model="params.search"/>
        </div>
        <Card>
            <template #content>
                <Table>
                    <TableHeader class="bg-gray-100">
                        <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Email</TableHead>
                        <TableHead class="text-center">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!$page.props.centre_managers.data.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found 
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="user, index in $page.props.centre_managers.data">
                            <TableCell class="cursor-pointer" @click="manageUser(user.id)">{{ $page.props.centre_managers.from + index }}</TableCell>
                            <TableCell class="cursor-pointer" @click="manageUser(user.id)">{{ user.name }}</TableCell>
                            <TableCell class="cursor-pointer" @click="manageUser(user.id)">{{ user.email }}</TableCell>
                            <TableCell class="text-center">
                                <DropdownMenu>
                                    <DropdownMenuTrigger as-child>
                                    <Button size="icon" variant="outline" class="h-8 w-8">
                                        <MoreVertical class="h-3.5 w-3.5" />
                                        <span class="sr-only">More</span>
                                    </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent align="end">
                                        <DropdownMenuItem v-if="$page.props.can.manage_centre_manager" @click="manageUser(user.id)">Edit</DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Pagination :page_data="$page.props.centre_managers" :params="params"></Pagination>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue'
import { debounce } from 'vue-debounce'
import Card from '@/Components/Card.vue'
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import DropdownMenu from '@/Components/ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuTrigger from '@/Components/ui/dropdown-menu/DropdownMenuTrigger.vue';
import DropdownMenuContent from '@/Components/ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '@/Components/ui/dropdown-menu/DropdownMenuItem.vue';
import { MagnifyingGlassIcon } from '@radix-icons/vue'
import { MoreVertical } from 'lucide-vue-next';

export default {
    components: {
        Head, Link, Pagination
    },
    props: {
        filter: Object,
    },
    data(){
        return{
            params: {
                search: this.$page.props.filter.search ? this.$page.props.filter.search : '',
                centre_id: this.$page.props.filter.centre_id ? this.$page.props.filter.centre_id : '',
            }
        }
    },
    methods: {
        manageUser(user_id){
            this.$inertia.get(this.route('centre_manager.manage'), {'user_id': user_id});
        },
        search(){
            this.$inertia.get(this.route('centre_manager'), this.params, { replace: true, preserveState: true});
        }
    }
}
</script>
