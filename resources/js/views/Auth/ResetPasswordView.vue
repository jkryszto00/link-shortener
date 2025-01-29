<script setup>
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import useForm from "@/composables/form.js";
import axios from "@/lib/axios.js";
import {useRoute, useRouter} from "vue-router";
import {ref} from "vue";
import Guest from "@/layouts/Guest.vue";

const route = useRoute()
const router = useRouter()

const status = ref("")

const form = useForm({
    token: route.params.token,
    email: route.query.email,
    password: '',
    password_confirmation: '',
    error: {},
    processing: false
});

async function handleSubmit() {
    await form.submit(async fields => {
        const { data } = await axios.post("/reset-password", fields)
        status.value = data.status
    })
}
</script>

<template>
    <Guest>
        <div
            v-if="status"
            class="mb-4 text-sm font-medium text-green-600 dark:text-green-400"
        >
            {{ status }} <RouterLink to="/login" class="font-medium underline">Go to login page.</RouterLink>
        </div>

        <form @submit.prevent="handleSubmit">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.fields.email"
                    required
                    autofocus
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
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Reset Password
                </PrimaryButton>
            </div>
        </form>
    </Guest>
</template>
