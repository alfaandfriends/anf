<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import {
  Tooltip,
  TooltipContent,
  TooltipProvider,
  TooltipTrigger,
} from '@/Components/ui/tooltip'
</script>

<template>
    <Head title="Teacher Resources" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="flex items-center justify-between space-x-2">
            <div class="flex justify-between space-x-2">
                <div class="relative">
                    <MagnifyingGlassIcon class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
                    <Input type="text" placeholder="Search" class="w-full rounded-lg bg-background pl-8 md:w-[200px] lg:w-[336px]" v-debounce:800ms="search" v-model="params.search"/>
                </div>
                <Button class="border border-slate-700 border-dashed bg-white text-slate-800 hover:bg-slate-50" @click="showFilters()"> 
                    <Filter class="h-4 w-4" />
                    <span class="ml-1 hidden sm:block">Filters</span>
                </Button>
            </div>
            <Button @click="$inertia.get(route('teacher_resources.create'))" v-if="$page.props.can.create_teacher_resources">
                <PlusCircle class="h-4 w-4" />
                <span class="ml-1 hidden sm:block">New Resource</span>
            </Button>
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-5 gap-2" v-if="show_filters">
            <ComboBox :canClear="true" :items="$page.props.programmes" label-property="name" value-property="id" @select="search" v-model="params.programme_id" select-placeholder="Programmes" search-placeholder="Search programme..."></ComboBox>
            <ComboBox :canClear="true" :items="$page.props.levels" label-property="name" value-property="id" @select="search" v-model="params.level" select-placeholder="Levels" search-placeholder="Search level..."></ComboBox>
            <ComboBox :canClear="true" :items="$page.props.languages" label-property="name" value-property="id" @select="search" v-model="params.language" select-placeholder="Languages" search-placeholder="Search language..."></ComboBox>
            <div class="">
                <Button @click="$inertia.get(route('teacher_resources'))">Clear Search</Button>
            </div>
        </div>
        <Card>
            <template #content>
                <Table>
                    <TableHeader class="bg-gray-100">
                        <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Title</TableHead>
                        <TableHead>Programme</TableHead>
                        <TableHead>Level</TableHead>
                        <TableHead class="text-center">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!$page.props.teacher_resources.data.length">
                            <TableCell class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found
                                </div>
                            </TableCell>
                        </TableRow> 
                        <TableRow v-for="result, index in $page.props.teacher_resources.data">
                            <TableCell>{{ $page.props.teacher_resources.from + index }}</TableCell>
                            <TableCell>{{ result.title }}</TableCell>
                            <TableCell>{{ result.programme }}</TableCell>
                            <TableCell>{{ result.name }}</TableCell>
                            <TableCell class="text-center space-x-2">
                                <div class="flex justify-center space-x-2">
                                    <Button variant="outline" @click="viewResource(result.id)" v-if="$page.props.can.view_teacher_resources">View / Download</Button>
                                    <Button @click="editResource(result.id)" v-if="$page.props.can.edit_teacher_resources">Edit</Button>
                                    <Button variant="destructive" @click="deleteResource(result.id)" v-if="$page.props.can.delete_teacher_resources">Delete</Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </template>
        </Card>
        <Pagination :page_data="$page.props.teacher_resources" :params="params"></Pagination>
        <DeleteConfirmation :open="confirmation.is_open" @close="confirmation.is_open = false" :routeName="confirmation.route_name" :id="confirmation.id">
            <template #title>Delete Resource</template>
            <template #description>Are you sure want to delete this resource?</template>
        </DeleteConfirmation>
        <Dialog v-model:open="show_resource">
            <template #title>Resource Information</template>
            <template #content>
                <div class="p-1 grid grid-cols-1 gap-4">
                    <div class="flex items-center justify-center p-5 h-72" v-if="loading_resource">
                        <div class="flex space-x-2 animate-pulse">
                            <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                        </div>
                    </div>
                    <div class="" v-else>
                        <template v-if="resource_data.media_type_id == 1">
                            <div class="flex justify-center" v-html="resource_data.content"></div>
                        </template>
                        <template v-if="resource_data.media_type_id == 2">
                            <div class="flex justify-center">
                                <iframe class="w-full h-[300px]" frameborder="0" :src="baseUrl() + '/storage/teacher_resources/'+resource_data.content"></iframe>
                            </div>
                        </template>
                        <template v-if="resource_data.media_type_id == 3">
                            <div class="flex justify-center">
                                <iframe class="flex-1" frameborder="0" :src="'https://view.officeapps.live.com/op/view.aspx?src=' + baseUrl() + '/storage/teacher_resources/' + resource_data.content + '&embedded=true'" style="width:600px; height:500px;"></iframe>
                            </div>
                        </template>
                        <template v-if="resource_data.media_type_id == 4">
                            <div class="flex justify-center">
                                <img class="w-[50%] h-[50%]" frameborder="0" :src="'/storage/teacher_resources/'+resource_data.content" alt="">
                            </div>
                        </template>
                        <div class="flex justify-center">
                            <div class="w-full px-2 mb-3">
                                <div class="mt-6">
                                    <dl class="divide-y divide-gray-100">
                                        <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                            <Label>Title</Label>
                                            <Label class="font-normal text-slate-700 whitespace-nowrap">{{ resource_data.title }}</Label>
                                        </div>
                                        <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                            <Label>Programme / Level</Label>
                                            <Label class="font-normal text-slate-700">{{ resource_data.programme + ` ( Level ${resource_data.level} )` }}</Label>
                                        </div>
                                        <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                            <Label>Language</Label>
                                            <Label class="font-normal text-slate-700">{{ resource_data.language }}</Label>
                                        </div>
                                        <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                            <Label>Media Type</Label>
                                            <Label class="font-normal text-slate-700">{{ resource_data.media_type_name }}</Label>
                                        </div>
                                        <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                            <Label>Created Date</Label>
                                            <Label class="font-normal text-slate-700">{{ moment(resource_data.created_at).format('DD/MM/Y') }}</Label>
                                        </div>
                                        <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                            <Label>Last Updated</Label>
                                            <Label class="font-normal text-slate-700">{{ moment(resource_data.updated_at).format('DD/MM/Y') }}</Label>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template #footer>
                <TooltipProvider>
                    <Tooltip :delayDuration="0" :open="show_copied">
                        <TooltipTrigger as-child @click="copyText(resource_data.content)">
                            <Button variant="outline">
                                <Clipboard class="w-4 h-4 mr-2"/>Copy Link
                            </Button>
                        </TooltipTrigger>
                        <TooltipContent>
                            <p>Copied to clipboard!</p>
                        </TooltipContent>
                    </Tooltip>
                </TooltipProvider>
                <Button @click="downloadFile(resource_data.content)" v-if="resource_data.media_type_id !== 1">Download</Button>
                <Button variant="outline" @click="show_resource = false">Close</Button>
            </template>
        </Dialog>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { MagnifyingGlassIcon } from '@radix-icons/vue'
