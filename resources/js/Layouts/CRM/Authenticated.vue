<template>
    <!-- Header -->
    <header class="sticky top-0 inset-x-0 flex flex-wrap sm:justify-start sm:flex-nowrap z-[48] w-full bg-white shadow-sm border-b text-sm py-2.5 sm:py-4 lg:ps-64">
      <nav class="flex basis-full items-center w-full mx-auto px-4 sm:px-6" aria-label="Global">
        <div class="me-5 lg:me-0 lg:hidden">
          <!-- Logo -->
			<Link :href="route('crm.dashboard')">
				<BreezeApplicationLogo class="w-20 fill-current text-gray-500" />
			</Link>
          <!-- End Logo -->
        </div>
    
        <div class="w-full flex items-center justify-end ms-auto sm:justify-end sm:gap-x-3 sm:order-3">
          <div class="flex flex-row items-center justify-end gap-2">
            <!-- <button type="button" class="w-[2.375rem] h-[2.375rem] inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none">
              <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
            </button> -->
            <!-- <button type="button" class="w-[2.375rem] h-[2.375rem] inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" data-hs-offcanvas="#hs-offcanvas-right">
              <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            </button> -->
    
            <div class="hs-dropdown [--placement:bottom-right] relative inline-flex">
              <button id="hs-dropdown-with-header" type="button" class="w-[2.375rem] h-[2.375rem] inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none">
                <img class="inline-block size-[38px] rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=320&h=320&q=80" alt="Image Description">
              </button>
    
              <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-md rounded-lg p-2" aria-labelledby="hs-dropdown-with-header">
                <div class="py-3 px-5 -m-2 bg-gray-100 rounded-t-lg">
                  <p class="text-sm text-gray-500">Signed in as</p>
                  <p class="text-sm font-medium text-gray-800">{{$page.props.auth.user.display_name}}</p>
                </div>
                <div class="mt-2 py-2 first:pt-0 last:pb-0">
                  <a :href="route('admin.logout')" method="post" class="flex space-x-2 items-center px-4 py-2 transition cursor-pointer group hover:bg-indigo-100 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="16" width="16"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/></svg>
					<span>Logout</span>
                  </a>
                  <!-- <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500" href="#">
                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    Purchases
                  </a>
                  <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500" href="#">
                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="M12 12v9"/><path d="m8 17 4 4 4-4"/></svg>
                    Downloads
                  </a>
                  <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500" href="#">
                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Team Account
                  </a> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </header>
    <!-- End Header -->
    
    <!-- Breadcrumb -->
    <div class="sticky top-0 inset-x-0 z-20 bg-white border-y px-4 sm:px-6 md:px-8 lg:hidden">
      <div class="flex justify-between items-center py-2">
        <!-- Breadcrumb -->
        <ol class="ms-3 flex items-center whitespace-nowrap">
          <li class="flex items-center text-sm text-gray-800">
            Dashboard
            <svg class="flex-shrink-0 mx-3 overflow-visible size-2.5 text-gray-400" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M5 1L10.6869 7.16086C10.8637 7.35239 10.8637 7.64761 10.6869 7.83914L5 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </li>
          <li class="text-sm font-semibold text-gray-800 truncate" aria-current="page">
            Pipelines
          </li>
        </ol>
        <!-- End Breadcrumb -->
    
        <!-- Sidebar -->
        <button type="button" class="py-2 px-3 flex justify-center items-center gap-x-1.5 text-xs rounded-lg border border-gray-200 text-gray-500 hover:text-gray-600" data-hs-overlay="#application-sidebar" aria-controls="application-sidebar" aria-label="Sidebar">
          <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 8L21 12L17 16M3 12H13M3 6H13M3 18H13"/></svg>
          <span class="sr-only">Sidebar</span>
        </button>
        <!-- End Sidebar -->
      </div>
    </div>
    <!-- End Breadcrumb -->
    
    <!-- Sidebar -->
    <div id="application-sidebar" class="hs-overlay [--auto-close:lg]
      hs-overlay-open:translate-x-0
      -translate-x-full transition-all duration-300 transform
      w-[260px]
      hidden
      fixed inset-y-0 start-0 z-[60]
      bg-white border-e border-gray-200
      lg:block lg:translate-x-0 lg:end-auto lg:bottom-0
     
     ">
      <div class="px-6 py-4 bg-white border-b">
        <!-- Logo -->
		<Link class="flex justify-between items-center space-x-2" :href="route('crm.dashboard')">
			<BreezeApplicationLogo class="h-10 fill-current text-gray-500" />
			<span class="text-md text-slate-600 font-bold">ALFA and Friends</span>
		</Link>
        <!-- End Logo -->
      </div>
    
      <nav class="hs-accordion-group p-4 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
        <ul class="space-y-1.5">
          <li>
            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-neutral-700 rounded-lg hover:bg-indigo-100" :class="route().current('crm.dashboard') || route().current('crm.') ? 'bg-indigo-100' : ''" :href="route('crm.dashboard')">
              <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
              Dashboard
            </a>
          </li>
    
          <!-- <li class="hs-accordion" id="users-accordion">
            <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent text-sm text-neutral-700 rounded-lg hover:bg-gray-100">
              <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
              Users
    
              <svg class="hs-accordion-active:block ms-auto hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
    
              <svg class="hs-accordion-active:hidden ms-auto block size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
            </button>
    
            <div id="users-accordion-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
              <ul class="hs-accordion-group ps-3 pt-2" data-hs-accordion-always-open>
                <li class="hs-accordion" id="users-accordion-sub-1">
                  <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent text-sm text-neutral-700 rounded-lg hover:bg-gray-100">
                    Sub Menu 1
    
                    <svg class="hs-accordion-active:block ms-auto hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
    
                    <svg class="hs-accordion-active:hidden ms-auto block size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                  </button>
    
                  <div id="users-accordion-sub-1-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
                    <ul class="pt-2 ps-2">
                      <li>
                        <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-neutral-700 rounded-lg hover:bg-gray-100" href="#">
                          Link 1
                        </a>
                      </li>
                      <li>
                        <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-neutral-700 rounded-lg hover:bg-gray-100" href="#">
                          Link 2
                        </a>
                      </li>
                      <li>
                        <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-neutral-700 rounded-lg hover:bg-gray-100" href="#">
                          Link 3
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="hs-accordion" id="users-accordion-sub-2">
                  <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent text-sm text-neutral-700 rounded-lg hover:bg-gray-100">
                    Sub Menu 2
    
                    <svg class="hs-accordion-active:block ms-auto hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
    
                    <svg class="hs-accordion-active:hidden ms-auto block size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                  </button>
    
                  <div id="users-accordion-sub-2-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden ps-2">
                    <ul class="pt-2 ps-2">
                      <li>
                        <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-neutral-700 rounded-lg hover:bg-gray-100" href="#">
                          Link 1
                        </a>
                      </li>
                      <li>
                        <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-neutral-700 rounded-lg hover:bg-gray-100" href="#">
                          Link 2
                        </a>
                      </li>
                      <li>
                        <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-neutral-700 rounded-lg hover:bg-gray-100" href="#">
                          Link 3
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </div>
          </li> -->
    
    
          <li class="hs-accordion" :class="route().current('crm.sales.*') ? 'active' : ''" id="projects-accordion">
            <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-neutral-700 rounded-lg hover:bg-indigo-100" :class="route().current('crm.sales.*') ? 'hs-accordion-active:bg-indigo-100' : ''">
              <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
              Sales
    
              <svg class="hs-accordion-active:block ms-auto hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
    
              <svg class="hs-accordion-active:hidden ms-auto block size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
            </button>
    
            <div id="projects-accordion-child" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300" :class="route().current('crm.sales.*') ? '' : 'hidden'">
              <ul class="pt-2 ps-2">
                <li>
                  <a class="flex items-center gap-x-3.5 py-2 px-6 text-sm text-neutral-700 rounded-lg hover:bg-indigo-100" :class="route().current('crm.sales.pipelines') || route().current('crm.sales.pipelines.*') ? 'bg-indigo-100' : ''" :href="route('crm.sales.pipelines')">
                    Pipelines
                  </a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
    </div>
    <!-- End Sidebar -->
    
    <!-- Content -->
    <div class="w-full h-screen lg:ps-64 flex flex-col justify-between">
      
        <div class="p-4 sm:py-6 sm:px-8 space-y-4 sm:space-y-6">
            <Toast :toastData="$page.props.flash"></Toast>
            <slot></slot>
        </div>
        <footer class="bg-white border-t shadow w-full z-50">
            <div class="w-full py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-center items-center">
                    <p class="text-sm font-semibold text-gray-800">© 2024 ALFA and Friends - CRM</p>
                </div>
            </div>
        </footer>
    </div>
    <!-- End Content -->
</template>

<script>
import BreezeApplicationLogo from '../../Components/ApplicationLogo.vue'
import { Link } from '@inertiajs/inertia-vue3'
import BreezeNavLink from '../../Components/NavLink.vue'
import { HSStaticMethods } from "preline";
import Toast from '@/Components/Toast.vue'

HSStaticMethods.autoInit();

const observer = new MutationObserver((mutationsList) => {
    for (const mutation of mutationsList) {
        HSStaticMethods.autoInit();
    }
});

observer.observe(document.body, {
    attributes: true,
    subtree: true,
    childList: true,
    characterData: true,
});

export default {
	components: {
		BreezeApplicationLogo, Link, BreezeNavLink, Toast
	},
}
</script>