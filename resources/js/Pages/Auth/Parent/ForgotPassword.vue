<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, useForm, Link } from '@inertiajs/inertia-vue3';

defineProps({
    status: String,
});

const form = useForm({
    user_email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <BreezeGuestLayout>
        <Head title="Forgot Password" />

        <div class="mb-4 text-sm text-gray-600">
            Please enter your email address and we will email you a password reset link that will allow you to choose a new one.
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <BreezeValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div class="mb-3">
                <BreezeLabel for="email" value="Email" />
                <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.user_email" required autofocus autocomplete="off" />
            </div>
            <div class="flex mb-3 text-right justify-between items-center">
                <BreezeButton type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Send Password Reset Link
                </BreezeButton>
                <Link :href="route('login')" class="underline text-sm text-gray-500 hover:text-gray-700">
                    Back to Login
                </Link>
            </div>
            <div class="border-b-2 my-4"></div>
                <div class="flex justify-center">
                    <Link :href="route('contact.support')">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span class="text-xs">Contact Support</span>
                        </div>
                    </Link>
                </div>
        </form>
    </BreezeGuestLayout>
</template>
