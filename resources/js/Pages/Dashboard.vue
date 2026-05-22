<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth?.user ?? null);
const isAdmin = computed(() => user.value?.role === 'admin');
const isTeacher = computed(() => user.value?.role === 'teacher');
const isStudent = computed(() => user.value?.role === 'student');
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        Dashboard
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Welcome back,
                        <span class="font-medium text-gray-800">
                            {{ user?.name }}
                        </span>
                    </p>
                </div>
                <div v-if="user" class="flex items-center gap-2">
                    <span
                        class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold"
                        :class="{
                            'bg-indigo-100 text-indigo-700': isAdmin,
                            'bg-emerald-100 text-emerald-700': isTeacher,
                            'bg-blue-100 text-blue-700': isStudent,
                        }"
                    >
                        <span class="h-1.5 w-1.5 rounded-full bg-green-500 mr-2" />
                        {{ (user.role ?? 'student').toUpperCase() }}
                    </span>
                </div>
            </div>
        </template>

        <div class="bg-slate-950 py-10">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <!-- Quick summary cards -->
                <div class="grid gap-6 md:grid-cols-3 mb-10">
                    <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Your role
                        </p>
                        <p class="mt-3 text-2xl font-semibold text-slate-50">
                            {{ (user?.role ?? 'student') | capitalize }}
                        </p>
                        <p class="mt-2 text-xs text-slate-400">
                            Access level is tailored to your role in the system.
                        </p>
                    </div>
                    <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Content
                        </p>
                        <p class="mt-3 text-2xl font-semibold text-slate-50">
                            Blogs &amp; AI tools
                        </p>
                        <p class="mt-2 text-xs text-slate-400">
                            Create or explore articles and use the AI Assistant to help write.
                        </p>
                    </div>
                    <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Account
                        </p>
                        <p class="mt-3 text-2xl font-semibold text-slate-50">
                            Profile &amp; security
                        </p>
                        <p class="mt-2 text-xs text-slate-400">
                            Keep your profile, password, and preferences up to date.
                        </p>
                    </div>
                </div>

                <!-- Actions grid -->
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Admin: manage posts -->
                    <div
                        v-if="isAdmin"
                        class="flex flex-col justify-between rounded-2xl border border-slate-800 bg-slate-900/70 p-5"
                    >
                        <div>
                            <h3 class="text-lg font-semibold text-slate-50">
                                Manage all posts
                            </h3>
                            <p class="mt-2 text-sm text-slate-400">
                                Review, edit, or delete any post in the system to keep content high-quality.
                            </p>
                        </div>
                        <div class="mt-4">
                            <Link
                                :href="route('admin.posts.index')"
                                class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700"
                            >
                                Go to Admin Posts
                            </Link>
                        </div>
                    </div>

                    <!-- Teachers: own posts -->
                    <div
                        v-if="isTeacher || isAdmin"
                        class="flex flex-col justify-between rounded-2xl border border-slate-800 bg-slate-900/70 p-5"
                    >
                        <div>
                            <h3 class="text-lg font-semibold text-slate-50">
                                Manage your articles
                            </h3>
                            <p class="mt-2 text-sm text-slate-400">
                                Create new posts, update existing content, and share knowledge with students.
                            </p>
                        </div>
                        <div class="mt-4 flex gap-3">
                            <Link
                                :href="route('blogs')"
                                class="inline-flex items-center rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700"
                            >
                                Open Blog Workspace
                            </Link>
                        </div>
                    </div>

                    <!-- Students: explore content -->
                    <div
                        class="flex flex-col justify-between rounded-2xl border border-slate-800 bg-slate-900/70 p-5"
                    >
                        <div>
                            <h3 class="text-lg font-semibold text-slate-50">
                                Explore blog posts
                            </h3>
                            <p class="mt-2 text-sm text-slate-400">
                                Browse content from teachers and other creators, leave comments, and like posts.
                            </p>
                        </div>
                        <div class="mt-4">
                            <Link
                                :href="route('blogs')"
                                class="inline-flex items-center rounded-xl border border-slate-700 px-4 py-2 text-sm font-semibold text-slate-100 hover:border-blue-500 hover:text-blue-300"
                            >
                                Browse Blogs
                            </Link>
                        </div>
                    </div>

                    <!-- AI Assistant -->
                    <div
                        class="flex flex-col justify-between rounded-2xl border border-slate-800 bg-slate-900/70 p-5 md:col-span-2 lg:col-span-1"
                    >
                        <div>
                            <h3 class="text-lg font-semibold text-slate-50">
                                Use the AI Assistant
                            </h3>
                            <p class="mt-2 text-sm text-slate-400">
                                Get help generating ideas, outlines, and improving the quality of your posts.
                            </p>
                        </div>
                        <div class="mt-4">
                            <Link
                                href="/blogs/ai-assistant"
                                class="inline-flex items-center rounded-xl bg-purple-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-purple-700"
                            >
                                Open AI Assistant
                            </Link>
                        </div>
                    </div>

                    <!-- Profile settings -->
                    <div
                        class="flex flex-col justify-between rounded-2xl border border-slate-800 bg-slate-900/70 p-5 md:col-span-2 lg:col-span-1"
                    >
                        <div>
                            <h3 class="text-lg font-semibold text-slate-50">
                                Profile &amp; account
                            </h3>
                            <p class="mt-2 text-sm text-slate-400">
                                Update your personal information, password, and notification preferences.
                            </p>
                        </div>
                        <div class="mt-4">
                            <Link
                                :href="route('profile.edit')"
                                class="inline-flex items-center rounded-xl border border-slate-700 px-4 py-2 text-sm font-semibold text-slate-100 hover:border-emerald-500 hover:text-emerald-300"
                            >
                                Edit Profile
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
