<template>
    <div
        class="mx-auto bg-white max-w-md items-center rounded-xl gap-x-4 p-5 shadow-lg outline outline-black w-full"
    >
        <h2
            class="block font-sans font-bold text-2xl p-4 mx-auto text-center text-black"
        >
            AI-Blogger
        </h2>
        <form action="/login" method="post" class="space-y-5">
            <div class="px-3">
                <label
                    class="block mb-1.5 font-sans text-black font-medium text-shadow-md text-xl"
                    for="email"
                    >Email</label
                >
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="shadow-lg rounded-xl w-full border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:outline-none p-3"
                />
            </div>
            <div class="px-3">
                <label
                    class="block mb-1.5 font-sans text-black font-medium text-shadow-md text-xl"
                    for="password"
                    >Password</label
                >
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="shadow-lg rounded-xl w-full border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:outline-none p-3"
                />
            </div>
            <div class="flex items-center justify-between px-3">
                <label
                    class="flex items-center space-x-2 text-sm text-gray-600"
                >
                    <input type="checkbox" class="form-checkbox" />
                    <span>Remember me</span>
                </label>
                <a href="#" class="text-sm text-indigo-500 hover:underline"
                    >Forgot Password?</a
                >
            </div>
            <div class="px-3">
                <button
                    type="submit"
                    class="w-full bg-indigo-600 text-white py-2 px-4 rounded-xl hover:bg-indigo-700 transition duration-300"
                >
                    Login
                </button>
            </div>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            Don't have an account?
            <a href="/register" class="text-indigo-500 hover:underline"
                >Sign up</a
            >
        </p>
    </div>
</template>
