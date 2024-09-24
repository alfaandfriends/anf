<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Admin/Authenticated.vue';
</script>

<style>
.multiselect-assistive-text{
    display: none;
}
</style>

<template>
    <Head title="Countries" />

    <BreezeAuthenticatedLayout>
        <template #header></template>
        <Card>
            <template #title>Country Information</template>
            <template #content>
                <div class="grid grid-cols-1 2xl:grid-cols-3 gap-4">
                    <div>
                        <Label>Name<span class="text-red-500">*</span></Label>
                        <ComboBox :items="selection.countries" @search="getCountryList" label-property="label" value-property="value" :error="$page.props.errors.country_name" v-model="form.country_name" select-placeholder="Select Country" search-placeholder="Search country..."></ComboBox>
                    </div>
                    <div>
                        <Label>Country Code</Label>
                        <Input type="text" :error="$page.props.errors.code" v-model="form.country_code" disabled></Input>
                    </div>
                    <div>
                        <Label>Currency Name</Label>
                        <Input type="text" :error="$page.props.errors.currency_name" v-model="form.currency_name" disabled></Input>
                    </div>
                    <div>
                        <Label>Currency Code</Label>
                        <Input type="text" :error="$page.props.errors.currency_code" v-model="form.currency_code" disabled></Input>
                    </div>
                    <div>
                        <Label>Currency Symbol</Label>
                        <Input type="text" :error="$page.props.errors.currency_symbol" v-model="form.currency_symbol" disabled></Input>
                    </div>
                    <div>
                        <Label>Calling Code</Label>
                        <Input type="text" :error="$page.props.errors.calling_code" v-model="form.calling_code" disabled></Input>
                    </div>
                </div>
            </template>
        </Card>
        <Card>
            <template #content>
                <div class="flex justify-end">
                    <div class="flex space-x-2">
                        <Button variant="outline" @click="$inertia.get(route('countries'))">Cancel</Button>
                        <Button @click="submit">Save</Button>
                    </div>
                </div>
            </template>
        </Card>
    </BreezeAuthenticatedLayout>
</template>



<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Multiselect from '@vueform/multiselect'
import Card from '@/Components/Card.vue'
import axios from 'axios';

export default {
    components: {
        Head, Link, Multiselect
    },
    data(){
        return{
            selection: {
                countries: []
            },
            form: {
                country_name: '',
                country_code: '',
                currency_name: '',
                currency_code: '',
                currency_symbol: '',
                calling_code: '',
            }
        }
    },
    watch: {
        'form.country_name': {
            handler(){
                if(this.form.country_name){
                    /* Set calling code and state list*/
                    this.setCountryData(this.form.country_name)

                }
            },
            immediate: true
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('countries.store'), this.form, { preserveState: true})
        },
        getCountryList(query){
            if(query){
                axios.get('https://restcountries.com/v2/name/' + query)
                .then((response)=>{
                    this.selection.countries =  response.data.map((item) => {
                        return { 
                            value: item.name, 
                            label: item.name 
                        }
                    })
                })
            }
        },
        setCountryData(country_name){
            axios
                .get('https://restcountries.com/v2/name/' + country_name)
                .then(response => {
                    this.form.country_name      =   response.data[0].name
                    this.form.country_code      =   response.data[0].alpha2Code
                    this.form.currency_name     =   response.data[0].currencies[0].name
                    this.form.currency_code     =   response.data[0].currencies[0].code
                    this.form.currency_symbol   =   response.data[0].currencies[0].symbol
                    this.form.calling_code      =   '+'+response.data[0].callingCodes[0]
                })
                .catch(error => {
                    this.errored = true
                })
        }
    }

}
</script>
