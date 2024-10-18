<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<template>
    <Head title="Fee Invoices" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <Card>
            <template #title>Invoice Information</template>
            <template #content>
                <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-4 gap-4">
                    <div>
                        <Label>Invoice Number<span class="text-red-500">*</span></Label>
                        <Input type="text" :error="!!$page.props.errors.invoice_number" v-model="$page.props.invoice_data.invoice_number" disabled></Input>
                    </div>
                    <div>
                        <Label>Student Name<span class="text-red-500">*</span></Label>
                        <Input type="text" :error="!!$page.props.errors.student_name" v-model="$page.props.invoice_data.student_name" disabled></Input>
                    </div>
                    <div>
                        <Label>Date Issued<span class="text-red-500">*</span></Label>
                        <Input type="text" :error="!!$page.props.errors.date_issued" v-model="$page.props.invoice_data.date_issued" disabled></Input>
                    </div>
                    <div>
                        <Label>Due Date<span class="text-red-500">*</span></Label>
                        <Input type="text" :error="!!$page.props.errors.due_date" v-model="$page.props.invoice_data.due_date" disabled></Input>
                    </div>
                    <!-- <div>
                        <Label>Start Time<span class="text-red-500">*</span></Label>
                        <Datepicker mode="time" v-model="form.start_time"/>
                    </div> -->
                </div>
            </template>
        </Card>
        <Card>
            <template #title>Programme Information</template>
            <template #content>
                <Collapsible v-for="item, index in form.invoice_items" v-model="collapsible_is_open">
                    <template #trigger>{{ item.programme_name }} ( Level {{ item.programme_level }} )</template>
                    <template #content>
                        <Table class="px-4">
                            <TableHeader class="bg-gray-100">
                                <TableRow>
                                    <TableHead>Items</TableHead>
                                    <TableHead>Discount</TableHead>
                                    <TableHead>Amount</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow>
                                    <TableCell>{{ item.programme_type }}</TableCell>
                                    <TableCell>{{ item.programme_fee_discount }}</TableCell>
                                    <TableCell>{{ item.use_old_fee && item.old_programme_fee? item.old_programme_fee : item.programme_fee }}</TableCell>
                                </TableRow>
                                <TableRow v-if="item.include_registration_fee && item.registration_fee != 0">
                                    <TableCell>Registration Fee</TableCell>
                                    <TableCell>{{ item.registration_fee_discount }}</TableCell>
                                    <TableCell>{{ item.registration_fee }}</TableCell>
                                </TableRow>
                                <TableRow v-if="item.include_material_fee">
                                    <TableCell>Material Fee</TableCell>
                                    <TableCell>{{ item.material_fee_discount }}</TableCell>
                                    <TableCell>{{ item.material_fee }}</TableCell>
                                </TableRow>
                                <TableRow v-if="item.promos" v-for="promo in item.promos">
                                    <TableCell class="space-x-2"><span>{{ promo.promo_name }}</span><Badge variant="">Promo</Badge></TableCell>
                                    <TableCell>{{ promo.type_id === 1 ? item.programme_fee * promo.value / 100 : promo.value }}</TableCell>
                                    <TableCell>0</TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </template>
                </Collapsible>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="w-full">
                        <Label for="payment_status"> Payment Status </Label>
                        <ComboBox id="payment_status" :items="$page.props.invoice_status" label-property="name" value-property="id" :error="$page.props.errors.status" v-model="form.payment.status" select-placeholder="Select Status" search-placeholder="Search status..."></ComboBox>
                    </div>
                    <div class="flex flex-col justify-end items-end">
                        <Label class="text-md font-medium"> Total Amount</Label>
                        <Label class="text-xl font-bold">{{ $page.props.invoice_data.amount }}</Label>
                    </div>
                </div>
            </template>
        </Card>
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-2">
            <Card>
                <template #title>Online Payment (Billplz)</template>
                <template #content>
                    <Table class="px-4">
                        <TableHeader class="bg-gray-100">
                            <TableRow>
                                <TableHead class="px-4">Payment Date</TableHead>
                                <TableHead>Email</TableHead>
                                <TableHead>Receipt</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-if="$page.props.bill_info.paid">
                                <TableCell class="px-4">{{ moment($page.props.bill_info.paid_at).format('DD/MM/Y') }}</TableCell>
                                <TableCell>{{ $page.props.bill_info.email }}</TableCell>
                                <TableCell><Button @click="openPaymentLink()">View</Button></TableCell>
                            </TableRow>
                            <TableRow v-else>
                                <TableCell class="text-center" colspan="3">No Records</TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </template>
            </Card>
            <Card>
                <template #title>
                    <div class="flex justify-between items-center">
                        Proof of Payment
                        <Button @click="showModal">
                            <PlusCircle class="h-4 w-4" />
                            <span class="ml-1 hidden sm:block">Add</span>
                        </Button>
                    </div>
                </template>
                <template #content>
                    <Table class="px-4">
                        <TableHeader class="bg-gray-100">
                            <TableRow>
                                <TableHead>#</TableHead>
                                <TableHead>Date</TableHead>
                                <TableHead>Transaction ID</TableHead>
                                <TableHead>File Name</TableHead>
                                <TableHead>Remark</TableHead>
                                <TableHead class="text-center">Action</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-if="form.payment.proofs.length" v-for="proof, proof_index in form.payment.proofs">
                                <TableCell>{{ proof_index+1 }}</TableCell>
                                <TableCell>{{ proof.date }}</TableCell>
                                <TableCell>
                                    <kbd class="min-h-[18px] inline-flex justify-center items-center px-1 bg-gray-200 border border-transparent font-mono text-gray-800 rounded-md">
                                        {{ proof.transaction_id }}
                                    </kbd>
                                </TableCell>
                                <TableCell>
                                    <a :href="proof.file ? proof.url : '/storage/proof_of_payment/' + proof.url" download class="min-h-[30px] inline-flex justify-center items-center py-1 px-1.5 bg-white border border-gray-200 font-mono text-sm text-gray-800 rounded-md shadow-[0px_2px_0px_0px_rgba(0,0,0,0.08)] dark:bg-neutral-900">
                                        {{ proof.file ? proof.file.name : proof.url }}
                                    </a>
                                </TableCell>
                                <TableCell>{{ proof.remark }}</TableCell>
                                <TableCell class="text-center">
                                    <Button variant="destructive" @click="deleteProof(proof_index, proof.id)">Delete</Button>
                                </TableCell>
                            </TableRow>
                            <TableRow v-else>
                                <TableCell class="text-center" colspan="10">No Records</TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </template>
            </Card>
        </div>
        <Card>
            <template #content>
                <div class="flex items-center justify-end">
                    <div class="flex space-x-2">
                        <Button variant="outline" @click="$inertia.get(route('fee.invoices', $page.props.params))">Cancel</Button>
                        <Button @click="submit">Save</Button>
                    </div>
                </div>
            </template>
        </Card>
        <Dialog v-model:open="show.add_attachment">
            <template #title>Add Proof of Payment</template>
            <template #content>
                <div class="p-1 grid grid-cols-1 gap-4">
                    <div class="relative">
                        <Label id="date">Date</Label>
                        <Datepicker mode="date" v-model="attachment.date" format="dd/MM/Y" teleport="#date" :teleportCenter="true"></Datepicker>
                    </div>
                    <div>
                        <Label for="transaction_id">Transaction ID</Label>
                        <Input type="text" name="transaction_id" id="transaction_id" v-model="attachment.transaction_id" autocomplete="off"></Input>
                    </div>
                    <div>
                        <Label>Proof of Payment ( <span class="text-xs text-indigo-500">PDF, JPEG</span> )</Label>
                        <div class="mt-1 items-center w-full">
                            <div class=""> 
                                <label class="block focus:ring-0 focus:border-gray-300">
                                    <span class="sr-only">Browse File</span>
                                    <input type="file" ref="file_input" class="focus:ring-0 border rounded-md block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-700 focus:outline-none" :class="errors.proof_of_payment ? 'border-red-300' : 'border-gray-300'" @change="uploadFile"/>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <Label for="remark">Remark</Label>
                        <Textarea type="text" name="remark" id="remark" v-model="attachment.remark" autocomplete="off"></Textarea>
                    </div>
                </div>
            </template>
            <template #footer>
                <Button variant="outline" @click="show.add_attachment = false">Cancel</Button>
                <Button @click="addAttachment">Add</Button>
            </template>
        </Dialog>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { PlusCircle } from 'lucide-vue-next';
