<template>
    <Transition
        enter-active-class="transition ease-out duration-200"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition ease-in duration-150"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-4 rounded-lg shadow-lg text-center">
                <div class="animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-gray-900 mx-auto"></div>
                <p class="mt-2 text-gray-700">{{ message }}</p>
            </div>
        </div>
    </Transition>
</template>

<script setup>
defineProps({
    show: {
        type: Boolean,
        default: false
    },
    message: {
        type: String,
        default: 'Loading...'
    }
});
</script>