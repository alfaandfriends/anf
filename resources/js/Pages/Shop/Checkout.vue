<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Shop" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-left flex space-x-3">
                        <div class="bg-white rounded shadow p-8 w-1/2">
                            <!-- Order Summary  -->
                            <div>
                                <h3 class="text-xl mt-4 font-bold">Shopping Cart</h3>
                                <!--     BOX     -->
                                <div class="border w-full rounded mt-5 flex p-4 justify-between items-center flex-wrap">
                                    <img src="https://images-na.ssl-images-amazon.com/images/I/41KufN65f8L.jpg" class="w-12">
                                    <div class="w-2/3">
                                        <h3 class="text-lg font-medium">Black Jacket XL</h3>
                                        <p class="text-gray-600 text-xs">Sold by <b>Joey Khan</b></p>
                                        <h4 class="text-red-700 text-xs font-bold mt-1">Only 2 left in stock</h4>
                                    </div>
                                    <div>
                                        <h4 class="text-3xl font-medium"><sup class="text-lg text-purple-800">RM</sup> 89</h4>
                                    </div>
                                    <div class="w-full flex justify-between mt-4">
                                        <button class="text-red-700 px-2">DELETE</button>
                                        <label class="block tracking-wide text-gray-700" for="grid-first-name"> Quantity
                                            <button class="py-1 px-3 bg-indigo-600 hover:bg-indigo-700 rounded-sm text-white">-</button>
                                            <label class="px-3 font-bold">3</label>
                                            <button class="py-1 px-3 bg-indigo-600 hover:bg-indigo-700 rounded-sm text-white">+</button>
                                        </label>
                                    </div>
                                </div>
                                <div class="border w-full rounded mt-5 flex p-4 justify-between items-center flex-wrap">
                                    <img src="https://m.media-amazon.com/images/I/71I3TJMpqCL._AC_SR180,120_QL70_.jpg" class="w-12">
                                    <div class="w-2/3">
                                        <h3 class="text-lg font-medium">Black Hat</h3>
                                        <p class="text-gray-600 text-xs">Sold by <b>Tammy Austin</b></p>
                                        <h4 class="text-red-700 text-xs font-bold mt-1">Only 1 left in stock</h4>
                                    </div>
                                    <div>
                                        <h4 class="text-3xl font-medium"><sup class="text-lg text-purple-800">RM</sup> 20</h4>
                                    </div>
                                    <div class="w-full flex justify-between mt-4">
                                        <button class="text-red-700 px-2">DELETE</button>
                                        <label class="block tracking-wide text-gray-700" for="grid-first-name"> Quantity
                                            <button class="py-1 px-3 bg-indigo-600 hover:bg-indigo-700 rounded-sm text-white">-</button>
                                            <label class="px-3 font-bold">3</label>
                                            <button class="py-1 px-3 bg-indigo-600 hover:bg-indigo-700 rounded-sm text-white">+</button>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded shadow p-8 w-1/2 space-y-2">
                            <h3 class="font-bold">Payment Method</h3>
                            <div class="flex space-x-1">
                                <div class="relative overflow-hidden border hover:border-indigo-500 hover:text-indigo-700 px-4 py-2 cursor-pointer" @click="activatePayment('fpx')" :class="activePayment.fpx ? 'border-indigo-500 text-indigo-700' : ' border-gray-300'">
                                    Online Banking (FPX)
                                    <div class="absolute right-[-5px] top-0 h-10 w-10" v-show="activePayment.fpx">
                                        <div class="absolute transform rotate-45 bg-indigo-500 text-center text-white font-semibold py-1 left-[15px] top-[-10px] w-[40px] h-[25px]">
                                        </div>
                                    </div>
                                </div>
                                <div class="relative overflow-hidden border hover:border-indigo-500 hover:text-indigo-700 px-4 py-2 cursor-pointer" @click="activatePayment('cc')" :class="activePayment.cc ? 'border-indigo-500 text-indigo-700' : ' border-gray-300'">
                                    Credit Card
                                    <div class="absolute right-[-5px] top-0 h-10 w-10" v-show="activePayment.cc">
                                        <div class="absolute transform rotate-45 bg-indigo-500 text-center text-white font-semibold py-1 left-[15px] top-[-10px] w-[40px] h-[25px]">
                                        </div>
                                    </div>
                                </div>
                                <div class="relative overflow-hidden text-gray-400 border px-4 py-2 cursor-not-allowed">Installments</div>
                            </div>
                            <div class="flex flex-col space-y-4 border border-gray-300 p-3" v-if="activePayment.fpx">
                                <div class="flex items-center space-x-4 cursor-pointer" @click="selectBank('maybank', 'MB2U0227')">
                                    <div class="border border-gray-200 w-4 h-4 rounded-full" :class="bankSelected.maybank ? 'bg-indigo-600' : 'bg-white'"></div>
                                    <img class="w-10 h-10" src="/storage/bank_logos/img_bankmy_maybank.png" alt="">
                                    <label for="" class="cursor-pointer">Maybank2u</label>
                                </div>
                                <div class="flex items-center space-x-4 cursor-pointer" @click="selectBank('cimb', 'BCBB0235')">
                                    <div class="border border-gray-200 w-4 h-4 bg-white rounded-full" :class="bankSelected.cimb ? 'bg-indigo-600' : 'bg-white'"></div>
                                    <img class="w-10 h-10" src="/storage/bank_logos/img_bankmy_cimb.png" alt="">
                                    <label for="" class="cursor-pointer">CIMB Clicks</label>
                                </div>
                            </div>
                            <div class="flex flex-col space-y-4 border border-gray-300 p-3" v-if="activePayment.cc">
                                <div id="paypal-button-container" v-html="activatePayment.cc ? '' : ''">
                                </div>
                            </div>
                            <div class="flex justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white cursor-pointer" @click="pay" v-if="paymentSelected">
                                <label for="">Pay Now</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import { loadScript } from "@paypal/paypal-js";

