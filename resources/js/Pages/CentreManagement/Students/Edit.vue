<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Admin/Authenticated.vue";
import BreezeButton from "@/Components/Button.vue";
</script>

<style>
.multiselect-assistive-text {
  display: none;
}
.student-date-picker {
  border: 1px solid #d1d5db; /* Default border color and thickness */
  border-radius: 0.5rem;
}
:hover.student-date-picker {
  border: 1px solid #d1d5db; /* Highlighted border color and thickness */
}
:focus.student-date-picker {
  border: 1px solid #d1d5db; /* Highlighted border color and thickness */
}
.simplebar-content {
  display: flex;
  gap: 5px;
}
</style>
<template>
  <Head title="Students" />

  <BreezeAuthenticatedLayout>
    <template #header></template>
    <Card>
      <template #title>Student Information</template>
      <template #content>
        <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-4 gap-4">
          <div>
            <Label>Name<span class="text-red-500">*</span></Label>
            <Input
              :error="$page.props.errors.name"
              v-model="form.basic_info.name"
              disabled
            ></Input>
          </div>
          <div>
            <Label>Gender<span class="text-red-500">*</span></Label>
            <ComboBox
              :items="$page.props.gender_list"
              label-property="name"
              value-property="id"
              :error="$page.props.errors.gender"
              v-model="form.basic_info.gender"
              select-placeholder=""
              search-placeholder="Search gender..."
              disabled
            ></ComboBox>
          </div>
          <div>
            <Label>Date of Birth<span class="text-red-500">*</span></Label>
            <Datepicker
              mode="date"
              format="dd/MM/Y"
              :error="errors.dob"
              v-model="form.basic_info.dob"
              disabled
            />
          </div>
          <div>
            <Label>Date Joined</Label>
            <Datepicker
              mode="date"
              format="dd/MM/Y"
              :error="errors.date_joined"
              v-model="form.basic_info.date_joined"
            />
          </div>
        </div>
      </template>
    </Card>
    <Card>
      <template #title>Parent Information</template>
      <template #content>
        <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-4 gap-4">
          <div>
            <Label>Name<span class="text-red-500">*</span></Label>
            <Input v-model="form.parent_info.name" disabled></Input>
          </div>
          <div>
            <Label>Email<span class="text-red-500">*</span></Label>
            <Input v-model="form.parent_info.email" disabled></Input>
          </div>
          <div>
            <Label>Phone Number<span class="text-red-500">*</span></Label>
            <Input v-model="form.parent_info.phone" disabled></Input>
          </div>
          <div>
            <Label>Address</Label>
            <Input v-model="form.parent_info.address" disabled></Input>
          </div>
        </div>
      </template>
    </Card>
    <Card>
      <template #title>
        <div class="flex justify-between items-center">
          Academic Information
          <Button @click="showAddClass">
            <PlusCircle class="h-4 w-4" />
            <span class="ml-1 hidden sm:block">New Class</span>
          </Button>
        </div>
      </template>
      <template #content>
        <Tabs :default-value="current_academic_info_tab" class="mb-2">
          <TabsList>
            <TabsTrigger :value="1" @click="current_academic_info_tab = 1">
              This Month
            </TabsTrigger>
            <TabsTrigger :value="2" @click="current_academic_info_tab = 2">
              History
            </TabsTrigger>
          </TabsList>
        </Tabs>
        <div class="" v-if="current_academic_info_tab == 1">
          <Collapsible v-if="current_fee.length"  v-for="(fee, fee_index) in current_fee">
            <template #trigger>
              <div class="flex space-x-2 items-center">
                <Label class="whitespace-pre-line"
                  >{{ fee.fee_info.programme_name }} (Level
                  {{ fee.fee_info.programme_level }})</Label
                >
                <Trash2
                  class="h-4 w-4 text-red-500 cursor-pointer shrink-0"
                  @click.stop="
                    deleteClass(
                      fee.fee_info.student_fee_id,
                      fee.fee_info.invoice_id,
                      fee.fee_info.admission_date,
                      fee.fee_info.centre_id,
                      fee.fee_info.programme_id
                    )
                  "
                ></Trash2>
              </div>
            </template>
            <template #content>
              <div class="grid grid-cols-1 gap-1 overflow-auto">
                <Tabs
                  :defaultValue="
                    current_programme_info_tab[fee_index]
                      ? current_programme_info_tab[fee_index]
                      : (current_programme_info_tab[fee_index] = 1)
                  "
                  class="mb-1"
                >
                  <TabsList>
                    <TabsTrigger
                      :value="1"
                      @click="current_programme_info_tab[fee_index] = 1"
                    >
                      Fee Info
                    </TabsTrigger>
                    <TabsTrigger
                      :value="2"
                      @click="current_programme_info_tab[fee_index] = 2"
                    >
                      Timetable
                    </TabsTrigger>
                    <TabsTrigger
                      :value="3"
                      @click="current_programme_info_tab[fee_index] = 3"
                    >
                      Promotions
                    </TabsTrigger>
                  </TabsList>
                </Tabs>
                <div
                  class="grid grid-cols-1"
                  v-if="current_programme_info_tab[fee_index] == 1"
                >
                  <div class="flex flex-wrap gap-1 p-1">
                    <Badge variant="" class="space-x-2">
                      <span class="whitespace-nowrap">{{ fee.fee_info.centre_name }}</span>
                      <RefreshCcw
                        class="h-3.5 w-3.5 cursor-pointer"
                        @click="
                          showTransferStudent(
                            fee.fee_info.fee_id,
                            fee.fee_info.student_fee_id,
                            fee.fee_info.programme_id,
                            fee.fee_info.class_type_id,
                            fee.fee_info.programme_level
                          )
                        "
                      ></RefreshCcw>
                    </Badge>
                    <Badge variant="">
                      <span class="whitespace-nowrap">{{ fee.fee_info.class_method }}</span>
                    </Badge>
                    <Badge variant="">
                      <span class="whitespace-nowrap">{{
                        fee.fee_info.programme_type
                      }}</span>
                    </Badge>
                  </div>
                  <hr class="mt-4 mb-1" />
                  <div class="p-1">
                    <Label> Status </Label>
                    <RadioGroup v-model="fee.fee_info.student_fee_status">
                      <div class="flex items-center space-x-2">
                        <RadioGroupItem
                          id="default"
                          value=""
                          :disabled="!!fee.fee_info.student_fee_status"
                        />
                        <Label
                          for="default"
                          class="cursor-pointer"
                          :class="['cursor-not-allowed', fee.fee_info.student_fee_status]"
                          >Ongoing</Label
                        >
                        <template v-for="status in $page.props.fee_status">
                          <RadioGroupItem
                            :id="'radio_' + fee.fee_info.student_fee_id + '_' + status.id"
                            :value="status.id"
                            v-if="status.id != 2"
                            @click="
                              changeFeeStatus(
                                fee.fee_info.student_fee_id,
                                fee.fee_info.student_fee_status
                              )
                            "
                          />
                          <Label
                            :for="'radio_' + fee.fee_info.student_fee_id + '_' + status.id"
                            class="cursor-pointer"
                            v-if="status.id != 2"
                            >{{ status.name }}</Label
                          >
                        </template>
                      </div>
                    </RadioGroup>
                    <div class="mt-3"></div>
                  </div>
                </div>
                <div
                  class="flex flex-wrap gap-1 p-1"
                  v-if="current_programme_info_tab[fee_index] == 2"
                >
                  <Badge variant="" v-for="classes in fee.classes" :key="classes.id">
                    <span class="whitespace-nowrap"
                      >{{ classes.class_day }} ({{ moment(classes.start_time).format("h:mm A") }} -
                      {{ moment(classes.end_time).format("h:mm A") }})</span
                    >
                  </Badge>
                </div>
                <div
                  class="flex flex-wrap gap-1 p-1"
                  v-if="current_programme_info_tab[fee_index] == 3"
                >
                  <Badge
                    variant="outline"
                    class="space-x-1"
                    v-if="fee.fee_info.promos.length"
                    v-for="(applied_promo, promo_index) in fee.fee_info.promos"
                  >
                    <span class="whitespace-nowrap">{{ applied_promo.promo_name }}</span>
                    <XCircle
                      class="h-4 w-4 cursor-pointer text-red-500"
                      @click="
                        deleteExistingClassPromo(
                          fee.fee_info.fee_id,
                          fee.fee_info.student_fee_id,
                          applied_promo.promo_id,
                          applied_promo.student_fee_promo_id
                        )
                      "
                    ></XCircle>
                  </Badge>
                  <Badge
                  class="cursor-pointer"
                    variant=""
                    @click="
                      showExistingClassPromoModal(
                        fee_index,
                        fee.fee_info.fee_id,
                        fee.fee_info.student_fee_id
                      )
                    "
                  >
                    <span class="whitespace-nowrap">Add Promotion</span>
                  </Badge>
                </div>
              </div>
            </template>
          </Collapsible>
          <div class="p-3 border rounded-lg" v-else>
            <span class="text-sm text-slate-500">No class has been added.</span>
          </div>
        </div>
        <div class="flex flex-col" v-else>
          <!-- <div class="flex px-0.5 mb-5">
            <div class="">
              <Label>Year Filter : </Label>
              <Datepicker mode="year" :format="'yyyy'" v-model="form.date_admission"/>
            </div>
          </div> -->
          <Collapsible v-if="previous_fee.length"  v-for="(fee, fee_index) in previous_fee">
            <template #trigger>
              <div class="flex space-x-2 items-center">
                <Badge variant="" class="cursor-default">
                  <span class="whitespace-nowrap">{{ moment(fee.fee_info.fee_month).format('MMMM') }}</span>
                </Badge>
                <Label class="whitespace-pre-line"
                  >{{ fee.fee_info.programme_name }} (Level
                  {{ fee.fee_info.programme_level }})</Label
                >
              </div>
            </template>
            <template #content>
              <div class="grid grid-cols-1 gap-1 overflow-auto">
                <Tabs
                  :defaultValue="
                    current_programme_info_tab[fee_index]
                      ? current_programme_info_tab[fee_index]
                      : (current_programme_info_tab[fee_index] = 1)
                  "
                  class="mb-1"
                >
                  <TabsList>
                    <TabsTrigger
                      :value="1"
                      @click="current_programme_info_tab[fee_index] = 1"
                    >
                      Fee Info
                    </TabsTrigger>
                    <TabsTrigger
                      :value="2"
                      @click="current_programme_info_tab[fee_index] = 2"
                    >
                      Timetable
                    </TabsTrigger>
                    <TabsTrigger
                      :value="3"
                      @click="current_programme_info_tab[fee_index] = 3"
                    >
                      Promotions
                    </TabsTrigger>
                  </TabsList>
                </Tabs>
                <div
                  class="grid grid-cols-1"
                  v-if="current_programme_info_tab[fee_index] == 1"
                >
                  <div class="flex flex-wrap gap-1 p-1">
                    <Badge variant="" class="space-x-2">
                      <span class="whitespace-nowrap">{{ fee.fee_info.centre_name }}</span>
                    </Badge>
                    <Badge variant="">
                      <span class="whitespace-nowrap">{{ fee.fee_info.class_method }}</span>
                    </Badge>
                    <Badge variant="">
                      <span class="whitespace-nowrap">{{
                        fee.fee_info.programme_type
                      }}</span>
                    </Badge>
                  </div>
                  <hr class="mt-4 mb-1" />
                  <div class="p-1">
                    <Label> Status </Label>
                    <RadioGroup v-model="fee.fee_info.student_fee_status">
                      <div class="flex items-center space-x-2">
                        <RadioGroupItem
                          id="default"
                          value=""
                          :disabled="true"
                        />
                        <Label
                          for="default"
                          >Ongoing</Label
                        >
                        <template v-for="status in $page.props.fee_status">
                          <RadioGroupItem
                            :id="'radio_' + fee.fee_info.student_fee_id + '_' + status.id"
                            :value="status.id"
                            v-if="status.id != 2"
                            :disabled="true"
                          />
                          <Label
                            :for="'radio_' + fee.fee_info.student_fee_id + '_' + status.id"
                            v-if="status.id != 2"
                            >{{ status.name }}</Label
                          >
                        </template>
                      </div>
                    </RadioGroup>
                    <div class="mt-3"></div>
                  </div>
                </div>
                <div
                  class="flex flex-wrap gap-1 p-1"
                  v-if="current_programme_info_tab[fee_index] == 2"
                >
                  <Badge variant="" v-for="classes in fee.classes" :key="classes.id">
                    <span class="whitespace-nowrap"
                      >{{ classes.class_day }} ({{ moment(classes.start_time).format("h:mm A") }} -
                      {{ moment(classes.end_time).format("h:mm A") }})</span
                    >
                  </Badge>
                </div>
                <div
                  class="flex flex-wrap gap-1 p-1"
                  v-if="current_programme_info_tab[fee_index] == 3"
                >
                  <Badge
                    variant="outline"
                    class="space-x-1"
                    v-if="fee.fee_info.promos.length"
                    v-for="(applied_promo, promo_index) in fee.fee_info.promos"
                  >
                    <span class="whitespace-nowrap">{{ applied_promo.promo_name }}</span>
                  </Badge>
                  <Label v-else>No promotions applied</Label>
                </div>
              </div>
            </template>
          </Collapsible>
        </div>
      </template>
    </Card>
    <Card>
      <template #content>
        <div class="flex items-center justify-between">
          <div class="flex space-x-2 items-center">
            <Label>Active</Label>
            <Switch v-model="form.student_status"></Switch>
          </div>
          <div class="flex space-x-2">
            <Button variant="outline" @click="$inertia.get(route('students'))"
              >Cancel</Button
            >
            <Button @click="saveStudentDetails">Save</Button>
          </div>
        </div>
      </template>
    </Card>
    <!-- Delete Class -->
    <DeleteConfirmation
      :open="confirmation.delete_class.is_open"
      @close="confirmation.delete_class.is_open = false"
      :routeName="confirmation.delete_class.route_name"
      method="post"
      :params="confirmation.delete_class.params"
    >
      <template #title>Delete Student's Class</template>
      <template #description>Are you sure want to delete this student's class?</template>
    </DeleteConfirmation>
    <!-- Set Status Complete -->
    <DeleteConfirmation
      :open="confirmation.set_status.is_open"
      @close="confirmation.set_status.is_open = false"
      @cancel="resetFeeStatus"
      :routeName="confirmation.set_status.route_name"
      method="post"
      :params="confirmation.set_status.params"
    >
      <template #title>Class Completed</template>
      <template #description
        >Are you sure want to change this class to completed?</template
      >
    </DeleteConfirmation>
    <!-- Transfer Student -->
    <Dialog v-model:open="show_transfer_student" classProp="max-w-5xl">
      <template #title>Transfer Student</template>
      <template #content>
        <div ref="transfer_centre_info">
          <Collapsible v-model="transfer.show.centre_info">
            <template #trigger>Centre Information</template>
            <template #content>
              <div class="p-1 grid grid-cols-1 xl:grid-cols-3 items-end gap-4">
                <div>
                  <Label>Centre<span class="text-red-500">*</span></Label>
                  <ComboBox
                    :items="$page.props.allowed_centres"
                    label-property="label"
                    value-property="ID"
                    :error="errors.centre"
                    v-model="form.centre_id"
                    select-placeholder="Select Centre"
                    search-placeholder="Search centre..."
                  ></ComboBox>
                </div>
                <div>
                  <Label>Class Method<span class="text-red-500">*</span></Label>
                  <ComboBox
                    :items="$page.props.method_list"
                    label-property="name"
                    value-property="id"
                    :error="errors.class_method"
                    v-model="search_form.class_method"
                    select-placeholder="Select Centre"
                    search-placeholder="Search centre..."
                  ></ComboBox>
                </div>
                <div>
                  <Button @click="findClasses">Search Classes</Button>
                </div>
              </div>
            </template>
          </Collapsible>
        </div>
        <div ref="transfer_class_info">
          <Collapsible v-model="transfer.show.class_info">
            <template #trigger>Class Information</template>
            <template #content>
              <template v-if="enable_container.available_classes">
                <div class="max-h-[26rem] overflow-y-auto">
                  <Table>
                    <TableHeader class="bg-gray-100">
                      <TableRow>
                        <TableHead class="px-4">#</TableHead>
                        <TableHead>Day</TableHead>
                        <TableHead class="text-center">Time</TableHead>
                        <TableHead class="text-center">Capacity</TableHead>
                        <TableHead class="text-center">Action</TableHead>
                      </TableRow>
                    </TableHeader>
                    <TableBody>
                      <TableRow v-if="!searching.class && !list.available_classes.length">
                        <TableCell class="text-center" colspan="10">
                          <div class="p-3">No classes available</div>
                        </TableCell>
                      </TableRow>
                      <TableRow v-for="(classes, index) in list.available_classes">
                        <TableCell class="px-4">{{ index + 1 }}</TableCell>
                        <TableCell>{{ classes.class_day }}</TableCell>
                        <TableCell class="text-center">
                          <span class="pl-2 whitespace-nowrap"
                            >{{ moment(classes.start_time).format("h:mm A") }}
                            -
                            {{
                              moment(classes.end_time).format("h:mm A")
                            }}</span
                          >
                        </TableCell>
                        <TableCell class="text-center">{{ classes.capacity }}</TableCell>
                        <TableCell class="text-center">
                          <Checkbox
                            :id="classes.id"
                            :value="classes.id"
                            :checked="
                              checkIfClassSelected(classes.class_id, classes.programme_id)
                            "
                            @click.native="
                              getPlusFee(
                                $event,
                                classes.class_id,
                                classes.class_type,
                                classes.programme_id,
                                true
                              )
                            "
                          />
                        </TableCell>
                      </TableRow>
                    </TableBody>
                  </Table>
                </div>
              </template>
              <div
                class="flex justify-center py-2 text-sm"
                v-if="
                  !enable_container.available_classes &&
                  !searching.class &&
                  !list.available_classes.length
                "
              >
                <span>Please search for classes.</span>
              </div>
            </template>
          </Collapsible>
        </div>
        <div ref="transfer_summary">
          <Collapsible class="bg-white" v-model="transfer.show.fee_summary">
            <template #trigger>Transfer Confirmation</template>
            <template #content>
              <div class="grid px-3 divide-y select-none" v-if="form.fee.length">
                <div class="py-4" v-for="(fee, fee_index) in form.fee">
                  <div class="flex justify-between mb-3 font-semibold">
                    <span class="text-sm">{{ fee.fee_info.programme_name }}</span>
                    <span class="text-sm">Level {{ fee.fee_info.programme_level }}</span>
                  </div>
                  <ul class="grid gap-2 mb-4 text-xs font-semibold">
                    <li class="flex items-center justify-between">
                      <span>Centre</span>
                      <span class="text-slate-600">{{ fee.fee_info.centre_name }}</span>
                    </li>
                    <li class="flex items-center justify-between">
                      <span>Fee</span>
                      <span class="text-slate-600">{{
                        fee.fee_info.programme_type
                      }}</span>
                    </li>
                    <li class="flex items-center justify-between">
                      <span>Class Method</span>
                      <span class="text-slate-600">{{ fee.fee_info.class_method }}</span>
                    </li>
                  </ul>
                  <ul class="grid gap-2 mb-3 text-xs font-semibold">
                    <li class="flex items-center">
                      <span class="underline">Timetable</span>
                    </li>
                    <li class="flex flex-wrap items-center gap-4">
                      <span
                        class="text-slate-600 text-xs"
                        v-for="classes in fee.classes"
                        :key="classes.id"
                        >{{ classes.class_day }} ({{
                          moment(classes.start_time).format("h:mm A")
                        }}
                        -
                        {{ moment(classes.end_time).format("h:mm A") }})</span
                      >
                    </li>
                  </ul>
                </div>
              </div>
              <div class="flex justify-center py-2 text-sm" v-if="!searching.class">
                <span
                  v-if="
                    !enable_container.available_classes ||
                    (enable_container.available_classes &&
                      !form.fee.length &&
                      !no_fee_found)
                  "
                  >No classes have been selected.</span
                >
                <span
                  v-if="
                    enable_container.available_classes && !form.fee.length && no_fee_found
                  "
                  >Fees are not available for the selected classes.</span
                >
              </div>
            </template>
          </Collapsible>
        </div>
      </template>
      <template #footer>
        <Button variant="outline" @click="show_transfer_student = false">Cancel</Button>
        <Button @click="transferStudent()" v-if="form.fee.length">Transfer</Button>
      </template>
    </Dialog>
    <!-- Add Existing Class's Promotion -->
    <Dialog v-model:open="existing_promo.show" classProp="max-w-md">
        <template #title>Add Promotions</template>
        <template #content>
          <div class="grid grid-cols-1 gap-4">
          <Alert class="bg-red-300">
            <AlertTitle>Warning!</AlertTitle>
            <AlertDescription>
              Student's current invoice will be deleted including uploaded proof of payment attachments.
            </AlertDescription>
          </Alert>
          <ComboBox :items="$page.props.promos" label-property="promo_name" value-property="promo_id" v-model="selected_promo.promo_id" select-placeholder="Select Promo" search-placeholder="Search promo..."></ComboBox>
          </div>
        </template>
        <template #footer>
            <Button variant="outline" @click="existing_promo.show = false">Cancel</Button>
            <Button @click="addExistingClassPromo">Add</Button>
        </template>
    </Dialog>
    <!-- Delete Existing Fee's Promotion -->
    <DeleteConfirmation
      :open="confirmation.delete_promo.is_open"
      @close="confirmation.delete_promo.is_open = false"
      @cancel="resetFeeStatus"
      :routeName="confirmation.delete_promo.route_name"
      method="post"
      :params="confirmation.delete_promo.params"
    >
      <template #title>Delete Promotion</template>
      <template #description
        >Are you sure want to delete this promotion? Student's current invoice will be deleted including uploaded proof of payment attachments.</template
      >
    </DeleteConfirmation>
    <!-- Add Class -->
    <Dialog v-model:open="show_add_class" classProp="max-w-5xl">
      <template #title>Add Class</template>
      <template #content>
        <div ref="add_class_centre_info">
          <Collapsible v-model="add_class.show.centre_info">
            <template #trigger>Centre Information</template>
            <template #content>
              <div class="p-1 grid grid-cols-1 xl:grid-cols-2 items-end gap-4">
                <div>
                  <Label>Centre<span class="text-red-500">*</span></Label>
                  <ComboBox
                    :items="$page.props.allowed_centres"
                    label-property="label"
                    value-property="ID"
                    :error="errors.centre"
                    v-model="form.centre_id"
                    select-placeholder="Select Centre"
                    search-placeholder="Search centre..."
                  ></ComboBox>
                </div>
                <div>
                  <Label>Programme<span class="text-red-500">*</span></Label>
                  <ComboBox
                    :items="$page.props.programme_list"
                    label-property="name"
                    value-property="id"
                    :error="errors.programme"
                    v-model="search_form.programme_id"
                    select-placeholder="Select Programme"
                    search-placeholder="Search programme..."
                  >
                    <template #label="{ item }">
                        {{ item.name }} ({{ item.country_name }})
                    </template>
                    <template #label-content="{ selectedItem, selectedItems, multiple }">
                        <span v-if="selectedItem">{{ selectedItem.name }} ({{ selectedItem.country_name }})</span>
                    </template>
                  </ComboBox>
                </div>
              </div>
              <div class="p-1 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 items-end gap-4">
                <div>
                    <Label>Start Date<span class="text-red-500">*</span></Label>
                    <Datepicker mode="date" :format="'dd/MM/yyyy'" v-model="form.date_admission" :error="errors.admission_date"/>
                </div>
                <div>
                  <Label>Class Method<span class="text-red-500">*</span></Label>
                  <ComboBox
                    :items="$page.props.method_list"
                    label-property="name"
                    value-property="id"
                    :error="errors.class_method"
                    v-model="search_form.class_method"
                    select-placeholder="Select Class Method"
                    search-placeholder="Search class method..."
                  ></ComboBox>
                </div>
                <div>
                  <Label>Class Type<span class="text-red-500">*</span></Label>
                  <ComboBox
                    :items="list.class_types"
                    label-property="name"
                    value-property="id"
                    :error="errors.class_type"
                    v-model="search_form.class_type"
                    select-placeholder="Select Class Type"
                    search-placeholder="Search class type..."
                  ></ComboBox>
                </div>
                <div>
                  <Label>Class Level<span class="text-red-500">*</span></Label>
                  <ComboBox
                    :items="list.class_levels"
                    label-property="level"
                    value-property="level"
                    :error="errors.level"
                    v-model="search_form.class_level"
                    select-placeholder="Select Class Level"
                    search-placeholder="Search class level..."
                  ></ComboBox>
                </div>
              </div>
              <div class="flex justify-end mt-2">
                <Button @click="findClasses">Search Classes</Button>
              </div>
            </template>
          </Collapsible>
        </div>
        <div ref="add_class_info">
          <Collapsible v-model="add_class.show.class_info">
            <template #trigger>Class Information</template>
            <template #content>
              <template v-if="enable_container.available_classes">
                <div class="max-h-[26rem] overflow-y-auto">
                  <Table>
                    <TableHeader class="bg-gray-100">
                      <TableRow>
                        <TableHead class="px-4">#</TableHead>
                        <TableHead>Day</TableHead>
                        <TableHead class="text-center">Time</TableHead>
                        <TableHead class="text-center">Capacity</TableHead>
                        <TableHead class="text-center">Action</TableHead>
                      </TableRow>
                    </TableHeader>
                    <TableBody>
                      <TableRow v-if="!searching.class && !list.available_classes.length">
                        <TableCell class="text-center" colspan="10">
                          <div class="p-3">No classes available</div>
                        </TableCell>
                      </TableRow>
                      <TableRow v-for="(classes, index) in list.available_classes">
                        <TableCell class="px-4">{{ index + 1 }}</TableCell>
                        <TableCell>{{ classes.class_day }}</TableCell>
                        <TableCell class="text-center">
                          <span class="pl-2 whitespace-nowrap"
                            >{{ moment(classes.start_time).format("h:mm A") }}
                            -
                            {{
                              moment(classes.end_time).format("h:mm A")
                            }}</span
                          >
                        </TableCell>
                        <TableCell class="text-center">{{ classes.capacity }}</TableCell>
                        <TableCell class="text-center">
                          <Checkbox
                            :id="classes.id"
                            :value="classes.id"
                            :checked="
                              checkIfClassSelected(classes.class_id, classes.programme_id)
                            "
                            @click.native="
                              getPlusFee(
                                $event,
                                classes.class_id,
                                classes.class_type,
                                classes.programme_id,
                                false
                              )
                            "
                          />
                        </TableCell>
                      </TableRow>
                    </TableBody>
                  </Table>
                </div>
              </template>
              <div
                class="flex justify-center py-2 text-sm"
                v-if="
                  !enable_container.available_classes &&
                  !searching.class &&
                  !list.available_classes.length
                "
              >
                <span>Please search for classes.</span>
              </div>
            </template>
          </Collapsible>
        </div>
        <div ref="add_class_summary">
          <Collapsible class="bg-white" v-model="add_class.show.fee_summary">
            <template #trigger>Fee Summary</template>
            <template #content>
              <div class="grid px-3 divide-y select-none" v-if="form.fee.length">
                <div class="py-4" v-for="(fee, fee_index) in form.fee">
                  <div class="flex justify-between mb-3 font-semibold">
                    <span class="text-sm">{{ fee.fee_info.programme_name }}</span>
                    <span class="text-sm">Level {{ fee.fee_info.programme_level }}</span>
                  </div>
                  <ul class="grid gap-2 mb-4 text-xs font-semibold">
                    <li class="flex items-center justify-between">
                      <span>Centre</span>
                      <span class="text-slate-600">{{ fee.fee_info.centre_name }}</span>
                    </li>
                    <li class="flex items-center justify-between">
                      <span>Fee</span>
                      <span class="text-slate-600">{{
                        fee.fee_info.programme_type
                      }}</span>
                    </li>
                    <li class="flex items-center justify-between">
                      <span>Class Method</span>
                      <span class="text-slate-600">{{ fee.fee_info.class_method }}</span>
                    </li>
                  </ul>
                  <ul class="grid gap-2 mb-3 text-xs font-semibold">
                    <li class="flex items-center">
                      <span class="underline">Timetable</span>
                    </li>
                    <li class="flex flex-wrap items-center gap-4">
                      <span
                        class="text-slate-600 text-xs"
                        v-for="classes in fee.classes"
                        :key="classes.id"
                        >{{ classes.class_day }} ({{
                          moment(classes.start_time).format("h:mm A")
                        }}
                        -
                        {{ moment(classes.end_time).format("h:mm A") }})</span
                      >
                    </li>
                  </ul>
                  <ul class="grid gap-2 mb-3 text-xs font-semibold">
                      <li class="flex items-center space-x-2">
                          <span class="underline">Applied Promos</span>
                          <div @click="showNewClassPromoModal(fee_index)" class="font-medium text-indigo-500 cursor-pointer px-1.5 py-0.5 rounded border border-dashed border-indigo-500 bg-white hover:bg-indigo-50 whitespace-nowrap">
                              Add Promo
                          </div>
                      </li>
                      <li class="font-medium">
                          <div class="flex flex-wrap gap-2" v-if="fee.fee_info.promos.length">
                              <span class="flex space-x-2 items-center justify-center rounded-sm bg-indigo-200 px-2.5 py-1 text-indigo-800" v-for="applied_promo, promo_index in fee.fee_info.promos">
                                  <p class="whitespace-nowrap text-xs">{{ applied_promo.promo_name }}</p>
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor" @click="deleteNewClassPromo(fee_index, promo_index)" class="h-3.5 w-3.5 text-red-600 cursor-pointer">
                                      <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/>
                                  </svg>
                              </span>
                          </div>
                          <div class="" v-else>
                              <span class="text-xs font-semibold text-indigo-500">None</span>
                          </div>
                      </li>
                  </ul>
                  <ul class="grid gap-2 mb-3 text-xs font-semibold" v-if="fee.fee_info.registration_fee != 0">
                      <li class="flex flex-col">
                          <div class="flex items-center space-x-2">
                              <Checkbox :id="'registration_fee_' + fee_index" :value="fee.fee_info.include_registration_fee" :checked="fee.fee_info.include_registration_fee" @click.native="fee.fee_info.include_registration_fee = !fee.fee_info.include_registration_fee"/>
                              <label :for="'registration_fee_' + fee_index" class="cursor-pointer">Registration Fee: {{ fee.fee_info.currency_symbol }}{{ fee.fee_info.registration_fee }}</label>
                          </div>
                          <div class="flex items-center space-x-2 pl-6" v-if="fee.fee_info.include_registration_fee">
                              <span :for="'registration_fee_discount'+fee_index">Discount: </span>
                              <Input min="0" :id="'registration_fee_discount'+fee_index" type="number" class="text-xs h-6" placeholder="Discount" v-if="fee.fee_info.include_registration_fee && (fee.fee_info.registration_fee && fee.fee_info.registration_fee != 0)" v-model="fee.fee_info.registration_fee_discount"></Input>
                          </div>
                      </li>
                  </ul>
                  <ul class="grid gap-2 mb-3 text-xs font-semibold" v-if="fee.fee_info.material_fee != 0">
                      <li class="flex flex-col">
                          <div class="flex items-center space-x-2">
                              <Checkbox :id="'material_fee_' + fee_index" :value="fee.fee_info.include_material_fee" :checked="fee.fee_info.include_material_fee" @click.native="fee.fee_info.include_material_fee = !fee.fee_info.include_material_fee"/>
                              <label :for="'material_fee_' + fee_index" class="cursor-pointer">Material Fee: {{ fee.fee_info.currency_symbol }}{{ fee.fee_info.material_fee }}</label>
                          </div>
                          <div class="flex items-center space-x-2 pl-6" v-if="fee.fee_info.include_material_fee">
                              <span :for="'material_fee_discount_'+fee_index">Discount: </span>
                              <Input min="0" :id="'material_fee_discount_'+fee_index" type="number" class="text-xs h-6" placeholder="Discount" v-if="fee.fee_info.include_material_fee && (fee.fee_info.material_fee && fee.fee_info.material_fee != 0)" v-model="fee.fee_info.material_fee_discount"></Input>
                          </div>
                      </li>
                  </ul>
                  <ul class="grid gap-2 text-xs font-semibold">
                      <li class="flex flex-col">
                          <div class="col-span-2 mt-3">
                              <div class="flex items-center justify-end space-x-2">
                                  <Checkbox :id="'old_fee_' + fee_index" :value="fee.fee_info.use_old_fee" :checked="fee.fee_info.use_old_fee" @click.native="fee.fee_info.use_old_fee = !fee.fee_info.use_old_fee"/>
                                  <label :for="'old_fee_' + fee_index" class="cursor-pointer">Use old fee</label>
                              </div>
                              <div class="flex items-center justify-end text-lg space-x-1">
                                  <span class="font-brown">{{ fee.fee_info.currency_symbol }}{{ calculateTotal(fee_index, fee.fee_info.use_old_fee ? fee.fee_info.old_programme_fee : fee.fee_info.programme_fee) }}</span>
                                  <span class="font-medium text-sm text-gray-700">/month</span>
                              </div>
                          </div>
                      </li>
                  </ul>
                </div>
              </div>
              <div class="flex justify-center py-2 text-sm" v-if="!searching.class">
                <span
                  v-if="
                    !enable_container.available_classes ||
                    (enable_container.available_classes &&
                      !form.fee.length &&
                      !no_fee_found)
                  "
                  >No classes have been selected.</span
                >
                <span
                  v-if="
                    enable_container.available_classes && !form.fee.length && no_fee_found
                  "
                  >Fees are not available for the selected classes.</span
                >
              </div>
            </template>
          </Collapsible>
        </div>
        <!-- Add New Class's Promotion -->
        <Dialog v-model:open="add_new_promo.show" classProp="max-w-md">
            <template #title>Add Promotions</template>
            <template #content>
                <ComboBox :items="$page.props.promos" label-property="promo_name" value-property="promo_id" v-model="selected_promo.promo_id" select-placeholder="Select Promo" search-placeholder="Search promo..."></ComboBox>
            </template>
            <template #footer>
                <Button variant="outline" @click="add_new_promo.show = false">Cancel</Button>
                <Button @click="addNewClassPromo">Add</Button>
            </template>
        </Dialog>
      </template>
      <template #footer>
        <Button variant="outline" @click="show_add_class = false">Cancel</Button>
        <Button @click="addClass()" v-if="form.fee.length">Add</Button>
      </template>
    </Dialog>
  </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import Toggle from "@vueform/toggle";
