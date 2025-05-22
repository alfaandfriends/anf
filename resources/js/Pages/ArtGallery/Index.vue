<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Admin/Authenticated.vue";
</script>

<template>
  <Head title="Art Gallery" />

  <BreezeAuthenticatedLayout>
    <template #header></template>
    <div class="flex items-center justify-between space-x-2">
      <div class="flex justify-between space-x-2">
        <div class="relative">
          <MagnifyingGlassIcon
            class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground"
          />
          <Input
            type="text"
            placeholder="Search"
            class="w-full rounded-lg bg-background pl-8 md:w-[200px] lg:w-[336px]"
            v-debounce:800ms="search"
            v-model="params.search"
          />
        </div>
        <Button
          class="border border-slate-700 border-dashed bg-white text-slate-800 hover:bg-slate-50"
          @click="showFilters()"
        >
          <Filter class="h-4 w-4" />
          <span class="ml-1 hidden sm:block">Filters</span>
        </Button>
        <!-- <Button @click="$inertia.get(route('art_gallery.setting.levels'))"> 
                    <Settings class="h-4 w-4" />
                    <span class="ml-1 hidden sm:block">Setting</span>
                </Button> -->
      </div>
      <!-- <Button @click="show_add_artwork = true" v-if="$page.props.can.create_art_gallery">
                <PlusCircle class="h-4 w-4" />
                <span class="ml-1 hidden sm:block">New Artwork</span>
            </Button> -->
    </div>
    <div
      class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-5 gap-2"
      v-if="show_filters"
    >
      <ComboBox
        canClear
        :items="$page.props.levels"
        label-property="name"
        value-property="id"
        @select="search"
        v-model="params.level"
        select-placeholder="Levels"
        search-placeholder="Search level..."
      ></ComboBox>
      <ComboBox
        canClear
        :items="$page.props.themes"
        label-property="name"
        value-property="id"
        @select="search"
        v-model="params.theme"
        select-placeholder="Themes"
        search-placeholder="Search theme..."
      ></ComboBox>
      <ComboBox
        canClear
        :items="student_status"
        label-property="name"
        value-property="id"
        @select="search"
        v-model="params.status"
        select-placeholder="Status"
        search-placeholder="Search status..."
      ></ComboBox>
      <div class="">
        <Button @click="$inertia.get(route('art_gallery'))">Clear Search</Button>
      </div>
    </div>
    <Card>
      <template #content>
        <Table>
          <TableHeader class="bg-gray-100">
            <TableRow>
              <TableHead>#</TableHead>
              <TableHead>Name</TableHead>
              <TableHead>Level</TableHead>
              <TableHead>Theme</TableHead>
              <TableHead>Lesson - Title</TableHead>
              <TableHead>Activity</TableHead>
              <TableHead class="text-center">Action</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-if="!$page.props.arts.data.length">
              <TableCell class="text-center" colspan="10">
                <div class="p-3">No Record Found</div>
              </TableCell>
            </TableRow>
            <TableRow v-for="(result, index) in $page.props.arts.data">
              <TableCell>{{ $page.props.arts.from + index }}</TableCell>
              <TableCell>{{ result.student_name }}</TableCell>
              <TableCell>{{ result.level }}</TableCell>
              <TableCell>{{ result.theme }}</TableCell>
              <TableCell>{{ result.lesson }}</TableCell>
              <TableCell>{{ result.activity }}</TableCell>
              <TableCell class="text-center">
                <div class="flex justify-center space-x-2">
                  <Button
                    variant="outline"
                    @click="viewArtwork(result.art_file_location)"
                    v-if="$page.props.can.edit_art_gallery"
                    >View</Button
                  >
                  <Button
                    variant="destructive"
                    @click="deleteArtwork(result.artwork_id)"
                    v-if="$page.props.can.delete_art_gallery"
                    >Delete</Button
                  >
                </div>
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </template>
    </Card>
    <Pagination :page_data="$page.props.arts" :params="params"></Pagination>
    <DeleteConfirmation
      :open="confirmation.is_open"
      @close="confirmation.is_open = false"
      :routeName="confirmation.route_name"
      :id="confirmation.id"
    >
      <template #title>Delete Artwork</template>
      <template #description>Are you sure want to delete this artwork?</template>
    </DeleteConfirmation>
    <FsLightbox
      :toggler="lightbox.open"
      :sources="lightbox.src"
      :exitFullscreenOnClose="true"
    />
    <Dialog v-model:open="show_add_artwork">
      <template #title>Add Artwork</template>
      <template #content>
        <div class="p-1 grid grid-cols-1 gap-4">
          <div>
            <Label>Student Name<span class="text-red-500">*</span></Label>
            <ComboBox
              @search="findStudents"
              :items="list.students"
              label-property="name"
              value-property="id"
              :error="$page.props.errors.student_id"
              v-model="form.student_id"
              select-placeholder="Enter some characters to search"
              search-placeholder="Search student..."
            ></ComboBox>
          </div>
          <div>
            <Label>Level<span class="text-red-500">*</span></Label>
            <ComboBox
              :items="list.levels"
              label-property="name"
              value-property="id"
              :error="$page.props.errors.level_id"
              v-model="form.level_id"
              select-placeholder="Select Level"
              search-placeholder="Search level..."
            ></ComboBox>
          </div>
          <div>
            <Label>Theme<span class="text-red-500">*</span></Label>
            <ComboBox
              :items="list.themes"
              label-property="name"
              value-property="id"
              :error="$page.props.errors.theme_id"
              v-model="form.theme_id"
              select-placeholder="Select Theme"
              search-placeholder="Search theme..."
            ></ComboBox>
          </div>
          <div>
            <Label>Lesson<span class="text-red-500">*</span></Label>
            <ComboBox
              :items="list.lessons"
              label-property="name"
              value-property="id"
              :error="$page.props.errors.lesson_id"
              v-model="form.lesson_id"
              select-placeholder="Select Lesson"
              search-placeholder="Search lesson..."
            ></ComboBox>
          </div>
          <div>
            <Label>Activity<span class="text-red-500">*</span></Label>
            <ComboBox
              :items="list.activities"
              label-property="name"
              value-property="id"
              :error="$page.props.errors.activity_id"
              v-model="form.activity_id"
              select-placeholder="Select Activity"
              search-placeholder="Search activity..."
            ></ComboBox>
          </div>
          <div class="space-y-2" v-show="form.artwork.image_url == ''">
            <label class="block text-sm text-gray-700 font-bold"> Artwork File </label>
            <div
              class="rounded-md bg-red-100 p-4"
              v-if="$page.props.errors['artwork.file']"
            >
              <div class="flex">
                <div class="flex-shrink-0">
                  <ExclamationTriangleIcon
                    class="h-5 w-5 text-red-500"
                    aria-hidden="true"
                  />
                </div>
                <div class="ml-3">
                  <h3 class="text-sm font-medium text-red-500">File is required!</h3>
                </div>
              </div>
            </div>
            <div
              class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
              @change="changeArtwork"
              @dragover="dragoverArtWork"
              @drop="dropArtwork"
            >
              <div class="space-y-1 text-center">
                <svg
                  class="mx-auto h-12 w-12 text-gray-400"
                  stroke="currentColor"
                  fill="none"
                  viewBox="0 0 48 48"
                  aria-hidden="true"
                >
                  <path
                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
                <div class="flex text-sm text-gray-600">
                  <label
                    class="browse text-indigo-400 hover:text-indigo-800 cursor-pointer font-bold"
                    >Click here
                    <input
                      ref="artwork_file"
                      id="file"
                      class="sr-only"
                      type="file"
                      accept="image/*"
                    />
                  </label>
                  <p class="pl-1">or drag and drop an image</p>
                </div>
                <p class="text-xs text-gray-500">Image Format : PNG, JPG</p>
              </div>
            </div>
          </div>
          <div v-show="form.artwork.image_url != ''">
            <label class="block text-sm text-gray-700 font-bold mb-2">
              Artwork File
            </label>
            <div class="flex flex-row justify-start space-x-2">
              <div class="flex-column text-center">
                <img
                  class="object-scale-down w-full"
                  :src="form.artwork.image_url"
                  alt=""
                />
              </div>
              <div class="flex-column">
                <div class="flex flex-col space-y-1">
                  <Button @click="reselect_image()" title="Reselect an image">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-5 w-5"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      stroke-width="2"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                      />
                    </svg>
                  </Button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>
      <template #footer>
        <Button variant="outline" @click="show_add_artwork = false">Cancel</Button>
        <Button @click="submit">Add</Button>
      </template>
    </Dialog>
  </BreezeAuthenticatedLayout>
