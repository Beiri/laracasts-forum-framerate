<template>
    <div>
        <AppLayout>
            <Container>
                <div>
                    <PageHeading
                        v-text="
                            selectedTopic ? selectedTopic.name : 'All Posts'
                        "
                    />
                    <p v-if="selectedTopic" class="mt-1 text-gray-600 text-sm">
                        {{ selectedTopic.description }}
                    </p>

                    <menu class="flex space-x-1 mt-3 overflow-x-auto pb-2 pt-1">
                        <li>
                            <Pill
                                :href="route('posts.index')"
                                :filled="!selectedTopic"
                                >All Posts</Pill
                            >
                        </li>
                        <li v-for="topic in topics" :key="topic.id">
                            <Pill
                                :href="
                                    route('posts.index', { topic: topic.slug })
                                "
                                :filled="topic.id === selectedTopic?.id"
                            >
                                {{ topic.name }}
                            </Pill>
                        </li>
                    </menu>

                    <form @submit.prevent="search" action="" class="mt-4">
                        <div>
                            <InputLabel for="query">Search</InputLabel>
                            <div class="flex space-x-2 mt-1">
                                <TextInput
                                    v-model="searchForm.query"
                                    class="w-full"
                                    id="query"
                                />
                                <SecondaryButton type="submit"
                                    >Search</SecondaryButton
                                >
                            </div>
                        </div>
                    </form>
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
                                >{{ formattedDate(post) }} by
                                {{ post.user.name }}</span
                            >
                        </Link>
                        <Pill
                            :href="
                                route('posts.index', { topic: post.topic.slug })
                            "
                        >
                            {{ post.topic.name }}
                        </Pill>
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
import { Link, useForm } from "@inertiajs/vue3";
import { relativeDate } from "@/Utilities/date";
import PageHeading from "@/Components/PageHeading.vue";
import Pill from "@/Components/Pill.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps(["posts", "topics", "selectedTopic", "query"]);

const formattedDate = (post) => relativeDate(post.created_at);

const searchForm = useForm({
    query: props.query,
});

const search = () => searchForm.get(route("posts.index"));
</script>

<style lang="scss" scoped></style>
