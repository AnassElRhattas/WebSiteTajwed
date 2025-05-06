<script setup>
import { Head } from '@inertiajs/vue3';
import StudentLayout from '@/Layouts/StudentLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    module: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <Head :title="module.title" />

    <StudentLayout>
        <template #header>
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                    {{ module.title }}
                </h2>
                <Link :href="route('student.modules')" class="items-center px-4 py-2 border border-blue-600 text-blue-600 rounded-full hover:bg-blue-50 dark:hover:bg-blue-900 transition-all">
                    <span class="mr-2"> ← </span>
                    العودة إلى الوحدات
                </Link>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-8">
                        <div class="mb-8">
                            <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">{{ module.description }}</h3>
                        </div>

                        <div class="space-y-6">
                            <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100 border-b pb-4">الدروس المتاحة</h4>
                            
                            <div v-if="module.lessons && module.lessons.length > 0" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                                <div v-for="lesson in module.lessons" :key="lesson.id" 
                                    class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 transform hover:scale-105 transition-all duration-300 border border-gray-100 dark:border-gray-600">
                                    <div class="mb-6">
                                        <h5 class="text-xl font-bold mb-3 text-gray-900 dark:text-gray-100">{{ lesson.title }}</h5>
                                        <p class="text-gray-600 dark:text-gray-300">{{ lesson.description }}</p>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex flex-col space-y-2">
                                            <span v-if="lesson.completed" class="flex items-center text-green-500 font-medium">
                                                <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                مكتمل
                                            </span>
                                            <span class="text-gray-500 dark:text-gray-400 flex items-center">
                                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ lesson.duration }} دقيقة
                                            </span>
                                        </div>
                                        <Link 
                                            :href="route('student.lessons.show', [module.id, lesson.id])" 
                                            class="px-6 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transform hover:scale-105 transition-all duration-300 shadow-md">
                                            {{ lesson.completed ? 'مراجعة' : 'ابدأ الدرس' }}
                                        </Link>
                                    </div>
                                </div>
                            </div>
                            
                            <div v-else class="text-center py-12 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01"/>
                                </svg>
                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-lg">لا توجد دروس متاحة في هذا المسار حالياً</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StudentLayout>
</template>