<template>
    <AppLayout title="Create a Post">
        <Container>
            <PageHeading>Create a Post</PageHeading>

            <form action="" @submit.prevent="createPost" class="mt-6">
                <div class="mt-3">
                    <InputLabel for="title" class="sr-only">Title</InputLabel>
                    <TextInput
                        id="title"
                        class="w-full"
                        v-model="form.title"
                        placeholder="Give it a great title..."
                    />
                    <InputError :message="form.errors.title" class="mt-1" />
                </div>

                <div class="mt-3">
                    <InputLabel for="body" class="sr-only">Body</InputLabel>
                    <MarkdownEditor v-model="form.body">
                        <template #toolbar="{ editor }">
                            <li v-if="!isInProduction()">
                                <button
                                    @click="autofill"
                                    type="button"
                                    class="px-3 py-2"
                                    title="Autofill"
                                >
                                    <i class="ri-article-line"></i>
                                </button>
                            </li>
                        </template>
                    </MarkdownEditor>
                    <InputError :message="form.errors.body" class="mt-1" />
                </div>

                <div class="mt-3">
                    <PrimaryButton type="submit">Create Post</PrimaryButton>
                </div>
            </form>
        </Container>
    </AppLayout>
</template>

<script setup>
import Container from "@/Components/Container.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import MarkdownEditor from "@/Components/MarkdownEditor.vue";
import PageHeading from "@/Components/PageHeading.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { isInProduction } from "@/Utilities/environment";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";

const form = useForm({
    title: "",
    body: "",
});

const createPost = () => form.post(route("posts.store"));

const autofill = async () => {
    if (isInProduction()) {
        console.log("hello");
        return;
    }

    const response = await axios.get("/local/post-content");

    form.title = response.data.title;
    form.body = response.data.body;
};
</script>

<style lang="scss" scoped></style>
