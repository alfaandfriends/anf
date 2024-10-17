<script setup>
import BreezeGuestLayout from '@/Layouts/Admin/Guest.vue';
import { Head, useForm, Link } from '@inertiajs/inertia-vue3';
import Card from '@/Components/Card.vue';
import { Alert, AlertDescription, AlertTitle } from '@/Components/ui/alert'

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
            <template #title>Forgot Password</template>
            <template #description>
                Please enter your email address, and we will send you a password reset link that will allow you to reset your password.
            </template>
            <template #content>
                <Alert variant="destructive" v-if="Object.keys($page.props.errors).length > 0">
                    <AlertDescription v-for="(error, key) in $page.props.errors" :key="key">
                        {{ error }}
                    </AlertDescription>
                </Alert>
                <form @submit.prevent="submit">
                    <div class="grid gap-4">
                        <div v-if="status" class="mb-2 font-medium text-sm text-green-600">
                            {{ status }}
                        </div>
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
    </BreezeGuestLayout>
</template>
