<template>
    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tajwid Modules
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div v-for="module in modules" :key="module.id" 
                         class="overflow-hidden bg-white shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                        <Link :href="route('student.lessons', module.id)" class="block p-6">
                            <h3 class="text-xl font-semibold text-gray-900">
                                {{ module.title }}
                            </h3>
                            <p class="mt-2 text-gray-600">
                                {{ module.description }}
                            </p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-sm text-gray-500">
                                    {{ module.lessons.length }} lessons
                                </span>
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-500 mr-2">
                                        Progress:
                                    </span>
                                    <div class="w-24 h-2 bg-gray-200 rounded-full">
                                        <div class="h-full bg-green-500 rounded-full"
                                             :style="{ width: calculateProgress(module) + '%' }">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

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