<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trunodjoyo Class - {{ Auth::user()->role == 'dosen' ? 'Panel Dosen' : 'Portal Mahasiswa' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('images/Logo-utm.png') }}">
    </link>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #1e293b;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }
    </style>

</head>

<body class="bg-slate-900 text-white font-sans antialiased overflow-x-hidden">

    @php
    $user = Auth::user();
    $isDosen = $user->role == 'dosen';
    $themeText = 'text-amber-400';
    $themeBg = 'bg-amber-400';
    $themeBorder = 'border-amber-400/20';
    $headerAvatar = $user->avatar ? route('profile.avatar', $user->id) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=FBBF24&color=0F172A&size=128&bold=true';
    $studentLevel = min(5, intdiv(max(0, min(500, (int) $user->exp)), 100) + 1);
    $studentFrameImage = asset('images/lv'.$studentLevel.'.png');

    $sidebarClassrooms = $isDosen ? $user->taughtClassrooms : $user->joinedClassrooms;
    $currentPath = Request::path();
    $defaultHeader = 'Beranda';
    if ($currentPath == '/' || $currentPath == 'kelas') {
    $defaultHeader = 'Dashboard Utama';
    } elseif ($currentPath == 'tugas') {
    $defaultHeader = 'Daftar Tugas';
    } elseif ($currentPath == 'profile') {
    $defaultHeader = 'Profil Pengguna';
    }
    @endphp

    {{-- HEADER --}}
    <header class="fixed top-0 left-0 right-0 h-16 bg-slate-800 border-b border-slate-700 flex items-center justify-between px-6 z-50 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 flex items-center justify-center p-0.5">
                <img src="{{ asset('images/Logo-utm.png') }}" alt="UTM" class="w-full h-full object-contain">
            </div>
            <span class="text-xl font-bold {{ $themeText }} tracking-tighter hidden sm:block">
                Trunodjoyo <span class="text-white">Classroom</span>
            </span>
        </div>

        <div class="flex items-center gap-4">
            {{-- HEADER TITLE DINAMIS --}}
            <div class="hidden md:block text-slate-400 text-sm font-medium mr-4">
                @hasSection('header_title')
                @yield('header_title')
                @else
                {{ $defaultHeader }}
                @endif
            </div>

            <div class="flex items-center gap-4">
                <button onclick="openModal()" class="{{ $themeBg }} text-slate-900 px-4 py-2 rounded-xl font-black hover:opacity-90 transition-all text-xs uppercase tracking-wider shadow-lg flex items-center gap-2">
                    <span>{{ $isDosen ? 'Buat Kelas' : 'Gabung Kelas' }}</span>
                </button>
                @if($isDosen)
                    <a href="{{ route('profile.show') }}" class="hidden md:flex items-center gap-4 rounded-full border border-slate-600 bg-black/40 px-4 py-2 hover:border-slate-500 transition-all">
                        <img src="{{ asset('images/dosen.png') }}" alt="Dosen" class="h-10 w-auto object-contain rounded-lg bg-white/90 px-2 py-1">
                        <div class="w-12 h-12 rounded-full border-2 border-slate-300 overflow-hidden">
                            <img src="{{ $headerAvatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        </div>
                    </a>
                @else
                    <a href="{{ route('profile.show') }}" class="flex items-center gap-3 hover:bg-slate-700/50 p-2 rounded-xl transition-all cursor-pointer">
                        <div class="relative w-11 h-11">
                            <img src="{{ $headerAvatar }}" alt="{{ $user->name }}" class="w-11 h-11 rounded-full object-cover relative z-[1]">
                            <img src="{{ $studentFrameImage }}" alt="Frame Level {{ $studentLevel }}" class="absolute inset-0 w-11 h-11 object-contain scale-[1.2] pointer-events-none z-[2]">
                        </div>
                        <div class="hidden sm:block overflow-hidden">
                            <p class="text-sm font-bold text-white leading-none truncate">{{ $user->name }}</p>
                            <p class="text-slate-500 text-xs italic">{{ ucfirst($user->role) }}</p>
                        </div>
                        <p class="hidden xl:block text-[9px] text-amber-400 uppercase tracking-widest font-mono">Lihat Profil</p>
                    </a>
                @endif
            </div>
        </div>
    </header>

    {{-- SIDEBAR --}}
    <aside class="fixed top-16 left-0 bottom-0 w-64 bg-slate-800 border-r border-slate-700 flex flex-col z-40 hidden md:flex">
        <nav class="flex-1 overflow-y-auto py-6 custom-scrollbar">
            <div class="px-6 mb-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Menu Utama</div>
            <ul class="space-y-1 px-3">
                <li>
