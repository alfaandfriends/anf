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
              <TableCell class="text-center space-x-2">
                <Button variant="outline" @click="viewProgressReport(index)">Edit</Button>
                <!-- <Button variant="" @click="showGenerateQrModal(result.id)">Upload Artwork</Button> -->
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
          <div class="mb-3">
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
          <div class="">
            <Label>Theme</Label>
            <ComboBox
              :items="$page.props.art_traditional_themes"
              label-property="name"
              value-property="id"
              v-model="search.theme_id"
              select-placeholder="Select Theme"
              search-placeholder="Search theme..."
              @select="getLessons(search.theme_id)"
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
              @select="getActivity(search.lesson_id)"
              :loading="loading.lessons"
            ></ComboBox>
          </div>
          <div class="">
            <Label>Activity</Label>
            <ComboBox
              :items="options.activities"
              label-property="name"
              value-property="id"
              v-model="search.activity_id"
              select-placeholder="Select Activity"
              search-placeholder="Search activity..."
              @select="getOutcomes(search.activity_id)"
              :loading="loading.activities"
            ></ComboBox>
          </div>
          <div class="">
            <Label>Learning Outcome</Label>
            <ComboBox
              :items="options.outcomes"
              label-property="name"
              value-property="id"
              v-model="search.outcome_id"
              select-placeholder="Select Outcome"
              search-placeholder="Search outcome..."
              @select="addItem()"
              :loading="loading.outcomes"
            ></ComboBox>
          </div>
          <div>
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
                  <Label>{{ data.theme_name }} : {{ data.lesson_name }}</Label>
                  <Label class="text-red-600 cursor-pointer" @click="deleteItem(index)"
                    >Delete</Label
                  >
                </div>
              </template>
              <template #content>
                <div class="p-1">
                  <!-- <div class="flex flex-col space-y-1">
                                        <template v-for="lesson, lesson_index in theme.lessons">
                                            <span class="font-semibold underline text-[14px]">{{ lesson.lesson_name }}</span>
                                            <template v-for="activity, activity_index in lesson.activities">
                                                <Badge variant="ghost">
                                                    <span>{{ activity.activity_name }}</span>
                                                </Badge>
                                                <template v-for="outcome, outcome_index in activity.outcomes">
                                                    <Badge>
                                                        <span>{{ outcome.outcome_name }}</span>
                                                    </Badge>
                                                    <ul class="divide-y">
                                                        <li class="" v-for="objective, objective_index in outcome.objectives">
                                                            <Label class="flex items-center space-x-2 py-2">
                                                                <Checkbox :value="objective.id" :checked="objective.achieved" @click.native="objective.achieved = !objective.achieved"/>
                                                                <span class="cursor-pointer">{{ objective.name }}</span> 
                                                            </Label>
                                                        </li>
                                                    </ul>
                                                </template>
                                                <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-3">
                                                    <div class="flex flex-col space-y-2 items-center">
                                                        <div @click.passive="triggerInput(index)" class="border border-slate-300 rounded h-20 w-20 flex justify-center items-center hover:bg-gray-50 cursor-pointer">
                                                            <Plus class="text-slate-400"></Plus>
                                                            <input
                                                                type="file"
                                                                :ref="'artworkInput_' + index"
                                                                class="hidden"
                                                                accept="image/*"
                                                                multiple
                                                                @change="handleFileUpload($event, index)"
                                                            />
                                                        </div>
                                                        <Label class="cursor-pointer text-xs">Add Artwork</Label>
                                                    </div>
                                                    <div class="flex flex-col items-center relative" v-if="data.artworks" v-for="artwork, artwork_index in data.artworks">
                                                        <XCircle class="absolute -top-2 -right-2 h-5 w-5 cursor-pointer text-red-500" @click="deleteFile(index, artwork_index)"></XCircle>
                                                        <img class="border border-slate-300 h-20 w-20 rounded cursor-pointer" :src="artwork.filename ? '/storage/art_gallery/'+artwork.filename : artwork.blob_url" :alt="artwork.filename" @click="openArtworkInNewTab(artwork)">
                                                        <div class="flex items-center space-x-1 mt-2">
                                                            <Checkbox :id="index+'_'+artwork_index" :checked="!!form.report_data[index].artworks[artwork_index].for_artbook" @click.native="form.report_data[index].artworks[artwork_index].for_artbook = !form.report_data[index].artworks[artwork_index].for_artbook"></Checkbox>
                                                            <Label :for="index+'_'+artwork_index" class="cursor-pointer text-xs">Art Book</Label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </template>
                                    </div> -->
                  <div class="flex flex-col space-y-1">
                    <Badge>
                      <span>{{ data.activity_name }}</span>
                    </Badge>
                    <Badge variant="outline">
                      <span>{{ data.outcome_name }}</span>
                    </Badge>
                  </div>
                  <ul class="pt-3 divide-y">
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
                  <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-3">
                    <div class="flex flex-col space-y-2 items-center">
                      <div
                        @click.passive="triggerInput(index)"
                        class="border border-slate-300 rounded h-20 w-20 flex justify-center items-center hover:bg-gray-50 cursor-pointer"
                      >
                        <Plus class="text-slate-400"></Plus>
                        <input
                          type="file"
                          :ref="'artworkInput_' + index"
                          class="hidden"
                          accept="image/*"
                          multiple
                          @change="handleFileUpload($event, index)"
                        />
                      </div>
                      <Label class="cursor-pointer text-xs">Add Artwork</Label>
                    </div>
                    <div
                      class="flex flex-col items-center relative"
                      v-if="data.artworks"
                      v-for="(artwork, artwork_index) in data.artworks"
                    >
                      <XCircle
                        class="absolute -top-2 -right-2 h-5 w-5 cursor-pointer text-red-500"
                        @click="deleteFile(index, artwork_index)"
                      ></XCircle>
                      <img
                        class="border border-slate-300 h-20 w-20 rounded cursor-pointer"
                        :src="
                          artwork.filename
                            ? '/storage/art_gallery/' + artwork.filename
                            : artwork.blob_url
                        "
                        :alt="artwork.filename"
                        @click="openArtworkInNewTab(artwork)"
                      />
                      <!-- <div class="flex items-center space-x-1 mt-2">
                        <Checkbox
                          :id="index + '_' + artwork_index"
                          :checked="
                            !!form.report_data[index].artworks[artwork_index].for_artbook
                          "
                          @click.native="
                            form.report_data[index].artworks[
                              artwork_index
                            ].for_artbook = !form.report_data[index].artworks[
                              artwork_index
                            ].for_artbook
                          "
                        ></Checkbox>
                        <Label
                          :for="index + '_' + artwork_index"
                          class="cursor-pointer text-xs"
                          >Art Book</Label
                        >
                      </div> -->
                    </div>
                  </div>
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
    <Dialog v-model:open="show_qr_modal" classProp="max-w-sm">
      <template #title>Generate QR for upload</template>
      <template #content>
        <div class="p-1 grid grid-cols-1 items-center gap-2">
          <template v-if="!qr_data.image">
            <div>
              <Label>Theme</Label>
              <ComboBox
                :items="$page.props.art_themes"
                label-property="name"
                value-property="id"
                :error="!qr_data.theme_id"
                v-model="qr_data.theme_id"
                select-placeholder="Select Theme"
                search-placeholder="Search theme..."
                @select="getLessons(qr_data.theme_id)"
              ></ComboBox>
            </div>
            <div>
              <Label>Lesson</Label>
              <ComboBox
                :items="options.lessons"
                label-property="name"
                value-property="id"
                :error="!qr_data.lesson_id"
                v-model="qr_data.lesson_id"
                select-placeholder="Select Lesson"
                search-placeholder="Search lesson..."
                @select="getActivity(qr_data.lesson_id)"
                :loading="loading.lessons"
              ></ComboBox>
            </div>
            <div>
              <Label>Activity</Label>
              <ComboBox
                :items="options.activities"
                label-property="name"
                value-property="id"
                :error="!qr_data.activity_id"
                v-model="qr_data.activity_id"
                select-placeholder="Select Activity"
                search-placeholder="Search activity..."
                :loading="loading.activities"
              ></ComboBox>
            </div>
            <Button
              @click="generateQr"
              :class="
                qr_data.student_id &&
                qr_data.theme_id &&
                qr_data.lesson_id &&
                qr_data.activity_id
                  ? ''
                  : 'cursor-not-allowed opacity-30'
              "
              >Generate QR</Button
            >
          </template>
          <div class="flex flex-col items-center" v-else>
            <div class="h-40 w-40" v-html="qr_data.image"></div>
          </div>
        </div>
      </template>
      <template #footer>
        <Button variant="outline" @click="show_qr_modal = false">Close</Button>
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
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/Components/ui/table";
import Dialog from "@/Components/DialogModal.vue";
import Collapsible from "@/Components/Collapsible.vue";
import { Badge } from "@/Components/ui/badge";
import { Plus, Wand2, XCircle } from "lucide-vue-next";
import { Popover, PopoverContent, PopoverTrigger } from "@/Components/ui/popover";

