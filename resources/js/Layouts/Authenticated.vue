<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue'
import BreezeDropdown from '@/Components/Dropdown.vue'
import BreezeDropdownLink from '@/Components/DropdownLink.vue'
import BreezeNavLink from '@/Components/NavLink.vue'
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import { Link } from '@inertiajs/inertia-vue3';
export default {
    components: {
        BreezeApplicationLogo,
        BreezeDropdown,
        BreezeDropdownLink,
        BreezeNavLink,
        BreezeResponsiveNavLink,
        Link,
    },
    data() {
        return {
            showingNavigationDropdown: false,
            sideBar: false,
            open: false
        }
    },
    methods(){

    }
}
</script>

<template>
  <div class="flex">
    <!-- Sidebar -->
    <div class="min-h-screen bg-gray-50" x-data="{ sideBar: false }">
        <div class="flex">
            <nav
                class="fixed top-0 left-0 z-20 h-full pb-10 overflow-x-hidden overflow-y-auto transition origin-left transform bg-gray-900 w-60 sm:translate-x-0"
                :class="{ '-translate-x-full': !sideBar, 'translate-x-0': sideBar }"
            >
                <span class="flex items-center px-4 py-5 text-white font-bold">ALFA and Friends</span>
                <nav class="text-sm font-medium text-gray-500">
                    <BreezeNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard
                    </BreezeNavLink>
                    <BreezeNavLink :href="route('admin')" :active="route().current('admin')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Admin
                    </BreezeNavLink>
                    <div x-data="collapse()">
                    <div
                        class="
                        flex
                        items-center
                        justify-between
                        px-4
                        py-3
                        transition
                        cursor-pointer
                        group
                        hover:bg-gray-800 hover:text-gray-200
                        "
                        role="button"
                        x-spread="trigger"
                    >
                        <div class="flex items-center">
                        <svg
                            class="
                            shrink-0
                            w-5
                            h-5
                            mr-2
                            text-gray-400
                            transition
                            group-hover:text-gray-300
                            "
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                            fill-rule="evenodd"
                            d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                            />
                        </svg>
                        <span>Integrations</span>
                        </div>
                        <svg
                        :class="{ 'rotate-90': open }"
                        class="shrink-0 w-4 h-4 ml-2 transition transform"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        >
                        <path
                            fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"
                        />
                        </svg>
                    </div>
                    <div class="mb-4" x-spread="collapse" x-cloak>
                        <a
                        class="
                            flex
                            items-center
                            py-2
                            pl-12
                            pr-4
                            transition
                            cursor-pointer
                            hover:bg-gray-800 hover:text-gray-200
                        "
                        href="#"
                        >Shopify</a
                        >
                        <a
                        class="
                            flex
                            items-center
                            py-2
                            pl-12
                            pr-4
                            transition
                            cursor-pointer
                            hover:bg-gray-800 hover:text-gray-200
                        "
                        href="#"
                        >Slack</a
                        >
                        <a
                        class="
                            flex
                            items-center
                            py-2
                            pl-12
                            pr-4
                            transition
                            cursor-pointer
                            hover:bg-gray-800 hover:text-gray-200
                        "
                        href="#"
                        >Zapier</a
                        >
                    </div>
                    </div>
                    <a
                    class="
                        flex
                        items-center
                        px-4
                        py-3
                        transition
                        cursor-pointer
                        group
                        hover:bg-gray-800 hover:text-gray-200
                    "
                    href="#"
                    >
                    <svg
                        class="
                        shrink-0
                        w-5
                        h-5
                        mr-2
                        text-gray-400
                        transition
                        group-hover:text-gray-300
                        "
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                        fill-rule="evenodd"
                        d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z"
                        clip-rule="evenodd"
                        />
                        <path
                        d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z"
                        />
                    </svg>
                    <span>Changelog</span>
                    </a>
                    <a
                    class="
                        flex
                        items-center
                        px-4
                        py-3
                        transition
                        cursor-pointer
                        group
                        hover:bg-gray-800 hover:text-gray-200
                    "
                    href="#"
                    >
                    <svg
                        class="
                        shrink-0
                        w-5
                        h-5
                        mr-2
                        text-gray-400
                        transition
                        group-hover:text-gray-300
                        "
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                        fill-rule="evenodd"
                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                        clip-rule="evenodd"
                        />
                    </svg>
                    <span>Settings</span>
                    </a>
                    <BreezeNavLink class="w-full" :href="route('logout')" method="post" as="button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Log Out
                    </BreezeNavLink>
                </nav>
            </nav>
            <div class="ml-0 transition md:ml-60 bg-indigo-100">
            </div>
        </div>
    </div>
    <div class="min-h-screen bg-gray-100 w-full">
      <nav class="bg-white border-b border-gray-100 sticky top-0">
        <!-- Primary Navigation Menu -->
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex">
              <!-- Logo -->
              <div class="shrink-0 flex items-center">
                <Link :href="route('dashboard')">
                  <BreezeApplicationLogo class="block h-9 w-auto" />
                </Link>
              </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
              <!-- Settings Dropdown -->
              <div class="ml-3 relative">
                <BreezeDropdown align="right" width="48">
                  <template #trigger>
                    <span class="inline-flex rounded-md">
                      <button
                        type="button"
                        class="
                          inline-flex
                          items-center
                          px-3
                          py-2
                          border border-transparent
                          text-sm
                          leading-4
                          font-medium
                          rounded-md
                          text-gray-500
                          bg-white
                          hover:text-gray-700
                          focus:outline-none
                          transition
                          ease-in-out
                          duration-150
                        "
                      >
                        <div
                          class="
                            w-10
                            h-10
                            rounded-full
                            overflow-hidden
                            border-2
                            dark:border-white
                            border-gray-900
                            mr-2
                          "
                        >
                          <img
                            :src="$page.props.auth.user.avatar"
                            alt=""
                            class="w-full h-full object-cover"
                          />
                        </div>
                        <span class="">{{
                          $page.props.auth.user.display_name
                        }}</span>
                        <svg
                          class="ml-2 -mr-0.5 h-4 w-4"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 20 20"
                          fill="currentColor"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                          />
                        </svg>
                      </button>
                    </span>
                  </template>

                  <template #content>
                    <BreezeDropdownLink
                      :href="route('logout')"
                      method="post"
                      as="button"
                    >
                      Log Out
                    </BreezeDropdownLink>
                  </template>
                </BreezeDropdown>
              </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden"> 
              <button
                @click="showingNavigationDropdown = !showingNavigationDropdown, sideBar = !sideBar"
                class="
                  inline-flex
                  items-center
                  justify-center
                  p-2
                  rounded-md
                  text-gray-400
                  hover:text-gray-500 hover:bg-gray-100
                  focus:outline-none focus:bg-gray-100 focus:text-gray-500
                  transition
                  duration-150
                  ease-in-out
                "
              >
                <svg
                  class="h-6 w-6"
                  stroke="currentColor"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <path
                    :class="{
                      hidden: showingNavigationDropdown,
                      'inline-flex': !showingNavigationDropdown,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                  />
                  <path
                    :class="{
                      hidden: !showingNavigationDropdown,
                      'inline-flex': showingNavigationDropdown,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div
          :class="{
            block: showingNavigationDropdown,
            hidden: !showingNavigationDropdown,
          }"
          class="sm:hidden"
        >
          <div class="pt-2 pb-3 space-y-1">
            <BreezeResponsiveNavLink
              :href="route('dashboard')"
              :active="route().current('dashboard')"
            >
              Dashboard
            </BreezeResponsiveNavLink>
          </div>

          <!-- Responsive Settings Options -->
          <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
              <div class="font-medium text-base text-gray-800">
                {{ $page.props.auth.user.name }}
              </div>
              <div class="font-medium text-sm text-gray-500">
                {{ $page.props.auth.user.email }}
              </div>
            </div>

            <div class="mt-3 space-y-1">
            </div>
          </div>
        </div>
      </nav>

      <!-- Page Heading -->
      <header class="bg-white shadow" v-if="$slots.header">
        <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>

      <!-- Page Content -->
      <main>
        <slot />
      </main>
    </div>
  </div>
</template>
