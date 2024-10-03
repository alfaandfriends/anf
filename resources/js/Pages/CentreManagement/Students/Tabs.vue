<script setup>
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/Components/ui/tabs'
</script>

<template>
    <div class="flex justify-between">
        <Tabs :default-value="route().current('students') ? 'active' : route().current('students.inactive') ? 'inactive' : 'unassigned'">
            <TabsList>
            <TabsTrigger @click="$inertia.get(route('students'))" value="active">
                Active
            </TabsTrigger>
            <TabsTrigger @click="$inertia.get(route('students.inactive'))" value="inactive">
                Inactive
            </TabsTrigger>
            <TabsTrigger @click="$inertia.get(route('students.unassigned'))" value="unassigned">
                Unassigned
            </TabsTrigger>
            </TabsList>
        </Tabs>
    </div>
</template>