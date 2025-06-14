<template>
  <Head title="Invoices" />
  <Header>{{ $page.props.session_data.current_active_programme.name }}</Header>
  <Authenticated>
    <div class="max-w-xl mx-auto border shadow bg-white rounded-lg px-4 mt-14">
      <simplebar data-simplebar-auto-hide="true">
        <div
          class="flex justify-evenly sm:justify-center space-x-8 md:space-x-10 pt-3 pb-4 font-medium"
        >
          <div
            class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap"
            :class="route().current('parent.stories') ? 'font-extrabold' : ''"
            @click="
              $inertia.get(
                route(
                  'parent.stories',
                  $page.props.session_data.current_active_programme.encrypted_id
                )
              )
            "
          >
            <img src="/images/parents/stories.png" class="w-10 h-10" alt="" />
            <span class="text-sm">Stories</span>
          </div>
          <div
            class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap"
            :class="route().current('parent.progress_reports') ? 'font-extrabold' : ''"
            @click="$inertia.get(route('parent.progress_reports'))"
          >
            <img src="/images/parents/progress_report.png" class="w-10 h-10" alt="" />
            <span class="text-sm">Progress Reports</span>
          </div>
          <div
            class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap"
            :class="route().current('parent.invoices') ? 'font-extrabold' : ''"
            @click="$inertia.get(route('parent.invoices'))"
          >
            <img src="/images/parents/fee_invoice.png" class="w-10 h-10" alt="" />
            <span class="text-sm">Invoices</span>
          </div>
          <div
            class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap"
            :class="route().current('parent.art_gallery') ? 'font-extrabold' : ''"
            @click="$inertia.get(route('parent.art_gallery'))"
            v-if="
              $page.props.session_data.current_active_programme.id == 3 ||
              $page.props.session_data.current_active_programme.id == 5
            "
          >
            <img src="/images/parents/art_gallery.png" class="w-10 h-10" alt="" />
            <span class="text-sm">Art Gallery</span>
          </div>
          <!-- <div class="flex flex-col items-center cursor-pointer hover:scale-105 duration-150 whitespace-nowrap" :class="route().current('parent.art_book') ? 'font-extrabold' : ''" @click="$inertia.get(route('parent.art_book'))" v-if="$page.props.session_data.current_active_programme.id == 3 || $page.props.session_data.current_active_programme.id == 5">
                        <img src="/images/parents/art_book.png" class="w-10 h-10" alt="">
                        <span class="text-sm">Art Book</span>
                    </div> -->
        </div>
      </simplebar>
    </div>
    <div class="max-w-xl mx-auto mt-10">
      <div class="flex items-center space-y-3" v-if="$page.props.invoices.data.length">
        <h2 class="text-lg md:text-xl mx-1 font-extrabold">Invoices</h2>
      </div>
      <div
        class="flex justify-center mx-1 mt-10"
        v-if="!$page.props.invoices.data.length"
      >
        <span class="text-slate-500">No Invoices Found</span>
      </div>
      <div class="mt-3" v-if="$page.props.invoices.data.length">
        <div class="bg-white shadow rounded-lg border">
          <simplebar
            data-simplebar-auto-hide="true"
            class="max-h-96"
            @scroll="handleInvoiceScroll"
            ref="invoice_container"
          >
            <ul class="divide-y divide-slate-200 dark:divide-zink-500 px-6 py-4">
              <li
                class="flex items-center gap-3 py-2 first:pt-0 last:pb-0"
                v-for="(invoice, invoice_index) in $page.props.invoices.data"
              >
                <div class="grow">
                  <h6 class="font-bold text-sm">
                    {{ moment(invoice.date_issued).format("MMMM Y") }} (<span
                      class="font-semibold text-blue-700"
                      >{{ invoice.invoice_number }}</span
                    >)
                  </h6>
                  <p class="text-slate-500 text-sm font-medium">
                    Amount: {{ invoice.amount }}
                  </p>
                  <p class="text-sm font-medium">
                    Status:
                    <span :class="[invoice.status_text_color]">{{ invoice.status }}</span>
                  </p>
                </div>
                <div class="shrink-0">
                  <a
                    target="_blank"
                    v-if="invoice.status_id == 1"
                    :href="invoice.payment_url"
                    class="text-sm cursor-pointer font-medium px-3 py-1 text-indigo-600 rounded bg-indigo-100 hover:bg-indigo-200 hover:rounded whitespace-nowrap"
                    >Pay Now</a
                  >
                  <div class="flex flex-col gap-1" v-if="invoice.status_id == 2">
                    <a
                      @click="checkPaymentStatus(invoice.bill_id)"
                      class="flex items-center gap-1 text-sm cursor-pointer font-medium px-3 py-1 text-indigo-600 rounded bg-indigo-100 hover:bg-indigo-200 hover:rounded whitespace-nowrap"
                      ><ReceiptTextIcon class="w-3 h-3" /><span>Receipt</span></a
                    >
                    <a
                      class="flex items-center gap-1 text-sm cursor-pointer font-medium px-3 py-1 text-blue-600 bg-blue-100 hover:bg-blue-200 rounded whitespace-nowrap"
                      @click="
                        generating[invoice_index]
                          ? ''
                          : viewInvoice(invoice.id, invoice_index)
                      "
                      ><EyeIcon class="w-3 h-3" /><span>{{
                        generating[invoice_index] ? "Generating..." : "Invoice"
                      }}</span></a
                    >
                  </div>
                </div>
              </li>
              <div
                class="flex items-center justify-between pt-5 animate-pulse"
                v-if="loading.invoices"
              >
                <div>
                  <div
                    class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-52 mb-2.5"
                  ></div>
                  <div
                    class="w-28 h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"
                  ></div>
                  <div class="w-20 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
                </div>
                <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-700 w-14"></div>
              </div>
            </ul>
          </simplebar>
        </div>
      </div>
    </div>
  </Authenticated>
