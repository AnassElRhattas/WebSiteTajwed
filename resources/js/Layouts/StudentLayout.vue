<template>
    <div dir="rtl" class="min-h-screen bg-gray-100 ">
        <LoadingOverlay :show="isLoading" message="جارٍ تسجيل الخروج..." />
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <Link :href="route('student.dashboard')">
                            <ApplicationLogo class="block h-9 w-auto" />
                            </Link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden sm:flex sm:mr-10 items-center">
                            <NavLink :href="route('student.dashboard')" :active="route().current('student.dashboard')"
                                class="px-4 py-2 mx-2 transition-all duration-300 hover:text-blue-600">
                                الرئيسية
                            </NavLink>
                            <NavLink :href="route('student.modules')" :active="route().current('student.modules')"
                                class="px-4 py-2 mx-2 transition-all duration-300 hover:text-blue-600">
                                الوحدات
                            </NavLink>
                            <NavLink :href="route('student.progress')" :active="route().current('student.progress')"
                                class="px-4 py-2 mx-2 transition-all duration-300 hover:text-blue-600">
                                التقدم الدراسي
                            </NavLink>
                            <NavLink :href="route('student.achievements')"
                                :active="route().current('student.achievements')"
                                class="px-4 py-2 mx-2 transition-all duration-300 hover:text-blue-600">
                                الإنجازات
                            </NavLink>
                        </div>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:mr-6">
                        <!-- Notifications -->
                        <div class="ml-4">
                            <button class="relative p-1 text-gray-400 hover:text-gray-500">
                                <span class="sr-only">عرض الإشعارات</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span v-if="unreadNotifications"
                                    class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400"></span>
                            </button>
                        </div>

                        <!-- User Menu -->
                        <div class="mr-3 relative">
                            <Dropdown align="left" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                            {{ $page.props.auth.user.name }}
                                            <svg class="mr-2 -ml-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <DropdownLink :href="route('student.edit')">
                                        حسابي
                                    </DropdownLink>
                                    <DropdownLink :href="route('student.settings')">
                                        الإعدادات
                                    </DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button">
                                        تسجيل الخروج
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="-ml-2 flex items-center sm:hidden">
                        <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path
                                    :class="{ 'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path
                                    :class="{ 'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }"
                class="sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <ResponsiveNavLink :href="route('student.dashboard')"
                        :active="route().current('student.dashboard')">
                        الرئيسية
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('student.modules')" :active="route().current('student.modules')">
                        الوحدات
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('student.progress')" :active="route().current('student.progress')">
                        التقدم الدراسي
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('student.achievements')"
                        :active="route().current('student.achievements')">
                        الإنجازات
                    </ResponsiveNavLink>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user.name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('student.edit')">
                            حسابي
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('student.settings')">
                            الإعدادات
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('logout')" method="post" as="button" @click="handleLogout">
                            تسجيل الخروج
                        </ResponsiveNavLink>
                    </div>
                </div>
            </div>
        </nav>

        <header class="bg-white shadow" v-if="$slots.header">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <main>
            <slot />
        </main>
    </div>
</template>


<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import LoadingOverlay from '@/Components/LoadingOverlay.vue'

const isLoading = ref(false)

const handleLogout = () => {
    isLoading.value = true
    router.post(route('logout'), {}, {
        preserveScroll: true,
        onBefore: () => {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            if (!token) {
                console.error('CSRF token not found')
                return false // annule la requête
            }
            return true // continue la requête si tout va bien
        },

        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        },
        onSuccess: () => {
            window.location.href = route('login')
        },
        onError: (errors) => {
            console.error('Logout failed:', errors)
        },
        onFinish: () => {
            isLoading.value = false
        }
    })
}
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'
import NavLink from '@/Components/NavLink.vue'
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'

const showingNavigationDropdown = ref(false)
const unreadNotifications = ref(false)
</script>