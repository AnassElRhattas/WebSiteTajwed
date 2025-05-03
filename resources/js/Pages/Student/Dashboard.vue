<template>
    <StudentLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                My Learning Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Progress Overview -->
                <div class="mb-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Overall Progress</h3>
                        <div v-if="totalLessons > 0">
                            <div class="w-full h-4 bg-gray-200 rounded-full">
                                <div class="h-full bg-green-500 rounded-full"
                                     :style="{ width: `${overallProgress}%` }">
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-600">
                                {{ completedLessons }} of {{ totalLessons }} lessons completed
                            </p>
                        </div>
                        <div v-else class="text-center py-4">
                            <p class="text-gray-600">Start your learning journey by exploring our modules!</p>
                            <Link :href="route('student.modules')"
                                  class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Browse Modules
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Current Module -->
                <div class="mb-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Current Module</h3>
                        <div v-if="currentModule" class="space-y-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="text-xl font-semibold">{{ currentModule.title }}</h4>
                                    <p class="text-gray-600">{{ currentModule.description }}</p>
                                </div>
                                <Link :href="route('student.lessons', currentModule.id)"
                                      class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    Continue Learning
                                </Link>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm text-gray-600 mb-2">Module Progress</p>
                                <div class="w-full h-2 bg-gray-200 rounded-full">
                                    <div class="h-full bg-blue-500 rounded-full"
                                         :style="{ width: `${currentModuleProgress}%` }">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-center py-8">
                            <p class="text-gray-600">No module in progress</p>
                            <Link :href="route('student.modules')"
                                  class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Start Learning
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Recent Achievements and Quiz Results Grid -->
                <div class="grid gap-6 md:grid-cols-2">
                    <!-- Recent Achievements -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Achievements</h3>
                            <div v-if="recentAchievements && recentAchievements.length > 0" class="space-y-4">
                                <div v-for="achievement in recentAchievements" :key="achievement.id"
                                     class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <div class="p-2 mr-4 bg-yellow-100 rounded-full">
                                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" 
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ achievement.title }}</p>
                                        <p class="text-sm text-gray-600">{{ achievement.description }}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="mt-4 text-gray-600">Complete lessons and quizzes to earn achievements!</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Results -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Quiz Results</h3>
                            <div v-if="quizResults && quizResults.length > 0" class="space-y-4">
                                <div v-for="result in quizResults" :key="result.id"
                                     class="p-3 bg-gray-50 rounded-lg">
                                    <div class="flex justify-between items-center">
                                        <h4 class="font-medium text-gray-900">{{ result.quiz_title }}</h4>
                                        <span :class="[
                                            'px-2 py-1 rounded-full text-sm',
                                            result.passed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                                        ]">
                                            {{ result.score }}%
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">{{ result.completed_at }}</p>
                                </div>
                            </div>
                            <div v-else class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <p class="mt-4 text-gray-600">Take quizzes to see your results here!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StudentLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import StudentLayout from '@/Layouts/StudentLayout.vue'

defineProps({
    overallProgress: Number,
    completedLessons: Number,
    totalLessons: Number,
    currentModule: Object,
    currentModuleProgress: Number,
    recentAchievements: Array,
    quizResults: Array
})
</script>