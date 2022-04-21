<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeTextarea from '@/Components/Textarea.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    message: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <BreezeGuestLayout>
        <Head title="Contact Support" />

        <BreezeValidationErrors class="mb-4" />

        <form @submit.prevent="submit">

            <div class="flex justify-between mb-3" data-intro="Hello World!">
                <div class="mt-4 pr-2">
                    <BreezeLabel for="first_name" value="First Name" />
                    <BreezeInput id="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name" required />
                </div>

                <div class="mt-4">
                    <BreezeLabel for="last_name" value="Last Name" />
                    <BreezeInput id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name" required  />
                </div>
            </div>

            <div>
                <BreezeLabel for="email" value="Email" />
                <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus  />
            </div>

            <div class="mt-4">
                <BreezeLabel for="message" value="Leave Your Message" />
                <BreezeTextarea rows="5" id="message" type="text" class="mt-1 block w-full" v-model="form.message" required  />
            </div>

            <div class="flex items-center justify-end mt-4">
                <BreezeButton class="bg-indigo-600 hover:bg-indigo-800" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Submit
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