export default {
  components: {
    Head,
    Link,
  },
  computed: {
    groupedData() {
      return this.form.report_data.reduce((acc, report) => {
        // Group by theme
        let theme = acc.find((t) => t.theme_id === report.theme_id);
        if (!theme) {
          theme = {
            theme_id: report.theme_id,
            theme_name: report.theme_name,
            lessons: [],
          };
          acc.push(theme);
        }

        // Group by lesson
        let lesson = theme.lessons.find((l) => l.lesson_id === report.lesson_id);
        if (!lesson) {
          lesson = {
            lesson_id: report.lesson_id,
            lesson_name: report.lesson_name,
            activities: [],
          };
          theme.lessons.push(lesson);
        }

        // Group by activity
        let activity = lesson.activities.find(
          (a) => a.activity_id === report.activity_id
        );
        if (!activity) {
          activity = {
            activity_id: report.activity_id,
            activity_name: report.activity_name,
            outcomes: [],
          };
          lesson.activities.push(activity);
        }

        // Group by activity
        let outcome = activity.outcomes.find((a) => a.outcome_id === report.outcome_id);
        if (!outcome) {
          outcome = {
            outcome_id: report.outcome_id,
            outcome_name: report.outcome_name,
          };
          activity.outcomes.push(outcome);
        }

        // Add the report to the corresponding activity
        outcome.objectives = report.objectives;

        return acc;
      }, []);
    },
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
      show_select_student: false,
      show_qr_modal: false,
      show_progress_report: false,
      open_objectives: [],
      searching: false,
      progress_report_list: {},
      qr_data: {
        report_detail_id: "",
        student_id: "",
        theme_id: "",
        lesson_id: "",
        activity_id: "",
        image: "",
      },
      disabled: {
        themes: true,
        lessons: true,
        activities: true,
        outcomes: true,
      },
      list: {
        teachers: [],
        students: [],
        artworks: [],
      },
      options: {
        themes: [],
        lessons: [],
        activities: [],
        outcomes: [],
        objectives: [],
      },
      loading: {
        themes: false,
        lessons: false,
        activities: false,
        outcomes: false,
        teachers: false,
      },
      search: {
        theme_id: "",
        lesson_id: "",
        activity_id: "",
        outcome_id: "",
      },
      form: {
        student_id: "",
        student_level: "",
        teacher_user_id: "",
        date: "",
        report_data: [],
        comments: "",
        attendance_status: "",
        file_to_delete: [],
      },
    };
  },
  methods: {
    viewProgressReport(index) {
      this.clearSearch();
      axios
        .get(route("progress_report.artworks"), {
          params: {
            report_detail_id: this.$page.props.progress_reports[index].id,
          },
        })
        .then((response) => {
          this.list.artworks = response.data;
          this.form.student_id = this.$page.props.student_info.id;
          this.form.student_level = this.$page.props.student_info.level;
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
          this.form.file_to_delete = [];
          this.show_progress_report = true;
        });
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
    findStudents: debounce(function (query) {
      if (query) {
        this.isLoading = true;
        axios
          .get(route("students.find_digital_art_students"), {
            params: {
              keyword: query,
            },
          })
          .then((res) => {
            this.list.students = res.data;
            this.isLoading = false;
          });
      }
    }, 1000),
    getLessons(theme_id) {
      this.loading.lessons = true;

      this.options.lessons = [];
      this.options.activities = [];
      this.options.outcomes = [];

      this.search.lesson_id = "";
      this.search.activity_id = "";
      this.search.outcome_id = "";

      axios
        .get(route("progress_report.get_art_traditional_lessons", theme_id))
        .then((response) => {
          this.options.lessons = response.data;
          this.loading.lessons = false;
        });
    },
    getActivity(lesson_id) {
      this.loading.activities = true;

      this.options.activities = [];
      this.options.outcomes = [];

      this.search.activity_id = "";
      this.search.outcome_id = "";

      axios
        .get(route("progress_report.get_art_traditional_activities", lesson_id))
        .then((response) => {
          this.options.activities = response.data;
          this.loading.activities = false;
        });
    },
    getOutcomes(activity_id) {
      this.loading.outcomes = true;

      this.options.outcomes = [];

      this.search.outcome_id = "";

      axios
        .get(route("progress_report.get_art_traditional_learning_outcomes", activity_id))
        .then((response) => {
          this.options.outcomes = response.data;
          this.loading.outcomes = false;
        });
    },
    addItem() {
      if (this.searching) {
        return;
      }
      if (
        this.search.theme_id &&
        this.search.lesson_id &&
        this.search.activity_id &&
        this.search.outcome_id
      ) {
        const itemExists = this.form.report_data.some(
          (item) => item.outcome_id === this.search.outcome_id
        );
        if (itemExists) {
          alert("Item exists!");
        } else {
          this.searching = true;
          axios
            .get(
              route(
                "progress_report.get_art_traditional_objectives",
                this.search.outcome_id
              )
            )
            .then((response) => {
              const new_item = {
                theme_id: this.search.theme_id,
                theme_name: this.$page.props.art_themes.find(
                  (item) => item.id === this.search.theme_id
                )?.name,
                lesson_id: this.search.lesson_id,
                lesson_name: this.options.lessons.find(
                  (item) => item.id === this.search.lesson_id
                )?.name,
                activity_id: this.search.activity_id,
                activity_name: this.options.activities.find(
                  (item) => item.id === this.search.activity_id
                )?.name,
                outcome_id: this.search.outcome_id,
                outcome_name: this.options.outcomes.find(
                  (item) => item.id === this.search.outcome_id
                )?.name,
                objectives: [],
                artworks: [],
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
      this.search.theme_id = "";
      this.search.lesson_id = "";
      this.search.outcome_id = "";
      this.search.activity_id = "";
    },
    scrollToTop() {
      const modalContent = this.$refs.progress_report;
      if (modalContent) {
        modalContent.scrollTop = 0;
      }
    },
    showGenerateQrModal(report_detail_id) {
      this.clearQrModal();
      this.qr_data.student_id = this.$page.props.student_info.id;
      this.qr_data.report_detail_id = report_detail_id;
      this.qr_data.level = this.$page.props.student_info.level;
      this.show_qr_modal = true;
    },
    generateQr() {
      if (
        this.qr_data.student_id &&
        this.qr_data.theme_id &&
        this.qr_data.lesson_id &&
        this.qr_data.activity_id
      ) {
        axios
          .post(route("progress_report.generate_qr"), this.qr_data)
          .then((response) => {
            this.qr_data.image = response.data;
          });
      }
    },
    clearQrModal() {
      this.qr_data.report_detail_id = "";
      this.qr_data.student_id = "";
      this.qr_data.level = "";
      this.qr_data.theme_id = "";
      this.qr_data.lesson_id = "";
      this.qr_data.activity_id = "";
      this.qr_data.image = "";
    },
    openArtworkInNewTab(artwork) {
      const url = artwork.filename
        ? "/storage/art_gallery/" + artwork.filename
        : artwork.blob_url;
      window.open(url, "_blank");
    },
    triggerInput(index) {
      this.$refs["artworkInput_" + index][0].click();
    },
    handleFileUpload(event, index) {
      const files = event.target.files;
      for (let i = 0; i < files.length; i++) {
        if (!files[i].type.startsWith("image/")) {
          alert(`${files[i].name} is not an image file.`);
          return;
        }
        if (!this.form.report_data[index].artworks) {
          this.form.report_data[index].artworks = [];
        }
        if (
          this.form.report_data[index].artworks.find(
            (item) => item.file && item.file.name == files[i].name
          )
        ) {
          alert(`${files[i].name} already_exists.`);
          return;
        }
        const blob = new Blob([files[i]], { type: files[i].type });
        const blob_url = URL.createObjectURL(blob);

        this.form.report_data[index].artworks.push({
          file: files[i],
          blob_url: blob_url,
          for_artbook: false,
        });
      }
    },
    deleteFile(index, artwork_index) {
      if (this.form.report_data[index].artworks[artwork_index].filename) {
        this.form.file_to_delete.push(
          this.form.report_data[index].artworks[artwork_index].filename
        );
      }
      this.form.report_data[index].artworks.splice(artwork_index, 1);
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
