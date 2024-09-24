<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Diagnostic Test" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <Card>
            <template #title>Category</template>
            <template #content>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <Label>Label<span class="text-red-500">*</span></Label>
                        <Input type="text" :error="$page.props.errors.category_name" v-model="form.category_name"></Input>
                    </div>
                </div>
            </template>
        </Card>
        <Card>
            <template #footer>
                <Button variant="outline" @click="$inertia.get(route('dt.settings.details', {'dt_id': $page.props.diagnostic_test_id}))">Cancel</Button>
                <Button @click="submit">Save</Button>
            </template>
        </Card>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Card from '@/Components/Card.vue'

export default {
    components: {
        Head, Link,
    },
    data() {
        return {
            form: {
                dt_id: this.$page.props.diagnostic_test_id ? this.$page.props.diagnostic_test_id : '',
                category_name: '',
            }
        };
    },
    methods: {
        submit() {
            this.$inertia.post(route('dt.settings.categories.store'), this.form, { preserveState: true})
        }
    }

}
</script>
                                