</template>

<script setup>
import Authenticated from "@/Layouts/Parent/Authenticated.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import simplebar from "simplebar-vue";
import "simplebar-vue/dist/simplebar.min.css";
import axios from "axios";
import moment from "moment";
import Header from "./Header.vue";
import { EyeIcon, ReceiptIcon, ReceiptTextIcon } from "lucide-vue-next";
</script>

<script>
export default {
  components: {
    simplebar,
  },
  data() {
    return {
      open_modal: false,
      generating: [],
      invoice_data: {
        parent_name: "",
        parent_address: "No 27, Jalan Kap Empat, 17/17D, Seksyen 17, Shah Alam",
        invoice_number: "",
        invoice_items: [],
        date_issued: "",
        due_date: "",
        total_amount: "",
      },
      loading: {
        invoices: false,
      },
    };
  },
  methods: {
    viewInvoice(invoice_id, index) {
      if (this.generating[index]) {
        return;
      }
      this.generating[index] = true;
      axios
        .get(route("fee.invoices.generate"), {
          responseType: "blob", // Set the response type to 'blob' to handle binary data
          params: {
            invoice_id: invoice_id,
          },
        })
        .then((response) => {
          // Create a Blob object from the response data
          const blob = new Blob([response.data], { type: "application/pdf" });

          // Create a URL for the Blob object
          const pdfUrl = URL.createObjectURL(blob);

          // Open the PDF in a new tab
          window.open(pdfUrl, "_blank");
          this.generating[index] = false;
        })
        .catch((error) => {
          console.error("Error fetching PDF:", error);
          this.generating[index] = false;
        });
    },
    checkPaymentStatus(bill_id) {
      axios.post(route("parent.invoices.payment_status", bill_id)).then((response) => {
        window.open(response.data.url_redirect, "_blank");
      });
    },
    totalFee(invoice_items) {
      let total = 0;
      const parsed_invoice_items = JSON.parse(invoice_items);
      for (const item of parsed_invoice_items) {
        // Parse fees and discounts as numbers
        const programmeFee = parseFloat(item.programme_fee);
        const programmeDiscount = parseFloat(item.programme_fee_discount);
        const materialFee = parseFloat(item.material_fee);
        const materialDiscount = parseFloat(item.material_fee_discount);

        // Add programme fee and subtract programme discount
        total += programmeFee - programmeDiscount;

        // Check if material fee should be included
        if (item.include_material_fee) {
          // Add material fee and subtract material discount
          total += materialFee - materialDiscount;
        }
      }
      return total;
    },
    pay(billing_id) {
      window.location.href = import.meta.env.VITE_BILLPLZ_ENDPOINT + billing_id;
    },
    handleInvoiceScroll() {
      const container = this.$refs.invoice_container.$el.querySelector(
        ".simplebar-content-wrapper"
      );
      const scrollTop = container.scrollTop;
      const scrollHeight = container.scrollHeight;
      const clientHeight = container.clientHeight;

      if (scrollTop + clientHeight >= scrollHeight - 100) {
        if (this.$page.props.invoices.next_page_url) {
          if (!this.loading.invoices) {
            this.loading.invoices = true;
            axios
              .get(route("parent.student_invoices"), {
                params: {
                  page: this.$page.props.invoices.current_page + 1,
                },
              })
              .then((res) => {
                res.data.data.forEach((item) => {
                  this.$page.props.invoices.data.push(item);
                });
                this.$page.props.invoices.current_page = res.data.current_page;
                this.$page.props.invoices.next_page_url = res.data.next_page_url;
                this.loading.invoices = false;
              });
          }
        }
      }
    },
  },
  mounted() {
    this.$page.props.invoices.data.forEach((element) => {
      this.generating.push(false);
    });
  },
};
</script>
