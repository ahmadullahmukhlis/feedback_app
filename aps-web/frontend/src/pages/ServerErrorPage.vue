<template>
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-sm p-8 bg-white rounded-lg shadow-lg">
            <div class="text-center">
                <span class="text-4xl text-red-600 material-icons">error</span>
                <h1 class="text-4xl font-bold text-red-600">Server Down</h1>
                <p class="text-gray-600 text-xl mt-2">
                    We apologize for the inconvenience
                </p>
            </div>
            <div class="mt-8 text-center">
                <p class="text-gray-500">
                    Our server is currently experiencing some technical
                    difficulties.
                </p>
                <p class="text-gray-500">Please check back later.</p>
            </div>
            <div class="mt-6 text-center">
                <q-btn color="primary" to="/"> Go Home </q-btn>
            </div>
        </div>
    </div>
</template>
