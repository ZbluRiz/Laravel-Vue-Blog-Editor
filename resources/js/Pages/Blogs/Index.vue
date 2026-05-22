<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import logo from "../../../assets/future-blog-logo1.png";

defineProps({
    blogs: {
        type: Array,
        default: () => [],
    },
});

const page = usePage();
const flash = page.props.flash || {};

// Modal + comments/likes state
const showModal = ref(false);
const selectedPost = ref(null);
const newComment = ref('');
const submittingComment = ref(false);

// Mobile menu state
const mobileMenuOpen = ref(false);

const deletePost = (id) => {
    console.log("ID yang dikirim untuk dihapus:", id); // <--- Tambahkan ini

    if (!id) {
        alert("ID artikel tidak ditemukan");
        return;
    }

    if (confirm("Yakin ingin menghapus artikel ini?")) {
        router.delete(`/blogs/${id}`, {
            onSuccess: () => {
                alert("Artikel berhasil dihapus");
            },
            onError: (err) => {
                console.error("Gagal menghapus:", err);
            }
        });
    }
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

const getReadingTime = (content) => {
    const wordsPerMinute = 200;
    const words = content.split(" ").length;
    const readingTime = Math.ceil(words / wordsPerMinute);
    return readingTime;
};

const truncateContent = (content, maxLength = 300) => {
    if (content.length <= maxLength) return content;
    return content.substring(0, maxLength) + "...";
};

// Tambahkan fungsi untuk mengelola modal
const openModal = (post) => {
    selectedPost.value = post;
    newComment.value = '';
    showModal.value = true;
    // Mencegah scroll di background
    document.body.style.overflow = "hidden";
};

const closeModal = () => {
    showModal.value = false;
    selectedPost.value = null;
    // Mengembalikan scroll di background
    document.body.style.overflow = "auto";
};

// Tutup modal jika user menekan tombol Escape
const handleKeydown = (event) => {
    if (event.key === "Escape" && showModal.value) {
        closeModal();
    }
};

// Tambahkan event listener untuk tombol Escape
import { onMounted, onUnmounted } from "vue";

onMounted(() => {
    document.addEventListener("keydown", handleKeydown);
});

onUnmounted(() => {
    document.removeEventListener("keydown", handleKeydown);
    // Pastikan scroll dikembalikan jika component di-unmount
    document.body.style.overflow = "auto";
});

function logout() {
    router.post(route("logout"));
}

const commentsForSelected = () => selectedPost.value?.comments || [];

const commentsCount = (post) =>
    post.comments_count ?? (post.comments ? post.comments.length : 0);

const likesCount = (post) => post.likes_count ?? 0;

const toggleLike = (post) => {
    if (!post?.id) return;
    router.post(
        route('blogs.likes.toggle', post.id),
        {},
        { preserveScroll: true, preserveState: true }
    );
};

const submitComment = () => {
    if (!selectedPost.value?.id || !newComment.value.trim()) return;
    submittingComment.value = true;
    router.post(
        route('blogs.comments.store', selectedPost.value.id),
        { content: newComment.value },
        {
            preserveScroll: true,
            onFinish: () => {
                submittingComment.value = false;
            },
            onSuccess: () => {
                newComment.value = '';
            },
        }
    );
};

// Toggle mobile menu
const toggleMobileMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value;
};

const editPost = (post) => {
    if (!post || !post.id) {
        console.error("ID post tidak ditemukan", post);
        return;
    }

    router.get(route('blogs.edit', post.id));
};
</script>

