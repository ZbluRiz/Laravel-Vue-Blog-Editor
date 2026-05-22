<template>
  <div class="bg-white shadow rounded-xl p-4 mb-4 border">
    <h3 class="text-xl font-bold text-indigo-600">{{ post.title }}</h3>
    <p class="text-gray-600">{{ post.excerpt }}</p>
    <Link :href="`/post/${post.id}`" class="text-sm text-blue-500">Baca Selengkapnya</Link>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
defineProps(['post']);
</script>
