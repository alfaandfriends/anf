<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeGuestLayout from '@/Layouts/Admin/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

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

        <BreezeValidationErrors class="mb-4" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <BreezeLabel for="username" value="Username or Email" />
                <BreezeInput id="username" type="text" class="mt-1 block w-full" v-model="form.username" required autofocus autocomplete="off" />
            </div>

            <div class="mt-4">
                <BreezeLabel for="password" value="Password" />
                <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="off" />
            </div>

            <div class="mt-4 flex justify-between place-items-end">
                <label class="">
                    <BreezeCheckbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
                <Link v-if="canResetPassword" :href="route('admin.password.request')" class="underline text-sm text-gray-500 hover:text-gray-700">
                    Forgot your password?
                </Link>
            </div>
            <div class="border-b-2 mt-4"></div>
            <div class="mt-4">
                <div class="flex justify-end">
                    <BreezeButton type="submit" :buttonType="'info'" :class="{ 'opacity-25 px-4 py-2': form.processing }" :disabled="form.processing">
                        Sign in
                    </BreezeButton>
                </div>
                <!-- <div class="text-center text-gray-400 pt-2">or</div>
                <div class="text-center">
                    <span class="text-sm ">Don't have an account? | </span>
                    <Link :href="route('register')" class="text-sm font-bold underline text-indigo-700 hover:text-indigo-900">Register new account</Link>
                </div> -->
            </div>
        </form>
    </BreezeGuestLayout>
</template>
