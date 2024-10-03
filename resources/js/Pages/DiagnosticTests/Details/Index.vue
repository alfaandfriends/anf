<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Diagnostic Test" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <Card>
            <template #title>
                <div class="flex justify-between items-center">
                    Categories
                    <Button @click="$inertia.get(route('dt.settings.categories.create', {'dt_id': $page.props.diagnostic_test_id}))">
                        <PlusCircle class="h-4 w-4" />
                        <span class="ml-1 hidden sm:block">Add</span>
                    </Button>
                </div>  
            </template>
            <template #content>
                <template v-if="$page.props.diagnostic_test_categories.length > 0">
                    <div class="flex flex-col">
                        <ul class=" divide-y">
                            <li class="flex justify-between py-1 items-center" v-for="(category, index) in $page.props.diagnostic_test_categories" :key="category.id">
                                <Label>{{ index + 1 }}. {{ category.name }}</Label>
                                <div class="flex space-x-1">
                                    <Button variant="outline" @click="categoriesEdit(category.id)">Edit</Button>
                                    <Button variant="destructive" @click="categoriesDelete(category.id)">Delete</Button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </template>
                <template v-else>
                    <div class="flex text-center">
                        <Label>No categories found</Label>
                    </div>
                </template>
            </template>
        </Card>
        <Card>
            <template #title>
                <div class="flex justify-between items-center">
                    Questions
                    <Button @click="$inertia.get(route('dt.settings.details.create', {'dt_id': $page.props.diagnostic_test_id}))">
                        <PlusCircle class="h-4 w-4" />
                        <span class="ml-1 hidden sm:block">Add</span>
                    </Button>
                </div>  
            </template>
            <template #content>
                <div class="overflow-hidden">
                    <draggable class="w-full" v-model="$page.props.diagnostic_test_list" v-if="$page.props.diagnostic_test_list.length > 0" @change="updateSorting">
                        <div class="mb-1" v-for="(element, index) in $page.props.diagnostic_test_list" :key="index">
                            <div class="grid grid-cols-12 items-center">
                                <div class="col-span-11 cursor-pointer flex w-full space-x-2 items-center bg-slate-300 text-slate-900 hover:bg-slate-200 px-4 py-1.5 text-left rounded" @click="dtEdit(element.id, element.dt_id)">
                                    <Label class="cursor-pointer truncate py-0.5">{{ (index+1) + '. ' + element.question }}</Label>
                                </div>
                                <div class="col-span-1 flex pl-0.5" @click="dtDelete(element.id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </draggable>
                    <div v-else class="flex text-center">
                        <Label>No questions found</Label>
                    </div>
                </div>
            </template>
        </Card>
        <DeleteConfirmation :open="category_confirmation.is_open" @close="category_confirmation.is_open = false" :routeName="category_confirmation.route_name" :id="category_confirmation.id">
            <template #title>Delete Category</template>
            <template #description>Are you sure want to delete this category?</template>
        </DeleteConfirmation>
        <DeleteConfirmation :open="question_confirmation.is_open" @close="question_confirmation.is_open = false" :routeName="question_confirmation.route_name" :id="question_confirmation.id">
            <template #title>Delete Question</template>
            <template #description>Are you sure want to delete this question?</template>
        </DeleteConfirmation>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { PlusCircle } from 'lucide-vue-next';
import Card from '@/Components/Card.vue'
import { VueDraggableNext } from 'vue-draggable-next'
import DeleteConfirmation from '@/Components/DeleteConfirmation.vue';   

export default {
    components: {
        Head, Link, draggable: VueDraggableNext
    },
    data() {
        return {
            category_confirmation: {
                is_open: false,
                route_name: '',
                id: ''
            },
            question_confirmation: {
                is_open: false,
                route_name: '',
                id: ''
            },
        };
    },
    methods: {
        dtEdit(test_id, dt_id){
            this.$inertia.get(route('dt.settings.details.edit'), {'test_id': test_id, 'dt_id': dt_id}, {preserveScroll: true})
        },
        dtDelete(test_id){
            this.question_confirmation.route_name    = 'dt.settings.details.destroy'
            this.question_confirmation.id            = test_id
            this.question_confirmation.is_open       = true
        },
        updateSorting(){
            this.$inertia.post(route('dt.settings.details.sort'), {'sorted_list': this.$page.props.diagnostic_test_list}, {preserveScroll: true})
        },
        categoriesEdit(category_id){
            this.$inertia.get(route('dt.settings.categories.edit'), {'category_id': category_id}, {preserveScroll: true})
        },
        categoriesDelete(category_id){
            this.category_confirmation.route_name    = 'dt.settings.categories.destroy'
            this.category_confirmation.id            = category_id
            this.category_confirmation.is_open       = true
        }
    }
}
</script>
                                