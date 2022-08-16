<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <Head title="Title" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Title
            </h2>
        </template>
        <div class="py-4 px-4">
            <div class="overflow-x-auto">
                <div class="mx-auto">
                    <div class="align-left inline-block min-w-full">
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
                            <button class="px-4 py-4 bg-purple-700 text-white w-full mt-3 rounded shadow font-bold hover:bg-purple-900" @click="checkout">PROCEED TO CHECKOUT</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Head, Link
    },
    methods: {
        checkout(){
            this.$inertia.get(route('shop.checkout'))
        }
    }
}
</script>