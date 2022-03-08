<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template> -->

        <div class="py-6">
            <div class="mx-auto px-6">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3';
export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
}
</script>