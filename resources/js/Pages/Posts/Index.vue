<template>
    <div>
        <AppLayout>
            <Container>
                <div>
                    <Link
                        :href="route('posts.index')"
                        class="text-indigo-500 hover:text-indigo-700"
                        >Back to all Posts</Link
                    >
                    <PageHeading
                        v-text="
                            selectedTopic ? selectedTopic.name : 'All Posts'
                        "
                    />
                    <p v-if="selectedTopic" class="mt-1 text-gray-600 text-sm">
                        {{ selectedTopic.description }}
                    </p>
                </div>
                <ul class="divide-y mt-4">
                    <li
                        v-for="post in posts.data"
                        :key="post.id"
                        class="flex justify-between items-baseline flex-col md:flex-row"
                    >
                        <Link
                            :href="post.routes.show"
                            class="group px-2 py-4 block"
                        >
                            <span
                                class="font-bold text-lg group-hover:text-indigo-500"
                                >{{ post.title }}</span
                            >
                            <span class="block pt-1 text-sm text-gray-600"
                                >{{ formattedDate(post) }} ago by
                                {{ post.user.name }}</span
                            >
                        </Link>
                        <Link
                            :href="
                                route('posts.index', { topic: post.topic.slug })
                            "
                            class="mb-2 rounded-full py-0.5 px-2 border border-pink-500 text-pink-500 hover:bg-indigo-500 hover:text-indigo-50"
                        >
                            {{ post.topic.slug }}</Link
                        >
                    </li>
                </ul>

                <Pagination :meta="posts.meta" />
            </Container>
        </AppLayout>
    </div>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import Pagination from "@/Components/Pagination.vue";
import { Link } from "@inertiajs/vue3";
import { relativeDate } from "@/Utilities/date";
import PageHeading from "@/Components/PageHeading.vue";

defineProps(["posts", "selectedTopic"]);

const formattedDate = (post) => relativeDate(post.created_at);
</script>

<style lang="scss" scoped></style>
