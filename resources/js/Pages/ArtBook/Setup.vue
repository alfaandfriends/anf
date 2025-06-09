<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Admin/Authenticated.vue";
import { Inertia } from "@inertiajs/inertia";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { ref, watch } from "vue";
import axios from "axios";
import { debounce } from "vue-debounce";

// Shadcn UI components
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import Card from "@/Components/Card.vue";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from "@/Components/ui/dialog";
import ComboBox from "@/Components/ComboBox.vue";
import { Checkbox } from "@/Components/ui/checkbox";
import {
  ArrowLeftIcon,
  PlusIcon,
  TrashIcon,
  PencilIcon,
  Cog,
  ArrowRightIcon,
} from "lucide-vue-next";
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/Components/ui/table";
import { Badge } from "@/Components/ui/badge";
import { MagnifyingGlassIcon } from "@radix-icons/vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
  themes: Array,
  conditions: Object,
});

// Form states
const conditionForm = ref({
  id: "",
  theme_id: "",
  lesson_id: "",
  activity_id: "",
  artwork_number: 1,
});

// Modal states
const showConditionModal = ref(false);
const isEditing = ref(false);

// Error states
const errors = ref({
  condition: {},
});

// Dropdown data
const lessons = ref([]);
const activities = ref([]);

// Loading states
const loading = ref({
  lessons: false,
  activities: false,
  submit: false,
});

// Search and filter
const searchQuery = ref("");
const filteredConditions = ref([]);

// Initialize filtered conditions with all conditions
filteredConditions.value = props.conditions.data;

// Search function
const search = debounce(function () {
  if (searchQuery.value) {
    filteredConditions.value = props.conditions.data.filter((condition) => {
      const themeName = props.themes.find((t) => t.id === condition.theme_id)?.name || "";
      return (
        themeName.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        condition.lesson_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        condition.activity_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        condition.artwork_number.toString().includes(searchQuery.value)
      );
    });
  } else {
    filteredConditions.value = props.conditions.data;
  }
}, 300);

// Watch for lesson_id changes to fetch activities
watch(
  () => conditionForm.value.lesson_id,
  (newLessonId) => {
    if (newLessonId) {
      fetchActivities(newLessonId);
    } else {
      activities.value = [];
    }
  }
);

// Fetch lessons when theme changes
const fetchLessons = (themeId) => {
  if (!themeId) return;

  loading.value.lessons = true;
  axios
    .get(route("art_book.get_lessons", themeId))
    .then((response) => {
      lessons.value = response.data;
      loading.value.lessons = false;
    })
    .catch((error) => {
      console.error("Error fetching lessons:", error);
      loading.value.lessons = false;
    });
};

// Fetch activities when lesson changes
const fetchActivities = (lessonId) => {
  if (!lessonId) return;

  loading.value.activities = true;
  axios
    .get(route("art_book.get_activities", lessonId))
    .then((response) => {
      activities.value = response.data;
      loading.value.activities = false;
    })
    .catch((error) => {
      console.error("Error fetching activities:", error);
      loading.value.activities = false;
    });
};

// Open condition modal
const openConditionModal = (condition = null) => {
  isEditing.value = !!condition;

  if (condition) {
    loading.value.submit = true;
    conditionForm.value = {
      id: condition.id,
      theme_id: condition.theme_id,
      lesson_id: condition.lesson_id,
      activity_id: condition.activity_id,
      artwork_number: condition.artwork_number,
    };

    // First load lessons
    axios
      .get(route("art_book.get_lessons", condition.theme_id))
      .then((response) => {
        lessons.value = response.data;
        // After lessons are loaded, load activities
        return axios.get(route("art_book.get_activities", condition.lesson_id));
      })
      .then((response) => {
        activities.value = response.data;
        // Only open modal after both lessons and activities are loaded
        showConditionModal.value = true;
        loading.value.submit = false;
      })
      .catch((error) => {
        console.error("Error loading data:", error);
        loading.value.submit = false;
      });
  } else {
    conditionForm.value = {
      id: "",
      theme_id: "",
      lesson_id: "",
      activity_id: "",
      artwork_number: 1,
    };
    showConditionModal.value = true;
  }

  errors.value.condition = {};
};

// Submit condition form
const submitConditionForm = () => {
  loading.value.submit = true;

  const url = isEditing.value
    ? route("art_book.update_condition")
    : route("art_book.store_condition");

  Inertia.post(url, conditionForm.value, {
    preserveState: false,
    onSuccess: () => {
      showConditionModal.value = false;
      loading.value.submit = false;
      // Reset form and errors after successful submission
      conditionForm.value = {
        id: "",
        theme_id: "",
        lesson_id: "",
        activity_id: "",
        artwork_number: 1,
      };
      errors.value.condition = {};
    },
    onError: (errors) => {
      if (errors) {
        errors.value.condition = errors;
      }
      loading.value.submit = false;
    },
  });
};

// Delete condition
const deleteCondition = (id) => {
  if (confirm("Are you sure you want to delete this condition?")) {
    axios
      .delete(route("art_book.delete_condition", id))
      .then(() => {
        Inertia.reload({ only: ["conditions"] });
      })
      .catch((error) => {
        console.error("Error deleting condition:", error);
      });
  }
};

// Navigate back to art book index
const navigateBack = () => {
  Inertia.visit(route("art_book"));
};

// Add pagination methods
const handlePageChange = (page) => {
  Inertia.visit(route("art_book.setup", { page }), {
    preserveState: true,
    preserveScroll: true,
    only: ["conditions"],
  });
};
</script>

