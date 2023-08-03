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
                <div class="bg-orange-50 min-h-screen">
                    <div class="flex justify-center">
                        <div class="flex-1 max-w-4xl overflow-auto p-3">
                            <slot/>
                        </div>
                    </div>
                </div>
                <Footer />
            </main>
        </div>
    </div>
</template>
