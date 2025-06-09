<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Admin/Authenticated.vue";
import { Inertia } from "@inertiajs/inertia";
</script>

<template>
  <Head title="Art Book" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Art Book</h2>
      </div>
    </template>
    <div class="flex justify-end">
      <Button @click="navigateToSetup"><CogIcon class="w-4 h-4 mr-2" /> Setting </Button>
    </div>
    <Card v-for="(themes, level) in $page.props.artbooks">
      <template #title>{{ level }}</template>
      <template #content>
        <div class="grid grid-cols-1 px-12 py-2">
          <Carousel
            class="relative w-full mx-1"
            :opts="{
              align: 'start',
              loop: true,
              skipSnaps: false,
              containScroll: 'trimSnaps',
            }"
            @scroll="handleScroll"
          >
            <CarouselContent>
              <CarouselItem
                v-for="(artbook, index) in themes"
                :key="index"
                class="py-2 sm:basis-1/2 lg:basis-1/3 xl:basis-1/4 2xl:basis-1/6 cursor-pointer"
                @click="openDownloadModal(artbook.id, artbook.art_book_assets)"
              >
                <div class="p-1 border rounded-lg">
                  <img
                    :src="'/images/' + artbook.art_book_assets + 'thumbnail.jpg'"
                    class="w-full rounded-lg hover:scale-105 duration-200"
                    loading="lazy"
                  />
                </div>
              </CarouselItem>
            </CarouselContent>
            <CarouselPrevious />
            <CarouselNext />
          </Carousel>
        </div>
      </template>
    </Card>
    <Dialog
      v-model:open="open_generate_modal"
      classProp="max-w-3xl"
      :interactOutside="
        (e) => {
          e.preventDefault();
        }
      "
      :hideClose="true"
    >
      <template #title v-if="!generating">Generate Art Book</template>
      <template #title v-else>Do not close the browser</template>
      <template #content v-if="!generating">
        <div class="p-1 grid grid-cols-1 gap-4">
          <div>
            <Label>Student Name<span class="text-red-500">*</span></Label>
            <ComboBox
              @search="findStudents"
              :items="list.students"
              label-property="name"
              value-property="id"
              :error="error_student_id"
              v-model="form.student_id"
              select-placeholder="Enter some characters to search"
              search-placeholder="Search student..."
              :loading="loading.students"
            ></ComboBox>
          </div>
          <div>
            <Label>Nickname<span class="text-red-500">*</span></Label>
            <Input
              :error="error_student_nickname"
              v-model="form.student_nickname"
              maxlength="10"
              placeholder="Max : 10 Characters"
            ></Input>
          </div>
          <div v-if="form.student_id">
            <Label>Select Images<span class="text-red-500">*</span></Label>

            <!-- Initial Loading State -->
            <div v-if="loadingStates.artwork" class="mt-4 text-center">
              <div
                class="inline-block w-8 h-8 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin"
              ></div>
              <p class="mt-2 text-sm text-gray-600">Loading images...</p>
            </div>

            <!-- Error State -->
            <div
              v-else-if="errorStates.artwork"
              class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg"
            >
              <p class="text-sm text-red-600">{{ errorStates.artwork }}</p>
              <button
                @click="fetchArtworkForStudent"
                class="mt-2 text-sm text-red-600 hover:text-red-700 underline"
              >
                Try Again
              </button>
            </div>

            <!-- Image Selection Grid -->
            <div v-else class="grid grid-cols-1 gap-6 mt-2">
              <div
                v-for="sectionIndex in required_sections"
                :key="'section-' + sectionIndex"
              >
                <h4 class="text-sm font-medium mb-2">
                  Image {{ sectionIndex }} <span class="text-red-500">*</span>
                  <span class="text-xs text-gray-500">(Select 1)</span>
                </h4>

                <!-- Section Loading State -->
                <div v-if="loadingStates.sections[sectionIndex]" class="text-center py-4">
                  <div
                    class="inline-block w-6 h-6 border-3 border-indigo-600 border-t-transparent rounded-full animate-spin"
                  ></div>
                  <p class="mt-1 text-xs text-gray-500">Loading section...</p>
                </div>

                <!-- Section Error State -->
                <div
                  v-else-if="errorStates.sections[sectionIndex]"
                  class="p-3 bg-red-50 border border-red-200 rounded-lg"
                >
                  <p class="text-xs text-red-600">
                    {{ errorStates.sections[sectionIndex] }}
                  </p>
                  <button
                    @click="() => fetchArtworkForStudent()"
                    class="mt-1 text-xs text-red-600 hover:text-red-700 underline"
                  >
                    Retry
                  </button>
                </div>

                <!-- Section Content -->
                <div v-else-if="sectionReady[sectionIndex]" class="relative">
                  <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                    <!-- Existing Images -->
                    <div
                      v-for="image in available_images[sectionIndex]"
                      :key="'section' + sectionIndex + '-' + image.id"
                      class="relative cursor-pointer border rounded-lg overflow-hidden group"
                    >
                      <div
                        @click="selectImageForSection(sectionIndex - 1, image)"
                        class="relative w-full h-24 bg-gray-100"
                      >
                        <!-- Loading Placeholder -->
                        <div
                          v-if="
                            imageLoadingStates[`${sectionIndex}-${image.id}`] !== false
                          "
                          class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-75"
                        >
                          <div
                            class="w-6 h-6 border-2 border-indigo-600 border-t-transparent rounded-full animate-spin"
                          ></div>
                        </div>

                        <!-- Error State -->
                        <div
                          v-if="imageErrorStates[`${sectionIndex}-${image.id}`]"
                          class="absolute inset-0 flex items-center justify-center bg-gray-50"
                        >
                          <span class="text-xs text-gray-500">Failed to load image</span>
                        </div>

                        <!-- Image -->
                        <img
                          :src="'/storage/art_gallery/' + image.filename"
                          class="w-full h-24 object-cover transition-transform duration-200 group-hover:scale-105"
                          loading="lazy"
                          decoding="async"
                          fetchpriority="low"
                          @load="handleImageLoad(sectionIndex, image.id)"
                          @error="handleImageError(sectionIndex, image.id)"
                          :alt="'Artwork for section ' + sectionIndex"
                        />
                      </div>
                      <div
                        v-if="isImageSelectedForSection(sectionIndex - 1, image)"
                        class="absolute top-2 right-2 bg-indigo-600 text-white rounded-full w-6 h-6 flex items-center justify-center"
                      >
                        ✓
                      </div>
                      <!-- Delete Button -->
                      <button
                        @click.stop="deleteArtwork(image.id, sectionIndex)"
                        class="absolute top-2 left-2 p-1 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-red-600"
                        v-if="$page.props.can?.delete_art_book_artwork"
                      >
                        <svg
                          class="w-4 h-4"
                          fill="none"
                          stroke="currentColor"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                          />
                        </svg>
                      </button>
                    </div>

                    <!-- Upload Option -->
                    <div
                      class="relative cursor-pointer border-2 border-dashed border-gray-300 rounded-lg overflow-hidden group hover:border-indigo-400 transition-colors duration-200"
                      v-if="$page.props.can?.upload_art_book_artwork"
                    >
                      <div
                        v-if="loadingStates.upload[sectionIndex]"
                        class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center"
                      >
                        <div class="space-y-2 text-center">
                          <div class="w-full bg-gray-200 rounded-full h-2">
                            <div
                              class="h-2 rounded-full transition-all duration-300"
                              :style="'width: ' + uploadProgress[sectionIndex] + '%'"
                            ></div>
                          </div>
                          <p class="text-sm text-gray-500">
                            Uploading... {{ uploadProgress[sectionIndex] }}%
                          </p>
                        </div>
                      </div>
                      <div v-else class="h-24 flex items-center justify-center">
                        <input
                          type="file"
                          accept="image/*"
                          class="hidden"
                          :id="'upload-' + sectionIndex"
                          @change="(e) => handleFileUpload(e, sectionIndex)"
                        />
                        <label
                          :for="'upload-' + sectionIndex"
                          class="cursor-pointer inline-flex items-center px-4 py-2 border border-transparent text-xs font-medium rounded-md text-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
                        >
                          <svg
                            class="w-5 h-5 mr-0.5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 4v16m8-8H4"
                            ></path>
                          </svg>
                          Upload
                        </label>
                      </div>
                      <p
                        v-if="errorStates.upload[sectionIndex]"
                        class="absolute bottom-0 left-0 right-0 text-xs text-red-600 bg-white bg-opacity-75 p-1"
                      >
                        {{ errorStates.upload[sectionIndex] }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div
              v-if="error_image_selection"
              class="mt-2 p-2 bg-red-50 border border-red-200 rounded-md"
            >
              <p class="text-sm text-red-600 font-medium">
                Please select all required images
              </p>
              <ul class="text-xs text-red-500 mt-1 list-disc list-inside">
                <li
                  v-for="(isError, index) in error_sections"
                  v-if="isError"
                  :key="'error-' + index"
                >
                  Image {{ index + 1 }} is required
                </li>
              </ul>
            </div>
          </div>
        </div>
      </template>
      <template #content v-else>
        <div class="pb-10">
          <div class="flex items-center mb-4 text-sm">
            <div role="status">
              <svg
                aria-hidden="true"
                class="w-6 h-6 me-2 text-indigo-200 animate-spin fill-indigo-600"
                viewBox="0 0 100 101"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                  fill="currentColor"
                />
                <path
                  d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                  fill="currentFill"
                />
              </svg>
              <span class="sr-only">Loading...</span>
            </div>
            Please stay in this page and kindly wait as the system is in the process of
            creating your art book, this might take a while...
          </div>
          <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
            <div
              class="bg-indigo-600 text-xs font-medium text-indigo-100 text-center p-0.5 leading-none rounded-full h-2"
              :style="'width: ' + current_progress + '%'"
            ></div>
          </div>
        </div>
      </template>
      <template #footer v-if="!generating">
        <Button variant="outline" @click="open_generate_modal = false">Cancel</Button>
        <Button @click="generateArtBook">Generate</Button>
      </template>
    </Dialog>
    <Dialog
      v-model:open="open_ad_detected"
      classProp="max-w-md"
      :interactOutside="
        (e) => {
          e.preventDefault();
        }
      "
      :hideClose="true"
    >
      <template #title>Adblocker Detected</template>
      <template #content>
        <span class="font-medium text-sm text-slate-600"
          >Please disable adblocker to prevent error during artbook generation. Thank
          you.</span
        >
      </template>
      <template #footer>
        <Button @click="open_ad_detected = false">Okay</Button>
      </template>
    </Dialog>
    <Dialog
      v-model:open="deleteDialog.open"
      classProp="max-w-md"
      :interactOutside="
        (e) => {
          e.preventDefault();
        }
      "
      :hideClose="true"
    >
      <template #title>Delete Artwork</template>
      <template #content>
        <div class="space-y-4">
          <p class="text-sm text-gray-600">
            Are you sure you want to delete this artwork? This action cannot be undone.
          </p>
          <p v-if="deleteDialog.error" class="text-sm text-red-600">
            {{ deleteDialog.error }}
          </p>
        </div>
      </template>
      <template #footer>
        <Button
          variant="outline"
          @click="deleteDialog.open = false"
          :disabled="deleteDialog.loading"
        >
          Cancel
        </Button>
        <Button
          variant="destructive"
          @click="confirmDelete"
          :loading="deleteDialog.loading"
        >
          Delete
        </Button>
      </template>
    </Dialog>
  </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import axios from "axios";
import { debounce } from "vue-debounce";
import detectAdBlocker from "../../Plugins/DetectAdBlocker/index";
import {
  Carousel,
  CarouselContent,
  CarouselItem,
  CarouselNext,
  CarouselPrevious,
} from "@/Components/ui/carousel";
import Card from "@/Components/Card.vue";
import Dialog from "@/Components/DialogModal.vue";
import { Inertia } from "@inertiajs/inertia";
import { CogIcon } from "lucide-vue-next";

export default {
  components: {
    Head,
    Link,
  },
  mixins: [detectAdBlocker],
  data() {
    return {
      open_ad_detected: false,
      open_generate_modal: false,
      form: {
        student_id: "",
        student_nickname: "",
        theme_id: "",
        selected_images: [],
      },
      loading: {
        students: false,
        conditions: false,
        artwork: false,
      },
      list: {
        students: [],
      },
      current_progress: 0,
      interval_id: null,
      generating: false,
      error_student_nickname: false,
      error_student_id: false,
      error_image_selection: false,
      error_sections: [],
      theme_assets: "",
      available_images: {},
      theme_sections: {},
      required_sections: 0,
      currentPage: 1,
      itemsPerPage: 12,
      isLoadingMore: false,
      imageLoadingStates: {},
      imageErrorStates: {},
      uploadingImage: {},
      uploadProgress: {},
      uploadError: {},
      imagesLoaded: {},
      allImagesLoaded: false,
      loadingStates: {
        artwork: false,
        upload: {},
        sections: {},
      },
      errorStates: {
        artwork: null,
        upload: {},
        sections: {},
      },
      sectionReady: {},
      deleteDialog: {
        open: false,
        imageId: null,
        sectionIndex: null,
        loading: false,
        error: null,
      },
    };
  },
  methods: {
    navigateToSetup() {
      Inertia.visit(route("art_book.setup"));
    },
    async openDownloadModal(theme_id, assets_path) {
      this.open_generate_modal = true;
      this.form.student_id = "";
      this.form.student_nickname = "";
      this.form.theme_id = theme_id;
      this.theme_assets = assets_path;
      this.error_image_selection = false;

      // Fetch conditions for the selected theme
      this.loading.conditions = true;
      try {
        const response = await axios.get(route("art_book.get_conditions", theme_id));
        const conditions = response.data;

        // Set the number of required sections based on conditions
        this.required_sections = conditions.length;

        // Initialize selected images array with nulls based on required sections
        this.form.selected_images = Array(this.required_sections).fill(null);

        // Initialize error sections array
        this.error_sections = Array(this.required_sections).fill(false);

        // Store conditions
        this.theme_sections = {};
        this.available_images = {};

        for (const condition of conditions) {
          this.theme_sections[condition.artwork_number] = {
            lesson_id: condition.lesson_id,
            activity_id: condition.activity_id,
          };
        }
      } catch (error) {
        console.error("Error fetching conditions:", error);
      } finally {
        this.loading.conditions = false;
      }
    },
    async fetchArtworkForStudent() {
      if (!this.form.student_id) return;

      this.loadingStates.artwork = true;
      this.errorStates.artwork = null;
      this.allImagesLoaded = false;
      this.imagesLoaded = {};
      this.sectionReady = {};

      try {
        // Fetch artwork for each condition
        const fetchPromises = Object.entries(this.theme_sections).map(
          async ([sectionNumber, section]) => {
            this.loadingStates.sections[sectionNumber] = true;
            try {
              const artworkResponse = await axios.get(
                route("art_book.get_artwork", {
                  lessonId: section.lesson_id,
                  activityId: section.activity_id,
                  studentId: this.form.student_id,
                })
              );
              this.available_images[sectionNumber] = artworkResponse.data;
              this.imagesLoaded[sectionNumber] = false;
              this.errorStates.sections[sectionNumber] = null;
              // Mark section as ready to display
              this.sectionReady[sectionNumber] = true;
            } catch (error) {
              console.error(
                `Error fetching artwork for section ${sectionNumber}:`,
                error
              );
              this.available_images[sectionNumber] = [];
              this.imagesLoaded[sectionNumber] = true;
              this.errorStates.sections[sectionNumber] =
                "Failed to load images for this section";
              this.sectionReady[sectionNumber] = true;
            } finally {
              this.loadingStates.sections[sectionNumber] = false;
            }
          }
        );

        await Promise.all(fetchPromises);
      } catch (error) {
        console.error("Error fetching artwork:", error);
        this.errorStates.artwork = "Failed to load artwork. Please try again.";
      } finally {
        this.loadingStates.artwork = false;
      }
    },
    selectImageForSection(sectionIndex, image) {
      // Create a new array to maintain reactivity
      const newSelectedImages = [...this.form.selected_images];
      newSelectedImages[sectionIndex] = image;
      this.form.selected_images = newSelectedImages;

      // Clear error for this section
      const newErrorSections = [...this.error_sections];
      newErrorSections[sectionIndex] = false;
      this.error_sections = newErrorSections;

      this.error_image_selection = false;
    },
    isImageSelectedForSection(sectionIndex, image) {
      return this.form.selected_images[sectionIndex]?.id === image.id;
    },
    findStudents: debounce(function (query) {
      if (query) {
        this.loading.students = true;
        axios
          .get(route("students.find_digital_art_students"), {
            params: {
              keyword: query,
            },
          })
          .then((res) => {
            this.list.students = res.data;
            this.loading.students = false;
          });
      }
    }, 1000),
    generateArtBook() {
      this.error_student_nickname =
        this.form.student_nickname === "" || this.form.student_nickname.length > 10
          ? true
          : false;
      this.error_student_id = this.form.student_id === "" ? true : false;

      // Check if all sections have an image selected
      let hasError = false;
      const newErrorSections = Array(this.required_sections).fill(false);

      for (let i = 0; i < this.required_sections; i++) {
        if (this.form.selected_images[i] === null) {
          newErrorSections[i] = true;
          hasError = true;
        }
      }

      this.error_sections = newErrorSections;
      this.error_image_selection = hasError;

      if (this.form.student_nickname === "" || this.form.student_nickname.length > 10) {
        return;
      }

      if (this.form.student_id === "") {
        return;
      }

      if (hasError) {
        return;
      }

      if (this.generating) {
        return;
      }

      this.generating = true;
      this.interval_id = null;
      this.current_progress = 0;

      const increment = 100 / 120;

      this.interval_id = setInterval(() => {
        this.current_progress += increment;
      }, 1000);

      // Format the selected images data
      const selectedImages = this.form.selected_images.map((image, index) => ({
        id: image.id,
        filename: image.filename,
        lesson_id: this.theme_sections[index + 1].lesson_id,
        activity_id: this.theme_sections[index + 1].activity_id,
      }));

      const formData = {
        student_id: this.form.student_id,
        theme_id: this.form.theme_id,
        student_nickname: this.form.student_nickname,
        selected_images: selectedImages,
      };

      axios
        .post(route("art_book.generate"), formData, {
          responseType: "blob",
        })
        .then((response) => {
          // Create a Blob object from the response data
          const blob = new Blob([response.data], { type: "application/pdf" });

          // Create a URL for the Blob object
          const pdfUrl = URL.createObjectURL(blob);

          // Open the PDF in a new tab
          window.open(pdfUrl, "_blank");
          this.generating = false;
          this.open_generate_modal = false;
          clearInterval(this.interval_id);
        })
        .catch((error) => {
          console.error("Error generating PDF:", error);
          this.generating = false;
          clearInterval(this.interval_id);
          // Show error message to user
          alert("Failed to generate art book. Please try again.");
        });
    },
    clearStudents() {
      this.list.students = [];
    },
    handleScroll(event) {
      const { scrollLeft, scrollWidth, clientWidth } = event.target;
      const scrollPosition = scrollLeft + clientWidth;
      const scrollThreshold = scrollWidth - clientWidth * 0.8;

      if (scrollPosition >= scrollThreshold && !this.isLoadingMore) {
        this.loadMoreImages();
      }
    },
    loadMoreImages() {
      if (this.isLoadingMore) return;

      this.isLoadingMore = true;
      this.currentPage++;

      // Simulate loading more images (replace with actual API call)
      setTimeout(() => {
        const newImages = Array.from(
          { length: this.itemsPerPage },
          (_, i) => `image${this.currentPage * this.itemsPerPage + i + 1}.jpg`
        );

        this.available_images = {
          ...this.available_images,
          ...newImages.map((image) => ({
            id: image,
            url: `/storage/art_gallery/${this.theme_assets}${image}`,
          })),
        };
        this.isLoadingMore = false;
      }, 500);
    },
    handleImageLoad(sectionIndex, imageId) {
      this.imageLoadingStates[`${sectionIndex}-${imageId}`] = false;

      // Check if all images in this section are loaded
      const sectionImages = this.available_images[sectionIndex] || [];
      const allLoaded = sectionImages.every((image) => {
        return !this.imageLoadingStates[`${sectionIndex}-${image.id}`];
      });

      if (allLoaded) {
        this.imagesLoaded[sectionIndex] = true;
      }
    },
    handleImageError(sectionIndex, imageId) {
      this.imageErrorStates[`${sectionIndex}-${imageId}`] = true;
      this.imageLoadingStates[`${sectionIndex}-${imageId}`] = false;

      // Mark section as loaded even if there's an error
      this.imagesLoaded[sectionIndex] = true;
    },
    async handleFileUpload(event, sectionIndex) {
      const file = event.target.files[0];
      if (!file) return;

      // Validate file type
      if (!file.type.startsWith("image/")) {
        this.errorStates.upload[sectionIndex] = "Please upload an image file";
        return;
      }

      // Validate file size (max 5MB)
      if (file.size > 5 * 1024 * 1024) {
        this.errorStates.upload[sectionIndex] = "File size should be less than 5MB";
        return;
      }

      this.loadingStates.upload[sectionIndex] = true;
      this.uploadProgress[sectionIndex] = 0;
      this.errorStates.upload[sectionIndex] = null;

      const formData = new FormData();
      formData.append("image", file);
      formData.append("student_id", this.form.student_id);
      formData.append("theme_id", this.form.theme_id);
      formData.append("lesson_id", this.theme_sections[sectionIndex].lesson_id);
      formData.append("activity_id", this.theme_sections[sectionIndex].activity_id);

      try {
        const response = await axios.post(route("art_book.upload_artwork"), formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
          onUploadProgress: (progressEvent) => {
            this.uploadProgress[sectionIndex] = Math.round(
              (progressEvent.loaded * 100) / progressEvent.total
            );
          },
        });

        // Add the new image to available images
        if (!this.available_images[sectionIndex]) {
          this.available_images[sectionIndex] = [];
        }
        this.available_images[sectionIndex].push(response.data);

        // Clear the file input
        event.target.value = "";
      } catch (error) {
        console.error("Upload error:", error);
        this.errorStates.upload[sectionIndex] =
          error.response?.data?.message || "Failed to upload image";
      } finally {
        this.loadingStates.upload[sectionIndex] = false;
        this.uploadProgress[sectionIndex] = 0;
      }
    },
    async deleteArtwork(imageId, sectionIndex) {
      this.deleteDialog.imageId = imageId;
      this.deleteDialog.sectionIndex = sectionIndex;
      this.deleteDialog.open = true;
      this.deleteDialog.error = null;
    },
    async confirmDelete() {
      if (!this.deleteDialog.imageId || !this.deleteDialog.sectionIndex) return;

      this.deleteDialog.loading = true;
      this.deleteDialog.error = null;

      try {
        await axios.delete(route("art_book.delete_artwork", this.deleteDialog.imageId));

        // Remove the image from the available images
        this.available_images[this.deleteDialog.sectionIndex] = this.available_images[
          this.deleteDialog.sectionIndex
        ].filter((img) => img.id !== this.deleteDialog.imageId);

        // If this was the selected image, clear the selection
        const sectionIndex = this.deleteDialog.sectionIndex - 1;
        if (this.form.selected_images[sectionIndex]?.id === this.deleteDialog.imageId) {
          const newSelectedImages = [...this.form.selected_images];
          newSelectedImages[sectionIndex] = null;
          this.form.selected_images = newSelectedImages;
        }

        this.deleteDialog.open = false;
      } catch (error) {
        console.error("Error deleting artwork:", error);
        this.deleteDialog.error =
          error.response?.data?.message || "Failed to delete artwork";
      } finally {
        this.deleteDialog.loading = false;
      }
    },
  },
  created() {
    this.detectAdBlock().then((response) => {
      if (response) {
        this.open_ad_detected = true;
      }
    });
  },
  watch: {
    "form.student_id": {
      handler(newVal) {
        if (newVal) {
          this.fetchArtworkForStudent();
        } else {
          // Clear artwork when student is deselected
          this.available_images = {};
          this.form.selected_images = Array(this.required_sections).fill(null);
        }
      },
    },
  },
};
</script>
