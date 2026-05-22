<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100">
        <div class="container mx-auto px-4 py-8">
            <div class="flex gap-8 max-w-7xl mx-auto">
                <!-- Blog Editor Container - Center -->
                <div class="flex-1 max-w-4xl">
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden">
                        <!-- Header -->
                        <div class="bg-white/90 backdrop-blur-sm border-b border-gray-200 p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h1 class="text-2xl font-bold text-gray-800">Blog Editor</h1>
                                        <p class="text-sm text-gray-600">Create amazing content with AI assistance</p>
                                    </div>
                                </div>

                                <!-- Stats -->
                                <div class="hidden md:flex items-center gap-4 text-sm text-gray-600">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        <span>{{ wordCount }} words</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>{{ readingTime }} min read</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Editor Content -->
                        <div class="p-8">
                            <!-- Title Input -->
                            <div class="mb-8">
                                <input
                                    v-model="title"
                                    type="text"
                                    placeholder="Enter your blog title..."
                                    class="w-full text-4xl font-bold text-gray-800 bg-transparent border-none outline-none placeholder-gray-400 focus:ring-0 pb-4"
                                />
                                <div
                                    class="h-1 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full transform origin-left transition-transform duration-300"
                                    :style="{ transform: `scaleX(${title.length > 0 ? 1 : 0})` }"
                                ></div>
                            </div>

                            <!-- Content Editor -->
                            <div class="relative mb-8">
                                <textarea
                                    v-model="content"
                                    @input="updateStats"
                                    class="w-full h-96 p-6 bg-white/60 backdrop-blur-sm border border-gray-200 rounded-2xl resize-none focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-lg transition-all duration-300 text-gray-800 leading-relaxed text-lg"
                                    placeholder="Start writing your amazing blog post here... 

✨ Tips:
- Use clear, engaging language
- Break content into short paragraphs
- Add examples and stories
- Ask questions to engage readers"
                                    :disabled="isGenerating"
                                ></textarea>

                                <!-- Character limit indicator -->
                                <div class="absolute bottom-4 right-4 text-xs text-gray-500 bg-white/80 px-3 py-1 rounded-full shadow">
                                    {{ content.length }}/20000
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                                <button
                                    @click="improveContent"
                                    :disabled="!content.trim() || isGenerating"
                                    class="flex items-center justify-center gap-2 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 disabled:from-gray-400 disabled:to-gray-500 text-white font-semibold px-4 py-3 rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105 active:scale-95 disabled:scale-100 disabled:cursor-not-allowed"
                                >
                                    <svg v-if="!isGenerating" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                    <svg v-else class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                                    </svg>
                                    <span class="text-sm">{{ isGenerating ? "Improving..." : "Improve AI" }}</span>
                                </button>

                                <button
                                    @click="generateIdeas"
                                    :disabled="isGenerating"
                                    class="flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-600 hover:to-teal-600 disabled:from-gray-400 disabled:to-gray-500 text-white font-semibold px-4 py-3 rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105 active:scale-95 disabled:scale-100 disabled:cursor-not-allowed"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                    <span class="text-sm">Get Ideas</span>
                                </button>

                                <button
                                    @click="checkGrammar"
                                    :disabled="!content.trim() || isGenerating"
                                    class="flex items-center justify-center gap-2 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 disabled:from-gray-400 disabled:to-gray-500 text-white font-semibold px-4 py-3 rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105 active:scale-95 disabled:scale-100 disabled:cursor-not-allowed"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-sm">Grammar</span>
                                </button>

                                <button
                                    @click="postBlog"
                                    :disabled="!content.trim() || isGenerating"
                                    class="flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-500 to-violet-500 hover:from-indigo-600 hover:to-violet-600 disabled:from-gray-400 disabled:to-gray-500 text-white font-semibold px-4 py-3 rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105 active:scale-95 disabled:scale-100 disabled:cursor-not-allowed"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="text-sm">Post Blog</span>
                                </button>
                            </div>

                            <!-- AI Suggestions -->
                            <div v-if="aiSuggestion" class="mb-8">
                                <div class="bg-white/80 backdrop-blur-sm border border-blue-200 rounded-2xl shadow-xl p-6">
                                    <div class="flex items-start gap-4">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-3">
                                                <h3 class="text-lg font-semibold text-gray-800">AI Suggestion</h3>
                                                <div class="flex gap-2">
                                                    <button @click="applySuggestion" class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-sm rounded-lg transition-colors">Apply</button>
                                                    <button @click="dismissSuggestion" class="px-3 py-1 bg-gray-500 hover:bg-gray-600 text-white text-sm rounded-lg transition-colors">Dismiss</button>
                                                </div>
                                            </div>
                                            <div class="bg-gradient-to-r from-blue-50 to-purple-50 text-gray-800 p-4 rounded-xl border border-blue-100">
                                                <div class="whitespace-pre-line">{{ aiSuggestion }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Tips -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-white/60 backdrop-blur-sm p-6 rounded-xl border border-gray-200 shadow-lg">
                                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                                        <span class="text-2xl">💡</span>
                                        Writing Tips
                                    </h4>
                                    <ul class="text-sm text-gray-600 space-y-2">
                                        <li class="flex items-start gap-2">
                                            <span class="text-blue-500 mt-1">•</span>
                                            Keep paragraphs short and focused
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="text-blue-500 mt-1">•</span>
                                            Use active voice for clarity
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="text-blue-500 mt-1">•</span>
                                            Add examples and stories
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="text-blue-500 mt-1">•</span>
                                            End with a call to action
                                        </li>
                                    </ul>
                                </div>

                                <div class="bg-white/60 backdrop-blur-sm p-6 rounded-xl border border-gray-200 shadow-lg">
                                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                                        <span class="text-2xl">🎯</span>
                                        SEO Best Practices
                                    </h4>
                                    <ul class="text-sm text-gray-600 space-y-2">
                                        <li class="flex items-start gap-2">
                                            <span class="text-green-500 mt-1">•</span>
                                            Use keywords naturally
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="text-green-500 mt-1">•</span>
                                            Write compelling headlines
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="text-green-500 mt-1">•</span>
                                            Include internal links
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="text-green-500 mt-1">•</span>
                                            Optimize meta descriptions
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- AI Chatbot Sidebar -->
                <div class="w-96 flex-shrink-0">
                    <AIAssistant />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import AIAssistant from "./AIAssistant.vue";
import { router } from '@inertiajs/vue3'

const title = ref("");
const content = ref("");
const aiSuggestion = ref("");
const isGenerating = ref(false);

// Computed properties for stats
const wordCount = computed(() => {
    return content.value
        .trim()
        .split(/\s+/)
        .filter((word) => word.length > 0).length;
});

const readingTime = computed(() => {
    const wordsPerMinute = 200;
    return Math.max(1, Math.ceil(wordCount.value / wordsPerMinute));
});

const updateStats = () => {
    // Stats automatically update via computed properties
};

const improveContent = async () => {
    if (!content.value.trim()) return;

    isGenerating.value = true;

    try {
        const improvePrompt = `Please improve the following blog content by making it more engaging, clear, and well-structured. Focus on:
1. Enhancing readability and flow
2. Making the language more compelling
3. Adding transitions between ideas
4. Improving sentence structure
5. Making it more engaging for readers

Please provide the improved version directly without asking for clarification:

${content.value}`;

        const res = await fetch("/api/ai/suggest", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content,
            },
            body: JSON.stringify({
                content: improvePrompt,
                action: "improve",
            }),
        });

        const data = await res.json();
        aiSuggestion.value = data.suggestion ?? data.response ?? data.result ?? "Sorry, I couldn't generate a suggestion.";
    } catch (error) {
        aiSuggestion.value = "Sorry, I encountered an error. Please try again.";
    } finally {
        isGenerating.value = false;
    }
};

