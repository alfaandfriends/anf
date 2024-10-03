<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Edupreneurs" />

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
                        <TableRow v-if="!$page.props.edupreneurs.data.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found 
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="user, index in $page.props.edupreneurs.data">
                            <TableCell>{{ $page.props.edupreneurs.from + index }}</TableCell>
                            <TableCell>{{ user.name }}</TableCell>
                            <TableCell>{{ user.email }}</TableCell>
                            <TableCell class="text-center">
                                <Button variant="outline" v-if="$page.props.can.manage_edupreneurs" @click="manageEdupreneur(user.id)">Edit</Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Pagination :page_data="$page.props.edupreneurs" :params="params"></Pagination>
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
    data(){
        return{
            params: {
                search: this.$page.props.filter.search ? this.$page.props.filter.search : '',
                centre_id: this.$page.props.filter.centre_id ? this.$page.props.filter.centre_id : '',
            }
        }
    },
    methods: {
        manageEdupreneur(user_id){
            this.$inertia.get(this.route('edupreneurs.manage'), {'user_id': user_id});
        },
        search(){
            this.$inertia.get(this.route('edupreneurs'), this.params, { replace: true, preserveState: true});
        }
    }
}
</script>