</template>

<script>
import { MagnifyingGlassIcon, ExclamationTriangleIcon } from "@radix-icons/vue";
import { Filter, PlusCircle, Settings } from "lucide-vue-next";
import { Head, Link } from "@inertiajs/inertia-vue3";
import DeleteConfirmation from "@/Components/DeleteConfirmation.vue";
import FsLightbox from "fslightbox-vue";
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
import Pagination from "@/Components/Pagination.vue";
import Dialog from "@/Components/DialogModal.vue";
import { debounce } from "vue-debounce";

const URL = window.URL || window.webkitURL;
const REGEXP_MIME_TYPE_IMAGES = /^image\/\w+$/;

export default {
  components: {
    Head,
    Link,
    FsLightbox,
  },
  props: {
    filter: Object,
  },
  watch: {
    "form.level_id": {
      handler() {
        if (this.form.level_id != "") {
          axios
            .get(route("art_gallery.get_themes", this.form.level_id))
            .then((response) => {
              this.list.themes = response.data;
              this.form.theme_id = "";
              this.form.lesson_id = "";
              this.form.activity_id = "";
            });
        }
      },
      deep: true,
    },
    "form.theme_id": {
      handler() {
        if (this.form.level_id != "" && this.form.theme_id != "") {
          axios
            .get(route("art_gallery.get_lessons", this.form.theme_id))
            .then((response) => {
              this.list.lessons = response.data;
              this.form.lesson_id = "";
              this.form.activity_id = "";
            });
        }
      },
      deep: true,
    },
    "form.lesson_id": {
      handler() {
        if (
          this.form.level_id != "" &&
          this.form.theme_id != "" &&
          this.form.lesson_id != ""
        ) {
          axios
            .get(route("art_gallery.get_activities", this.form.lesson_id))
            .then((response) => {
              this.list.activities = response.data;
              this.form.activity_id = "";
            });
        }
      },
      deep: true,
    },
  },
  computed: {
    baseUrl() {
      return window.location.origin;
    },
  },
  data() {
    return {
      show_filters: false,
      show_add_artwork: false,
      confirmation: {
        is_open: false,
        route_name: "",
        id: "",
      },
      lightbox: {
        open: false,
        src: [],
      },
      list: {
        students: [],
        levels: this.$page.props.levels,
        themes: [],
        lessons: [],
        activities: [],
      },
      form: {
        student_id: "",
        level_id: "",
        theme_id: "",
        lesson_id: "",
        activity_id: "",
        artwork: {
          image_url: "",
          file: "",
        },
      },
      student_status: [
        {
          id: "1",
          name: "Active",
        },
        {
          id: "0",
          name: "Inactive",
        },
      ],
      params: {
        search: this.filter.search || "",
        level: this.filter.level || "",
        theme: this.filter.theme || "",
        status: this.filter.status || "",
      },
    };
  },
  methods: {
    submit() {
      this.$inertia.post(route("art_gallery.store"), this.form, { preserveState: false });
    },
    viewArtwork(artwork_file_location) {
      fetch(
        window.location.origin + "/storage/art_gallery/" + artwork_file_location
      ).then((response) => {
        if (!response.ok) {
          this.lightbox.src = [window.location.origin + "/images/no_image.jpg"];
        } else {
          this.lightbox.src = [
            window.location.origin + "/storage/art_gallery/" + artwork_file_location,
          ];
        }
        this.lightbox.open = !this.lightbox.open;
      });
    },
    deleteArtwork(artwork_id) {
      this.confirmation.route_name = "art_gallery.destroy";
      this.confirmation.id = artwork_id;
      this.confirmation.is_open = true;
    },
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
    search() {
      this.$inertia.get(this.route("art_gallery"), this.params, {
        replace: true,
        preserveState: true,
      });
    },
    showFilters() {
      this.show_filters = !this.show_filters;
    },
    read(file, event) {
      return new Promise((resolve, reject) => {
        if (!file) {
          resolve();
          return;
        }
        if (REGEXP_MIME_TYPE_IMAGES.test(file.type)) {
          if (URL) {
            resolve({
              loaded: true,
              name: file.name,
              type: file.type,
              url: URL.createObjectURL(file),
            });
          } else {
            reject(new Error("Your browser is not supported."));
          }
        } else {
          reject(new Error(`Please select a valid image file.`));
          // reject(new Error(`Please ${event ? event.type : 'choose'} an image file.`));
        }
      });
    },
    changeArtwork({ target }) {
      const { files } = target;
      if (files && files.length > 0) {
        this.read(files[0], target)
          .then((data) => {
            this.form.artwork.image_url = data.url;
            this.form.artwork.file = files[0];
          })
          .catch(this.alert);
      }
    },
    dragoverArtWork(e) {
      e.preventDefault();
    },
    dropArtwork(e) {
      const { files } = e.dataTransfer;
      e.preventDefault();
      if (files && files.length > 0) {
        this.read(files[0], e)
          .then((data) => {
            this.form.artwork.image_url = data.url;
            this.form.artwork.file = files[0];
          })
          .catch(this.alert);
      }
    },
    reselect_image() {
      this.$refs.artwork_file.value = "";
      this.form.artwork.image_url = "";
      this.form.artwork.file = "";
    },
  },
};
</script>
