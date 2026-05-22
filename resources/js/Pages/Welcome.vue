<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import logo from "../../assets/future-blog-logo1.png";

// Reactive variables
const isMenuOpen = ref(false)
const currentSlide = ref(0)

// Data
const testimonials = ref([
    {
        name: "Sarah Johnson",
        role: "High School Teacher",
        content: "EduCommunity has transformed how I share knowledge with my students. The platform is intuitive and the community is incredibly supportive.",
        rating: 5
    },
    {
        name: "Dr. Michael Chen",
        role: "University Professor",
        content: "As an educator, I've found EduCommunity to be the perfect platform for sharing research insights and connecting with fellow academics worldwide.",
        rating: 5
    },
    {
        name: "Lisa Rodriguez",
        role: "Learning Enthusiast",
        content: "The quality of educational content here is outstanding. I've learned so much from the diverse range of topics shared by experts.",
        rating: 5
    }
])

const features = ref([
    {
        icon: 'book',
        title: "Rich Content Creation",
        description: "Create and share comprehensive educational articles with our intuitive editor. Support for multimedia content and interactive elements."
    },
    {
        icon: 'users',
        title: "Vibrant Community",
        description: "Connect with educators, students, and lifelong learners from around the world. Engage in meaningful discussions and collaborations."
    },
    {
        icon: 'zap',
        title: "Instant Knowledge Sharing",
        description: "Share your expertise instantly with our fast publishing system. Reach thousands of learners with just a few clicks."
    },
    {
        icon: 'award',
        title: "Recognition System",
        description: "Get recognized for your contributions with our reputation system. Build your profile as a trusted educator in the community."
    }
])

const stats = ref([
    { number: "10K+", label: "Active Members" },
    { number: "5K+", label: "Articles Published" },
    { number: "98%", label: "Learning Success Rate" },
    { number: "50+", label: "Subject Areas" }
])

// Methods
const scrollToSection = (id) => {
    document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' })
    isMenuOpen.value = false
}

const goToLogin = () => {
    router.visit('/login')
}

const goToBlog = () => {
    router.visit('/blogs')
}

// Auto-rotate testimonials
let testimonialInterval = null

onMounted(() => {
    testimonialInterval = setInterval(() => {
        currentSlide.value = (currentSlide.value + 1) % testimonials.value.length
    }, 5000)
})

onUnmounted(() => {
    if (testimonialInterval) {
        clearInterval(testimonialInterval)
    }
})
</script>

