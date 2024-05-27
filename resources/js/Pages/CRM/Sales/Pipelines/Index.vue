<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/CRM/Authenticated.vue';
</script>

<template>
	<BreezeAuthenticatedLayout>
		<div class="flex flex-col">
			<div class="-m-1.5 overflow-x-auto">
				<div class="p-1.5 min-w-full inline-block align-middle">
					<div class="border rounded-lg divide-y divide-gray-200">
						<div class="flex justify-between py-3 px-4">
							<div class="relative max-w-xs">
								<label class="sr-only">Search</label>
								<input type="text" name="hs-table-with-pagination-search" id="hs-table-with-pagination-search" class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Search for items" v-debounce:800ms="search" v-model="params.search">
								<div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
									<svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<circle cx="11" cy="11" r="8"></circle>
										<path d="m21 21-4.3-4.3"></path>
									</svg>
								</div>
							</div>
							<button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50 disabled:pointer-events-none" @click="$inertia.get(route('crm.sales.pipelines.create'))">
								Add Pipeline
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="12" width="12" fill="currentColor"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
							</button>
						</div>
						<div class="overflow-hidden">
							<table class="min-w-full divide-y divide-gray-100">
								<thead class="bg-gray-100">
									<tr>
										<th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">#</th>
										<th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">School Name</th>
										<th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">School Type</th>
										<th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Progress</th>
										<th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Principal Name</th>
										<th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Phone Number</th>
										<th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Address</th>
										<th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Action</th>
									</tr>
								</thead>
								<tbody class="divide-y divide-gray-100">
									<tr class="hover:bg-gray-50" v-if="$page.props.pipelines.data.length" v-for="pipeline, pipeline_index in $page.props.pipelines.data">
										<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800" width="1%">{{ pipeline_index + 1 }}</td>
										<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800" width="20%">{{ pipeline.school_name }}</td>
										<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ pipeline.school_type }}</td>
										<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ pipeline.progress_percentage }}</td>
										<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ pipeline.principal_name }}</td>
										<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ pipeline.principal_phone_number }}</td>
										<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ pipeline.school_address }}</td>
										<td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium space-x-2">
											<button type="button" class="py-1 px-2 inline-flex items-center gap-x-2 text-sm font-semibold rounded-md border border-indigo-600 text-indigo-600 hover:border-indigo-500 hover:text-indigo-500 disabled:opacity-50 disabled:pointer-events-none" @click="edit(pipeline.id)">
											  Edit
											</button>
											<button type="button" class="py-1 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-md border border-red-600 bg-white text-red-500 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" data-hs-overlay="#delete-pipeline" @click="pipeline_id_to_delete = pipeline.id">
											  Delete
											</button>
										</td>
									</tr>
									<tr class="" v-else>
										<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-600 text-center" colspan="10">No Records</td>
									</tr>
								</tbody>
							</table>
						</div>
						<Pagination :page_data="$page.props.pipelines" :params="params" class="bg-gray-100"/>
					</div>
				</div>
			</div>
		</div>
		<div id="delete-pipeline" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none">
			<div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
				<div class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
					<div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
						<h3 class="font-bold text-gray-800 dark:text-white">
							Delete Pipeline
						</h3>
						<button type="button" class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#delete-pipeline">
							<span class="sr-only">Close</span>
							<svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M18 6 6 18"></path>
								<path d="m6 6 12 12"></path>
							</svg>
						</button>
					</div>
					<div class="p-4 overflow-y-auto">
						<p class="mt-1 text-gray-800 dark:text-neutral-400">
							Are you sure you want to delete this pipeline?
						</p>
					</div>
					<div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-neutral-700">
						<button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" data-hs-overlay="#delete-pipeline">
							Cancel
						</button>
						<button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 disabled:opacity-50 disabled:pointer-events-none" @click="deletePipeline">
							Delete
						</button>
					</div>
				</div>
			</div>
		</div>
	</BreezeAuthenticatedLayout>
</template>

<script>
import Pagination from '@/Components/Pagination.vue'
import { debounce } from 'vue-debounce'

export default {
	Components: {
		Pagination
	},
    props: {
        filter: Object,
    },
	data(){
		return {
			pipeline_id_to_delete: '',
            params: {
                search: this.filter.search ? this.filter.search : '',
            },
		}
	},
	methods: {
		edit(id){
			this.$inertia.get(route('crm.sales.pipelines.edit', id))
		},
		deletePipeline(){
			this.$inertia.delete(route('crm.sales.pipelines.destroy', this.pipeline_id_to_delete), {'preserveState' : false})
  			HSOverlay.close('#delete-pipeline');
		},
        search(){
            this.$inertia.get(this.route('crm.sales.pipelines'), this.params, { replace: true, preserveState: true});
        }
	}
}

</script>