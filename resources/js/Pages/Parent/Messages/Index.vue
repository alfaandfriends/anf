<template>
    <Head title="Fee Invoices" />
    <Authenticated>
        <div class="flex justify-center">
            <div class="flex-1 max-w-xl overflow-auto justify-center">
                <div class="flex justify-center py-10 text-slate-500 text-lg">
                    Coming soon
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
