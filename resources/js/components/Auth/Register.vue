<template>
    <div
        class="mx-auto bg-white max-w-md items-center rounded-xl gap-x-4 p-5 shadow-lg outline outline-black w-full"
    >
        <h2 class="font-bold font-sans text-2xl text-center">AI-Blogger</h2>
        <form action="post">
            <div class="px-3">
                <label
                    class="block mb-1.5 font-sans text-black font-medium text-shadow-md text-xl"
                    for="name"
                    >Name</label
                >
                <input
                    type="name"
                    name="name"
                    id="name"
                    class="shadow-lg rounded-xl w-full border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:outline-none p-3"
                />
            </div>
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
                    >password</label
                >
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="shadow-lg rounded-xl w-full border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:outline-none p-3"
                />
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
    </div>
</template>
