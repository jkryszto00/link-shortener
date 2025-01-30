<script setup>
import PrimaryButton from "@/components/PrimaryButton.vue";
import InputLabel from "@/components/InputLabel.vue";
import TextInput from "@/components/TextInput.vue";
import InputError from "@/components/InputError.vue";
import Authenticated from "@/layouts/Authenticated.vue";
import useForm from "@/composables/form.js";
import axios from "@/lib/axios.js";
import {useRouter} from "vue-router";

const router = useRouter()

const form = useForm({
    title: '',
    destination: '',
    error: {},
    processing: false
});

async function handleSubmit() {
    await form.submit(async fields => {
        const { data } = await axios.post('/api/links', fields)
        await router.push(`/links/${data.link_id}`)
    })
}
</script>

<template>
    <Authenticated>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Create a link
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="handleSubmit" class="space-y-4">
                            <div>
                                <InputLabel for="title" value="Title (Optional)" class="dark:text-gray-300" />
                                <TextInput type="text" v-model="form.fields.title" class="mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" :class="{ 'border-red-600': form.error?.validation.title }" />
                                <InputError class="mt-2 dark:text-red-400" :message="form.error?.validation.title" />
                            </div>

                            <div>
                                <InputLabel for="destination" value="Destination" class="dark:text-gray-300" />
                                <TextInput type="text" v-model="form.fields.destination" class="mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" :class="{ 'border-red-600': form.error?.validation.destination }" placeholder="https://example.com/my-long-url" />
                                <InputError class="mt-2 dark:text-red-400" :message="form.error?.validation.destination" />
                            </div>

                            <div>
                                <PrimaryButton
                                    class="dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Create your link
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </Authenticated>
</template>
