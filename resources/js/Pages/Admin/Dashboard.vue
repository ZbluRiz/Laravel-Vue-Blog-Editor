<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    posts: {
        type: Array,
        default: () => [],
    },
});

const totalPosts = computed(() => props.posts.length);
const totalAuthors = computed(() => {
    const ids = new Set();
    props.posts.forEach((p) => {
        if (p.user_id) {
            ids.add(p.user_id);
        }
    });
    return ids.size;
});
const latestPost = computed(() =>
    props.posts.length
        ? props.posts
              .slice()
              .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))[0]
        : null,
);

const deletePost = (post) => {
    if (!confirm(`Delete post "${post.title}"?`)) return;

    router.delete(route('admin.posts.destroy', post.id));
};
</script>

<template>
    <div class="min-h-screen bg-slate-950 text-slate-100">
        <Head title="Admin Dashboard" />

        <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
            <header
                class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
            >
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight sm:text-3xl">
                        Admin Dashboard
                    </h1>
                    <p class="mt-1 text-sm text-slate-400">
                        Moderate posts and keep the platform content in good shape.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <Link
                        href="/dashboard"
                        class="rounded-lg border border-slate-700 px-3 py-2 text-xs font-medium text-slate-200 hover:border-slate-500"
                    >
                        Back to User Dashboard
                    </Link>
                    <Link
                        href="/blogs"
                        class="rounded-lg border border-slate-700 px-3 py-2 text-xs font-medium text-slate-200 hover:border-blue-500 hover:text-blue-300"
                    >
                        Go to Blogs
                    </Link>
                </div>
            </header>

            <!-- Stats row -->
            <div class="mb-8 grid gap-4 sm:grid-cols-3">
                <div
                    class="rounded-2xl border border-slate-800 bg-slate-900/70 p-4 shadow-sm"
                >
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Total posts
                    </p>
                    <p class="mt-3 text-2xl font-semibold text-slate-50">
                        {{ totalPosts }}
                    </p>
                </div>
                <div
                    class="rounded-2xl border border-slate-800 bg-slate-900/70 p-4 shadow-sm"
                >
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Unique authors
                    </p>
                    <p class="mt-3 text-2xl font-semibold text-slate-50">
                        {{ totalAuthors }}
                    </p>
                </div>
                <div
                    class="rounded-2xl border border-slate-800 bg-slate-900/70 p-4 shadow-sm"
                >
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Latest post
                    </p>
                    <p class="mt-3 text-sm font-medium text-slate-50" v-if="latestPost">
                        {{ latestPost.title }}
                    </p>
                    <p class="mt-1 text-xs text-slate-400" v-if="latestPost">
                        {{ new Date(latestPost.created_at).toLocaleString() }}
                    </p>
                    <p class="mt-3 text-sm text-slate-400" v-else>
                        No posts yet.
                    </p>
                </div>
            </div>

            <!-- Posts table -->
            <div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/60">
                <table class="min-w-full text-left text-sm">
                    <thead
                        class="bg-slate-900/80 text-xs uppercase tracking-wide text-slate-400"
                    >
                        <tr>
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3">Author</th>
                            <th class="px-4 py-3">Created</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="post in props.posts"
                            :key="post.id"
                            class="border-t border-slate-800/80 hover:bg-slate-800/60"
                        >
                            <td class="px-4 py-3">
                                <div class="flex flex-col">
                                    <span class="font-medium text-slate-100">
                                        {{ post.title }}
                                    </span>
                                    <span
                                        class="mt-1 line-clamp-1 text-xs text-slate-400"
                                    >
                                        {{ post.content }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-300">
                                {{ post.user?.name ?? 'Unknown' }}
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-400">
                                {{ new Date(post.created_at).toLocaleString() }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <button
                                    type="button"
                                    class="rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-red-700"
                                    @click="deletePost(post)"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>

                        <tr v-if="!props.posts.length">
                            <td
                                colspan="4"
                                class="px-4 py-8 text-center text-sm text-slate-400"
                            >
                                No posts found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

