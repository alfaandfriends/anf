<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Admin/Authenticated.vue";
</script>
<style>
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.3s ease-in-out;
}
.fade-slide-enter-from {
  opacity: 0;
  transform: translate(-50%, 30px);
}

.fade-slide-leave-to {
  opacity: 0;
  transform: translate(-50%, 30px);
}
</style>
<template>
  <Head title="Progress Report" />

  <BreezeAuthenticatedLayout>
    <template #header></template>
    <StudentInformation></StudentInformation>
    <Card>
      <template #title>Progress Reports</template>
      <template #content>
        <Table>
          <TableHeader class="bg-gray-100">
            <TableRow>
              <TableHead>#</TableHead>
              <TableHead>Date</TableHead>
              <TableHead>Teacher's Name</TableHead>
              <TableHead class="text-center">Status</TableHead>
              <TableHead class="text-center">Action</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-if="!$page.props.progress_reports.length">
              <TableCell class="text-center" colspan="10">
                <div class="p-3">No Record Found</div>
              </TableCell>
            </TableRow>
            <TableRow v-for="(result, index) in $page.props.progress_reports">
              <TableCell>{{ index + 1 }}</TableCell>
              <TableCell>{{ moment(result.date).format("DD/MM/Y") }}</TableCell>
              <TableCell>{{ result.display_name }}</TableCell>
              <TableCell class="text-center">
                <span
                  class="inline-flex items-center justify-center px-2 py-1 text-xs rounded"
                  :class="[
                    { 'bg-green-200 text-green-600': result.attendance_status == 1 },
                    { 'bg-red-200 text-red-600': result.attendance_status == 2 },
                    { 'bg-gray-200 text-gray-600': result.attendance_status == 3 },
                    { 'bg-blue-200 text-blue-600': result.attendance_status == 4 },
                  ]"
                  >{{ result.attendance_status_name }}</span
                >
              </TableCell>
              <TableCell class="text-center">
                <Button variant="outline" @click="viewProgressReport(index)">Edit</Button>
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </template>
    </Card>
    <FeedbackSummary :report_details="$page.props.report_details" />
    <Dialog v-model:open="show_progress_report">
      <template #title>Edit Progress Report</template>
      <template #content>
        <div class="p-1 grid grid-cols-1 gap-4">
          <div class="">
            <Label id="date">Date<span class="text-red-500">*</span></Label>
            <Datepicker
              v-model="form.date"
              mode="date"
              format="dd/MM/Y"
              :error="!form.date"
              teleport="#date"
              :teleportCenter="true"
            ></Datepicker>
          </div>
          <div class="">
            <Label>Teacher's Name<span class="text-red-500">*</span></Label>
            <ComboBox
              :items="list.teachers"
              label-property="display_name"
              value-property="ID"
              :error="form.attendance_status == 1 && !form.teacher_user_id"
              v-model="form.teacher_user_id"
              :select-placeholder="form.teacher_name"
              search-placeholder="Search teacher..."
              @search="findTeachers"
              :loading="loading.teachers"
            ></ComboBox>
          </div>
          <div class="mb-3">
            <Label class="flex items-center space-x-2">
              <Checkbox
                :value="form.revision"
                :checked="form.revision"
                @click.native="form.revision = !form.revision"
              />
              <span class="cursor-pointer">Revision</span>
            </Label>
          </div>
          <div class="">
            <Label>Term / Book</Label>
            <ComboBox
              :items="$page.props.math_terms_books"
              label-property="name"
              value-property="id"
              v-model="search.term_book_id"
              select-placeholder="Select Term/Book"
              search-placeholder="Search term/book..."
              @select="getUnits(search.term_book_id)"
            ></ComboBox>
          </div>
          <div class="">
            <Label>Unit</Label>
            <ComboBox
              :items="options.units"
              label-property="name"
              value-property="id"
              v-model="search.unit_id"
              select-placeholder="Select Unit"
              search-placeholder="Search unit..."
              @select="getLessons(search.unit_id)"
              :loading="loading.units"
            ></ComboBox>
          </div>
          <div class="">
            <Label>Lesson</Label>
            <ComboBox
              :items="options.lessons"
              label-property="name"
              value-property="id"
              v-model="search.lesson_id"
              select-placeholder="Select Lesson"
              search-placeholder="Search lesson..."
              @select="addItem()"
              :loading="loading.lessons"
            ></ComboBox>
          </div>
          <div class="mb-3">
            <Label>Objectives</Label>
            <div
              class="px-4 py-2 bg-slate-100 rounded-lg"
              v-if="!form.report_data.length"
            >
              <Label>No objectives found.</Label>
            </div>
            <Collapsible
              class="bg-white"
              v-else
              v-for="(data, index) in form.report_data"
              v-model="open_objectives[index]"
            >
              <template #trigger>
                <div class="flex items-center space-x-2">
                  <Label>{{ data.term_book_name }}</Label>
                  <Label class="text-red-600 cursor-pointer" @click="deleteItem(index)"
                    >Delete</Label
                  >
                </div>
              </template>
              <template #content>
                <div class="p-1">
                  <div class="flex flex-col space-y-1">
                    <Badge>
                      <span>{{ data.unit_name }}</span>
                    </Badge>
                    <Badge variant="outline">
                      <span>{{ data.lesson_name }}</span>
                    </Badge>
                  </div>
                  <ul class="pt-3 divide-y" v-if="form.revision == false">
                    <li class="" v-for="(objective, objective_index) in data.objectives">
                      <Label class="flex items-center space-x-2 py-2">
                        <Checkbox
                          :value="objective.id"
                          :checked="
                            form.report_data[index].objectives[objective_index].achieved
                          "
                          @click.native="
                            form.report_data[index].objectives[
                              objective_index
                            ].achieved = !form.report_data[index].objectives[
                              objective_index
                            ].achieved
                          "
                        />
                        <span class="cursor-pointer">{{ objective.name }}</span>
                      </Label>
                    </li>
                  </ul>
                </div>
              </template>
            </Collapsible>
            <Label
              class="text-xs text-red-500 font-semibold"
              v-if="!form.report_data.length && form.attendance_status == 1"
              >At least one (1) objective is required.</Label
            >
          </div>
          <div class="">
            <div class="flex justify-between items-center mb-2">
              <Label>Comments</Label>
              <Popover v-model:open="open_prompt">
                <PopoverTrigger>
                  <Button
                    size="xs"
                    variant="outline"
                    class="border-0 bg-gradient-to-r from-purple-300 to-indigo-300 hover:bg-gradient-to-r hover:from-indigo-300 hover:to-purple-300"
                  >
                    <div class="flex items-center">
                      <Wand2
                        class="w-3.5 h-3.5 mr-1 mt-0.5"
                        :class="{ 'animate-pulse': generating.comments }"
                      />
                      <span class="text-xs" v-if="!generating.comments"
                        >Generate with AI</span
                      >
                      <span
                        class="text-xs"
                        :class="{ 'animate-pulse': generating.comments }"
                        v-else
                        >Generating...</span
                      >
                    </div>
                  </Button>
                </PopoverTrigger>
                <PopoverContent
                  :align="'start'"
                  side="left"
                  class="w-96 bg-gradient-to-r from-purple-200 to-indigo-200 bg-opacity-70 p-2"
                >
                  <div class="flex flex-col gap-2">
                    <Textarea
                      class="bg-white placeholder:text-sm placeholder:text-zinc-400"
                      rows="4"
                      type="text"
                      :placeholder="`What would you like to add? \n\nExample: Teaching methods, activities, issues, in Malay/English and etc...`"
                      v-model="additional_inputs"
                    ></Textarea>
                    <Button
                      size="xs"
                      class=""
                      variant=""
                      @click="additional_inputs ? generateComment() : ''"
                      >Prompt It</Button
                    >
                  </div>
                </PopoverContent>
              </Popover>
            </div>
            <div class="relative">
              <Textarea
                class="mb-2"
                rows="10"
                v-model.lazy="form.comments"
                contenteditable="true"
                @mouseup="handleSelection"
                @mousedown="clearSelection"
                @blur="clearSelection"
                @keyup="handleSelection"
              ></Textarea>
              <transition name="fade-slide">
                <Button
                  @blur="clearSelection"
                  @click="improveWriting"
                  v-show="selected_text"
                  size="xs"
                  variant="outline"
                  class="improve-btn bg-gradient-to-r from-purple-200 to-blue-200 font-medium absolute text-xs bottom-3 left-1/2 transform -translate-x-1/2"
                >
                  {{ improving_comment ? "Generating..." : "Improve Writing" }}
                </Button>
              </transition>
            </div>
          </div>
          <div class="">
            <Label>Status</Label>
            <ComboBox
              :items="$page.props.attendance_status"
              label-property="name"
              value-property="id"
              :error="form.attendance_status == 3"
              v-model="form.attendance_status"
              select-placeholder="Select Status"
              search-placeholder="Search status..."
            ></ComboBox>
          </div>
        </div>
      </template>
      <template #footer>
        <Button variant="outline" @click="show_progress_report = false">Cancel</Button>
        <Button @click="updateProgressReport">Save</Button>
      </template>
    </Dialog>
  </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import StudentInformation from "@/Pages/ProgressReport/Templates/StudentInformation.vue";
