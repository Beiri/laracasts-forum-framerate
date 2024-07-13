<template>
    <div>
        <AppLayout>
            <Container>
                <ul class="divide-y">
                    <li v-for="post in posts.data" :key="post.id">
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

defineProps(["posts"]);

const formattedDate = (post) => relativeDate(post.created_at);
</script>

<style lang="scss" scoped></style>
