<template>
    <div class="min-h-screen bg-gray-100">
        <div class="p-4 bg-white shadow">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ lesson.title }}
                </h2>
                <Link :href="route('student.modules.show', lesson.module.id)" class="text-blue-600 hover:text-blue-800">
                العودة إلى الدروس
                </Link>
            </div>
        </div>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Lesson Content -->
                        <div class="prose max-w-none">
                            <div v-html="lesson.content"></div>


                            <!-- Quran Verses Section -->
                            <div v-if="chapters.length" class="mt-12 p-6 bg-gray-100 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">آيات من القرآن الكريم</h3>
                                <div class="space-y-4">
                                    <div v-for="verse in chapters" :key="verse.id"
                                        class="bg-white p-4 shadow rounded text-right">
                                        <p class="text-2xl font-arabic leading-loose text-right"
                                            v-html="verse.text_uthmani_tajweed"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Audio Resources -->
                        <div v-if="lesson.audio_resources?.length" class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900">التسجيلات الصوتية</h3>
                            <div class="mt-4 space-y-4">
                                <div v-for="audio in lesson.audio_resources" :key="audio.id"
                                    class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-700">{{ audio.title }}</h4>
                                    <audio controls class="mt-2 w-full">
                                        <source :src="audio.file_path" type="audio/mpeg">
                                        متصفحك لا يدعم مشغل الصوت
                                    </audio>
                                    <p v-if="audio.description" class="mt-2 text-sm text-gray-600">
                                        {{ audio.description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Tajweed Legend Component -->
                        <div class="mt-6">
                            <TajweedRegles />
                        </div>

                        <!-- Actions -->
                        <div class="mt-8 flex justify-between items-center">
                            <button @click="completeLesson" :disabled="lesson.user_progress?.lesson_completed" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 
                                           disabled:opacity-50 disabled:cursor-not-allowed">
                                {{ lesson.user_progress?.lesson_completed ? 'تم إكمال الدرس' : 'إكمال الدرس' }}
                            </button>

                            <Link v-if="lesson.quiz" :href="route('student.quiz.show', lesson.quiz.id)"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            ابدأ الاختبار
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'
import '../../../../css/app.css'
import TajweedRegles from '../../../Components/TajwedRegles.vue'


const props = defineProps({
    lesson: Object
})

const chapters = ref([])
const apiError = ref(null)

const completeLesson = () => {
    router.post(route('student.lesson.complete', props.lesson.id))
}

// Appel API pour récupérer les chapitres du Coran
async function loadChapters() {
    const selectedVerseKeys = ['1:1', '2:13', '2:286']

    try {
        const response = await fetch('/chapters')
        const data = await response.json()
        console.log('Chapters API response:', data)

        if (data.verses) {
            // Filtrer les versets en fonction des verse_key souhaités
            const filteredVerses = data.verses.filter(v => selectedVerseKeys.includes(v.verse_key))
            chapters.value = filteredVerses
        } else {
            apiError.value = 'La réponse ne contient pas de versets.'
        }
    } catch (error) {
        console.error('Erreur lors du chargement des chapitres :', error)
        apiError.value = 'Impossible de charger les chapitres du Coran.'
    }
}



// Charger les chapitres au montage du composant
onMounted(() => {
    loadChapters()
})
</script>