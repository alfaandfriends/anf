<template>
    <Head title="Fee Invoices" />
    <Authenticated>
        <div class="flex justify-center">
            <div class="flex-1 max-w-4xl overflow-auto justify-center">
                <div class="flex justify-center py-10">
                    <span class="text-lg text-gray-500">Coming Soon...</span>
                </div>
            </div>
        </div>
    </Authenticated>
</template>

<script setup>
import Authenticated from '@/Layouts/Parent/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import BreezeButton from '@/Components/Button.vue';
</script>

<script>
import axios from 'axios'
import moment from 'moment';

export default {
    components: {
        Head, Link
    },
    data(){
        return{
        }
    },
    methods: {
    },
    mounted(){
    }
}
</script>
