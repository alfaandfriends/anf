<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Orders" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="flex justify-end mb-3" v-if="$page.props.can.create_orders">
                <BreezeButton :route="route('orders.create')">Add New Order</BreezeButton>
            </div>
            <hr class="my-3 border border-dashed border-gray-400">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-2 mb-3">
                <div class="relative w-full">
                    <svg class="absolute top-2.5 left-3 h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <input type="text" class="h-10 border-2 border-gray-300 w-full appearance-none focus:ring-0 focus:border-gray-300 py-1 pl-10 pr-4 text-gray-700 bg-white rounded-md" v-debounce:800ms="search" v-model="params.search">
                </div>
                <div class="w-full">
                    <Multiselect 
                        @select="search"
                        @deselect="search"
                        valueProp="id"
                        v-model="params.status"
                        :options="$page.props.status"
                        :clearOnSelect="false"
                        :closeOnDeselect="true"
                        :canClear="false"
                        :canDeselect="true"
                        trackBy="name"
                        label="name"
                        placeholder="All Status"
                            :classes="{
                                container: 'relative w-full flex items-center justify-end box-border cursor-pointer border-2 border-gray-300 rounded-md bg-white text-base leading-snug outline-none h-10',
                                containerDisabled: 'cursor-default bg-gray-100',
                                containerOpen: 'rounded-b-none',
                                containerActive: 'border-2 border-gray-300',
                                singleLabel: 'flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 pr-16 box-border',
                                singleLabelText: 'overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full',
                                search: 'w-full mt-1 h-8 absolute inset-0 focus:border-none outline-none focus:ring-0 appearance-none border-2 border-transparent focus:border-gray-300 text-base font-sans bg-white rounded-lg',
                                placeholder: 'flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-500',
                                clear: 'pr-10 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80 text-gray-800',
                                clearIcon: 'fa fa-heart bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px box-content inline-block',
                                spinner: 'bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0',
                                dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-b',
                                dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
                                dropdownHidden: 'hidden',
                                options: 'flex flex-col p-0 m-0 list-none w-full',
                                group: 'p-0 m-0',
                                groupLabel: 'flex text-sm box-border items-center justify-start text-left py-2 px-3 font-semibold bg-gray-200 cursor-default leading-normal',
                                groupLabelPointable: 'cursor-pointer',
                                groupLabelPointed: 'bg-gray-300 text-black-700',
                                groupLabelSelected: 'bg-gray-100 text-black',
                                groupLabelSelectedPointed: 'bg-gray-100 text-black opacity-90',
                                groupOptions: 'p-0 m-0',
                                option: 'flex items-center justify-start box-border text-left cursor-pointer text-base leading-snug py-2 px-3',
                                optionPointed: 'text-gray-800 bg-gray-100',
                                optionSelected: 'text-white bg-indigo-500',
                                optionDisabled: 'text-gray-300 cursor-not-allowed',
                                optionSelectedPointed: 'text-white bg-indigo-500 opacity-90',
                                optionSelectedDisabled: 'text-green-100 bg-green-500 bg-opacity-50 cursor-not-allowed',
                                noOptions: 'py-2 px-3 text-gray-600 bg-white text-left',
                                noResults: 'py-2 px-3 text-gray-600 bg-white text-left',
                                fakeInput: 'bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent',
                            }">
                        </Multiselect>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14">#</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-6/14">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/14">Attachments</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/14">Shipment Tracking</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14">Status</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/14">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-if="!$page.props.orders.data || !$page.props.orders.data.length">
                            <td class="text-center" colspan="10">
                                <div class="p-3">
                                    No Record Found!
                                </div>
                            </td>
                        </tr>
                        <tr v-else class="" v-for="(order, index) in $page.props.orders.data">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">{{ index + 1 }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ order.parent_full_name }}
                                </div>
                                <div class="text-sm font-medium text-slate-500"> {{ order.parent_calling_code }}{{ order.parent_contact }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ moment(order.created_at).format('DD/MM/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                <span @click="viewInvoice(order.id, index)" class="font-semibold border border-blue-600 bg-blue-100 hover:bg-blue-200 text-blue-700 whitespace-nowrap rounded px-2.5 py-1 text-sm cursor-pointer">
                                    {{ generating[index].invoice ? 'Generating...' : 'Invoice'}}
                                </span>
                                <span @click="viewPackingSlip(order.id, index)" class="font-semibold border border-blue-600 bg-blue-100 hover:bg-blue-200 text-blue-700 whitespace-nowrap rounded px-2.5 py-1 text-sm cursor-pointer">
                                    {{ generating[index].packing_slip ? 'Generating...' : 'Packing Slip'}}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col text-sm font-medium text-gray-900" v-if="order.shipping_provider_name">
                                    <small class="font-bold text-gray-600">{{ order.shipping_provider_name }}</small>
                                    <span class="font-semibold text-indigo-700">{{ order.tracking_number }}</span>
                                </div>
                                <div class="" v-else>-</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    <span @click="viewTrackingStatus(order.tracking_status)" class="border whitespace-nowrap rounded px-2.5 py-1 text-sm cursor-pointer " :class="[order.class_name]">{{ order.status_name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex space-x-2 justify-center">
                                    <BreezeButton @click="editOrder(order.id)" buttonType="warning" v-if="$page.props.can.edit_orders">Edit</BreezeButton>
                                    <BreezeButton @click="deleteOrder(order.id)" buttonType="danger" v-if="$page.props.can.delete_orders">Delete</BreezeButton>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Pagination v-if="$page.props.orders.data.length" :page_data="$page.props.orders" :params="params"></Pagination>
            <ConfirmationModal
                :show="show_delete_order"
                @close="show_delete_order = false"
                confirmationAlert="danger"
                confirmationTitle="Delete Order"
                confirmationText="Are you sure want to delete this order?"
                confirmationButton="Delete"
                confirmationMethod="delete"
                confirmationRoute="orders.destroy"
                :confirmationData="confirmation_data"
            >
            </ConfirmationModal>
        </div>
        <Modal :showModal="show_tracking_status" :modalType="'sm'" @hideModal="show_tracking_status = false">
            <template v-slot:content>
                <div class="p-4 md:p-6 overflow-y-auto scrollbar">
                    <body class="bg-gray-50">
                        <div class="container">
                            <div class="flex flex-col text-gray-50">
                                <div class="flex md:px-4" v-if="!tracking_status || !tracking_status.length"> 
                                    <h3 class="font-semibold text-md italic mb-1 text-slate-700">Sorry, no status has been added right now.</h3>
                                </div>
                                <div class="flex space-x-2 md:space-x-4" v-else v-for="status in tracking_status"> 
                                    <div class="relative">
                                        <div class="h-full w-6 flex items-center justify-center">
                                            <div class="h-full w-1 bg-green-600 pointer-events-none"></div>
                                        </div>
                                        <div class="w-6 h-6 absolute top-1/2 -mt-3 rounded-full bg-green-600 shadow text-center">
                                            <i class="fas fa-check-circle text-white"></i>
                                        </div>
                                    </div>
                                    <div class="bg-green-600 col-start-4 col-end-12 p-4 rounded-xl my-4 mr-auto shadow-md w-full">
                                        <h3 class="font-semibold text-sm mb-1">{{ status.name }}</h3>
                                        <p class="leading-tight text-xs text-justify w-full">
                                            {{ moment(status.datetime).format('DD/MM/Y HH:mm A') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </body>
                </div>
            </template>
            <template v-slot:footer>
                <div class="flex justify-between space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                    <BreezeButton buttonType="gray" @click="show_tracking_status = false">Close</BreezeButton>
                </div>
            </template>
        </Modal>
        <Modal :showModal="show_invoice" modalType="md" @hideModal="show_invoice = false" v-if="show_invoice">
            <template v-slot:header>
                <div class="flex items-center justify-between py-3 px-4 border-b rounded-t font-semibold">   
                    <h3 class="text-gray-900 text-xl font-semibold">                
                        Invoice
                    </h3>   
                    <button type="button" @click="show_invoice = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>               
            </template>
            <template v-slot:content>
                <Invoice :invoice_data="invoice_data"></Invoice>
            </template>
            <template v-slot:footer>
                <div class="flex justify-between space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                    <BreezeButton buttonType="blue" class="px-4 py-2 space-x-2" @click="print">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                        </svg>
                        <span>Print</span>
                    </BreezeButton>
                    <BreezeButton buttonType="gray" @click="show_invoice = false">Close</BreezeButton>
                </div>
            </template>
        </Modal>
        <Modal :showModal="show_packing_slip" modalType="md" @hideModal="show_packing_slip = false" v-if="show_packing_slip">
            <template v-slot:header>
                <div class="flex items-center justify-between py-3 px-4 border-b rounded-t font-semibold">                  
                    <h3 class="text-gray-900 text-xl font-semibold">                
                        Packing Slip
                    </h3>    
                    <button type="button" @click="show_packing_slip = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="default-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>              
            </template>
            <template v-slot:content>
                <PackingSlip :packing_slip_data="packing_slip_data"></PackingSlip>
            </template>
            <template v-slot:footer>
                <div class="flex justify-between space-x-2 items-center p-4 border-t border-gray-200 rounded-b">
                    <BreezeButton buttonType="blue" class="px-4 py-2 space-x-2" @click="print">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                        </svg>
                        <span>Print</span>
                    </BreezeButton>
                    <BreezeButton buttonType="gray" @click="show_packing_slip = false">Close</BreezeButton>
                </div>
            </template>
        </Modal>
    </BreezeAuthenticatedLayout>
</template>

<script>
import Modal from '@/Components/Modal.vue'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import moment from 'moment'
import Invoice from '@/Pages/Order/Invoice.vue'
import PackingSlip from '@/Pages/Order/PackingSlip.vue'
import { debounce } from 'vue-debounce'
import Pagination from '@/Components/Pagination.vue'
import Multiselect from '@vueform/multiselect'

export default {
    components: {
        Pagination, Multiselect
    },
    data(){
        return{
            show_invoice: false,
            show_packing_slip: false,
            show_delete_order: false,
            confirmation_data: '',
            show_tracking_status: false,
            tracking_status: [],
            params: {
                search: this.$page.props.filter.search ? this.$page.props.filter.search : '',
                status: this.$page.props.filter.status ? this.$page.props.filter.status : '',
            },
            invoice_data: [],
            packing_slip_data: [],
            generating: []
        }
    },
    methods: {
        viewTrackingStatus(tracking_status){
            this.tracking_status    =   JSON.parse(tracking_status)
            this.show_tracking_status = true
        },
        editOrder(order_id){
            this.$inertia.get(route('orders.edit'), {order_id: order_id})
        },
        deleteOrder(order_id){
            this.confirmation_data = order_id
            this.show_delete_order = true
        },
        viewInvoice(order_id, index){
            if(this.generating[index].invoice){
                return
            }
            this.generating[index].invoice = true
            axios.get(route('orders.invoice.generate'), {
                responseType: 'blob', // Set the response type to 'blob' to handle binary data
                params: {
                    'order_id': order_id
                }
            })
            .then(response => {
                // Create a Blob object from the response data
                const blob = new Blob([response.data], { type: 'application/pdf' });

                // Create a URL for the Blob object
                const pdfUrl = URL.createObjectURL(blob);

                // Open the PDF in a new tab
                window.open(pdfUrl, '_blank');
                this.generating[index].invoice = false
            })
            .catch(error => {
                console.error('Error fetching PDF:', error);
                this.generating[index].invoice = false
            });
            // this.invoice_data = this.$page.props.orders.data[index]
            // this.show_invoice = true
        },
        viewPackingSlip(order_id, index){
            if(this.generating[index].packing_slip){
                return
            }
            this.generating[index].packing_slip = true
            axios.get(route('orders.packing_slip.generate'), {
                responseType: 'blob', // Set the response type to 'blob' to handle binary data
                params: {
                    'order_id': order_id
                }
            })
            .then(response => {
                // Create a Blob object from the response data
                const blob = new Blob([response.data], { type: 'application/pdf' });

                // Create a URL for the Blob object
                const pdfUrl = URL.createObjectURL(blob);

                // Open the PDF in a new tab
                window.open(pdfUrl, '_blank');
                this.generating[index].packing_slip = false
            })
            .catch(error => {
                console.error('Error fetching PDF:', error);
                this.generating[index].packing_slip = false
            });
            // this.packing_slip_data = this.$page.props.orders.data[index]
            // this.show_packing_slip = true
        },
        search(){
            this.$inertia.get(this.route('orders'), this.params, { replace: true, preserveState: true});
        }
    },
    created(){
        this.$page.props.orders.data.forEach(element => {
            this.generating.push({
                invoice: false,
                packing_slip: false
            })
        });
    }
}
</script>
