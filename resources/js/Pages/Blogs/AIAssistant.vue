<template>
    <div>
        <!-- Chat Button - Fixed position at bottom right -->
        <div class="fixed bottom-6 right-6 z-50" v-if="!isChatOpen">
            <button
                @click="openChat"
                class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white rounded-full shadow-lg hover:shadow-xl transform transition-all duration-300 hover:scale-110 bounce-animation"
            >
                <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </button>

            <!-- Notification badge -->
            <div
                v-if="hasNotification"
                class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white text-xs rounded-full flex items-center justify-center animate-pulse"
            >
                1
            </div>
        </div>

        <!-- Full Screen Chat Overlay -->
        <div
            v-if="isChatOpen"
            class="fixed inset-0 z-50 bg-black/20 backdrop-blur-sm chat-fade-in"
            @click="closeChat"
        >
            <!-- Chat Container -->
            <div
                @click.stop
                class="flex flex-col h-full max-w-4xl mx-auto bg-gradient-to-br from-slate-50 to-blue-50 chat-slide-up"
            >
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6 text-white relative overflow-hidden">
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold">AI Assistant</h2>
                                    <p class="text-blue-100 text-sm opacity-90">Siap membantu Anda dengan konten blog dan penulisan</p>
                                </div>
                            </div>
                            
                            <!-- Action buttons -->
                            <div class="flex items-center gap-3">
                                <button
                                    @click="clearChat"
                                    class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors"
                                    title="Hapus Chat"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                                
                                <button
                                    @click="exportChat"
                                    class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors"
                                    title="Export Chat"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </button>

                                <button
                                    @click="closeChat"
                                    class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors"
                                    title="Tutup Chat"
                                >
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2 text-sm text-blue-100 mt-3">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span>Online & Siap Membantu</span>
                            <span class="mx-2">•</span>
                            <span>{{ messages.length }} pesan</span>
                        </div>
                    </div>
                </div>

                <!-- Chat Messages -->
                <div class="flex-1 overflow-y-auto p-8 space-y-6" ref="chatBox">
                    <!-- Welcome message -->
                    <div v-if="messages.length === 0" class="text-center py-16">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-800 mb-4">Halo! 👋</h3>
                        <p class="text-gray-600 text-lg max-w-2xl mx-auto mb-8">
                            Saya AI Assistant, siap membantu Anda dengan konten blog, penulisan, dan berbagai keperluan lainnya. Mulai percakapan dengan memilih salah satu opsi di bawah atau ketik pertanyaan Anda sendiri.
                        </p>
                        <div class="flex flex-wrap gap-4 justify-center max-w-3xl mx-auto">
                            <button
                                @click="quickPrompt('Berikan 10 ide untuk blog post tentang teknologi terbaru')"
                                class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-200 transform hover:scale-105 shadow-lg"
                            >
                                💡 Ide Blog Teknologi
                            </button>
                            <button
                                @click="quickPrompt('Tips menulis artikel yang engaging dan SEO-friendly')"
                                class="px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-lg"
                            >
                                ✨ Tips Menulis
                            </button>
                            <button
                                @click="quickPrompt('Buatkan judul SEO friendly untuk blog tentang digital marketing')"
                                class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-200 transform hover:scale-105 shadow-lg"
                            >
                                🚀 SEO Optimizer
                            </button>
                            <button
                                @click="quickPrompt('Bantu saya membuat outline untuk artikel tentang AI')"
                                class="px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-200 transform hover:scale-105 shadow-lg"
                            >
                                📝 Outline Creator
                            </button>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div
                        v-for="(msg, index) in messages"
                        :key="index"
                        class="flex items-start gap-4"
                        :class="msg.role === 'user' ? 'flex-row-reverse' : 'flex-row'"
                    >
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            <div
                                :class="[
                                    'w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg',
                                    msg.role === 'user'
                                        ? 'bg-gradient-to-br from-blue-500 to-blue-600'
                                        : 'bg-gradient-to-br from-purple-500 to-pink-500',
                                ]"
                            >
                                {{ msg.role === "user" ? "U" : "AI" }}
                            </div>
                        </div>

                        <!-- Message bubble -->
                        <div class="flex-1 max-w-[70%]">
                            <div
                                :class="[
                                    'px-6 py-4 rounded-2xl shadow-lg text-base leading-relaxed',
                                    msg.role === 'user'
                                        ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white ml-auto'
                                        : 'bg-white text-gray-800 border border-gray-200',
                                ]"
                            >
                                <div class="whitespace-pre-line">{{ msg.text }}</div>

                                <!-- Typing indicator -->
                                <div
                                    v-if="msg.role === 'ai' && msg.typing"
                                    class="flex items-center gap-2 mt-3"
                                >
                                    <div class="flex gap-1">
                                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                    </div>
                                    <span class="text-sm text-gray-500">Mengetik...</span>
                                </div>
                            </div>

                            <!-- Timestamp -->
                            <div
                                :class="[
                                    'text-sm text-gray-500 mt-2',
                                    msg.role === 'user' ? 'text-right' : 'text-left',
                                ]"
                            >
                                {{ formatTime(msg.timestamp) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Input section -->
                <div class="p-6 bg-white/80 backdrop-blur-sm border-t border-gray-200">
                    <div class="max-w-4xl mx-auto">
                        <div class="flex items-end gap-4">
                            <div class="flex-1">
                                <textarea
                                    v-model="input"
                                    @keydown.enter.prevent="handleEnter"
                                    @input="adjustTextareaHeight"
                                    ref="textarea"
                                    placeholder="Ketik pesan Anda di sini..."
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none transition-all duration-200 bg-white/90 backdrop-blur-sm text-base min-h-[50px] max-h-32"
                                    rows="1"
                                    :disabled="isLoading"
                                ></textarea>
                            </div>

                            <button
                                @click="sendMessage"
                                :disabled="!input.trim() || isLoading"
                                class="bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 disabled:from-gray-400 disabled:to-gray-500 text-white p-3 rounded-xl transition-all duration-200 transform hover:scale-105 active:scale-95 disabled:scale-100 disabled:cursor-not-allowed shadow-lg"
                            >
                                <svg
                                    v-if="!isLoading"
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                <svg
                                    v-else
                                    class="w-6 h-6 animate-spin"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Quick actions and hints -->
                        <div class="flex items-center justify-between mt-4">
                            <div class="flex gap-3">
                                <button
                                    @click="quickPrompt('Jelaskan lebih detail')"
                                    class="px-3 py-1 text-sm text-gray-600 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-full transition-colors"
                                >
                                    🔍 Detail
                                </button>
                                <button
                                    @click="quickPrompt('Berikan contoh')"
                                    class="px-3 py-1 text-sm text-gray-600 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-full transition-colors"
                                >
                                    💡 Contoh
                                </button>
                                <button
                                    @click="quickPrompt('Sederhanakan penjelasan')"
                                    class="px-3 py-1 text-sm text-gray-600 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-full transition-colors"
                                >
                                    ✨ Sederhanakan
                                </button>
                            </div>
                            
                            <div class="text-sm text-gray-500">
                                <span>Enter untuk kirim • Shift+Enter untuk baris baru</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, nextTick, onMounted, onUnmounted } from 'vue';

// Reactive data
const isChatOpen = ref(false);
const hasNotification = ref(true);
const input = ref('');
const messages = ref([]);
const chatBox = ref(null);
const textarea = ref(null);
const isLoading = ref(false);

// Methods
const openChat = () => {
    isChatOpen.value = true;
    hasNotification.value = false;
    document.body.style.overflow = 'hidden'; // Prevent background scroll
    nextTick(() => {
        if (textarea.value) {
            textarea.value.focus();
        }
    });
};

const closeChat = () => {
    isChatOpen.value = false;
    document.body.style.overflow = 'auto'; // Restore background scroll
};

const scrollToBottom = async () => {
    await nextTick();
    if (chatBox.value) {
        chatBox.value.scrollTop = chatBox.value.scrollHeight;
    }
};

const adjustTextareaHeight = () => {
    if (textarea.value) {
        textarea.value.style.height = 'auto';
        textarea.value.style.height = Math.min(textarea.value.scrollHeight, 128) + 'px';
    }
};

const handleEnter = (e) => {
    if (!e.shiftKey) {
        sendMessage();
    }
};

const formatTime = (timestamp) => {
    return new Date(timestamp).toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit',
    });
};

