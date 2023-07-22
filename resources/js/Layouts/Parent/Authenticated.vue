<script setup>
import Header from '@/Components/Header.vue'
import Footer from '@/Components/Footer.vue'
import Navigation from '@/Components/Navigation.vue'
</script>

<template>
    <div class="flex">
        <div class="min-h-screen bg-gray-100 w-full">
            <VueGuidedTour :steps="steps" @afterEnd="completedTour"></VueGuidedTour>
            <Toast :toastData="$page.props.flash"></Toast>

            <!-- Page Content -->
            <main class="flex flex-col bg-indigo-50 relative h-full justify-between">
                <Header />
                <Navigation />
                <slot/>
                <Footer />
            </main>
        </div>
    </div>
</template>
