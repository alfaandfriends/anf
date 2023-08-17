<!DOCTYPE html>
<html>
<head>
    <title>Your Email Title</title>
</head>
<body>
    <div class="overflow-y-auto no-scrollbar modal-main" id="invoice" ref="invoice">
        <div class="flex flex-col justify-between divide-y p-8 min-h-screen">
            <div class="flex flex-col flex-grow">
                <div class="flex flex-row justify-between">
                    <div class="flex self-center ">
                        <img src="/images/invoice_logo_alt.jpg" class="w-48 h-28 block select-none" alt="">
                    </div>
                    <div class="text-right">
                        <span class="mt-4 not-italic text-gray-800 text-md">
                            <span class="font-bold text-lg">ALFA and Friends Sdn Bhd</span><br>
                            36, Jalan BP 7/8, Bandar Bukit Puchong,<br>
                            47120 Puchong, Selangor Darul Ehsan,<br>
                            Malaysia<br>
                        </span>
                    </div>
                </div>
                <div class="flex flex-row justify-between items-start">
                    <h3 class="mt-8 text-md font-semibold text-gray-800">To:</h3>
                </div>
                <div class="flex flex-row justify-between items-start space-y-0">
                    <span class="not-italic text-gray-700 text-md">
                        <span class="font-bold">asdas</span><br>
                        <div class="w-64">
                            <span>asdasd</span>
                        </div>
                    </span>
                    <div class="space-y-2">
                        <div class="grid grid-cols-1 gap-2">
                            <dl class="grid grid-cols-5">
                                <dt class="col-span-3 font-semibold text-gray-800">Invoice Number:</dt>
                                <dd class="col-span-2 text-gray-500">adsdasd</dd>
                            </dl>
                            <dl class="grid grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800">Invoice Date:</dt>
                                <dd class="col-span-2 text-gray-500">asdsad</dd>
                            </dl>
                            <dl class="grid grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800">Due Date:</dt>
                                <dd class="col-span-2 text-gray-500">adasdasd</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="mt-8 grid sm:grid-cols-2 gap-3">
                    <h4 class="text-md font-semibold text-gray-800">Student: asdasd</h4>
                </div>

                <!-- Desktop View or Print View -->
                <div class="mt-6">
                    <table class="w-full">
                        <thead class="bg-gray-800">
                            <tr>
                                <th class="text-left py-2 px-4 text-xs font-medium text-gray-100 uppercase w-4/6">Item</th>
                                <th class="py-2 px-4 text-xs font-medium text-gray-100 uppercase w-1/6">Discount</th>
                                <th class="py-2 px-4 text-xs font-medium text-gray-100 uppercase w-1/6">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border">
                                <td class="py-2 px-4">
                                    <p class="font-bold text-md text-gray-800 mb-1">Product Name</p>
                                </td>
                                <td class="text-center align-bottom py-2 px-4">
                                    <p class="font-normal text-md text-gray-800" v-if="data.include_material_fee">0</p>
                                </td>
                                <td class="text-center align-bottom py-2 px-4">
                                    <p class="font-normal text-md text-gray-800" v-if="data.include_material_fee">0</p>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="pt-5 py-2 px-4"></td>
                                <td class="pt-5 py-2 px-4 text-center">
                                    <p class="font-medium text-lg text-gray-800">Total :</p>
                                </td>
                                <td class="pt-5 py-2 px-4 text-center">
                                    <p class="font-medium text-lg text-gray-800">0</p>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="pt-8">
                <h4 class="text-md text-center font-semibold text-xl text-gray-800">Thank you!</h4>
            </div>
        </div>
    </div>
</body>
</html>