<template>
    <div
        class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50"
    >
        <!-- Enhanced Navbar -->
        <nav
            class="bg-white shadow-lg border-b border-gray-200 sticky top-0 z-50"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo Section -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center space-x-3">
                            <div
                                class="w-10 h-10 bg-gradient-to-r rounded-lg flex items-center justify-center shadow-lg"
                            >
                                <img :src="logo" alt="Future Blog Logo" />
                            </div>
                            <div class="hidden sm:block">
                                <h1 class="text-xl font-bold text-gray-900">
                                    FutureBlog
                                </h1>
                                <p class="text-xs text-gray-600">
                                    Knowledge Platform
                                </p>
                            </div>
                        </div>

                        <!-- Desktop Navigation Menu -->
                        <div class="hidden md:block ml-10">
                            <div class="flex items-baseline space-x-4">
                                <a
                                    href="#"
                                    class="text-gray-900 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200"
                                >
                                    Home
                                </a>
                                <a
                                    href="#"
                                    class="text-gray-500 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200"
                                >
                                    Articles
                                </a>
                                <a
                                    href="#"
                                    class="text-gray-500 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200"
                                >
                                    Categories
                                </a>
                                <a
                                    href="#"
                                    class="text-gray-500 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200"
                                >
                                    About
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side Actions -->
                    <div class="hidden md:flex items-center space-x-4">
                        <!-- Search Bar -->
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                            >
                                <svg
                                    class="h-5 w-5 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>
                            </div>
                            <input
                                type="text"
                                placeholder="Search articles..."
                                class="block w-64 pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                            />
                        </div>

                        <!-- Create Article Button -->
                        <button
                            @click="router.visit('/blog-editor/create')"
                            class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 flex items-center space-x-2 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 4v16m8-8H4"
                                />
                            </svg>
                            <span>Write Article</span>
                        </button>

                        <!-- User Profile Dropdown -->
                        <div class="relative group">
                            <button
                                class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none"
                            >
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center"
                                >
                                    <span class="text-white font-medium text-sm"
                                        >U</span
                                    >
                                </div>
                                <svg
                                    class="w-4 h-4 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 9l-7 7-7-7"
                                    />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform scale-95 group-hover:scale-100"
                            >
                                <div class="py-1">
                                    <a
                                        href="#"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                                    >
                                        <svg
                                            class="w-4 h-4 mr-3 text-gray-400"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                            />
                                        </svg>
                                        Profile
                                    </a>
                                    <a
                                        href="#"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                                    >
                                        <svg
                                            class="w-4 h-4 mr-3 text-gray-400"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                            />
                                        </svg>
                                        Settings
                                    </a>
                                    <a
                                        href="#"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                                    >
                                        <svg
                                            class="w-4 h-4 mr-3 text-gray-400"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                            />
                                        </svg>
                                        My Articles
                                    </a>
                                    <div class="border-t border-gray-100"></div>
                                    <button
                                        @click="logout"
                                        class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                                    >
                                        <svg
                                            class="w-4 h-4 mr-3"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                            />
                                        </svg>
                                        Logout
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center space-x-2">
                        <!-- Mobile Create Button -->
                        <button
                            @click="router.visit('/blog-editor/create')"
                            class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-2 rounded-lg shadow-md"
                        >
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 4v16m8-8H4"
                                />
                            </svg>
                        </button>

                        <!-- Hamburger Menu -->
                        <button
                            @click="toggleMobileMenu"
                            class="text-gray-700 hover:text-gray-900 focus:outline-none"
                        >
                            <svg
                                class="w-6 h-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    v-if="!mobileMenuOpen"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    v-else
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div
                    v-show="mobileMenuOpen"
                    class="md:hidden border-t border-gray-200 bg-white"
                >
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        <!-- Search Bar Mobile -->
                        <div class="relative mb-3">
                            <div
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                            >
                                <svg
                                    class="h-5 w-5 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>
                            </div>
                            <input
                                type="text"
                                placeholder="Search articles..."
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm"
                            />
                        </div>

                        <!-- Navigation Links -->
                        <a
                            href="#"
                            class="text-gray-900 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium"
                            >Home</a
                        >
                        <a
                            href="#"
                            class="text-gray-500 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium"
                            >Articles</a
                        >
                        <a
                            href="#"
                            class="text-gray-500 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium"
                            >Categories</a
                        >
                        <a
                            href="#"
                            class="text-gray-500 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium"
                            >About</a
                        >

                        <div class="border-t border-gray-200 pt-4 mt-4">
                            <div class="flex items-center px-3 mb-3">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center"
                                >
                                    <span class="text-white font-medium text-sm"
                                        >U</span
                                    >
                                </div>
                                <div class="ml-3">
                                    <p
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        User Profile
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        user@example.com
                                    </p>
                                </div>
                            </div>

                            <a
                                href="#"
                                class="text-gray-500 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium"
                                >Profile</a
                            >
                            <a
                                href="#"
                                class="text-gray-500 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium"
                                >Settings</a
                            >
                            <a
                                href="#"
                                class="text-gray-500 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium"
                                >My Articles</a
                            >

                            <button
                                @click="logout"
                                class="text-red-600 hover:text-red-800 block w-full text-left px-3 py-2 rounded-md text-base font-medium"
                            >
                                Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Success Message -->
            <div
                v-if="flash && flash.success"
                class="mb-8 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl flex items-center space-x-3"
            >
                <svg
                    class="w-6 h-6 text-green-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
                <span class="font-medium">{{ flash.success }}</span>
            </div>

            <!-- Hero Section -->
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Discover & Share Educational Content
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Join our community of learners and educators. Share your
                    knowledge, discover new insights, and grow together.
                </p>
            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div
                    class="bg-white rounded-xl p-6 shadow-lg border border-gray-100"
                >
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center"
                        >
                            <svg
                                class="w-6 h-6 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-2xl font-bold text-gray-900">
                                {{ blogs.length }}
                            </p>
                            <p class="text-gray-600">Articles Published</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl p-6 shadow-lg border border-gray-100"
                >
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center"
                        >
                            <svg
                                class="w-6 h-6 text-green-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"
                                />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-2xl font-bold text-gray-900">4</p>
                            <p class="text-gray-600">Community Members</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl p-6 shadow-lg border border-gray-100"
                >
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center"
                        >
                            <svg
                                class="w-6 h-6 text-purple-600"
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
                        <div class="ml-4">
                            <p class="text-2xl font-bold text-gray-900">98%</p>
                            <p class="text-gray-600">Learning Success Rate</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- No Posts Message -->
            <div v-if="!blogs || blogs.length === 0" class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <div
                        class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6"
                    >
                        <svg
                            class="w-12 h-12 text-blue-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                            />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        Start Your Educational Journey
                    </h3>
                    <p class="text-gray-600 mb-8">
                        Be the first to share valuable educational content with
                        our community. Your knowledge can inspire and help
                        others learn.
                    </p>
                    <button
                        @click="router.visit('/blog-editor/create')"
                        class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-8 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl"
                    >
                        Create Your First Article
                    </button>
                </div>
            </div>

            <!-- Blog Posts Grid -->
            <div v-else class="grid gap-8 lg:grid-cols-2 xl:grid-cols-3">
                <article
                    v-for="post in blogs"
                    :key="post.id"
                    class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden group"
                >
                    <!-- Article Header -->
                    <div class="p-6 pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center"
                                >
                                    <span class="text-white font-bold text-sm"
                                        >AU</span
                                    >
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">
                                        Albert Einstein
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Educator
                                    </p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div
                                class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                            >
                               
                            </div>
                        </div>

                        <!-- Article Title -->
                        <h3
                            class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors duration-200"
                        >
                            {{ post.title }}
                        </h3>

                        <!-- Article Preview -->
                        <p
                            class="text-gray-600 leading-relaxed mb-4 line-clamp-3"
                        >
                            {{ truncateContent(post.content, 150) }}
                        </p>
                    </div>

                    <!-- Article Footer -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        <div
                            class="flex items-center justify-between text-sm text-gray-500"
                        >
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center space-x-1">
                                    <svg
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                    <span
                                        >{{ getReadingTime(post.content) }} min
                                        read</span
                                    >
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="flex items-center space-x-1">
                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                            />
                                        </svg>
                                        <span>{{ commentsCount(post) }} comments</span>
                                    </div>
                                    <button
                                        type="button"
                                        class="flex items-center space-x-1 text-gray-500 hover:text-red-500"
                                        @click.stop="toggleLike(post)"
                                    >
                                        <svg
                                            class="w-4 h-4"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        <span>{{ likesCount(post) }}</span>
                                    </button>
                                </div>
                            </div>
                            <time class="text-gray-400">{{
                                formatDate(post.created_at)
                            }}</time>
                        </div>

                        <!-- Tags -->
                        <div class="mt-3 flex flex-wrap gap-2">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                            >
                                Education
                            </span>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                            >
                                Knowledge
                            </span>
                        </div>

                        <!-- Read More Button -->
                        <div class="mt-4">
                            <button
                                @click="openModal(post)"
                                class="w-full bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-medium py-2.5 px-4 rounded-lg transition-all duration-200 flex items-center justify-center space-x-2"
                            >
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                    />
                                </svg>
                                <span>Read Full Article</span>
                            </button>
                        </div>
                    </div>
                </article>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="text-center">
                    <p class="text-gray-600">
                        © 2025 EduCommunity. Empowering minds through shared
                        knowledge.
                    </p>
                </div>
            </div>
        </footer>

        <!-- Modal Popup -->
        <Teleport to="body">
            <div
                v-if="showModal"
                class="fixed inset-0 z-50 overflow-y-auto"
                @click="closeModal"
            >
                <div
                    class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0"
                >
                    <!-- Background overlay -->
                    <div
                        class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75"
                    ></div>

                    <!-- Modal panel -->
                    <div
                        class="inline-block w-full max-w-4xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl"
                        @click.stop
                    >
                        <!-- Modal Header -->
                        <div
                            class="flex items-start justify-between pb-4 border-b border-gray-200"
                        >
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center"
                                >
                                    <span class="text-white font-bold text-lg"
                                        >AU</span
                                    >
                                </div>
                                <div>
                                    <h3
                                        class="text-lg font-semibold text-gray-900"
                                    >
                                        Author
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        Educator
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <!-- Edit Button -->
                                <button
                                    @click="
                                        editPost(selectedPost)
                                    "
                                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                    title="Edit Article"
                                >
                                    <svg
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                        />
                                    </svg>
                                </button>

                                <!-- Delete Button -->
                                <button
                                    @click="deletePost(selectedPost?.id)"
                                    class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                    title="Delete Article"
                                >
                                    <svg
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                        />
                                    </svg>
                                </button>

                                <!-- Close Button -->
                                <button
                                    @click="closeModal"
                                    class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-200"
                                    title="Close"
                                >
                                    <svg
                                        class="w-6 h-6"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Modal Content -->
                        <div class="mt-6">
                            <!-- Article Title -->
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                                {{ selectedPost?.title || "Loading..." }}
                            </h1>

                            <!-- Article Metadata -->
                            <div
                                class="flex items-center space-x-6 text-sm text-gray-500 mb-6 pb-4 border-b border-gray-100"
                            >
                                <div class="flex items-center space-x-2">
                                    <svg
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                    <span
                                        >{{
                                            getReadingTime(
                                                selectedPost?.content || ""
                                            )
                                        }}
                                        min read</span
                                    >
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                    <span>{{
                                        selectedPost?.created_at
                                            ? formatDate(
                                                  selectedPost.created_at
                                              )
                                            : ""
                                    }}</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="flex items-center space-x-1">
                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                            />
                                        </svg>
                                        <span>{{ commentsCount(selectedPost) }} comments</span>
                                    </div>
                                    <button
                                        type="button"
                                        class="flex items-center space-x-1 text-gray-500 hover:text-red-500"
                                        @click.stop="toggleLike(selectedPost)"
                                    >
                                        <svg
                                            class="w-4 h-4"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        <span>{{ likesCount(selectedPost) }}</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Article Content -->
                            <div class="prose prose-lg max-w-none">
                                <div
                                    class="text-gray-700 leading-relaxed whitespace-pre-line text-base"
                                >
                                    {{
                                        selectedPost?.content ||
                                        "Loading content..."
                                    }}
                                </div>
                            </div>

                            <!-- Comments Section -->
                            <div class="mt-8 pt-6 border-t border-gray-100">
                                <h2 class="text-lg font-semibold text-gray-900 mb-4">
                                    Comments
                                </h2>

                                <div v-if="commentsForSelected().length" class="space-y-4 mb-6 max-h-64 overflow-y-auto pr-1">
                                    <div
                                        v-for="comment in commentsForSelected()"
                                        :key="comment.id"
                                        class="rounded-lg border border-gray-100 bg-gray-50 px-4 py-3"
                                    >
                                        <div class="flex items-center justify-between mb-1.5">
                                            <div class="flex items-center gap-2 text-sm text-gray-700 font-medium">
                                                <span>
                                                    {{ comment.user?.name ?? 'User' }}
                                                </span>
                                            </div>
                                            <span class="text-xs text-gray-400">
                                                {{ formatDate(comment.created_at) }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-700 whitespace-pre-line">
                                            {{ comment.content }}
                                        </p>
                                    </div>
                                </div>

                                <form @submit.prevent="submitComment" class="space-y-3">
                                    <textarea
                                        v-model="newComment"
                                        rows="3"
                                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                        placeholder="Write a comment..."
                                    />
                                    <div class="flex justify-end">
                                        <button
                                            type="submit"
                                            :disabled="!newComment.trim() || submittingComment"
                                            class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 disabled:cursor-not-allowed disabled:bg-gray-400"
                                        >
                                            {{ submittingComment ? 'Sending...' : 'Post Comment' }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Teleport>
    </div>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
