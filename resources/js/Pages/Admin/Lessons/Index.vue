<template>
    <AdminLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Manage Lessons
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Lesson Creation Form -->
                <div class="p-6 mb-6 bg-white shadow-sm sm:rounded-lg">
                    <form @submit.prevent="createLesson" enctype="multipart/form-data">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <InputLabel for="module" value="Module" />
                                <select v-model="form.module_id" 
                                        class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select Module</option>
                                    <option v-for="module in modules" 
                                            :key="module.id" 
                                            :value="module.id">
                                        {{ module.title }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <InputLabel for="title" value="Title" />
                                <TextInput id="title" 
                                          v-model="form.title" 
                                          type="text" 
                                          class="block w-full mt-1" 
                                          required />
                            </div>
                            <div class="md:col-span-2">
                                <InputLabel for="content" value="Content" />
                                <TextArea id="content" 
                                         v-model="form.content" 
                                         class="block w-full mt-1" 
                                         rows="6" 
                                         required />
                            </div>
                            <div class="md:col-span-2">
                                <InputLabel for="explanation" value="Explanation" />
                                <TextArea id="explanation" 
                                         v-model="form.explanation" 
                                         class="block w-full mt-1" 
                                         rows="4" 
                                         required />
                            </div>
                            <div>
                                <InputLabel for="order" value="Order" />
                                <TextInput id="order" 
                                          v-model="form.order" 
                                          type="number" 
                                          class="block w-full mt-1" 
                                          required />
                            </div>
                            <div>
                                <InputLabel for="audio" value="Audio File" />
                                <input type="file" 
                                       @change="handleAudioUpload" 
                                       accept="audio/*" 
                                       class="block w-full mt-1" />
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton :disabled="form.processing">
                                Create Lesson
                            </PrimaryButton>
                        </div>
                    </form>
                </div>

                <!-- Lessons List -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div v-for="lesson in lessons" :key="lesson.id" 
                             class="mb-6 p-4 border rounded">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold">{{ lesson.title }}</h3>
                                    <p class="text-sm text-gray-600">
                                        Module: {{ lesson.module.title }}
                                    </p>
                                </div>
                                <div class="flex space-x-2">
                                    <Link :href="route('admin.quizzes.create', { lesson: lesson.id })" 
                                          class="px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-700">
                                        Add Quiz
                                    </Link>
                                    <button @click="editLesson(lesson)" 
                                            class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                        Edit
                                    </button>
                                    <button @click="deleteLesson(lesson.id)" 
                                            class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700">
                                        Delete
                                    </button>
                                </div>
                            </div>
                            <div class="mt-4">
                                <h4 class="font-medium">Audio Resources:</h4>
                                <div class="mt-2 space-y-2">
                                    <div v-for="audio in lesson.audio_resources" 
                                         :key="audio.id" 
                                         class="flex items-center justify-between">
                                        <audio controls class="w-64">
                                            <source :src="audio.file_path" type="audio/mpeg">
                                        </audio>
                                        <button @click="deleteAudio(audio.id)" 
                                                class="text-red-600 hover:text-red-800">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    lessons: Array,
    modules: Array
})

const form = ref({
    module_id: '',
    title: '',
    content: '',
    explanation: '',
    order: 0,
    audio: null
})

const handleAudioUpload = (event) => {
    form.value.audio = event.target.files[0]
}

const createLesson = () => {
    router.post(route('admin.lessons.store'), form.value, {
        onSuccess: () => {
            form.value = {
                module_id: '',
                title: '',
                content: '',
                explanation: '',
                order: 0,
                audio: null
            }
        }
    })
}

const deleteLesson = (id) => {
    if (confirm('Are you sure you want to delete this lesson?')) {
        router.delete(route('admin.lessons.destroy', id))
    }
}

const deleteAudio = (id) => {
    if (confirm('Are you sure you want to delete this audio?')) {
        router.delete(route('admin.audio.destroy', id))
    }
}
</script>