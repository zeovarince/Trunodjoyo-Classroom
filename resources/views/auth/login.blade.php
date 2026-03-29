<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Trunodjoyo Classroom</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
    tailwind.config = {
        theme: {
        extend: {
            colors: {
            'navy-main': '#0F172A',
            'slate-card': '#1E293B',
            'gold-primary': '#FBBF24',
            'slate-text': '#94A3B8',
            }
        }
        }
    }
    </script>
</head>
<body class="bg-navy-main min-h-screen flex items-center justify-center font-sans">
    
    <div class="bg-slate-card p-10 rounded-3xl shadow-2xl w-full max-w-lg border border-gray-800 transition-all duration-300 transform">
        <div class="flex justify-center mb-10">
            <img src="{{ asset('images/Logo-utm.png') }}" alt="Logo UTM" class="h-20 object-contain drop-shadow-md">
        </div>
        
        <h2 class="text-3xl font-extrabold text-center text-white mb-8 tracking-tight">Login to Classroom</h2>

        @if ($errors->any())
            <div class="bg-red-900/50 border-l-4 border-red-500 text-red-200 p-4 mb-6 rounded-r">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label class="block text-slate-text text-sm font-semibold mb-2.5" for="email">Email</label>
                <input class="w-full px-5 py-3.5 bg-navy-main border border-gray-700 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-gold-primary focus:border-transparent transition-all placeholder-gray-500" id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan email Anda">
            </div>
            
            <div class="mb-8">
                <label class="block text-slate-text text-sm font-semibold mb-2.5" for="password">Password</label>
                <input class="w-full px-5 py-3.5 bg-navy-main border border-gray-700 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-gold-primary focus:border-transparent transition-all placeholder-gray-500" id="password" type="password" name="password" required placeholder="••••••••">
            </div>
            
            <button class="w-full bg-gold-primary hover:bg-yellow-500 text-navy-main font-bold py-3 px-6 rounded-xl focus:outline-none focus:ring-4 focus:ring-yellow-700 transition-colors duration-300 text-lg" type="submit">
                Masuk
            </button>
        </form>
        
        <p class="text-center text-slate-text text-sm mt-8">
            Belum punya akun? <a href="{{ route('register') }}" class="text-gold-primary hover:text-yellow-300 font-semibold transition-colors">Daftar di sini</a>
        </p>
    </div>

</body>
</html>