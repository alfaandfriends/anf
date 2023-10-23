<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Main from '@/Pages/Docs/Layouts/Main.vue'
</script>

<template>
    <Head title="Workflow" />
    <Main>
        <article class="">
            <header class="">
                <p class="text-base font-medium text-slate-500">Getting started</p>
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Setup</h1>
                <div class="mt-3">
                    <span class="">This page provides instructions on what setup is needed to ensure the application runs smoothly.</span>
                </div>
            </header>
            <div class="mt-10 bg-indigo-100 rounded-md border border-indigo-700 p-3">
                <p class="font-semibold tracking-normal text-slate-900 mb-3">Please do the setup and follow as below sequence <span class="italic text-sm">(click the item to view details)</span> </p>
                <ol>
                    <li class="mb-2 flex items-center">
                        <span class="flex py-0.5 px-2 mr-2 bg-indigo-600 items-center justify-center rounded text-white text-sm">1</span>
                        <Link :href="route('docs.countries')" class="font-semibold hover:underline text-sm">Countries</Link>
                    </li>
                    <li class="mb-2 flex items-center">
                        <span class="flex py-0.5 px-2 mr-2 bg-indigo-600 items-center justify-center rounded text-white text-sm">2</span>
                        <Link :href="route('docs.centres')" class="font-semibold hover:underline text-sm">Centres</Link>
                    </li>
                    <li class="mb-2 flex items-center">
                        <span class="flex py-0.5 px-2 mr-2 bg-indigo-600 items-center justify-center rounded text-white text-sm">3</span>
                        <Link :href="route('docs.products')" class="font-semibold hover:underline text-sm">Products</Link>
                    </li>
                    <li class="mb-2 flex items-center">
                        <span class="flex py-0.5 px-2 mr-2 bg-indigo-600 items-center justify-center rounded text-white text-sm">4</span>
                        <Link :href="route('docs.programmes')" class="font-semibold hover:underline text-sm">Programmes</Link>
                    </li>
                    <li class="mb-2 flex items-center">
                        <span class="flex py-0.5 px-2 mr-2 bg-indigo-600 items-center justify-center rounded text-white text-sm">5</span>
                        <Link :href="route('docs.classes')" class="font-semibold hover:underline text-sm">Classes</Link>
                    </li>
                </ol>
            </div>
        </article>
        <dl class="flex pt-6 mt-20 border-t border-slate-200">

            <div class="mr-auto text-left">
                <dt class="text-sm font-normal tracking-tight text-slate-600">Previous</dt>

                <dd class="mt-1">
                    <Link :href="route('docs.workflow')" class="text-base font-semibold text-slate-900 hover:underline">Workflow</Link>
                </dd>
            </div>
        </dl>
    </Main>
</template>
