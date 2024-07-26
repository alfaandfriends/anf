<script setup>
import BreezeGuestLayout from '@/Layouts/Admin/Guest.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import Card from '@/Components/Card.vue';
import { Alert, AlertDescription, AlertTitle } from '@/Components/ui/alert'

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <BreezeGuestLayout>
        <Head title="Reset Password" />
        <Card>
            <template #title>
                <h3>Reset Password</h3>
            </template>
            <template #description>
                Please enter your email and set a new password.
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
                            <Input id="email" type="email" v-model="form.email" required autofocus autocomplete="off"/>
                        </div>
                        <div class="grid gap-2">
                            <Label for="password">Password</Label>
                            <Input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="off"/>
                        </div>
                        <div class="grid gap-2">
                            <Label for="password_confirmation">Confirm Password</Label>
                            <Input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="off"/>
                        </div>
                        <Button class="w-full" @click="submit" :disabled="form.processing">Reset Password</Button>
                    </div>
                </form>
            </template>
        </Card>
    </BreezeGuestLayout>
</template>
