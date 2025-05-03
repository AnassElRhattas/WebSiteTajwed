<template>
    <AppLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ module.title }} - Lessons
                </h2>
                <Link :href="route('student.modules')" class="text-blue-600 hover:text-blue-800">
                    Back to Modules
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="space-y-6">
                    <div v-for="lesson in lessons" :key="lesson.id" 
                         class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-semibold">{{ lesson.title }}</h3>
                                    <p class="mt-2 text-gray-600">{{ lesson.explanation }}</p>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <span v-if="lesson.user_progress?.lesson_completed" 
                                          class="text-green-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <Link :href="route('student.lesson.show', lesson.id)" 
                                          class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                        Start Lesson
                                    </Link>
                                </div>
                            </div>
                            
                            <div v-if="lesson.audio_resources?.length" class="mt-4">
                                <h4 class="text-sm font-medium text-gray-700">Audio Resources:</h4>
                                <div class="mt-2 space-y-2">
                                    <div v-for="audio in lesson.audio_resources" :key="audio.id"
                                         class="flex items-center space-x-2">
                                        <audio controls class="w-full">
                                            <source :src="audio.file_path" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({
    module: Object,
    lessons: Array
})
</script>