<script setup>
import BreezeGuestLayout from '@/Layouts/Admin/Guest.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import Card from '@/Components/Card.vue';
import { Alert, AlertDescription, AlertTitle } from '@/Components/ui/alert'

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    username: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post(route('admin.login'), {
        onFinish: () => form.reset('admin.password'),
    });
};
</script>

<template>
    <BreezeGuestLayout>
        <Head title="Log in" />
            <Card>
                <template #title>
                    <h3>Admin Login</h3>
                </template>
                <template #description>
                    Please enter your credentials to log in.
                </template>
                <template #content>
                    <Alert variant="destructive" v-if="Object.keys($page.props.errors).length > 0">
                        <AlertDescription v-for="(error, key) in $page.props.errors" :key="key">
                            {{ error }}
                        </AlertDescription>
                    </Alert>
                    <form @submit.prevent="submit">
                        <div class="grid gap-4">
                            <div class="grid gap-2">
                                <Label for="email">Email / Username</Label>
                                <Input type="email" v-model="form.username" required autofocus autocomplete="off"/>
                            </div>
                            <div class="grid gap-2">
                                <Label for="password">Password</Label>
                                <Input type="password" v-model="form.password" required autocomplete="off"/>
                            </div>
                            <div class="flex justify-between">
                                <Label for="terms" class="flex space-x-2 items-center text-sm cursor-pointer">
                                    <Checkbox id="terms" v-model:checked="form.remember"/>
                                    <span>Remember me</span>
                                </Label>
                            </div>
                            <Button class="w-full" @click="submit" :disabled="form.processing">Log in</Button>
                            <div class="flex justify-center">
                                <a v-if="canResetPassword" :href="route('admin.password.request')">
                                    <Label class="hover:underline cursor-pointer">Forgot your password?</Label>
                                </a>
                            </div>
                        </div>
                    </form>
                </template>
            </Card>
    </BreezeGuestLayout>
</template>