<template>
  <Head title="Art Book Settings" />

  <BreezeAuthenticatedLayout>
    <template #header></template>

    <div class="flex items-center justify-between">
      <div class="flex justify-between space-x-2">
        <!-- <div class="relative">
          <MagnifyingGlassIcon
            class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground"
          />
          <Input
            type="text"
            placeholder="Search conditions..."
            class="w-full rounded-lg bg-background pl-8 md:w-[200px] lg:w-[336px]"
            v-model="searchQuery"
            @input="search"
          />
        </div> -->
        <!-- <Button variant="outline" @click="navigateBack">
          <ArrowLeftIcon class="w-4 h-4 mr-2" /> Back to Art Book
        </Button> -->
      </div>
      <!-- <Button @click="openConditionModal()">
        <PlusIcon class="w-4 h-4 mr-2" /> Add Condition
      </Button> -->
    </div>

    <Card>
      <template #content>
        <Table>
          <TableHeader class="bg-gray-100">
            <TableRow>
              <TableHead>#</TableHead>
              <TableHead>Theme</TableHead>
              <TableHead>Artwork Number</TableHead>
              <TableHead>Lesson</TableHead>
              <TableHead>Activity</TableHead>
              <TableHead class="text-center">Actions</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-if="!filteredConditions.length">
              <TableCell class="text-center" colspan="6">
                <div class="p-3">No conditions found</div>
              </TableCell>
            </TableRow>
            <TableRow
              v-for="(condition, index) in filteredConditions"
              :key="condition.id"
            >
              <TableCell>{{
                (conditions.current_page - 1) * conditions.per_page + index + 1
              }}</TableCell>
              <TableCell>
                <!-- <Badge> -->
                {{
                  props.themes.find((t) => t.id === condition.theme_id)?.name || "Unknown"
                }}
                <!-- </Badge> -->
              </TableCell>
              <TableCell>{{ condition.artwork_number }}</TableCell>
              <TableCell>{{ condition.lesson_name || "Unknown" }}</TableCell>
              <TableCell>{{ condition.activity_name || "Unknown" }}</TableCell>
              <TableCell class="text-center">
                <div class="flex justify-center space-x-2">
                  <Button
                    variant="outline"
                    size="sm"
                    @click="openConditionModal(condition)"
                  >
                    <PencilIcon class="w-4 h-4 mr-1" /> Edit
                  </Button>
                  <!-- <Button
                    variant="destructive"
                    size="sm"
                    @click="deleteCondition(condition.id)"
                  >
                    <TrashIcon class="w-4 h-4 mr-1" /> Delete
                  </Button> -->
                </div>
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>

        <!-- Replace the existing pagination with the Pagination component -->
      </template>
    </Card>
    <Pagination :page_data="conditions" :params="{}" />

    <!-- Condition Modal -->
    <Dialog :open="showConditionModal" @update:open="showConditionModal = $event">
      <DialogContent>
        <DialogHeader>
          <DialogTitle>{{
            isEditing ? "Edit Artwork Condition" : "Add Artwork Condition"
          }}</DialogTitle>
        </DialogHeader>
        <div class="grid gap-4 py-4">
          <div class="grid gap-2">
            <Label for="condition-theme">Theme<span class="text-red-500">*</span></Label>
            <ComboBox
              v-model="conditionForm.theme_id"
              :items="props.themes"
              label-property="name"
              value-property="id"
              select-placeholder="Select a theme"
              search-placeholder="Search theme..."
              :error="errors.condition?.theme_id"
              :disabled="true"
            />
            <p v-if="errors.condition?.theme_id" class="text-xs text-red-500">
              {{ errors.condition.theme_id[0] }}
            </p>
          </div>

          <div class="grid gap-2">
            <Label for="condition-artwork-number"
              >Artwork Number<span class="text-red-500">*</span></Label
            >
            <Input
              id="condition-artwork-number"
              v-model="conditionForm.artwork_number"
              type="number"
              min="1"
              max="7"
              :class="{ 'border-red-500': errors.condition?.artwork_number }"
              disabled
            />
            <p v-if="errors.condition?.artwork_number" class="text-xs text-red-500">
              {{ errors.condition.artwork_number[0] }}
            </p>
            <p class="text-xs text-gray-500">
              Number between 1-7 representing the artwork position
            </p>
          </div>

          <div class="grid gap-2">
            <Label for="condition-lesson"
              >Lesson<span class="text-red-500">*</span></Label
            >
            <ComboBox
              v-model="conditionForm.lesson_id"
              :items="lessons"
              label-property="name"
              value-property="id"
              select-placeholder="Select a lesson"
              search-placeholder="Search lesson..."
              :disabled="loading.lessons || !conditionForm.theme_id"
              :loading="loading.lessons"
              :error="errors.condition?.lesson_id"
            />
            <p v-if="errors.condition?.lesson_id" class="text-xs text-red-500">
              {{ errors.condition.lesson_id[0] }}
            </p>
          </div>

          <div class="grid gap-2">
            <Label for="condition-activity"
              >Activity<span class="text-red-500">*</span></Label
            >
            <ComboBox
              v-model="conditionForm.activity_id"
              :items="activities"
              label-property="name"
              value-property="id"
              select-placeholder="Select an activity"
              search-placeholder="Search activity..."
              :disabled="loading.activities || !conditionForm.lesson_id"
              :loading="loading.activities"
              :error="errors.condition?.activity_id"
            />
            <p v-if="errors.condition?.activity_id" class="text-xs text-red-500">
              {{ errors.condition.activity_id[0] }}
            </p>
          </div>
        </div>
        <DialogFooter>
          <Button variant="outline" @click="showConditionModal = false">Cancel</Button>
          <Button @click="submitConditionForm" :disabled="loading.submit">
            {{ isEditing ? "Update" : "Save" }}
          </Button>
        </DialogFooter>
      </DialogContent>
    </Dialog>
  </BreezeAuthenticatedLayout>
</template>
