<script setup>
import Card from "@/Components/Card.vue";
</script>

<template>
  <Card>
    <template #title>Report Summary</template>
    <template #content>
      <div class="grid grid-cols-1 2xl:grid-cols-2 gap-4">
        <div>
          <Label>What's Next</Label>
          <Textarea rows="3" v-model.lazy="form.upcoming_feedback"></Textarea>
        </div>
        <div>
          <Label>Need Improvement On</Label>
          <Textarea rows="3" v-model.lazy="form.improvement_feedback"></Textarea>
        </div>
      </div>
    </template>
  </Card>
  <Card>
    <template #content>
      <div class="flex justify-end">
        <div class="flex space-x-2">
          <Button variant="outline" @click="$inertia.get(route('progress_report'))"
            >Cancel</Button
          >
          <Button @click="saveFeedback">Save</Button>
        </div>
      </div>
    </template>
  </Card>
</template>

<script>
export default {
  props: {
    report_details: Object,
  },
  data() {
    return {
      form: {
        id: this.$page.props.report_details.id,
        upcoming_feedback: this.$page.props.report_details.upcoming_feedback
          ? this.$page.props.report_details.upcoming_feedback
          : "",
        improvement_feedback: this.$page.props.report_details.improvement_feedback
          ? this.$page.props.report_details.improvement_feedback
          : "",
      },
    };
  },
  methods: {
    saveFeedback() {
      this.$inertia.post(route("progress_report.store_summary"), this.form);
    },
  },
};
</script>