const quickPrompt = (prompt) => {
    input.value = prompt;
    sendMessage();
};

const sendMessage = async () => {
    const message = input.value.trim();
    if (!message || isLoading.value) return;

    const timestamp = Date.now();

    // User message
    messages.value.push({
        role: 'user',
        text: message,
        timestamp,
    });

    input.value = '';
    adjustTextareaHeight();
    isLoading.value = true;

    // Add typing indicator
    const typingMessage = {
        role: 'ai',
        text: '',
        typing: true,
        timestamp: Date.now(),
    };
    messages.value.push(typingMessage);

    await scrollToBottom();

    try {
        // Fetch AI response dari Laravel backend
        const res = await fetch('/api/ai/suggest', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
            },
            body: JSON.stringify({ content: message }),
        });

        const data = await res.json();

        // Remove typing indicator and add actual response
        messages.value.pop();
        messages.value.push({
            role: 'ai',
            text: data.suggestion ?? data.response ?? data.result ?? 'Maaf, saya tidak bisa memberikan respons saat ini.',
            timestamp: Date.now(),
        });
    } catch (error) {
        console.error('Error:', error);
        messages.value.pop();
        messages.value.push({
            role: 'ai',
            text: 'Maaf, terjadi kesalahan. Silakan coba lagi.',
            timestamp: Date.now(),
        });
    } finally {
        isLoading.value = false;
        await scrollToBottom();
    }
};

const clearChat = () => {
    if (confirm('Apakah Anda yakin ingin menghapus semua pesan?')) {
        messages.value = [];
    }
};

const exportChat = () => {
    const chatContent = messages.value
        .map((msg) => `${msg.role.toUpperCase()}: ${msg.text}`)
        .join('\n\n');

    const blob = new Blob([chatContent], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `ai-chat-export-${new Date().toISOString().split('T')[0]}.txt`;
    a.click();
    URL.revokeObjectURL(url);
};

// Handle escape key to close chat
const handleEscape = (e) => {
    if (e.key === 'Escape' && isChatOpen.value) {
        closeChat();
    }
};

onMounted(() => {
    adjustTextareaHeight();
    document.addEventListener('keydown', handleEscape);
});

onUnmounted(() => {
    document.removeEventListener('keydown', handleEscape);
    document.body.style.overflow = 'auto'; // Restore on unmount
});
</script>

<style scoped>
.chat-fade-in {
    animation: fadeIn 0.3s ease-out;
}

.chat-slide-up {
    animation: slideUp 0.4s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes slideUp {
    from {
        transform: translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.bounce-animation {
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

/* Custom scrollbar */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>