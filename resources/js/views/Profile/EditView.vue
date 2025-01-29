<script setup>
import Authenticated from "@/layouts/Authenticated.vue";
import UpdateProfileInformationForm from "@/views/Profile/Partials/UpdateProfileInformationForm.vue";
import UpdatePasswordForm from "@/views/Profile/Partials/UpdatePasswordForm.vue";
import DeleteUserForm from "@/views/Profile/Partials/DeleteUserForm.vue";
</script>

<template>

    <Authenticated>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Profile
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800"
                >
                    <UpdateProfileInformationForm
                        class="max-w-xl"
                    />
                </div>

                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800"
                >
                    <UpdatePasswordForm
                        class="max-w-xl"
                    />
                </div>

                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800"
                >
                    <DeleteUserForm
                        class="max-w-xl"
                    />
                </div>
            </div>
        </div>
    </Authenticated>
</template>
