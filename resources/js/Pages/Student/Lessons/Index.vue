<script setup>
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3'
import StudentLayout from '@/Layouts/StudentLayout.vue'

const props = defineProps({
    module: {
        type: Object,
        required: true,
        default: () => ({
            title: 'جاري التحميل...',
            lessons: []
        })
    },
    lessons: {
        type: Array,
        default: () => []
    }
});
</script>

<template>
    <StudentLayout>
        <template #header>
            <div class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-blue-50 to-white">
                <h2 class="text-2xl font-bold text-gray-800">
                    {{ module?.title || 'جاري التحميل...' }} - الدروس
                </h2>
                <Link :href="route('student.modules')" 
                      class="transition-all duration-300 px-4 py-2 rounded-full border-2 border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white">
                    العودة إلى الوحدات
                </Link>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-6xl px-4">
                <div class="grid gap-6">
                    <div v-for="lesson in lessons" :key="lesson.id" 
                         class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <div class="p-8">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-6">
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ lesson.title }}</h3>
                                    <p class="text-gray-600 leading-relaxed">{{ lesson.explanation }}</p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span v-if="lesson.user_progress?.lesson_completed" 
                                          class="text-green-500">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <Link :href="route('student.lesson.show', lesson.id)" 
                                          class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-full hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-md hover:shadow-lg">
                                        ابدأ الدرس
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </Link>
                                </div>
                            </div>
                            
                            <div v-if="lesson.audio_resources?.length" class="mt-6">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4">الموارد الصوتية:</h4>
                                <div class="space-y-4">
                                    <div v-for="audio in lesson.audio_resources" :key="audio.id"
                                         class="bg-gray-50 rounded-lg p-4">
                                        <audio controls class="w-full">
                                            <source :src="audio.file_path" type="audio/mpeg">
                                            متصفحك لا يدعم عنصر الصوت.
                                        </audio>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StudentLayout>
</template>