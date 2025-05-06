<template>
    <StudentLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-primary-800">
                    وحدات التجويد
                </h2>
                <div class="text-sm text-gray-500">
                    {{ modules?.length || 0 }} وحدة متاحة
                </div>
            </div>
        </template>

        <div class="py-12 bg-gray-50">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div v-if="modules && modules.length > 0" 
                     class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <div v-for="module in modules" :key="module.id" 
                         class="group relative bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="absolute top-0 right-0 w-full h-1 bg-gradient-to-l from-primary-500 to-primary-600"></div>
                        <Link :href="route('student.modules.show', module.id)" 
                              class="block p-8">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition-colors">
                                        {{ module.title }}
                                    </h3>
                                    <p class="text-gray-600 leading-relaxed">
                                        {{ module.description }}
                                    </p>
                                </div>
                                <div class="ml-4">
                                    <div class="w-12 h-12 rounded-full bg-primary-50 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 space-y-4">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="font-medium text-gray-700">
                                        {{ module.lessons.length }} درس
                                    </span>
                                    <span class="text-primary-600 font-medium">
                                        {{ calculateProgress(module) }}% مكتمل
                                    </span>
                                </div>
                                <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-l from-primary-500 to-primary-600 rounded-full transition-all duration-300"
                                         :style="{ width: calculateProgress(module) + '%' }">
                                    </div>
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>
                
                <div v-else class="text-center py-16">
                    <div class="bg-white rounded-2xl shadow-md p-8 max-w-lg mx-auto">
                        <div class="w-20 h-20 bg-primary-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">لا توجد وحدات متاحة حالياً</h3>
                        <p class="text-gray-600">سيتم إضافة وحدات تعليمية جديدة قريباً</p>
                    </div>
                </div>
            </div>
        </div>
    </StudentLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import StudentLayout from '@/Layouts/StudentLayout.vue'

const props = defineProps({
    modules: Array
})

const calculateProgress = (module) => {
    if (!module.lessons.length) return 0
    const completedLessons = module.lessons.filter(lesson => 
        lesson.user_progress && lesson.user_progress.lesson_completed
    ).length
    return Math.round((completedLessons / module.lessons.length) * 100)
}
</script>

<style>
.text-primary-600 { color: #2563eb; }
.text-primary-800 { color: #1e40af; }
.bg-primary-50 { background-color: #eff6ff; }
.bg-primary-500 { background-color: #3b82f6; }
.bg-primary-600 { background-color: #2563eb; }

.group:hover .group-hover\:text-primary-600 {
    color: #2563eb;
}

.from-primary-500 { --tw-gradient-from: #3b82f6; }
.to-primary-600 { --tw-gradient-to: #2563eb; }
</style>