export default {
    components: {
        Head, Link
    },
    data(){
        return {
            paymentSelected: false,
            bankSelected: {
                maybank: false,
                cimb: false
            },
            activePayment: {
                fpx: false,
                cc: false,
            },
            form: {
                collection_id: 'yu5exgud',
                description: 'Test payment',
                email: 'abdulraof628@gmail.com',
                name: 'Abdul Raof',
                amount: 100,
                reference_1_label: 'Bank Code',
                reference_1: 'MB2U0227',
                callback_url: 'http://localhost:8000/shop/payment',
                redirect_url: 'http://localhost:8000/shop/payment/status',
            }
        }
    },
    watch: {
        // activePayment: {
        //     handler(){
        //         if(this.activePayment.cc){
        //             const paypal_container = document.getElementById("paypal-button-container")
        //             console.log(paypal_container)
        //             loadScript({ "client-id": "test" })
        //                 .then((paypal) => {
        //                     paypal
        //                         .Buttons()
        //                         .render("#paypal-button-container")
        //                         .catch((error) => {
        //                             console.error("failed to render the PayPal Buttons", error);
        //                         });
        //                 })
        //                 .catch((error) => {
        //                     console.error("failed to load the PayPal JS SDK script", error);
        //                 });
        //         }
        //     },
        //     deep: true
        // }
    },
    methods: {
        checkout(){
            this.$inertia.get(route('shop.checkout'))
        },
        activatePayment(method){
            this.paymentSelected = false
            this.form.reference_1 = ''

            var activePayment = this.activePayment
            var bankSelected = this.bankSelected

            Object.keys(activePayment).forEach(key => {
                activePayment[key] = false
            })

            Object.keys(bankSelected).forEach(key => {
                bankSelected[key] = false
            })
            activePayment[method] = true

            if(this.activePayment.cc){
                loadScript({ "client-id": "test" })
                    .then((paypal) => {
                        console.log(paypal)
                        paypal
                            .Buttons({
                                style: {
                                    layout: 'vertical',
                                    color:  'blue',
                                    shape:  'rect',
                                    label:  'pay'
                                }
                            })
                            .render("#paypal-button-container")
                            .catch((error) => {
                                console.error("failed to render the PayPal Buttons", error);
                            });
                    })
                    .catch((error) => {
                        console.error("failed to load the PayPal JS SDK script", error);
                    });
            }
        },
        selectBank(bankName, bankCode){
            var bankSelected = this.bankSelected

            Object.keys(bankSelected).forEach(key => {
                bankSelected[key] = false
            })

            bankSelected[bankName] = true
            this.paymentSelected = true
            this.form.reference_1 = bankCode
        },
        pay(){
            if(this.activePayment.fpx){
                axios.post('https://www.billplz-sandbox.com/api/v3/bills', this.form, {
                                headers: {
                                    'Authorization': 'Basic ' + btoa(import.meta.env.MIX_BILLPLZ_SANDBOX_API_KEY)
                                }
                            })
                            .then(function (response) {
                                console.log(response.data.url)
                                window.location.href = response.data.url+'?auto_submit=true'
                            })
                            .catch(function (error) {
                                // handle error
                                console.log(error);
                            })
                            .then(function () {
                                // always executed
                            });
            }
        }
    }
}
</script>
