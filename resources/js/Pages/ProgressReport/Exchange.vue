import ComboBox from '@/Components/ComboBox.vue';
<template>
    <div class="min-h-screen bg-slate-50 px-3 flex flex-col">
        <div class="flex-grow w-full max-w-5xl mx-auto py-3 space-y-2">
            <div class="border rounded-lg bg-green-200 px-3 py-2" v-if="response.success">
                <Label>{{ $page.props.flash.message }}</Label>
            </div>
            <div class="border rounded-lg bg-red-100 px-3 py-2" v-if="response.error">
                <Label>{{ $page.props.flash.message }}</Label>
            </div>
            <div class="">
                <Label>Old Activity</Label>
                <ComboBox :multiple="true" :items="$page.props.student_art_gallery" valueProperty="activity_id" labelProperty="activity_name" v-model="form.from">
                    <template #label="{ item }">
                        {{ item.level_name }} - {{ item.theme_name }} - {{ item.lesson_name }} - {{ item.activity_name }}
                    </template>
                    <template #label-content="{ selectedItem, selectedItems, multiple }">
                        <span v-if="selectedItem">{{ selectedItem.length }} item(s) selected</span>
                    </template>
                </ComboBox>
            </div>
            <div class="">
                <Label>New Activity</Label>
                <ComboBox :items="$page.props.pr_art_activities" valueProperty="activity_id" labelProperty="activity_name" v-model="form.to">
                    <template #label="{ item }">
                        {{ item.level_name }} - {{ item.theme_name }} - {{ item.lesson_name }} - {{ item.activity_name }}
                    </template>
                    <template #label-content="{ selectedItem, selectedItems, multiple }">
                        <span v-if="selectedItem">{{ selectedItem.level_name }} - {{ selectedItem.theme_name }} - {{ selectedItem.lesson_name }} - {{ selectedItem.activity_name }}</span>
                    </template>
                </ComboBox>
            </div>
            <div class="flex justify-center">
                <Button @click="submit">Exchange</Button>
            </div>
        </div>
    </div>
  </template>

<script>
export default {
    data() { 
        return {
            response: {
                success: false,
                error: false,
            },
            form: {
                from: [],
                to: ''
            }
        }
    },
    methods: {
        submit(){
            this.$inertia.post(route('progress_report.exchange.store'), this.form, {
                onSuccess: () => {
                    if(this.$page.props.flash.type == 'success'){
                        this.response.success = true
                        this.response.error = false
                    }
                    else{
                        this.response.success = false
                        this.response.error = true
                    }
                }
            })
        }
    }
}
</script>