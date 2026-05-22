<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200 sticky top-0 z-10">
            <div class="max-w-4xl mx-auto px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-semibold text-gray-900">Edit Blog</h1>
                            <p class="text-sm text-gray-500">{{ wordCount }} words • {{ readingTime }} min read</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-3">
                        <button
                            @click="router.visit('/blogs')"
                            :disabled="form.processing"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors disabled:opacity-50"
                        >
                            Cancel
                        </button>
                        <button
                            @click="updateBlog"
                            :disabled="!form.title.trim() || !form.content.trim() || form.processing"
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                        >
                            <svg v-if="form.processing" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                            </svg>
                            {{ form.processing ? 'Saving...' : 'Save Changes' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto px-6 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Editor -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Title -->
                    <div>
                        <input
                            v-model="form.title"
                            type="text"
                            placeholder="Enter your blog title..."
                            class="w-full text-2xl font-bold text-gray-900 bg-transparent border-none outline-none placeholder-gray-400 focus:ring-0 p-0"
                        />
                        <div class="h-px bg-gray-200 mt-4"></div>
                    </div>

                    <!-- Content -->
                    <div class="relative">
                        <textarea
                            v-model="form.content"
                            @input="updateStats"
                            rows="20"
                            placeholder="Write your content here..."
                            class="w-full p-4 bg-white border border-gray-200 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-gray-800 leading-relaxed"
                            :disabled="isGenerating"
                        ></textarea>
                        
                        <!-- Character count -->
                        <div class="absolute bottom-3 right-3 text-xs text-gray-400">
                            {{ form.content.length }}/5000
                        </div>
                    </div>

                    <!-- AI Tools -->
                    <div class="flex flex-wrap gap-3">
                        <button
                            @click="improveContent"
                            :disabled="!form.content.trim() || isGenerating"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <svg v-if="!isGenerating" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            <svg v-else class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                            </svg>
                            {{ isGenerating ? 'Improving...' : 'Improve' }}
                        </button>

                        <button
                            @click="generateIdeas"
                            :disabled="isGenerating"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Ideas
                        </button>

                        <button
                            @click="checkGrammar"
                            :disabled="!form.content.trim() || isGenerating"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Grammar
                        </button>
                    </div>

                    <!-- AI Suggestion -->
                    <div v-if="aiSuggestion" class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 bg-blue-600 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>
                                <h3 class="font-medium text-gray-900">AI Suggestion</h3>
                            </div>
                            <div class="flex gap-2">
                                <button
                                    @click="applySuggestion"
                                    class="text-xs px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors"
                                >
                                    Apply
                                </button>
                                <button
                                    @click="dismissSuggestion"
                                    class="text-xs px-3 py-1 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors"
                                >
                                    Dismiss
                                </button>
                            </div>
                        </div>
                        <div class="text-gray-700 text-sm leading-relaxed whitespace-pre-line">
                            {{ aiSuggestion }}
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Writing Tips -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <h3 class="font-medium text-gray-900 mb-3 flex items-center gap-2">
                            <span class="text-blue-600">💡</span>
                            Writing Tips
                        </h3>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li class="flex items-start gap-2">
                                <span class="text-gray-400 text-xs mt-1">•</span>
                                <span>Keep paragraphs short and focused</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-gray-400 text-xs mt-1">•</span>
                                <span>Use active voice for clarity</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-gray-400 text-xs mt-1">•</span>
                                <span>Add examples and stories</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-gray-400 text-xs mt-1">•</span>
                                <span>End with a call to action</span>
                            </li>
                        </ul>
                    </div>

                    <!-- SEO Tips -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <h3 class="font-medium text-gray-900 mb-3 flex items-center gap-2">
                            <span class="text-green-600">🎯</span>
                            SEO Best Practices
                        </h3>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li class="flex items-start gap-2">
                                <span class="text-gray-400 text-xs mt-1">•</span>
                                <span>Use keywords naturally</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-gray-400 text-xs mt-1">•</span>
                                <span>Write compelling headlines</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-gray-400 text-xs mt-1">•</span>
                                <span>Include internal links</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-gray-400 text-xs mt-1">•</span>
                                <span>Optimize meta descriptions</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Stats -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <h3 class="font-medium text-gray-900 mb-3">Statistics</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Words</span>
                                <span class="font-medium text-gray-900">{{ wordCount }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Characters</span>
                                <span class="font-medium text-gray-900">{{ form.content.length }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Reading time</span>
                                <span class="font-medium text-gray-900">{{ readingTime }} min</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import { router, useForm } from '@inertiajs/vue3';

const props = defineProps({
    blog: Object
});

const form = useForm({
    title: props.blog.title,
    content: props.blog.content,
});

const aiSuggestion = ref("");
const isGenerating = ref(false);

// Computed properties for stats
const wordCount = computed(() => {
    return form.content
        .trim()
        .split(/\s+/)
        .filter((word) => word.length > 0).length;
});

const readingTime = computed(() => {
    const wordsPerMinute = 200;
    return Math.max(1, Math.ceil(wordCount.value / wordsPerMinute));
});

const updateStats = () => {
    // This function can be used for real-time updates if needed
};

const improveContent = async () => {
    if (!form.content.trim()) return;

    isGenerating.value = true;

    try {
        const res = await fetch("/api/ai/suggest", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                )?.content,
            },
            body: JSON.stringify({
                content: form.content,
                action: "improve",
            }),
        });

        const data = await res.json();
        aiSuggestion.value =
            data.suggestion ??
            data.response ??
            data.result ??
            "Sorry, I couldn't generate a suggestion.";
    } catch (error) {
        aiSuggestion.value = "Sorry, I encountered an error. Please try again.";
    } finally {
        isGenerating.value = false;
    }
};

const generateIdeas = async () => {
    isGenerating.value = true;

    try {
        const res = await fetch("/api/ai/suggest", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                )?.content,
            },
            body: JSON.stringify({
                content: form.title + "\n" + form.content,
                action: "ideas",
            }),
        });

        const data = await res.json();
        aiSuggestion.value =
            data.suggestion ??
            data.response ??
            data.result ??
            "Sorry, I couldn't generate ideas.";
    } catch (error) {
        aiSuggestion.value = "Sorry, I encountered an error. Please try again.";
    } finally {
        isGenerating.value = false;
    }
};

const checkGrammar = async () => {
    if (!form.content.trim()) return;

    isGenerating.value = true;

    try {
        const res = await fetch("/api/ai/suggest", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                )?.content,
            },
            body: JSON.stringify({
                content: form.content,
                action: "grammar",
            }),
        });

        const data = await res.json();
        aiSuggestion.value =
            data.suggestion ??
            data.response ??
            data.result ??
            "Sorry, I couldn't check grammar.";
    } catch (error) {
        aiSuggestion.value = "Sorry, I encountered an error. Please try again.";
    } finally {
        isGenerating.value = false;
    }
};

const applySuggestion = () => {
    if (form.content.trim()) {
        form.content += "\n\n" + aiSuggestion.value;
    } else {
        form.content = aiSuggestion.value;
    }
    aiSuggestion.value = "";
};

const dismissSuggestion = () => {
    aiSuggestion.value = "";
};

const updateBlog = () => {
    router.put(`/blogs/${props.blog.id}`, form);
};

// Auto-save functionality (optional)
watch(
    [() => form.title, () => form.content],
    () => {
        // Debounced auto-save logic could go here
    },
    { deep: true }
);
</script>