<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="General Setting" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-middle inline-block min-w-full">
                        <ul class="flex justify-start space-x-1 text-white">
                            <li>
                                <button @click="currentTab('settings.class_types')" class="inline-block px-4 py-2" v-if="$page.props.can.view_students"
                                        :class="route().current('settings.class_types') ? 'bg-white text-indigo-800 border-indigo-500 border-b-2' :
                                                           'bg-indigo-500 text-white border-indigo-500 border-t-2 hover:bg-indigo-700 hover:border-indigo-700'">Class Types</button>
                            </li>
                        </ul>
                        <div class="mt-4">
                            <div v-if="route().current('settings.class_types')">
                                <FeeTypesTable v-if="$page.props.can.view_students"></FeeTypesTable>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import FeeTypesTable from '@/Pages/Settings/CentreManagement/ClassTypes/Table.vue'

export default {
    components: {
        Head, Link, TabGroup, TabList, Tab, TabPanels, TabPanel,
    },
    data() {
        return {
            isOpen: false,
            current_tab: 1,
            confirmationTitle: '',
            confirmationText: '',
            confirmationAlert: '',
            confirmationButton: '',
            confirmationMethod: '',
            confirmationData: '',
            confirmationRoute: '',
        };
    },
    methods: {
        currentTab(routeName){
            this.$inertia.get(route(routeName))
        },
    }

}
</script>
