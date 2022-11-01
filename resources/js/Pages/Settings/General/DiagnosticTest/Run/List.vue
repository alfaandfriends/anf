<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Diagnostic Test" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="p-3">
            <div class="space-y-3">
                <div v-for="dt in $page.props.diagnostic_test_list" :key="dt.id" class="p-6 rounded-lg shadow-lg bg-white max-w-sm">
                    <i class="fa-solid fa-notes"></i>
                    <h5 class="font-bold text-blue-900 text-xl leading-tight mb-2 text-left">{{ dt.name }}</h5>
                    <BreezeButton @click="runTest(dt.id)">Start Test</BreezeButton>
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
