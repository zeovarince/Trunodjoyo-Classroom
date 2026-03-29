<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#0F172A]">
        <div class="w-full max-w-md bg-[#1E293B] rounded-lg shadow-lg p-8">
            <h1 class="text-2xl font-bold text-[#FBBF24] mb-6 text-center">
                Trunojoyo Classroom
            </h1>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 text-green-400">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-white font-medium mb-2">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-3 py-2 rounded border border-gray-600 bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#FBBF24]">
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-white font-medium mb-2">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-3 py-2 rounded border border-gray-600 bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#FBBF24]">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mb-4">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="rounded border-gray-600 bg-gray-800 text-[#FBBF24] focus:ring-[#FBBF24]">
                    <label for="remember_me" class="ml-2 text-sm text-gray-300">Ingat saya</label>
                </div>

                <div class="flex items-center justify-between">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-[#FBBF24] hover:underline" href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif

                    <button type="submit"
                        class="bg-[#FBBF24] text-black font-bold px-4 py-2 rounded hover:bg-yellow-500 transition">
                        Login
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <span class="text-gray-300">Belum punya akun?</span>
                <a href="{{ route('register') }}" class="text-[#FBBF24] hover:underline">Register</a>
            </div>
        </div>
    </div>
</x-guest-layout>