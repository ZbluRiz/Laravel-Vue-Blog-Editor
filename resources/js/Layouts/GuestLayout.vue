<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="relative flex min-h-screen items-center justify-center overflow-hidden bg-slate-950"
    >
        <!-- Soft gradient background to match AI pages -->
        <div class="pointer-events-none absolute inset-0 opacity-60" aria-hidden="true">
            <div class="absolute -top-40 -right-32 h-80 w-80 rounded-full bg-blue-600/60 blur-3xl" />
            <div class="absolute -bottom-40 -left-32 h-80 w-80 rounded-full bg-purple-600/60 blur-3xl" />
        </div>

        <!-- Main card -->
        <div
            class="relative z-10 mx-4 w-full max-w-md rounded-3xl border border-slate-800 bg-slate-900/80 px-6 py-8 shadow-2xl shadow-slate-900/70 backdrop-blur"
        >
            <!-- Logo inside square -->
            <div class="mb-6 flex flex-col items-center text-center">
                <Link href="/" class="group inline-flex items-center justify-center">
                    <div
                        class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-900/80 ring-1 ring-slate-700 shadow-lg shadow-slate-900/70 group-hover:ring-blue-500/70 group-hover:shadow-blue-900/70 transition-all"
                    >
                        <ApplicationLogo class="h-10 w-10 text-slate-200" />
                    </div>
                </Link>
                <div class="mt-4 space-y-1">
                    <h1 class="text-lg font-semibold text-slate-50">
                        Welcome back
                    </h1>
                    <p class="text-xs text-slate-400">
                        Sign in to continue managing your AI-powered blog.
                    </p>
                </div>
            </div>

            <!-- Content -->
            <div class="space-y-4">
                <slot />
            </div>
        </div>
    </div>
</template>
