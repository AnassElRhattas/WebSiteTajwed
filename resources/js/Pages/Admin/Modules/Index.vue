<template>
    <AdminLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Manage Modules
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Module Creation Form -->
                <div class="p-6 mb-6 bg-white shadow-sm sm:rounded-lg">
                    <form @submit.prevent="createModule">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <InputLabel for="title" value="Title" />
                                <TextInput
                                    id="title"
                                    v-model="form.title"
                                    type="text"
                                    class="block w-full mt-1"
                                    required
                                />
                            </div>
                            <div>
                                <InputLabel for="order" value="Order" />
                                <TextInput
                                    id="order"
                                    v-model="form.order"
                                    type="number"
                                    class="block w-full mt-1"
                                    required
                                />
                            </div>
                            <div class="md:col-span-2">
                                <InputLabel for="description" value="Description" />
                                <TextArea
                                    id="description"
                                    v-model="form.description"
                                    class="block w-full mt-1"
                                    required
                                />
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton :disabled="form.processing">
                                Create Module
                            </PrimaryButton>
                        </div>
                    </form>
                </div>

                <!-- Modules List -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div v-for="module in modules" :key="module.id" class="mb-6 p-4 border rounded">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold">{{ module.title }}</h3>
                                <div class="flex space-x-2">
                                    <PrimaryButton @click="editModule(module)">
                                        Edit
                                    </PrimaryButton>
                                    <DangerButton @click="deleteModule(module.id)">
                                        Delete
                                    </DangerButton>
                                </div>
                            </div>
                            <p class="mt-2 text-gray-600">{{ module.description }}</p>
                            <div class="mt-2 text-sm text-gray-500">
                                Order: {{ module.order }} | 
                                Status: {{ module.is_active ? 'Active' : 'Inactive' }}
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
import { useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import TextArea from '@/Components/TextArea.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'

const props = defineProps({
    modules: Array
})

const form = useForm({
    title: '',
    description: '',
    order: 0,
    is_active: true
})

const createModule = () => {
    form.post(route('admin.modules.store'), {
        onSuccess: () => form.reset()
    })
}

const deleteModule = (id) => {
    if (confirm('Are you sure you want to delete this module?')) {
        router.delete(route('admin.modules.destroy', id))
    }
}
</script>