import moment from "moment";
import axios from "axios";
import FeedbackSummary from "./FeedbackSummary.vue";
import { debounce } from "vue-debounce";
import Card from "@/Components/Card.vue";
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/Components/ui/table";
import Dialog from "@/Components/DialogModal.vue";
import Collapsible from "@/Components/Collapsible.vue";
import { Badge } from "@/Components/ui/badge";
import { Wand2 } from "lucide-vue-next";
import { Popover, PopoverContent, PopoverTrigger } from "@/Components/ui/popover";

export default {
  components: {
    Head,
    Link,
  },
  data() {
    return {
      open_prompt: false,
      selected_text: "",
      additional_inputs: "",
      generating: {
        comments: false,
      },
      improving_comment: false,
      value: [],
      show_progress_report: false,
      open_objectives: [],
      searching: false,
      progress_report_list: {},
      list: {
        teachers: [],
      },
      options: {
        terms_books: [],
        units: [],
        lessons: [],
        objectives: [],
      },
      loading: {
        terms_books: false,
        units: false,
        lessons: false,
        objectives: false,
        teachers: false,
      },
      search: {
        term_book_id: "",
        unit_id: [],
        lesson_id: [],
      },
      form: {
        teacher_user_id: "",
        revision: true,
        date: "",
        report_data: [],
        comments: "",
        attendance_status: "",
      },
    };
  },
  methods: {
    viewProgressReport(index) {
      this.clearSearch();
      this.form.report_id = this.$page.props.progress_reports[index].id;
      this.form.teacher_user_id = this.$page.props.progress_reports[
        index
      ].teacher_user_id;
      this.form.teacher_name = this.$page.props.progress_reports[index].display_name;
      this.form.date = this.$page.props.progress_reports[index].date;
      this.form.report_data = JSON.parse(
        this.$page.props.progress_reports[index].report_data
      )
        ? JSON.parse(this.$page.props.progress_reports[index].report_data)
        : [];
      this.form.attendance_status = this.$page.props.progress_reports[
        index
      ].attendance_status;
      this.form.comments = this.$page.props.progress_reports[index].comments;
      this.form.revision = !!this.$page.props.progress_reports[index].revision;
      this.show_progress_report = true;
    },
    updateProgressReport() {
      if (
        !this.form.date ||
        this.form.attendance_status == 3 ||
        (this.form.attendance_status == 1 && this.form.report_data.length < 1) ||
        (this.form.attendance_status == 1 && !this.form.teacher_user_id)
      ) {
        return;
      }
      this.$inertia.post(route("progress_report.store"), this.form, {
        preserveScroll: true,
        preserveState: false,
      });
    },
    findTeachers: debounce(function (query) {
      if (query) {
        this.loading.teachers = true;
        axios
          .get(route("teachers.find"), {
            params: {
              keyword: query,
            },
          })
          .then((res) => {
            this.list.teachers = res.data;
            this.loading.teachers = false;
          });
      }
    }, 1000),
    getUnits(term_book_id) {
      this.loading.units = true;

      this.options.units = [];
      this.options.lessons = [];

      this.search.unit_id = [];
      this.search.lesson_id = "";

      axios
        .get(route("progress_report.get_math_units", term_book_id))
        .then((response) => {
          this.options.units = response.data;
          this.loading.units = false;
        });
    },
    getLessons(unit_id) {
      this.loading.lessons = true;

      this.options.lessons = [];

      this.search.lesson_id = "";

      axios.get(route("progress_report.get_math_lessons", unit_id)).then((response) => {
        this.options.lessons = response.data;
        this.loading.lessons = false;
      });
    },
    addItem() {
      if (this.searching) {
        return;
      }
      if (this.search.term_book_id && this.search.unit_id && this.search.lesson_id) {
        const lessonIdExists = this.form.report_data.some(
          (item) => item.lesson_id === this.search.lesson_id
        );
        if (lessonIdExists) {
          alert("Item Exists!");
        } else {
          this.searching = true;
          axios
            .get(route("progress_report.get_math_objectives", this.search.lesson_id))
            .then((response) => {
              const new_item = {
                term_book_id: this.search.term_book_id,
                term_book_name: this.$page.props.math_terms_books.find(
                  (item) => item.id === this.search.term_book_id
                )?.name,
                unit_id: this.search.unit_id,
                unit_name: this.options.units.find(
                  (item) => item.id === this.search.unit_id
                )?.name,
                lesson_id: this.search.lesson_id,
                lesson_name: this.options.lessons.find(
                  (item) => item.id === this.search.lesson_id
                )?.name,
                objectives: [],
              };
              const initialLength = this.form.report_data.length;
              const test = this.form.report_data.push(new_item);
              const addedItemIndex = initialLength;
              const addedItem = this.form.report_data[addedItemIndex];

              response.data.forEach((data) => {
                addedItem.objectives.push({
                  id: data.id,
                  name: data.name,
                  achieved: false,
                });
              });
              this.searching = false;
            });
        }
      }
    },
    deleteItem(index) {
      this.form.report_data.splice(index, 1);
    },
    clearSearch() {
      this.form.teacher_user_id = "";
      this.search.term_book_id = "";
      this.search.unit_id = [];
      this.search.lesson_id = "";
    },
    async generateComment() {
      if (this.generating.comments) {
        return;
      }
      this.generating.comments = true;
      this.open_prompt = false;

      this.form.comments = "";

      const response = await fetch("/api/ai/comment-generator", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          user_prompt: `
                Report Content:
                ${JSON.stringify(this.form.report_data)}

                User Additional Information:
                ${this.additional_inputs}`,
        }),
      });

      if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

      const reader = response.body.getReader();
      const decoder = new TextDecoder();
      let result = "";

      while (true) {
        const { done, value } = await reader.read();
        if (done) break;

        this.form.comments += decoder.decode(value, { stream: true });
      }
      this.additional_inputs = "";

      this.generating.comments = false;
    },
    async improveWriting() {
      if (this.improving_comment) {
        return;
      }
      this.improving_comment = true;

      if (this.selected_text) {
        const temp_text = JSON.parse(JSON.stringify(this.selected_text));
        const response = await fetch("/api/ai/comment-improve", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            user_prompt: `
                Report Content:
                ${JSON.stringify(this.form.report_data)}

                Actual Comment:
                ${this.form.comments}

                Selected phrase:
                ${this.selected_text}`,
          }),
        });

        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

        const reader = response.body.getReader();
        const decoder = new TextDecoder();

        let new_text = "";
        while (true) {
          const { done, value } = await reader.read();
          if (done) break;

          new_text += decoder.decode(value, { stream: true });
        }
        this.form.comments = this.form.comments.replaceAll(temp_text, new_text);
      }

      this.improving_comment = false;
    },
    handleSelection() {
      const selection = window.getSelection();
      if (selection.rangeCount > 0 && selection.toString().trim().length > 0) {
        this.selected_text = selection.toString();
      } else {
        this.selected_text = "";
      }
    },
    clearSelection(event) {
      if (event && event.relatedTarget && event.relatedTarget.matches(".improve-btn")) {
        return;
      }
      window.getSelection().removeAllRanges();
      this.selected_text = "";
    },
  },
};
</script>
