<template>
    <div class="min-h-screen bg-slate-900 text-slate-100">
        <!-- Hero / Intro -->
        <section class="relative overflow-hidden">
            <!-- Background gradient blur -->
            <div
                class="pointer-events-none absolute inset-0 opacity-40"
                aria-hidden="true"
            >
                <div class="absolute -top-40 -right-32 h-80 w-80 rounded-full bg-blue-500 blur-3xl"></div>
                <div class="absolute -bottom-40 -left-32 h-80 w-80 rounded-full bg-purple-600 blur-3xl"></div>
            </div>

            <div class="relative mx-auto flex max-w-6xl flex-col gap-10 px-4 py-16 sm:px-6 lg:px-8 lg:flex-row lg:items-center">
                <!-- Left: Text -->
                <div class="flex-1 space-y-6">
                    <p class="inline-flex items-center gap-2 rounded-full bg-blue-500/10 px-3 py-1 text-xs font-medium text-blue-300 ring-1 ring-blue-500/30">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Tentang Platform
                    </p>
                    <h1 class="text-3xl font-bold tracking-tight sm:text-4xl lg:text-5xl">
                        <span class="bg-gradient-to-r from-blue-400 via-sky-400 to-purple-400 bg-clip-text text-transparent">
                            Membantu Anda Menulis
                        </span>
                        <br />
                        Konten Lebih Cepat &amp; Lebih Cerdas
                    </h1>
                    <p class="max-w-2xl text-base text-slate-300 sm:text-lg">
                        Halaman ini dibuat untuk memperkenalkan Anda pada
                        <span class="font-semibold text-blue-300">AI Assistant</span> kami —
                        partner menulis yang siap membantu menghasilkan ide, menyusun outline,
                        dan mengoptimasi konten blog Anda dengan mudah.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center gap-2 text-sm text-slate-300">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-500/20 text-blue-300">
                                ✔
                            </span>
                            <span>Bekerja 24/7 tanpa lelah</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-300">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-purple-500/20 text-purple-300">
                                ✔
                            </span>
                            <span>Terintegrasi langsung dengan sistem blog Anda</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Simple panel to echo AI look -->
                <div class="flex-1">
                    <div class="rounded-3xl border border-slate-700 bg-slate-900/60 p-6 shadow-2xl shadow-blue-900/40">
                        <div class="mb-4 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-purple-500 text-white shadow-lg">
                                    AI
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-100">AI Assistant</p>
                                    <p class="text-xs text-emerald-300">Online • Siap membantu</p>
                                </div>
                            </div>
                            <div class="flex gap-1">
                                <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                            </div>
                        </div>
                        <div class="space-y-3 text-sm text-slate-200">
                            <p class="rounded-2xl bg-slate-800/80 px-4 py-3">
                                “Saya dirancang untuk membantu proses kreatif Anda — dari mencari ide,
                                menyusun struktur artikel, sampai memberi saran optimasi SEO.”
                            </p>
                            <p class="rounded-2xl bg-gradient-to-r from-blue-600 to-purple-600 px-4 py-3 text-sm text-slate-50 shadow-lg">
                                Coba buka halaman
                                <span class="font-semibold">AI Assistant</span>
                                untuk mulai berdiskusi dan menulis konten Anda sekarang.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Feature section -->
        <section class="border-t border-slate-800 bg-slate-950/40">
            <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:px-8">
                <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold text-slate-50 sm:text-3xl">
                            Kenapa Menggunakan AI untuk Blog Anda?
                        </h2>
                        <p class="mt-2 max-w-xl text-sm text-slate-400 sm:text-base">
                            Kami menggabungkan antarmuka yang nyaman dengan AI yang powerful,
                            sehingga pengalaman menulis terasa lebih ringan dan menyenangkan.
                        </p>
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-3">
                    <!-- Card 1 -->
                    <article class="group rounded-2xl border border-slate-800 bg-slate-900/80 p-5 transition-colors hover:border-blue-500/70 hover:bg-slate-900">
                        <div class="mb-4 inline-flex rounded-xl bg-blue-500/15 p-2 text-blue-300 ring-1 ring-blue-500/30">
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"
                                />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-slate-50">
                            Proses Menulis Lebih Cepat
                        </h3>
                        <p class="text-sm text-slate-400">
                            Dapatkan ide, outline, dan paragraf pembuka hanya dalam hitungan detik
                            sehingga Anda bisa fokus pada penyempurnaan dan gaya penulisan.
                        </p>
                    </article>

                    <!-- Card 2 -->
                    <article class="group rounded-2xl border border-slate-800 bg-slate-900/80 p-5 transition-colors hover:border-purple-500/70 hover:bg-slate-900">
                        <div class="mb-4 inline-flex rounded-xl bg-purple-500/15 p-2 text-purple-300 ring-1 ring-purple-500/30">
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-slate-50">
                            Konsistensi Kualitas Konten
                        </h3>
                        <p class="text-sm text-slate-400">
                            AI membantu menjaga struktur, tone, dan fokus tulisan agar tetap konsisten
                            dari satu artikel ke artikel lainnya.
                        </p>
                    </article>

                    <!-- Card 3 -->
                    <article class="group rounded-2xl border border-slate-800 bg-slate-900/80 p-5 transition-colors hover:border-emerald-500/70 hover:bg-slate-900">
                        <div class="mb-4 inline-flex rounded-xl bg-emerald-500/15 p-2 text-emerald-300 ring-1 ring-emerald-500/30">
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 7h18M3 12h18M3 17h18"
                                />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-slate-50">
                            Fleksibel &amp; Mudah Digunakan
                        </h3>
                        <p class="text-sm text-slate-400">
                            Antarmuka yang sederhana mengikuti gaya desain halaman AI Assistant,
                            sehingga Anda langsung familiar dan nyaman saat menggunakannya.
                        </p>
                    </article>
                </div>
            </div>
        </section>
    </div>
</template>