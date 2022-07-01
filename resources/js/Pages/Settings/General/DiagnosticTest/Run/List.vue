<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <Head title="Diagnostic Test" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Diagnostic Test
            </h2>
        </template>
        <div class="p-3">
            <div class="space-y-3">
                <div v-for="dt in $page.props.diagnostic_test_list" :key="dt.id" class="p-6 rounded-lg shadow-lg bg-white max-w-sm">
                    <i class="fa-solid fa-notes"></i>
                    <h5 class="font-bold text-blue-900 text-xl leading-tight font-medium mb-2 text-left">{{ dt.name }}</h5>
                    <button type="button" class="text-right inline-block px-6 py-2.5 bg-indigo-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-indigo-700 hover:shadow-lg focus:bg-indigo-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-indigo-800 active:shadow-lg transition duration-150 ease-in-out" @click="runTest(dt.id)">Start Test</button>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Head, Link, 
    },
    data(){
        return{
        }
    },
    methods: {
        runTest(dt_id){
            this.$inertia.get(route('diagnostic_test.run'), {'dt_id': dt_id})
        }
    }

}
</script>
