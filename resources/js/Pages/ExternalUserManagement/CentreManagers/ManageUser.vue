<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Centre Managers" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <Card>
            <template #title>Assign Centre</template>
            <template #content>
                <div class="grid grid-cols-1 2xl:grid-cols-3 gap-4">
                    <div>
                        <Label>Name</Label>
                        <Input type="text" v-model="$page.props.user_info.display_name" disabled></Input>
                    </div>
                    <div>
                        <Label>Email</Label>
                        <Input type="text" v-model="$page.props.user_info.user_email" disabled></Input>
                    </div>
                    <div>
                        <Label>Centre<span class="text-red-500">*</span></Label>
                        <ComboBox :items="$page.props.allowed_centres" label-property="label" value-property="ID" :error="$page.props.errors.centre_id" v-model="centre_id" select-placeholder="Select Centre" search-placeholder="Search centre..."></ComboBox>
                    </div>
                </div>
            </template>
            <template #footer>
                <Button variant="outline" @click="$inertia.get(route('centre_manager'))">Cancel</Button>
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
        user_centre: Object,
    },
    data(){
        return{
            centre_id: this.user_centre ? this.user_centre.centre_id  : ''
        }
    },
    methods: {
        submit(){
            this.$inertia.post(this.route('centre_manager.store'), {'user_id': this.user_id, 'centre_id': this.centre_id});
        },
    }
}
</script>
