<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="fixed top-[3.5rem] h-screen shadow-xl4 left-0 lg:relative lg:top-0 lg:h-auto lg:px-0 lg:block lg:shadow-none">
        <nav class="overflow-y-auto scrollbar h-screen p-6 w-64 pr-8 text-base lg:text-sm bg-gray-800">
            <ul role="list" class="">
                <li>
                    <h3 class="font-semibold tracking-tight text-white">
                        Getting started
                    </h3>
                    <ul role="list" class="pl-3 my-3 space-y-2">
                        <li v-for="menu in setup_menu">
                            <Link :href="route(menu.url)" :class="route().current(menu.url) ? 'text-gray-200 font-semibold' : 'text-gray-400 hover:text-gray-200'">{{ menu.name }}</Link>
                        </li>
                    </ul>
                </li>
                <li>
                    <h3 class="font-semibold tracking-tight text-white">
                        Modules
                    </h3>
                    <ul role="list" class="pl-3 my-3 space-y-2">
                        <li v-for="menu in modules_menu">
                            <Link :href="route(menu.url)" :class="route().current(menu.url) ? 'text-gray-200 font-semibold' : 'text-gray-400 hover:text-gray-200'">{{ menu.name }}</Link>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    data(){
        return{
            setup_menu: [
                { name : 'Workflow', url: 'docs.workflow' },
                { name : 'Setup', url: 'docs.setup' },
            ],
            modules_menu: [
                { name : 'Centres', url: 'docs.centres' },
                { name : 'Division Manager', url: 'docs.division_manager' },
                { name : 'Centre Manager', url: 'docs.centre_manager' },
                { name : 'Edupreneurs', url: 'docs.edupreneurs' },
                { name : 'Programmes', url: 'docs.programmes' },
                { name : 'Classes', url: 'docs.classes' },
                { name : 'Students', url: 'docs.students' },
                { name : 'Art Gallery', url: 'docs.art_gallery' },
                { name : 'Progress Report', url: 'docs.progress_report' },
                { name : 'Teacher Resources', url: 'docs.teacher_resources' },
                { name : 'Math manipulatives', url: 'docs.math_manipulatives' },
                { name : 'Diagnostic Test', url: 'docs.diagnostic_test' },
                { name : 'Fee Invoices', url: 'docs.fee_invoices' },
                { name : 'Products', url: 'docs.products' },
                { name : 'Orders', url: 'docs.orders' },
                { name : 'Users', url: 'docs.users' },
                { name : 'Countries', url: 'docs.countries' },
                { name : 'Roles', url: 'docs.roles' },
                { name : 'Permissions', url: 'docs.permissions' },
                { name : 'Menu Editor', url: 'docs.menu_editor' },
                { name : 'Profile', url: 'docs.profile' },
            ]
        }
    },
    mounted(){
        this.modules_menu.sort((a, b) => {
            return a.name.localeCompare(b.name, undefined, { sensitivity: 'base' });
        });
    }
}


</script>