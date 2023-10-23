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
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Workflow</h1>
                <div class="mt-3">
                    <span class="">This page provides workflow of the application.</span>
                </div>
            </header>
            <h3 class="mt-20 bg-indigo-100 rounded-md border border-indigo-700 p-3">
                Detailed workflow will be added later.
            </h3>
        </article>
        <dl class="flex pt-6 mt-20 border-t border-slate-200">
            <div class="ml-auto text-right">
                <dt class="text-sm font-normal tracking-tight text-slate-600">Next</dt>
                <dd class="mt-1">
                    <Link :href="route('docs.setup')" class="text-base font-semibold text-slate-900 hover:underline">Setup</Link>
                </dd>
            </div>
        </dl>
    </Main>
</template>
