<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import { Inertia } from '@inertiajs/inertia'
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4">
            <article class="rounded-lg border border-gray-300 bg-white p-6 shadow">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <p class="font-semibold text-sm text-gray-500">Total Centres</p>
                    </div>
                    <Menu as="div" class="relative inline-block text-left">
                        <MenuButton class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white text-sm font-semibold text-gray-900 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 448 512">
                                <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
                            </svg>
                        </MenuButton>
                        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                            <MenuItems class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <div class="py-1">
                                <a @click="updateDataCentres('')" class="cursor-pointer block px-4 py-2 text-sm hover:bg-indigo-100 text-gray-900" :class="params.centre_status == null ? 'bg-indigo-100' : ''">All</a>
                                <a @click="updateDataCentres(1)" class="cursor-pointer block px-4 py-2 text-sm hover:bg-indigo-100 text-gray-900" :class="params.centre_status == 1 ? 'bg-indigo-100' : ''">Active</a>
                                <a @click="updateDataCentres(0)" class="cursor-pointer block px-4 py-2 text-sm hover:bg-indigo-100 text-gray-900" :class="params.centre_status == 0 ? 'bg-indigo-100' : ''">Inactive</a>
                            </div>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
                <hr class="border border-dashed border-blue-300 my-2">
                <p class="text-2xl font-bold text-gray-700">{{ $page.props.total_centres }}</p>
            </article>
            <article class="rounded-lg border border-gray-300 bg-white p-6 z-0 shadow">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <p class="font-semibold text-sm text-gray-500">Total Students</p>
                    </div>
                </div>
                <hr class="border border-dashed border-blue-300 my-2">
                <div class="flex self-center rounded bg-indigo-100 p-1 text-indigo-600">
                    <span class="text-xs font-medium"> Online </span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="flex self-center text-2xl font-semibold text-gray-900">
                        {{ $page.props.online_students_this_month }}
                    </div>
                    <div class="mt-1 flex gap-1 text-green-600" v-if="$page.props.online_students_this_month > $page.props.online_students_last_month">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        <p class="flex gap-2 text-xs">
                            <span class="font-medium"> {{ $page.props.online_students_this_month - $page.props.online_students_last_month }} </span>
                            <span class="text-gray-500"> Since last month </span>
                        </p>
                    </div>
                    <div class="mt-1 flex gap-1 text-red-600" v-if="$page.props.online_students_this_month < $page.props.online_students_last_month">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                        </svg>
                        <p class="flex gap-2 text-xs">
                            <span class="font-medium"> {{ $page.props.online_students_last_month - $page.props.online_students_this_month }} Students</span>
                            <span class="text-gray-500"> Since last month </span>
                        </p>
                    </div>
                    <div class="mt-1 flex gap-1 text-indigo-600" v-if="$page.props.online_students_this_month == $page.props.online_students_last_month">
                        <p class="flex gap-2 text-xs">
                            <span class="font-medium"> Students Remain </span>
                            <span class="text-gray-500"> Since last month </span>
                        </p>
                    </div>
                </div>
            </article>
            <article class="rounded-lg border border-gray-300 bg-white p-6 z-0 shadow">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <p class="font-semibold text-sm text-gray-500">Total Students</p>
                    </div>
                </div>
                <hr class="border border-dashed border-blue-300 my-2">
                <div class="flex self-center rounded bg-indigo-100 p-1 text-indigo-600">
                    <span class="text-xs font-medium"> Physical </span>
                </div>
                
                <div class="flex items-center space-x-2">
                    <div class="flex self-center text-2xl font-semibold text-gray-900">
                        {{ $page.props.physical_students_this_month }}
                    </div>
                    <div class="mt-1 flex gap-1 text-green-600" v-if="$page.props.physical_students_this_month > $page.props.physical_students_last_month">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        <p class="flex gap-2 text-xs">
                            <span class="font-medium"> {{ $page.props.physical_students_this_month - $page.props.physical_students_last_month }} </span>
                            <span class="text-gray-500"> Since last month </span>
                        </p>
                    </div>
                    <div class="mt-1 flex gap-1 text-red-600" v-if="$page.props.physical_students_this_month < $page.props.physical_students_last_month">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                        </svg>
                        <p class="flex gap-2 text-xs">
                            <span class="font-medium"> {{ $page.props.physical_students_last_month - $page.props.physical_students_this_month }} Students</span>
                            <span class="text-gray-500"> Since last month </span>
                        </p>
                    </div>
                    <div class="mt-1 flex gap-1 text-indigo-600" v-if="$page.props.physical_students_this_month == $page.props.physical_students_last_month">
                        <p class="flex gap-2 text-xs">
                            <span class="font-medium"> Students Remain </span>
                            <span class="text-gray-500"> Since last month </span>
                        </p>
                    </div>
                </div>
            </article>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3';
  import Multiselect from '@vueform/multiselect'

export default {
    components: {
        BreezeAuthenticatedLayout, Multiselect, Head,
    },
    props: {
        filters: Object
    },
    data() {
        return {
            params: {
                centre_status: this.$page.props.filters ? this.$page.props.filters.centre_status : '',
                student_status: this.$page.props.filters ? this.$page.props.filters.student_status : ''
            }
        }
    },
    methods: {
        updateDataCentres(status){
            this.params.centre_status  = status
            Inertia.visit(route('dashboard', this.params))
        },
        updateDataStudents(status){
            this.params.student_status  = status
            Inertia.visit(route('dashboard', this.params))
        }
    }
}
</script>