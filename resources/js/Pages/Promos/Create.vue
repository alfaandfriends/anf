<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<style>
.multiselect-assistive-text{
    display: none;
}

</style>

<template>
    <Head title="Promotions" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <Card>
            <template #title>Promotion Information</template>
            <template #content>
                <div class="grid grid-cols-1 2xl:grid-cols-3 gap-4">
                    <div>
                        <Label>Name<span class="text-red-500">*</span></Label>
                        <Input type="text" :error="$page.props.errors.promo_name" v-model="form.promo_name"></Input>
                    </div>
                    <div>
                        <Label>Country<span class="text-red-500">*</span></Label>
                        <ComboBox :items="$page.props.countries" label-property="name" value-property="id" :error="$page.props.errors.country_id" v-model="form.country_id" select-placeholder="Select Country" search-placeholder="Search country..."></ComboBox>
                    </div>
                    <div>
                        <Label>Duration<span class="text-red-500">*</span></Label>
                        <ComboBox :items="$page.props.durations" label-property="name" value-property="id" :error="$page.props.errors.duration_id" v-model="form.duration_id" select-placeholder="Select Duration" search-placeholder="Search duration..."></ComboBox>
                    </div>
                    <div>
                        <Label>Type of Promotion<span class="text-red-500">*</span></Label>
                        <ComboBox :items="$page.props.types" label-property="name" value-property="id" :error="$page.props.errors.type_id" v-model="form.type_id" select-placeholder="Select Type" search-placeholder="Search type..."></ComboBox>
                    </div>
                    <div>
                        <Label>Amount<span class="text-red-500">*</span></Label>
                        <Input type="number" :error="$page.props.errors.promo_value" v-model="form.promo_value"></Input>
                    </div>
                </div>
            </template>
        </Card>
        <Card>
            <template #content>
                <div class="flex items-center justify-end">
                    <div class="flex space-x-2">
                        <Button variant="outline" @click="$inertia.get(route('fee.promos'))">Cancel</Button>
                        <Button @click="submit">Save</Button>
                    </div>
                </div>
            </template>
        </Card>
    </BreezeAuthenticatedLayout>
</template>



<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Card from '@/Components/Card.vue'
import Dialog from '@/Components/DialogModal.vue'

export default {
    components: {
        Head, Link, Card, Dialog
    },
    data(){
        return{
            form: {
                promo_name: '',
                country_id: '',
                duration_id: '',
                type_id: '',
                promo_value: '',
            }
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('fee.promos.store'), this.form, { preserveState: true})
        },
    }

}
</script>
