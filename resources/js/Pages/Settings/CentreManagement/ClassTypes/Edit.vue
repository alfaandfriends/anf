<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="General Setting" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="md:grid md:grid-cols-2">
            <div class="md:mt-0 md:col-span-2">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <div class="grid grid-rows-2 grid-cols-1 sm:grid-cols-2 grid-flow-col gap-4">
                            <div class="sm:row-span-3">
                                <div class="mb-5">
                                    <h1 class="text-indigo-800 font-bold">Class Type Information</h1>
                                    <div class=" border-b border-dashed border-indigo-900 mt-1"></div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-0 gap-0 sm:gap-4">
                                    <div class="mb-4">
                                        <label for="class_type" class="block text-sm text-gray-700 font-bold">Class Type<span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="class_type" id="class_type" class="capitalize focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm" :class="$page.props.errors.class_type ? 'border-red-300' : 'border-gray-300'" v-model="form.class_type" autocomplete="off"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-end justify-start space-x-2">
                            <BreezeButton buttonType="gray" :route="route('settings.class_types')">Cancel</BreezeButton>
                            <BreezeButton type="submit">Save </BreezeButton>
                        </div>
                    </div>
                </form>
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
    props: {
        class_type_info: Object,
    },
    data(){
        return{
            form: {
                class_type_id: this.class_type_info ? this.class_type_info.id : '',
                class_type: this.class_type_info ? this.class_type_info.name : '',
            }
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('settings.class_types.update'), this.form, { preserveState: true})
        },
    }

}
</script>
