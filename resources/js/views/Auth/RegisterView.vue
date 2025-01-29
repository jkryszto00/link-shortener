<script setup>
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import useForm from "@/composables/form.js";
import axios from "@/lib/axios.js";
import {useAuthStore} from "@/stores/auth.js";
import {useRouter} from "vue-router";
import Guest from "@/layouts/Guest.vue";

const auth = useAuthStore()
const router = useRouter()

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    error: {},
    processing: false
});

async function handleSubmit() {
    await form.submit(async fields => {
        await axios.post("/register", fields)
        await axios.get("/sanctum/csrf-cookie")

        await auth.fetchUser()
        await router.go('/')
    })
}
</script>

<template>
    <Guest>
        <form @submit.prevent="handleSubmit">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.fields.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.error?.validation.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.fields.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.error?.validation.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.fields.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.error?.validation.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.fields.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.error?.validation.password_confirmation"
                />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <RouterLink
                    to="/login"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                >
                    Already registered?
                </RouterLink>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>
            </div>
        </form>
    </Guest>
</template>
