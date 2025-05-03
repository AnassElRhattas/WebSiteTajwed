<template>
    <AdminLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Admin Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Statistics Cards -->
                <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 mr-4 bg-blue-100 rounded-full">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div>
                                <p class="mb-2 text-sm font-medium text-gray-600">Total Modules</p>
                                <p class="text-lg font-semibold text-gray-700">{{ stats.totalModules }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 mr-4 bg-green-100 rounded-full">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <p class="mb-2 text-sm font-medium text-gray-600">Total Lessons</p>
                                <p class="text-lg font-semibold text-gray-700">{{ stats.totalLessons }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 mr-4 bg-purple-100 rounded-full">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="mb-2 text-sm font-medium text-gray-600">Total Quizzes</p>
                                <p class="text-lg font-semibold text-gray-700">{{ stats.totalQuizzes }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 mr-4 bg-yellow-100 rounded-full">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="mb-2 text-sm font-medium text-gray-600">Total Students</p>
                                <p class="text-lg font-semibold text-gray-700">{{ stats.totalStudents }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
                        <div class="space-y-4">
                            <div v-for="activity in recentActivity" :key="activity.id" 
                                 class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="mr-4">
                                        <img :src="activity.user.avatar" 
                                             :alt="activity.user.name"
                                             class="h-10 w-10 rounded-full">
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ activity.user.name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ activity.description }}
                                        </p>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">
                                    {{ activity.created_at }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineProps({
    stats: {
        type: Object,
        required: true
    },
    recentActivity: {
        type: Array,
        required: true
    }
})
</script>