<li>
                    <a href="/kelas" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::is('/') || Request::is('kelas') ? 'bg-slate-900/50 ' . $themeText . ' font-bold border border-slate-700' : 'text-slate-400 hover:bg-slate-700 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                </li>

                {{-- TAMBAHKAN @if DI SINI --}}
                @if(!$isDosen)
                <li>
                    <a href="/tugas" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::is('tugas') ? 'bg-slate-900/50 ' . $themeText . ' font-bold border border-slate-700' : 'text-slate-400 hover:bg-slate-700 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Daftar Tugas
                    </a>
                </li>
                @endif
                {{-- AKHIR @if --}}

            </ul>

            <div class="px-6 mt-8 mb-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Mata Kuliah Anda</div>
            <ul class="space-y-1 px-3">
                @if($sidebarClassrooms && $sidebarClassrooms->count() > 0)
                @foreach($sidebarClassrooms as $sidebarKelas)
                <li>
                    <a href="/kelas/{{ $sidebarKelas->id }}"
                        class="flex items-center gap-3 px-4 py-2 rounded-xl text-xs transition-all group 
               {{ Request::is('kelas/'.$sidebarKelas->id) ? 'bg-amber-400/10 ' . $themeText . ' font-bold border border-amber-400/20' : 'text-slate-400 hover:bg-slate-700/50 hover:text-white' }}">

                        {{-- Indikator Bulat --}}
                        <div class="w-2 h-2 rounded-full transition-all 
                    {{ Request::is('kelas/'.$sidebarKelas->id) ? 'bg-amber-400 shadow-[0_0_8px_rgba(251,191,36,0.5)]' : 'bg-slate-600 group-hover:bg-amber-400' }}">
                        </div>

                        <span class="truncate">{{ $sidebarKelas->name }}</span>
                    </a>
                </li>
                @endforeach
                @else
                <li class="px-4 py-2 text-[10px] text-slate-600 italic">Belum ada kelas.</li>
                @endif
            </ul>
        </nav>
    </aside>

    <main class="md:ml-64 pt-16 min-h-screen">
        <div class="p-6 md:p-10">
            @yield('content')
        </div>
    </main>

    <div id="actionModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-md transition-all">
        <div class="bg-slate-800 border border-slate-700 w-full max-w-md rounded-3xl shadow-2xl overflow-hidden" id="modalContent">
            <div class="p-6 border-b border-slate-700 flex justify-between items-center {{ $themeText }}">
                <h3 class="text-xl font-black uppercase tracking-tight">{{ $isDosen ? 'Buat Kelas Baru' : 'Gabung Kelas' }}</h3>
                <button onclick="closeModal()" class="text-slate-500 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            @if($isDosen)
            <form action="{{ route('kelas.store') }}" method="POST" class="p-8 space-y-5">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Nama Mata Kuliah</label>
                    <input type="text" name="name" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-5 py-3 text-sm text-white focus:border-amber-400 outline-none transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Ruangan / Seksi</label>
                    <input type="text" name="section" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-5 py-3 text-sm text-white focus:border-amber-400 outline-none transition-all">
                </div>
                <button type="submit" class="w-full bg-amber-400 text-slate-900 py-4 rounded-xl font-black text-xs uppercase tracking-[0.2em] shadow-lg hover:bg-amber-500 transition-all mt-4">Buat Kelas</button>
            </form>
            @else
            <form action="{{ route('kelas.storeJoin') }}" method="POST" class="p-8 space-y-5">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Kode Kelas</label>
                    <input type="text" name="code" required placeholder="Masukkan 6 digit kode kelas" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-5 py-3 text-sm text-white focus:border-amber-400 outline-none transition-all uppercase">
                </div>
                <button type="submit" class="w-full bg-amber-400 text-slate-900 py-4 rounded-xl font-black text-xs uppercase tracking-[0.2em] shadow-lg hover:bg-amber-500 transition-all mt-4">Gabung Kelas</button>
            </form>
            @endif
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('actionModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('actionModal').classList.add('hidden');
        }
    </script>
</body>

</html>