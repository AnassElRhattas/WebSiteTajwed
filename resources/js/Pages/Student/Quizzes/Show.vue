<template>
    <AppLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ quiz.title }}
                </h2>
                <Link :href="route('student.lesson.show', quiz.lesson.id)" 
                      class="text-blue-600 hover:text-blue-800">
                    Back to Lesson
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div v-if="!submitted">
                            <form @submit.prevent="submitQuiz">
                                <div class="space-y-8">
                                    <div v-for="question in quiz.questions" :key="question.id" 
                                         class="border-b pb-6">
                                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                                            {{ question.question }}
                                        </h3>
                                        <div class="space-y-4">
                                            <div v-for="option in question.options" :key="option"
                                                 class="flex items-center">
                                                <input type="radio" 
                                                       :id="`q${question.id}-${option}`"
                                                       :name="`question-${question.id}`"
                                                       :value="option"
                                                       v-model="answers[question.id]"
                                                       class="h-4 w-4 text-blue-600 border-gray-300"
                                                       required>
                                                <label :for="`q${question.id}-${option}`"
                                                       class="ml-3 block text-gray-700">
                                                    {{ option }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-8">
                                    <button type="submit" 
                                            class="w-full px-4 py-2 bg-blue-600 text-white rounded-md 
                                                   hover:bg-blue-700">
                                        Submit Quiz
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div v-else class="space-y-8">
                            <div class="text-center">
                                <h3 class="text-2xl font-bold text-gray-900">Quiz Results</h3>
                                <p class="mt-2 text-lg">
                                    Your score: {{ score }}%
                                </p>
                                <p class="mt-1 text-sm text-gray-600">
                                    Passing score: {{ quiz.passing_score }}%
                                </p>
                                <div class="mt-4">
                                    <span :class="[
                                        'px-4 py-2 rounded-full text-white',
                                        score >= quiz.passing_score ? 'bg-green-500' : 'bg-red-500'
                                    ]">
                                        {{ score >= quiz.passing_score ? 'Passed' : 'Failed' }}
                                    </span>
                                </div>
                            </div>

                            <Link :href="route('student.lesson.show', quiz.lesson.id)"
                                  class="block w-full text-center px-4 py-2 bg-gray-600 text-white 
                                         rounded-md hover:bg-gray-700">
                                Return to Lesson
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    quiz: Object,
    score: {
        type: Number,
        default: null
    }
})

const answers = ref({})
const submitted = ref(false)

const submitQuiz = () => {
    router.post(route('student.quiz.submit', props.quiz.id), {
        answers: answers.value
    }, {
        onSuccess: () => {
            submitted.value = true
        }
    })
}
</script>