const generateIdeas = async () => {
    isGenerating.value = true;

    try {
        const ideasPrompt = `Based on the following blog title and content, please provide 5-7 specific content ideas or suggestions to expand this blog post. Include:
1. Additional subtopics to cover
2. Examples or case studies to add
3. Questions to address
4. Call-to-action suggestions
5. Related topics that would add value

Title: ${title.value || "Untitled"}
Content: ${content.value || "No content yet"}

Please provide concrete, actionable ideas in a numbered list format:`;

        const res = await fetch("/api/ai/suggest", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content,
            },
            body: JSON.stringify({
                content: ideasPrompt,
                action: "ideas",
            }),
        });

        const data = await res.json();
        aiSuggestion.value = data.suggestion ?? data.response ?? data.result ?? "Sorry, I couldn't generate ideas.";
    } catch (error) {
        aiSuggestion.value = "Sorry, I encountered an error. Please try again.";
    } finally {
        isGenerating.value = false;
    }
};

const checkGrammar = async () => {
    if (!content.value.trim()) return;

    isGenerating.value = true;

    try {
        const grammarPrompt = `Please check the following text for grammar, spelling, and punctuation errors. Provide a corrected version and highlight the main issues that were fixed:

${content.value}

Please provide:
1. The corrected text
2. A brief summary of the main errors found`;

        const res = await fetch("/api/ai/suggest", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content,
            },
            body: JSON.stringify({
                content: grammarPrompt,
                action: "grammar",
            }),
        });

        const data = await res.json();
        aiSuggestion.value = data.suggestion ?? data.response ?? data.result ?? "Sorry, I couldn't check grammar.";
    } catch (error) {
        aiSuggestion.value = "Sorry, I encountered an error. Please try again.";
    } finally {
        isGenerating.value = false;
    }
};

const applySuggestion = () => {
    if (content.value.trim()) {
        content.value += "\n\n" + aiSuggestion.value;
    } else {
        content.value = aiSuggestion.value;
    }
    aiSuggestion.value = "";
};

const dismissSuggestion = () => {
    aiSuggestion.value = "";
};

const postBlog = () => {
    if (!title.value.trim() || !content.value.trim()) return;

    isGenerating.value = true;

    router.post('/blog', {
        title: title.value,
        content: content.value,
    }, {
        onFinish: () => {
            isGenerating.value = false;
        },
        onSuccess: () => {
            title.value = "";
            content.value = "";
            aiSuggestion.value = "";
        },
        onError: (errors) => {
            console.error("Validation failed:", errors);
        }
    });
};

// Auto-save functionality (optional)
watch(
    [title, content],
    () => {
        // Debounced auto-save logic could go here
    },
    { deep: true }
);
</script>