<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm, Link} from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps<{
    link: object
}>();

const form = useForm({
    title: props.link?.title,
    destination: props.link?.url
});

const submit = () => {
    form.patch(route('links.update', props.link))
}
</script>

<template>
    <Head title="Create" />

    <AuthenticatedLayout>
        <template #header>
            <div class="w-full inline-flex items-center justify-between">
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800"
                >
                    Edit a link
                </h2>
                <Link method="delete" :href="route('links.destroy', link)">
                    <DangerButton>
                        Delete link
                    </DangerButton>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit" class="space-y-4">
                            <div>
                                <InputLabel for="title" value="Title (Optional)" />
                                <TextInput type="text" v-model="form.title" class="mt-1 w-full" :class="{ 'border-red-600': form.errors.title }" />

                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>

                            <div>
                                <InputLabel for="destination" value="Destination" />
                                <TextInput type="text" v-model="form.destination" class="mt-1 w-full" :class="{ 'border-red-600': form.errors.destination }" placeholder="https://example.com/my-long-url" />

                                <InputError class="mt-2" :message="form.errors.destination" />
                            </div>

                            <div>
                                <PrimaryButton
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Update your link
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
