<template>
    <AppLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ lesson.title }}
                </h2>
                <Link :href="route('student.lessons', lesson.module.id)" 
                      class="text-blue-600 hover:text-blue-800">
                    Back to Lessons
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Lesson Content -->
                        <div class="prose max-w-none">
                            <div v-html="lesson.content"></div>
                        </div>

                        <!-- Audio Resources -->
                        <div v-if="lesson.audio_resources?.length" class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900">Practice Audio</h3>
                            <div class="mt-4 space-y-4">
                                <div v-for="audio in lesson.audio_resources" :key="audio.id"
                                     class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-700">{{ audio.title }}</h4>
                                    <audio controls class="mt-2 w-full">
                                        <source :src="audio.file_path" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                    <p v-if="audio.description" class="mt-2 text-sm text-gray-600">
                                        {{ audio.description }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-8 flex justify-between items-center">
                            <button @click="completeLesson" 
                                    :disabled="lesson.user_progress?.lesson_completed"
                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 
                                           disabled:opacity-50 disabled:cursor-not-allowed">
                                {{ lesson.user_progress?.lesson_completed ? 'Completed' : 'Mark as Complete' }}
                            </button>
                            
                            <Link v-if="lesson.quiz" 
                                  :href="route('student.quiz.show', lesson.quiz.id)"
                                  class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Take Quiz
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    lesson: Object
})

const completeLesson = () => {
    router.post(route('student.lesson.complete', props.lesson.id))
}
</script>