<template>
    <div class="min-h-screen bg-white">
        <!-- Navigation -->
        <nav class="fixed top-0 w-full bg-white/95 backdrop-blur-sm border-b border-gray-100 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r rounded-lg flex items-center justify-center">
                           <img :src="logo" alt="Future Blog Logo" class="h-auto w-auto" />
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">FutureBlog</h1>
                            <p class="text-xs text-gray-600">Knowledge Sharing Platform</p>
                        </div>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center space-x-8">
                        <button @click="scrollToSection('features')" class="text-gray-600 hover:text-blue-600 transition-colors">
                            Features
                        </button>
                        <button @click="scrollToSection('about')" class="text-gray-600 hover:text-blue-600 transition-colors">
                            About
                        </button>
                        <button @click="scrollToSection('testimonials')" class="text-gray-600 hover:text-blue-600 transition-colors">
                            Testimonials
                        </button>

                        <!-- Auth-aware links -->
                        <template v-if="$page.props.auth && $page.props.auth.user">
                            <Link
                                :href="route('dashboard')"
                                class="text-gray-600 hover:text-blue-600 transition-colors"
                            >
                                Dashboard
                            </Link>
                            <Link
                                :href="route('profile.edit')"
                                class="text-gray-600 hover:text-blue-600 transition-colors"
                            >
                                Profile
                            </Link>
                        </template>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="text-gray-600 hover:text-blue-600 transition-colors"
                            >
                                Login
                            </Link>
                            <Link
                                v-if="$page.props.canRegister"
                                :href="route('register')"
                                class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-2 px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl"
                            >
                                Get Started
                            </Link>
                        </template>
                    </div>

                    <!-- Mobile menu button -->
                    <button @click="isMenuOpen = !isMenuOpen" class="md:hidden p-2 rounded-lg hover:bg-gray-100">
                        <svg v-if="!isMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Mobile Navigation -->
                <div v-if="isMenuOpen" class="md:hidden py-4 border-t border-gray-100">
                    <div class="flex flex-col space-y-3">
                        <button @click="scrollToSection('features')" class="text-left text-gray-600 hover:text-blue-600 transition-colors py-2">
                            Features
                        </button>
                        <button @click="scrollToSection('about')" class="text-left text-gray-600 hover:text-blue-600 transition-colors py-2">
                            About
                        </button>
                        <button @click="scrollToSection('testimonials')" class="text-left text-gray-600 hover:text-blue-600 transition-colors py-2">
                            Testimonials
                        </button>

                        <!-- Mobile auth-aware buttons -->
                        <template v-if="$page.props.auth && $page.props.auth.user">
                            <Link
                                :href="route('dashboard')"
                                class="text-left text-gray-600 hover:text-blue-600 transition-colors py-2"
                            >
                                Dashboard
                            </Link>
                            <Link
                                :href="route('profile.edit')"
                                class="text-left text-gray-600 hover:text-blue-600 transition-colors py-2"
                            >
                                Profile
                            </Link>
                        </template>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="text-left text-gray-600 hover:text-blue-600 transition-colors py-2"
                            >
                                Login
                            </Link>
                            <Link
                                v-if="$page.props.canRegister"
                                :href="route('register')"
                                class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-3 px-6 rounded-lg mt-4 text-center"
                            >
                                Get Started
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="pt-20 pb-16 bg-gradient-to-br from-blue-50 via-white to-indigo-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-8">
                        <div class="space-y-4">
                            <div class="inline-flex items-center px-4 py-2 bg-blue-100 rounded-full text-blue-800 text-sm font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Transform Your Learning Journey
                            </div>
                            <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                                Share Knowledge,
                                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent"> Inspire Growth</span>
                            </h1>
                            <p class="text-xl text-gray-600 leading-relaxed">
                                Join FutureBlog community, the premier platform where educators, students, and lifelong learners come together to share knowledge, discover insights, and build a brighter future through education.
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <button @click="goToLogin" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-4 px-8 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center group">
                                Start Sharing Knowledge
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </button>
                            <button @click="goToBlog" class="border-2 border-gray-300 hover:border-blue-600 text-gray-700 hover:text-blue-600 font-semibold py-4 px-8 rounded-xl transition-all duration-200 flex items-center justify-center group">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M15 14h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Explore Articles
                            </button>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 pt-8">
                            <div v-for="(stat, index) in stats" :key="index" class="text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ stat.number }}</div>
                                <div class="text-sm text-gray-600">{{ stat.label }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="relative z-10 bg-white rounded-2xl shadow-2xl p-8 transform rotate-3 hover:rotate-0 transition-transform duration-500">
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold">JD</span>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Michael Shumacher</h3>
                                        <p class="text-sm text-gray-600">Mathematics Professor</p>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900 mb-2">Advanced Calculus Made Simple</h4>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Discover the beauty of calculus through intuitive explanations and real-world applications. This comprehensive guide will transform your understanding...
                                    </p>
                                </div>
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <span>5 min read</span>
                                    <span>2.1k views</span>
                                </div>
                                <div class="flex space-x-2">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Mathematics</span>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Education</span>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -top-4 -right-4 w-full h-full bg-gradient-to-r from-blue-400 to-indigo-400 rounded-2xl -z-10"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">
                        Powerful Features for Modern Learning
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Everything you need to create, share, and discover educational content in one comprehensive platform.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div v-for="(feature, index) in features" :key="index" class="group p-8 bg-gray-50 rounded-2xl hover:bg-white hover:shadow-xl transition-all duration-300 border border-gray-100">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center text-white mb-6 group-hover:scale-110 transition-transform duration-300">
                            <!-- Book Icon -->
                            <svg v-if="feature.icon === 'book'" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <!-- Users Icon -->
                            <svg v-else-if="feature.icon === 'users'" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                            </svg>
                            <!-- Zap Icon -->
                            <svg v-else-if="feature.icon === 'zap'" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <!-- Award Icon -->
                            <svg v-else-if="feature.icon === 'award'" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">{{ feature.title }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ feature.description }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-20 bg-gradient-to-br from-blue-50 to-indigo-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div class="space-y-8">
                        <div class="space-y-4">
                            <h2 class="text-4xl font-bold text-gray-900">
                                Empowering Education Through Community
                            </h2>
                            <p class="text-lg text-gray-600 leading-relaxed">
                                EduCommunity was born from the belief that knowledge grows when shared. Our platform brings together passionate educators, curious students, and lifelong learners to create a thriving ecosystem of educational content.
                            </p>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-gray-700">Expert-curated educational content</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-gray-700">Interactive learning experiences</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-gray-700">Global community of learners</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-gray-700">Personalized learning paths</span>
                            </div>
                        </div>

                        <button @click="scrollToSection('testimonials')" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-8 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                            Learn More About Us
                        </button>
                    </div>

                    <div class="relative">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-4">
                                <div class="bg-white p-6 rounded-xl shadow-lg">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-gray-900 mb-2">Quality Content</h4>
                                    <p class="text-sm text-gray-600">Peer-reviewed articles and tutorials</p>
                                </div>
                                <div class="bg-white p-6 rounded-xl shadow-lg">
                                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-gray-900 mb-2">Active Community</h4>
                                    <p class="text-sm text-gray-600">Engage with fellow learners</p>
                                </div>
                            </div>
                            <div class="space-y-4 mt-8">
                                <div class="bg-white p-6 rounded-xl shadow-lg">
                                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-gray-900 mb-2">Recognition</h4>
                                    <p class="text-sm text-gray-600">Build your reputation</p>
                                </div>
                                <div class="bg-white p-6 rounded-xl shadow-lg">
                                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-gray-900 mb-2">Innovation</h4>
                                    <p class="text-sm text-gray-600">Cutting-edge learning tools</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section id="testimonials" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">
                        What Our Community Says
                    </h2>
                    <p class="text-xl text-gray-600">
                        Join thousands of satisfied learners and educators who trust EduCommunity
                    </p>
                </div>

                <div class="relative max-w-4xl mx-auto">
                    <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
                        <div class="text-center">
                            <div class="flex justify-center mb-6">
                                <svg v-for="n in testimonials[currentSlide].rating" :key="n" class="w-6 h-6 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                            <blockquote class="text-xl md:text-2xl text-gray-700 leading-relaxed mb-8">
                                "{{ testimonials[currentSlide].content }}"
                            </blockquote>
                            <div class="flex items-center justify-center space-x-4">
                                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-lg">
                                        {{ testimonials[currentSlide].name.split(' ').map(n => n[0]).join('') }}
                                    </span>
                                </div>
                                <div class="text-left">
                                    <div class="font-bold text-gray-900">{{ testimonials[currentSlide].name }}</div>
                                    <div class="text-gray-600">{{ testimonials[currentSlide].role }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial Navigation -->
                    <div class="flex justify-center space-x-2 mt-8">
                        <button
                            v-for="(testimonial, index) in testimonials"
                            :key="index"
                            @click="currentSlide = index"
                            :class="[
                                'w-3 h-3 rounded-full transition-colors duration-200',
                                index === currentSlide ? 'bg-blue-600' : 'bg-gray-300'
                            ]"
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-r from-blue-600 to-indigo-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="max-w-3xl mx-auto">
                    <h2 class="text-4xl font-bold text-white mb-6">
                        Ready to Transform Your Learning Experience?
                    </h2>
                    <p class="text-xl text-blue-100 mb-8">
                        Join EduCommunity today and become part of a global movement towards accessible, high-quality education for everyone.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button @click="goToLogin" class="bg-white text-blue-600 hover:bg-gray-100 font-semibold py-4 px-8 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                            Join the Community
                        </button>
                        <button @click="goToBlog" class="border-2 border-white text-white hover:bg-white hover:text-blue-600 font-semibold py-4 px-8 rounded-xl transition-all duration-200">
                            Explore Articles
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-4 gap-8 mb-8">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">EduCommunity</h3>
                                <p class="text-sm text-gray-400">Knowledge Sharing Platform</p>
                            </div>
                        </div>
                        <p class="text-gray-400">
                            Empowering minds through shared knowledge and collaborative learning.
                        </p>
                    </div>

                    <div>
                        <h4 class="font-bold mb-4">Platform</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><button @click="goToBlog" class="hover:text-white transition-colors">Browse Articles</button></li>
                            <li><button @click="goToLogin" class="hover:text-white transition-colors">Create Content</button></li>
                            <li><button @click="goToLogin" class="hover:text-white transition-colors">Join Community</button></li>
                            <li><a href="#" class="hover:text-white transition-colors">Mobile App</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold mb-4">Resources</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Guidelines</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">API Docs</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold mb-4">Company</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors">About Us</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Privacy</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Terms</a></li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                    <p>© 2025 EduCommunity. Empowering minds through shared knowledge.</p>
                </div>
            </div>
        </footer>
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

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.float-animation {
    animation: float 6s ease-in-out infinite;
}

.gradient-text {
    background: linear-gradient(135deg, #3b82f6, #6366f1);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>