import moment from "moment";
import Card from "@/Components/Card.vue";
import { PlusCircle, RefreshCcw, Trash2, XCircle } from "lucide-vue-next";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/Components/ui/tabs";
import Collapsible from "@/Components/Collapsible.vue";
import { Badge } from "@/Components/ui/badge";
import DeleteConfirmation from "@/Components/DeleteConfirmation.vue";
import Dialog from "@/Components/DialogModal.vue";
import { Alert, AlertDescription, AlertTitle } from '@/Components/ui/alert'
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/Components/ui/table";

export default {
  components: { Head, Link, Toggle },
  data() {
    return {
      processing: {
        add_class: false,
        add_existing_class_promo: false,
      },
      transfer: {
        show: {
          centre_info: true,
          class_info: false,
          fee_summary: false,
        },
      },
      add_class: {
        show: {
          centre_info: true,
          class_info: false,
          fee_summary: false,
        },
      },
      existing_promo: {
        show: false
      },
      add_new_promo: {
        show: false
      },
      current_academic_info_tab: 1,
      current_programme_info_tab: [],
      open_new_class_promo_modal: false,
      open_existing_class_promo_modal: false,
      use_old_fee: false,
      current_tab: 1,
      no_fee_found: false,
      show_add_class: false,
      show_transfer_student: false,
      disable_check_box: false,
      fetching_fee: false,
      total_amount: 0,
      current_fee: this.$page.props.student_academics
        ? this.$page.props.student_academics["current"]
        : [],
      previous_fee: this.$page.props.student_academics
        ? this.$page.props.student_academics["history"]
        : [],
      selected_plus_class: {},
      confirmation: {
        delete_class: {
          is_open: false,
          route_name: "",
          params: {},
        },
        set_status: {
          is_open: false,
          route_name: "",
          id: "",
          params: {},
          student_fee_status: "",
        },
        delete_promo: {
          is_open: false,
          route_name: "",
          params: {},
        },
      },
      errors: {
        child: false,
        centre: false,
        admission_date: false,
        programme: false,
        class_type: false,
        programme: false,
        level: false,
        class_method: false,
      },
      disable: {
        class_type: true,
        class_levels: true,
      },
      list: {
        students: [],
        class_types: [],
        class_levels: [],
        available_classes: [],
      },
      searching: {
        student: false,
        class: false,
        fee: false,
      },
      confirmation_modal: {
        isOpen: false,
        confirmationAlert: "",
        confirmationTitle: "",
        confirmationText: "",
        confirmationButton: "",
        confirmationMethod: "",
        confirmationData: "",
        confirmationRoute: "",
      },
      enable_container: {
        available_classes: false,
        show_fee: false,
      },
      search_form: {
        programme_id: "",
        class_type: "",
        class_level: "",
        class_method: "",
      },
      form: {
        date_admission: "",
        children_id: this.$page.props.student_info
          ? this.$page.props.student_info.children_id
          : "",
        student_id: this.$page.props.student_info ? this.$page.props.student_info.id : "",
        centre_id: "",
        fee: [],
        basic_info: {
          name: this.$page.props.student_info ? this.$page.props.student_info.name : "",
          gender: this.$page.props.student_info
            ? this.$page.props.student_info.gender
            : "",
          dob: this.$page.props.student_info ? this.$page.props.student_info.dob : "",
          date_joined: this.$page.props.student_info
            ? this.$page.props.student_info.date_joined
            : "",
        },
        parent_info: {
          name: this.$page.props.student_info
            ? this.$page.props.student_info.parent_full_name
            : "",
          email: this.$page.props.student_info
            ? this.$page.props.student_info.parent_email
            : "",
          phone: this.$page.props.student_info
            ? this.$page.props.student_info.parent_calling_code +
              this.$page.props.student_info.parent_contact
            : "",
          address: this.$page.props.student_info
            ? this.$page.props.student_info.parent_address
            : "",
        },
        student_status: this.$page.props.student_info
          ? !!this.$page.props.student_info.status
          : "",
      },
      transfer_student_form: {
        centre_id: "",
      },
      selected_promo: {
        promo_id: "",
        fee_index: "",
        fee_id: "",
        student_fee_id: "",
      },
    };
  },
  watch: {
    "search_form.programme_id": {
      handler() {
        if (this.search_form.programme_id && this.show_add_class) {
          this.disable.class_type = true;
          this.disable.class_levels = true;
          this.search_form.class_type = "";
          this.search_form.class_level = "";
          axios
            .get(route("classes.get_class_types"), {
              params: {
                programme_id: this.search_form.programme_id,
              },
            })
            .then((response) => {
              this.list.class_types = response.data;
              this.disable.class_type = false;
            });
        }
      },
      deep: true,
    },
    "search_form.class_type": {
      handler() {
        if (
          this.search_form.programme_id &&
          this.search_form.class_type &&
          this.show_add_class
        ) {
          this.disable.class_levels = true;
          this.search_form.class_level = "";
          axios
            .get(route("classes.get_class_levels"), {
              params: {
                programme_id: this.search_form.programme_id,
                class_type: this.search_form.class_type,
              },
            })
            .then((response) => {
              this.list.class_levels = response.data;
              this.disable.class_levels = false;
            });
        }
      },
      deep: true,
    },
    "form.fee": {
      handler() {
        this.total_amount = 0;
        this.form.fee.forEach((feeObject) => {
          const {
            include_registration_fee,
            registration_fee,
            registration_fee_discount,
            include_material_fee,
            material_fee,
            material_fee_discount,
            programme_fee,
            promos,
          } = feeObject.fee_info;

          const registration_fee_amount = include_registration_fee
            ? Number(registration_fee)
            : 0;
          const registration_discount =
            registration_fee_discount != "" && registration_fee_discount > 0
              ? Number(registration_fee_discount)
              : 0;
          const material_fee_amount = include_material_fee ? Number(material_fee) : 0;
          const material_discount =
            material_fee_discount != "" && material_fee_discount > 0
              ? Number(material_fee_discount)
              : 0;

          const totalPercentValuePromo = promos.reduce(
            (accumulator, currentValue) =>
              currentValue.type_id === 1 ? accumulator + currentValue.value : accumulator,
            0
          );
          const totalFixedValuePromo = promos.reduce(
            (accumulator, currentValue) =>
              currentValue.type_id === 2 ? accumulator + currentValue.value : accumulator,
            0
          );

          this.total_amount +=
            Number(programme_fee) -
            totalFixedValuePromo -
            (this.total_amount * totalPercentValuePromo) / 100 +
            (Number(registration_fee_amount) - Number(registration_discount)) +
            (Number(material_fee_amount) - Number(material_discount));
        });
      },
      deep: true,
    },
  },
  methods: {
    saveStudentDetails() {
      this.$inertia.post(route("students.update"), this.form, { preserveState: true });
    },
    showAddClass() {
      this.clearSearchForm();
      this.show_add_class = true;
      this.add_class.show.centre_info = true
      this.add_class.show.class_info = false
      this.add_class.show.fee_summary = false
    },
    findClasses() {
      this.selected_plus_class = [];
      this.errors.centre = !this.form.centre_id ? true : false;
      this.errors.admission_date = !this.form.date_admission ? true : false;
      this.errors.programme = !this.search_form.programme_id ? true : false;
      this.errors.class_type = !this.search_form.class_type ? true : false;
      this.errors.level = !this.search_form.class_level ? true : false;
      this.errors.class_method = !this.search_form.class_method ? true : false;

      if (
        this.form.centre_id &&
        this.search_form.programme_id &&
        this.search_form.class_level &&
        this.search_form.class_type &&
        this.search_form.class_method
      ) {
        this.searching.class = true;
        this.enable_container.show_fee = false;
        this.list.available_classes = [];

        axios
          .get(route("classes.find"), {
            params: {
              centre_id: this.form.centre_id,
              programme_id: this.search_form.programme_id,
              class_method: this.search_form.class_method,
              class_level: this.search_form.class_level,
              class_type: this.search_form.class_type,
            },
          })
          .then((res) => {
            this.list.available_classes = res.data
            this.enable_container.available_classes = true
            this.searching.class = false
            this.scrollToElement("available_classes")
            this.goToTransferClassInfo()
            this.goToAddClassInfo()
          });
      }
    },
    getPlusFee(event, class_id, class_type, programme_id, is_transfer_student = false) {
      this.form.fee = [];
      if (this.fetching_fee) {
        return;
      }
      if (this.disable_check_box) {
        return;
      }
      if (!is_transfer_student) {
        const programme_already_added_form = this.current_fee.find(
          (item) =>
            item.fee_info.programme_id == programme_id &&
            item.fee_info.student_fee_status == ""
        );
        if (programme_already_added_form) {
          alert(
            "This programme already been added. Please remove the previous one first or set the status."
          );
          if (event.target.checked) {
            event.target.checked = false;
          }
          this.add_class.show.centre_info = true
          this.add_class.show.class_info = false
          this.add_class.show.fee_summary = false
          this.searching.fee = false;
          return;
        }
      }

      this.disable_check_box = true;

      const checked = this.checkIfClassSelected(class_id, programme_id);

      if (!checked) {
        if (!this.selected_plus_class[programme_id]) {
          this.selected_plus_class[programme_id] = [];
        }
        this.selected_plus_class[programme_id].push(class_id);
      } else {
        if (this.selected_plus_class[programme_id].length == 1) {
          this.selected_plus_class[programme_id] = [];
          this.no_fee_found = false;
        }
        this.selected_plus_class[programme_id] = this.selected_plus_class[
          programme_id
        ].filter((id) => id !== class_id);
      }
      this.form.fee = [];
      this.form.fee = this.form.fee.filter(
        (item) => item.fee_info.programme_id !== programme_id
      );

      if (this.selected_plus_class[programme_id].length) {
        this.fetching_fee = true;
        axios
          .get(route("programmes.get_fee"), {
            params: {
              class_type: this.search_form.class_type,
              class_count: this.selected_plus_class[programme_id].length,
              classes: this.selected_plus_class[programme_id],
            },
          })
          .then((res) => {
            if (res.data.fee_info) {
              this.form.fee.push(res.data);
              // this.pushMaterialFee(programme_id);
            }
            this.scrollToElement("class_fee");
            this.searching.fee = false;
            this.disable_check_box = false;
            this.fetching_fee = false;
            this.goToTransferSummary()
            this.goToAddClassSummary()
          })
          .catch((error) => {
            this.searching.fee = false;
            this.disable_check_box = false;
            this.fetching_fee = false;
            this.no_fee_found = true;
          });
      } else {
        this.disable_check_box = false;
      }
    },
    clearStudents() {
      this.students = [];
    },
    scrollToElement(element) {
      const el = this.$refs[element];
      if (el) {
        el.scrollIntoView({ behavior: "smooth", block: "center", inline: "nearest" });
      }
    },
    addClass() {
      if(this.processing.add_class){
        return
      }
      this.processing.add_class = true
      this.$inertia.post(route("students.add_student_class"), this.form, {
        preserveState: false,
        preserveScroll: true,
      });
    },
    deleteClass(student_fee_id, invoice_id, admission_date, centre_id, programme_id) {
      this.confirmation.delete_class.route_name = "students.destroy";
      this.confirmation.delete_class.params = {
        student_fee_id: student_fee_id,
        invoice_id: invoice_id,
        admission_date: admission_date,
        centre_id: centre_id,
        programme_id: programme_id,
      };
      this.confirmation.delete_class.is_open = true;
    },
    deleteFee(programme_id, class_type) {
      this.form.fee = this.form.fee.filter(
        (item) => item.fee_info.programme_id !== programme_id
      );
      if (class_type == 2) {
        if (this.selected_plus_class.hasOwnProperty(programme_id)) {
          delete this.selected_plus_class[programme_id];
        }
      }
    },
    checkIfClassSelected(class_id, programme_id) {
      const classExists = this.selected_plus_class[programme_id]
        ? this.selected_plus_class[programme_id].includes(class_id)
        : false;
      return classExists;
    },
    pushMaterialFee(programme_id) {
      for (const feeObject of this.form.fee) {
        const classObject = feeObject.fee_info;
        console.log(classObject)
        if (classObject.programme_id === programme_id) {
          classObject.include_material_fee = true;
          classObject.material_fee_discount = 0;
          classObject.programme_fee_discount = 0;
          break;
        }
      }
    },
    changeFeeStatus(student_fee_id, student_fee_status) {
      if (!student_fee_status) {
        this.confirmation.set_status.student_fee_status = 1;
        this.confirmation.set_status.route_name = "students.set_fee_status";
        this.confirmation.set_status.params = {
          student_fee_id: student_fee_id,
          student_fee_status: 1,
        };
        this.confirmation.set_status.is_open = true;
      }
    },
    showTransferStudent(fee_id, student_fee_id, programme_id, class_type_id, programme_level) {
      this.clearSearchForm();
      this.form.fee_id = fee_id;
      this.form.student_fee_id = student_fee_id;
      this.search_form.programme_id = programme_id;
      this.search_form.class_type = class_type_id;
      this.search_form.class_level = programme_level;
      this.transfer.show.centre_info = true
      this.transfer.show.class_info = false
      this.transfer.show.fee_summary = false
      this.show_transfer_student = true;
    },
    transferStudent() {
      if (this.selected_plus_class[this.search_form.programme_id].length) {
        const class_count = this.current_fee
          .filter((fee) => fee.fee_info.programme_id === this.search_form.programme_id)
          .map((fee) => fee.classes.length)
          .reduce((accumulator, currentValue) => accumulator + currentValue, 0);
        if (
          this.selected_plus_class[this.search_form.programme_id].length != class_count
        ) {
          alert("You will have to select " + class_count + " classes to proceed.");
          return;
        }
      }
      this.$inertia.post(route("students.transfer"), this.form, {
        preserveState: false,
        preserveScroll: true,
        onSuccess: () => {
          this.transfer.show.centre_info = true
          this.transfer.show.class_info = false
          this.transfer.show.fee_info = false
        }
      });
    },
    clearSearchForm() {
      this.form.centre_id = "";
      this.search_form.programme_id = "";
      this.search_form.class_type = "";
      this.search_form.class_level = "";
      this.search_form.class_method = "";
      this.list.class_types = [];
      this.list.class_levels = [];
      this.list.available_classes = [];
      this.form.fee = [];
      this.selected_plus_class = {};
    },
    sumMaterialFee(has_material_fee, material_fee, programme_fee) {
      return has_material_fee
        ? Number(material_fee) + Number(programme_fee)
        : Number(programme_fee);
    },
    deleteExistingClassPromo(fee_id, student_fee_id, promo_id, student_fee_promo_id) {
        this.confirmation.delete_promo.route_name = "students.delete_promo";
        this.confirmation.delete_promo.params = {
          fee_id: fee_id,
          student_fee_id: student_fee_id,
          promo_id: promo_id,
          student_fee_promo_id: student_fee_promo_id,
          form: this.form,
        };
        this.confirmation.delete_promo.is_open = true;
    },
    deleteNewClassPromo(fee_index, promo_index) {
      this.form.fee[fee_index].fee_info.promos.splice(promo_index, 1);
    },
    showExistingClassPromoModal(fee_index, fee_id, student_fee_id) {
      this.selected_promo.promo_id = "";
      this.selected_promo.fee_index = fee_index;
      this.selected_promo.fee_id = fee_id;
      this.selected_promo.student_fee_id = student_fee_id;
      this.existing_promo.show = true;
    },
    showNewClassPromoModal(fee_index, fee_id, student_fee_id) {
      this.selected_promo.promo_id = "";
      this.selected_promo.fee_index = fee_index;
      this.selected_promo.fee_id = fee_id;
      this.selected_promo.student_fee_id = student_fee_id;
      this.add_new_promo.show = true;
    },
    addExistingClassPromo() {
      if(this.processing.add_existing_class_promo){
        return
      }
      this.processing.add_existing_class_promo = true
      const selectedPromo = this.$page.props.promos.find(
        (promo) => promo.promo_id === this.selected_promo.promo_id
      );
      const promoAdded = this.current_fee[
        this.selected_promo.fee_index
      ].fee_info.promos.find((promo) => promo.promo_id === this.selected_promo.promo_id);

      if (!promoAdded && selectedPromo) {
        const data = {
          promo_id: selectedPromo.promo_id,
          promo_name: selectedPromo.promo_name,
          type_id: selectedPromo.type_id,
          type_name: selectedPromo.type_name,
          value: selectedPromo.value,
          duration_id: selectedPromo.type_id,
          duration_name: selectedPromo.duration_name,
          duration_count: selectedPromo.duration_count,
          duration_remaining: selectedPromo.duration_count,
        };
        this.$inertia.post(
          route("students.add_promo"),
          {
            fee_id: this.selected_promo.fee_id,
            student_fee_id: this.selected_promo.student_fee_id,
            data: data,
          },
          { preserveState: false }
        );
      }

      this.open_existing_class_promo_modal = false;
    },
    addNewClassPromo() {
      const selectedPromo = this.$page.props.promos.find(
        (promo) => promo.promo_id === this.selected_promo.promo_id
      );
      const promoAdded = this.form.fee[
        this.selected_promo.fee_index
      ].fee_info.promos.find((promo) => promo.promo_id === this.selected_promo.promo_id);

      if (!promoAdded && selectedPromo) {
        this.form.fee[this.selected_promo.fee_index].fee_info.promos.push({
          promo_id: parseInt(selectedPromo.promo_id),
          promo_name: selectedPromo.promo_name,
          type_id: parseInt(selectedPromo.type_id),
          type_name: selectedPromo.type_name,
          value: parseInt(selectedPromo.value),
          duration_id: parseInt(selectedPromo.type_id),
          duration_name: selectedPromo.duration_name,
          duration_count: parseInt(selectedPromo.duration_count),
          duration_remaining: parseInt(selectedPromo.duration_count),
        });
      }

      this.add_new_promo.show = false;
    },
    calculateTotal(fee_index, fee_amount) {
      const totalPercentValuePromo = this.form.fee[fee_index].fee_info.promos.reduce((accumulator, currentValue) => 
          currentValue.type_id === 1 ? accumulator + currentValue.value : accumulator
      , 0);
      const totalFixedValuePromo = this.form.fee[fee_index].fee_info.promos.reduce((accumulator, currentValue) => 
          currentValue.type_id === 2 ? accumulator + currentValue.value : accumulator
      , 0);
      return fee_amount - totalFixedValuePromo - (fee_amount * totalPercentValuePromo / 100)
    },
    resetFeeStatus() {
      const fee = this.current_fee.find(
        (item) =>
          item.fee_info.student_fee_status ==
          this.confirmation.set_status.student_fee_status
      );
      if (fee) {
        fee.fee_info.student_fee_status = "";
      }
    },
    goToAddClassInfo(){
      this.add_class.show.centre_info = false
      this.add_class.show.class_info = true
      this.add_class.show.fee_summary = false
      setTimeout(() => {
        this.scrollToElement("add_class_info");
      }, 300);
    },
    goToAddClassSummary(){
      this.add_class.show.centre_info = false
      this.add_class.show.class_info = false
      this.add_class.show.fee_summary = true
      setTimeout(() => {
        this.scrollToElement("add_class_summary");
      }, 300);
    },
    goToTransferClassInfo(){
      this.transfer.show.centre_info = false
      this.transfer.show.class_info = true
      this.transfer.show.fee_summary = false
      setTimeout(() => {
        this.scrollToElement("transfer_class_info");
      }, 300);
    },
    goToTransferSummary(){
      this.transfer.show.centre_info = false
      this.transfer.show.class_info = false
      this.transfer.show.fee_summary = true
      setTimeout(() => {
        this.scrollToElement("transfer_summary");
      }, 300);
    }
  },
  created() {
    const now = new Date();
    const dateString = now.toISOString().substring(0, 10);
    this.form.date_admission = `${dateString}T05:59:00.000Z`;
  },
};
</script>
<style>
.dp__input {
  border-radius: 6px;
}
.dp__theme_light {
  --dp-border-color: rgb(209 213 219 / var(--tw-border-opacity));
}
</style>
