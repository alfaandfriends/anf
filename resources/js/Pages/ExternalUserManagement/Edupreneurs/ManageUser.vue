<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
</script>

<template>
    <Head title="Edupreneurs" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <Card>
            <template #title>Assign Centre</template>
            <template #content>
                <div class="grid grid-cols-1 2xl:grid-cols-3 gap-2">
                    <div class="mb-4">
                        <Label>Name</Label>
                        <Input type="text" v-model="$page.props.user_info.display_name" disabled></Input>
                    </div>
                    <div class="mb-4">
                        <Label>Email</Label>
                        <Input type="text" v-model="$page.props.user_info.user_email" disabled></Input>
                    </div>
                    <div class="mb-4">
                        <Label>Centre<span class="text-red-500">*</span></Label>
                        <ComboBox :multiple="true" :items="$page.props.allowed_centres" label-property="label" value-property="ID" :error="$page.props.errors.centre_id" v-model="selected_centres" select-placeholder="Select Centre" search-placeholder="Search centre..."></ComboBox>
                    </div>
                </div>
            </template>
            <template #footer>
                <Button variant="outline" @click="$inertia.get(route('edupreneurs'))">Cancel</Button>
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
    props: {
        user_id: String,
        user_centres: Object
    },
    data(){
        return{
            selected_centres: this.$page.props.user_centres ? this.$page.props.user_centres : []
        }
    },
    methods: {
        submit(){
            this.$inertia.post(this.route('edupreneurs.store'), {'user_id': this.user_id, 'selected_centres': this.selected_centres});
        },
    }
}
</script>