import { Filter, PlusCircle, Languages, Clipboard, ClipboardCopy } from 'lucide-vue-next';
import moment from 'moment';
import Card from '@/Components/Card.vue'
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import Dialog from '@/Components/DialogModal.vue'
import Pagination from '@/Components/Pagination.vue'
import DeleteConfirmation from '@/Components/DeleteConfirmation.vue';   

export default {
    components: {
        Head, Link
    },
    data(){
        return{
            show_copied: false,
            show_filters: false,
            loading_resource: false,
            show_resource: false,
            confirmation: {
                is_open: false,
                route_name: '',
                id: ''
            },
            params: {
                search: this.$page.props.filter ? this.$page.props.filter.search : '',
                programme_id: this.$page.props.filter ? this.$page.props.filter.programme_id : '',
                level: this.$page.props.filter.level ? this.$page.props.filter.level : '',
                language: this.$page.props.filter.language ? this.$page.props.filter.language : '',
            },
            resource_data: [],
        }
    },
    methods: {
        viewResource(resource_id){
            this.resource_data      =   []
            this.show_resource      =   true
            this.loading_resource   =   true
            axios.get(route('teacher_resources.get_resource'), {
                    params: {
                        'resource_id': resource_id
                    }
                })
                .then(response => {
                    this.resource_data      =   response.data
                    this.loading_resource   =   false
                });
        },
        editResource(resource_id){
            this.$inertia.get(route('teacher_resources.edit'), {'resource_id':resource_id})
        },
        deleteResource(resource_id){
            this.confirmation.route_name    = 'teacher_resources.destroy'
            this.confirmation.id            = resource_id
            this.confirmation.is_open       = true
        },
        baseUrl() {
            const { protocol, host } = window.location;
            return `${protocol}//${host}`;
        },
        downloadFile(filename){
            axios.get(route('download.teacher_resources', filename), {
                responseType: 'blob', // Set the response type to 'blob'
            })
            .then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', filename); // Specify the file name
                document.body.appendChild(link);
                link.click();
            })
            .catch(error => {
                console.error(error);
            });
        },
        search(){
            this.$inertia.get(route('teacher_resources'), this.params, { preserveState: true })
        },
        showFilters(){
            this.show_filters = !this.show_filters
        },
        copyText(file_name){
            navigator.clipboard.writeText(this.baseUrl() + '/storage/teacher_resources/' + file_name).then(() => {
                this.show_copied = true
                setTimeout(() => {
                    this.show_copied = false
                }, 1000);
            });
        }
    },
}
</script>