<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Main from '@/Pages/Docs/Layouts/Main.vue'
</script>

<template>
    <Head title="Products" />
    <Main>
        <article class="">
            <header class="">
                <p class="text-base font-medium text-slate-500">Modules</p>
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Products</h1>
                <div class="mt-3">
                    <span class="">This page provides information for products module.</span>
                </div>
            </header>
            <div class="mt-10">
                <p class="font-semibold tracking-normal text-slate-900 mb-1">Requirements</p>
                <span class="text-sm">No requirement needed.</span>
            </div>
            <div class="mt-10">
                <p class="font-semibold tracking-normal text-slate-900 mb-1">Actions</p>
                <span class="text-sm">View, Create, Edit, Delete</span>
            </div>
            <div class="mt-10">
                <p class="font-semibold tracking-normal text-slate-900 mb-1">Troubleshoots</p>
                <div class="space-y-4">
                    <details class="group rounded-lg bg-indigo-50 border border-gray-500 p-6 [&_summary::-webkit-details-marker]:hidden" open>
                        <summary class="flex cursor-pointer items-center justify-between gap-1.5 text-gray-900">
                            <h2 class="font-medium">Cannot delete a product</h2>
                            <svg class="h-5 w-5 shrink-0 transition duration-300 group-open:-rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <div class="border border-dashed border-gray-400 mt-5"></div>
                        <p class="mt-4 leading-relaxed text-gray-700">
                            The product might be in used in 
                            <ul class="px-5 list-disc">
                                <li><Link ::href="route('docs.programmes')" class="hover:underline text-sm text-indigo-800 font-semibold">Programmes</Link></li>
                            </ul>
                        </p>
                    </details>
                </div>
            </div>
        </article>
    </Main>
</template>
