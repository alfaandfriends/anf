<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Diagnostic Test" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <Card>
            <template #title>Basic Information</template>
            <template #content>
                <div class="grid grid-cols-1 2xl:grid-cols-3 gap-4">
                    <div>
                        <Label>Name<span class="text-red-500">*</span></Label>
                        <Input type="text" :error="$page.props.errors.name" v-model="form.name"></Input>
                    </div>
                    <div>
                        <Label>Age<span class="text-red-500">*</span></Label>
                        <ComboBox :items="$page.props.ages" label-property="name" value-property="id" :error="$page.props.errors.age" v-model="form.age" select-placeholder="Select Age" search-placeholder="Search age..."></ComboBox>
                    </div>
                    <div>
                        <Label>Language<span class="text-red-500">*</span></Label>
                        <ComboBox :items="$page.props.languages" label-property="name" value-property="id" :error="$page.props.errors.language" v-model="form.language" select-placeholder="Select Language" search-placeholder="Search language..."></ComboBox>
                    </div>
                </div>
            </template>
        </Card>
        <Card>
            <template #title>Conditions</template>
            <template #content>
                <div class="grid grid-cols-1 2xl:grid-cols-2 gap-4">
                    <div>
                        <Label>If score less than<span class="text-red-500">*</span></Label>
                        <Input type="text" :error="$page.props.errors.lower_score" v-model="form.lower_score"></Input>
                    </div>
                    <div>
                        <Label>Go to</Label>
                        <ComboBox :canClear="true" :items="$page.props.dt_list" label-property="name" value-property="id" :error="$page.props.errors.lower_score_direction" v-model="form.lower_score_direction" select-placeholder="Default (No Redirection)" search-placeholder="Search redirection..."></ComboBox>
                    </div>
                    <div>
                        <Label>If score more than<span class="text-red-500">*</span></Label>
                        <Input type="text" :error="$page.props.errors.higher_score" v-model="form.higher_score"></Input>
                    </div>
                    <div>
                        <Label>Language</Label>
                        <ComboBox :canClear="true" :items="$page.props.dt_list" label-property="name" value-property="id" :error="$page.props.errors.higher_score_direction" v-model="form.higher_score_direction" select-placeholder="Default (No Redirection)" search-placeholder="Search language..."></ComboBox>
                    </div>
                </div>
            </template>
        </Card>
        <Card>
            <template #title>Chart</template>
            <template #content>
                <div class="grid grid-cols-1 2xl:grid-cols-2 gap-4">
                    <div>
                        <Label>Chart Type</Label>
                        <ComboBox :items="$page.props.chart_types" label-property="name" value-property="id" :error="$page.props.errors.chart_type" v-model="form.chart_type" select-placeholder="Select Chart" search-placeholder="Search chart..."></ComboBox>
                    </div>
                </div>
            </template>
        </Card>
        <Card>
            <template #content>
                <div class="flex justify-end">
                    <div class="flex space-x-2">
                        <Button variant="outline" @click="$inertia.get(route('dt.settings'))">Cancel</Button>
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

export default {
    components: {
        Head, Link, 
    },
    data(){
        return{
            form: {
                name: '',
                age: '',
                language: '',
                chart_type: this.$page.props.chart_types[0].id,
                lower_score: '',
                lower_score_direction: '',
                higher_score: '',
                higher_score_direction: '',
            }
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('dt.settings.store'), this.form, { preserveState: true})
        },
    }

}
</script>
