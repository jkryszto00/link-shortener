<script setup>
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import {useAuthStore} from "@/stores/auth.js";
import useForm from "@/composables/form.js";
import {ref} from "vue";
import axios from "@/lib/axios.js";

const auth = useAuthStore()

const user = auth.user;

const status = ref("")
const recentlySuccessful = ref(false)

const form = useForm({
    name: user.name,
    email: user.email,
    error: {},
    processing: false
});

async function handleSubmit() {
    recentlySuccessful.value = false

    await form.submit(async fields => {
        await axios.patch("/profile", fields)
        await auth.fetchUser()

        recentlySuccessful.value = true
    })
}
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Profile Information
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your account's profile information and email address.
            </p>
        </header>

        <form
            @submit.prevent="handleSubmit"
            class="mt-6 space-y-6"
        >
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

            <div>
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

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="recentlySuccessful"
                        class="text-sm text-gray-600 dark:text-gray-400"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
