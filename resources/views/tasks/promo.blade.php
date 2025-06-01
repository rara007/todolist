<x-guest-layout>
    <div class="relative w-full max-w-4xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden py-12 px-8 sm:px-16 md:px-24">
        {{-- Background utama putih di dalam kontainer --}}
        <div class="absolute inset-0 z-0"></div> 

        {{-- Bentuk abstrak/gelembung di latar belakang --}}
        <div class="absolute -top-16 -left-16 w-64 h-64 bg-[#C1D2E9] rounded-full mix-blend-multiply filter blur-xl opacity-70"></div>
        <div class="absolute -bottom-16 -right-16 w-80 h-80 bg-[#C1D2E9] rounded-full mix-blend-multiply filter blur-xl opacity-70"></div>
        <div class="absolute top-1/2 left-1/3 w-48 h-48 bg-[#C1D2E9] rounded-full mix-blend-multiply filter blur-xl opacity-70"></div>

        {{-- Konten Utama Promo --}}
        <div class="relative z-10 text-center py-10">
            {{-- Logo Laravel --}}
            <a href="{{ route('dashboard') }}" class="inline-block mb-10">
                <x-application-logo class="w-20 h-20 mx-auto text-gray-800" />
            </a>

            <h1 class="text-5xl font-extrabold text-gray-900 leading-tight mb-6">
                Organize Your Life, <br>One Task at a Time!
            </h1>
            <p class="text-xl text-gray-700 leading-relaxed mb-10 max-w-xl mx-auto">
                Seamlessly manage your daily tasks, set deadlines, and track your progress.
                Your ultimate To-Do List is just a click away.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-10 py-4 bg-[#376FB7] border border-transparent rounded-full font-bold text-lg text-white hover:bg-[#2F5E97] focus:outline-none focus:ring-2 focus:ring-[#376FB7] focus:ring-offset-2 transition duration-300 ease-in-out shadow-lg transform hover:scale-105">
                    Login
                </a>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-10 py-4 bg-white border border-[#376FB7] rounded-full font-bold text-lg text-[#376FB7] hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#376FB7] focus:ring-offset-2 transition duration-300 ease-in-out shadow-lg transform hover:scale-105">
                    Register
                </a>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="mt-8 text-gray-500 text-sm text-center">
        &copy; {{ date('Y') }} {{ config('Rara', 'Rara') }}. Made with taro and jasuke.
    </footer>
</x-guest-layout>