import moment from 'moment';
import Card from '@/Components/Card.vue'
import Dialog from '@/Components/DialogModal.vue'
import Collapsible from '@/Components/Collapsible.vue'
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import { Badge } from "@/Components/ui/badge"

export default {
    components: {
        Head, Link, Card, Dialog, Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow
    },
    data(){
        return{
            collapsible_is_open: true,
            date_issued: moment(this.$page.props.invoice_data.date_issued).format('DD MMM Y'),
            due_date: moment(this.$page.props.invoice_data.due_date).format('DD MMM Y'),
            show:{
                add_attachment: false,
            },
            form: {
                params: this.$page.props.params,
                invoice_id: this.$page.props.invoice_data.id,
                invoice_items: JSON.parse(this.$page.props.invoice_data.invoice_items),
                invoice_amount: this.$page.props.invoice_data.amount,
                payment: {
                    status: this.$page.props.invoice_data.status,
                    proofs: [],
                    proofs_to_delete: [],
                }
            },
            attachment: {
                date: '',
                transaction_id: '',
                url: '',
                file: '',
                remark: '',
            },
            errors: {
                date: false,
                transaction_id: false,
                proof_of_payment: false
            }
        }
    },
    watch: {
        'form.invoice_items': {
            handler(newVal) {
                newVal.forEach(item => {
                    !item.programme_fee             ? item.programme_fee = 0 : ''
                    !item.programme_fee_discount    ? item.programme_fee_discount = 0 : ''
                    !item.registration_fee          ? item.registration_fee = 0 : ''
                    !item.registration_fee_discount ? item.registration_fee_discount = 0 : ''
                    !item.material_fee              ? item.material_fee = 0 : ''
                    !item.material_fee_discount     ? item.material_fee_discount = 0 : ''
                });
            },
            deep: true,
        }
    },
    methods: {
        submit() {
            this.form.invoice_amount = this.totalFee(this.form.invoice_items)
            this.$inertia.post(route('fee.invoices.update'), this.form, { preserveState: true})
        },
        totalFee(invoice_items) {
            let total = 0;
            for (const item of invoice_items) {
                // Parse fees and discounts as numbers
                const programmeFee = parseFloat(item.programme_fee);
                const programmeDiscount = parseFloat(item.programme_fee_discount);
                const registrationFee = parseFloat(item.registration_fee);
                const registrationDiscount = parseFloat(item.registration_fee_discount);
                const materialFee = parseFloat(item.material_fee);
                const materialDiscount = parseFloat(item.material_fee_discount);

                // Add programme fee and subtract programme discount
                total += programmeFee - programmeDiscount;

                // Check if material fee should be included
                if (item.include_registration_fee) {
                    // Add material fee and subtract material discount
                    total += registrationFee - registrationDiscount;
                }
                if (item.include_material_fee) {
                    // Add material fee and subtract material discount
                    total += materialFee - materialDiscount;
                }
                var total_promo =   0
                if(item.promos && Array.isArray(item.promos)){
                    for (const promo of item.promos) {
                        if(promo.type_id === 1){
                            total_promo += (programmeFee * promo.value / 100)
                        }
                        if(promo.type_id === 2){
                            total_promo += promo.value
                        }
                    }
                    total = total - total_promo
                }
            }
            return total;
        },
        clearErrors(){
            this.errors.date = false
            this.errors.transaction_id = false
            this.errors.proof_of_payment = false
        },
        clearAttachmentFields(){
            this.attachment.date = ''
            this.attachment.transaction_id = ''
            this.attachment.url = ''
            this.attachment.file = ''
            this.attachment.remark = ''
        },
        showModal(){
            this.clearErrors()
            this.clearAttachmentFields()
            this.show.add_attachment = true
        },
        deleteProof(proof_index, proof_id){
            this.form.payment.proofs.splice(proof_index, 1)
            if(proof_id){
                this.form.payment.proofs_to_delete.push(proof_id)
            }
        },
        uploadFile($event){
            const file = $event.target.files[0];
                  
            if(file.type == 'application/pdf' || file.name.toLowerCase().endsWith('.pdf') || file.type == 'image/jpeg' || file.name.toLowerCase().endsWith('.png')){
                this.attachment.url = URL.createObjectURL(file)
                this.attachment.file = file
            }
            else{
                alert('Only Image / PDF File allowed!')
                this.$refs.file_input.value = ''
            }
        },
        addAttachment(){
            if(!this.attachment.date || !this.attachment.transaction_id || !this.attachment.file){
                this.errors.date = this.attachment.date ? false : true
                this.errors.transaction_id = this.attachment.transaction_id ? false : true
                this.errors.proof_of_payment = this.attachment.file ? false : true
                return
            }
            this.form.payment.proofs.push({
                'date': moment(this.attachment.date).format('DD-MM-YYYY'),
                'transaction_id': this.attachment.transaction_id,
                'url': this.attachment.url,
                'file': this.attachment.file,
                'remark': this.attachment.remark,
            })
            this.show_add_attachment = false
        },
        openPaymentLink(){ 
            window.open(this.$page.props.bill_info.url, '_blank');
        }
    },
    mounted(){
        this.$page.props.invoice_attachments.forEach((file) => {
            this.form.payment.proofs.push({
                'id': file.id,
                'date': moment(file.date).format('DD-MM-YYYY'),
                'transaction_id': file.transaction_id,
                'url': file.attachment,
                'file': '',
                'remark': file.remark,
            })
        })
    }
}
</script>