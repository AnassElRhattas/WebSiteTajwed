<template>
    <AdminLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Create Quiz for {{ lesson.title }}
                </h2>
                <Link :href="route('admin.lessons.index')" 
                      class="text-blue-600 hover:text-blue-800">
                    Back to Lessons
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="createQuiz">
                            <!-- Quiz Details -->
                            <div class="mb-8">
                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div>
                                        <InputLabel for="title" value="Quiz Title" />
                                        <TextInput id="title" 
                                                  v-model="form.title" 
                                                  type="text" 
                                                  class="block w-full mt-1" 
                                                  required />
                                    </div>
                                    <div>
                                        <InputLabel for="passing_score" value="Passing Score (%)" />
                                        <TextInput id="passing_score" 
                                                  v-model="form.passing_score" 
                                                  type="number" 
                                                  min="0" 
                                                  max="100" 
                                                  class="block w-full mt-1" 
                                                  required />
                                    </div>
                                    <div class="md:col-span-2">
                                        <InputLabel for="description" value="Description" />
                                        <TextArea id="description" 
                                                 v-model="form.description" 
                                                 class="block w-full mt-1" 
                                                 rows="3" 
                                                 required />
                                    </div>
                                </div>
                            </div>

                            <!-- Questions -->
                            <div class="space-y-6">
                                <div v-for="(question, index) in form.questions" 
                                     :key="index" 
                                     class="p-4 border rounded-lg">
                                    <div class="flex justify-between items-start mb-4">
                                        <h3 class="text-lg font-medium">Question {{ index + 1 }}</h3>
                                        <button type="button" 
                                                @click="removeQuestion(index)"
                                                class="text-red-600 hover:text-red-800">
                                            Remove
                                        </button>
                                    </div>

                                    <div class="space-y-4">
                                        <div>
                                            <InputLabel :for="`question-${index}`" value="Question Text" />
                                            <TextArea :id="`question-${index}`"
                                                     v-model="question.question"
                                                     class="block w-full mt-1"
                                                     required />
                                        </div>

                                        <div>
                                            <InputLabel value="Options" />
                                            <div class="space-y-2">
                                                <div v-for="(option, optionIndex) in question.options" 
                                                     :key="optionIndex"
                                                     class="flex items-center space-x-2">
                                                    <TextInput v-model="question.options[optionIndex]"
                                                              class="block w-full"
                                                              required />
                                                    <button type="button"
                                                            @click="removeOption(index, optionIndex)"
                                                            class="text-red-600 hover:text-red-800">
                                                        ×
                                                    </button>
                                                </div>
                                            </div>
                                            <button type="button"
                                                    @click="addOption(index)"
                                                    class="mt-2 text-sm text-blue-600 hover:text-blue-800">
                                                Add Option
                                            </button>
                                        </div>

                                        <div>
                                            <InputLabel :for="`correct-${index}`" value="Correct Answer" />
                                            <select v-model="question.correct_answer"
                                                    :id="`correct-${index}`"
                                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                                                    required>
                                                <option value="">Select correct answer</option>
                                                <option v-for="option in question.options"
                                                        :key="option"
                                                        :value="option">
                                                    {{ option }}
                                                </option>
                                            </select>
                                        </div>

                                        <div>
                                            <InputLabel :for="`explanation-${index}`" value="Explanation" />
                                            <TextArea :id="`explanation-${index}`"
                                                     v-model="question.explanation"
                                                     class="block w-full mt-1" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-between">
                                <button type="button"
                                        @click="addQuestion"
                                        class="text-blue-600 hover:text-blue-800">
                                    Add Question
                                </button>
                                <PrimaryButton :disabled="form.processing">
                                    Create Quiz
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import TextArea from '@/Components/TextArea.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const props = defineProps({
    lesson: Object
})

const form = ref({
    title: '',
    description: '',
    passing_score: 70,
    questions: [
        {
            question: '',
            options: [''],
            correct_answer: '',
            explanation: '',
            points: 1
        }
    ]
})

const addQuestion = () => {
    form.value.questions.push({
        question: '',
        options: [''],
        correct_answer: '',
        explanation: '',
        points: 1
    })
}

const removeQuestion = (index) => {
    form.value.questions.splice(index, 1)
}

const addOption = (questionIndex) => {
    form.value.questions[questionIndex].options.push('')
}

const removeOption = (questionIndex, optionIndex) => {
    form.value.questions[questionIndex].options.splice(optionIndex, 1)
}

const createQuiz = () => {
    router.post(route('admin.quizzes.store'), {
        ...form.value,
        lesson_id: props.lesson.id
    }, {
        onSuccess: () => {
            router.visit(route('admin.lessons.index'))
        }
    })
}
</script>