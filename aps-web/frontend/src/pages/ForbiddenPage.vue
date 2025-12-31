<template>
    <div class="flex h-screen items-center bg-[#f0f4f8]">
        <div class="w-full bg-white shadow-lg rounded-lg max-w-2xl mx-auto p-8">
            <div class="flex items-center justify-center">
                <div
                    class="w-20 h-20 bg-red-500 rounded-full flex items-center justify-center"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-12 w-12 text-white"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10 0a10 10 0 100 20 10 10 0 000-20zM8.293 7.293a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L10 10.414l-2.293 2.293a1 1 0 01-1.414-1.414l4-4z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>
            </div>
            <div class="text-center mt-6">
                <h1 class="text-2xl font-semibold text-gray-800">
                    Oops! Access Denied
                </h1>
                <p class="text-gray-600 mt-2">
                    You don't have permission to access this page.
                </p>
            </div>
            <div class="mt-8 text-center">
                <router-link to="/">
                    <a class="text-blue-500 hover:underline"
                        >Go back to the homepage</a
                    >
                </router-link>
            </div>
        </div>
    </div>
</template>
