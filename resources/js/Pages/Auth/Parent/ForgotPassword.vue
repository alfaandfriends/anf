<script setup>
import BreezeGuestLayout from '@/Layouts/Admin/Guest.vue';
import { Head, useForm, Link } from '@inertiajs/inertia-vue3';
import Card from '@/Components/Card.vue';

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


        <Card>
            <template #title>
                Forgot Password
            </template>
            <template #description>
                Please enter your email address, and we will send you a password reset link that will allow you to reset your password.
            </template>
            <template #content>
                <Alert variant="destructive" v-if="Object.keys($page.props.errors).length > 0">
                    <AlertTitle>Error</AlertTitle>
                    <AlertDescription v-for="(error, key) in $page.props.errors" :key="key">
                        {{ error }}
                    </AlertDescription>
                </Alert>
                <form @submit.prevent="submit">
                    <div class="grid gap-4">
                        <div class="grid gap-2">
                            <Label for="email">Email Address</Label>
                            <Input id="email" type="email" v-model="form.user_email" required autofocus autocomplete="off"/>
                        </div>
                        <Button class="w-full" @click="submit" :disabled="form.processing">Send Password Reset Link</Button>
                        <div class="flex justify-center">
                            <a :href="route('login')">
                                <Label class="hover:underline cursor-pointer">Back to Login</Label>
                            </a>
                        </div>
                    </div>
                </form>
            </template>
        </Card>
        <!-- <form @submit.prevent="submit">
            <div class="mb-3">
                <BreezeLabel for="email" value="Email" />
                <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.user_email" required autofocus autocomplete="off" />
            </div>
            <div class="flex mb-3 text-right justify-between items-center">
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
        </form> -->
    </BreezeGuestLayout>
</template>
