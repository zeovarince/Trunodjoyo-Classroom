<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trunodjoyo Class - {{ Auth::user()->role == 'dosen' ? 'Panel Dosen' : 'Portal Mahasiswa' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #1e293b; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-900 text-white font-sans antialiased overflow-x-hidden">

    @php
        $user = Auth::user();
        $isDosen = $user->role == 'dosen';
        $themeText = 'text-amber-400';
        $themeBg = 'bg-amber-400';
        $themeBorder = 'border-amber-400/20';
    @endphp
    $notifications = \App\Models\Notification::where('user_id', auth()->id())
    ->latest()
    ->take(5)
    ->get();

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
            <button onclick="openModal()" class="{{ $themeBg }} text-slate-900 px-4 py-2 rounded-xl font-black hover:opacity-90 transition-all text-xs uppercase tracking-wider shadow-lg flex items-center gap-2">
                <span>{{ $isDosen ? 'Buat Kelas' : 'Gabung Kelas' }}</span>
            </button>
            <a href="/profile" class="w-9 h-9 rounded-xl border {{ $themeBorder }} overflow-hidden bg-slate-800">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0F172A&color=FBBF24&bold=true" class="w-full h-full">
            </a>
        </div>
    </header>

    {{-- SIDEBAR --}}
    <aside class="fixed top-16 left-0 bottom-0 w-64 bg-slate-800 border-r border-slate-700 flex flex-col z-40 hidden md:flex">
        <nav class="flex-1 overflow-y-auto py-6 custom-scrollbar">
            <div class="px-6 mb-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Menu Utama</div>
            <ul class="space-y-1 px-3">
                <li>
                    <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::is('/') ? 'bg-slate-900/50 ' . $themeText . ' font-bold border border-slate-700' : 'text-slate-400 hover:bg-slate-700 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>
                </li>
            </ul>

            <div class="px-6 mt-8 mb-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Akademik</div>
            <ul class="space-y-1 px-3">
                <li>
                    <a href="/tugas" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-700 hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5h6M9 9h6m-6 4h6M5 5l1 1 2-2M5 11l1 1 2-2M5 17l1 1 2-2"/></svg>
                        Daftar Tugas
                    </a>
                </li>
            </ul>

            {{-- BAGIAN BARU: DAFTAR MATA KULIAH DI SIDEBAR --}}
            <div class="px-6 mt-8 mb-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Mata Kuliah Anda</div>
            <ul class="space-y-1 px-3">
                @isset($classrooms)
                    @foreach($classrooms as $sidebarKelas)
                    <li>
                        <a href="/kelas/{{ $sidebarKelas->id }}" class="flex items-center gap-3 px-4 py-2 rounded-xl text-xs {{ Request::is('kelas/'.$sidebarKelas->id) ? $themeText . ' bg-amber-400/5 font-bold' : 'text-slate-400 hover:bg-slate-700/50 hover:text-white' }} transition-all group">
                            <div class="w-2 h-2 rounded-full {{ Request::is('kelas/'.$sidebarKelas->id) ? 'bg-amber-400 shadow-[0_0_8px_rgba(251,191,36,0.5)]' : 'bg-slate-600 group-hover:bg-slate-400' }}"></div>
                            <span class="truncate">{{ $sidebarKelas->name }}</span>
                        </a>
                    </li>
                    @endforeach
                @else
                    <li class="px-4 py-2 text-[10px] text-slate-600 italic">Buka Dashboard untuk memuat kelas</li>
                @endisset
            </ul>
        </nav>

        {{-- USER INFO BOTTOM --}}
        <div class="p-4 border-t border-slate-700 bg-slate-800/80">
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-900/50 border border-slate-700/50">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=FBBF24&color=0F172A&bold=true" class="w-8 h-8 rounded-lg">
                <div class="overflow-hidden">
                    <p class="text-[11px] font-black text-white truncate">{{ $user->name }}</p>
                    <p class="text-[9px] {{ $themeText }} font-bold uppercase tracking-tighter">Verified Lecturer</p>
                </div>
            </div>
        </div>
    </aside>

    <main class="md:ml-64 pt-16 min-h-screen">
        <div class="p-6 md:p-10">
            @yield('content')
        </div>
    </main>

    {{-- MODAL BUAT KELAS --}}
    <div id="actionModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-md transition-all">
        <div class="bg-slate-800 border border-slate-700 w-full max-w-md rounded-3xl shadow-2xl overflow-hidden transform scale-95 transition-transform duration-300" id="modalContent">
            <div class="p-6 border-b border-slate-700 flex justify-between items-center {{ $themeText }}">
                <h3 class="text-xl font-black uppercase tracking-tight">Buat Kelas Baru</h3>
                <button onclick="closeModal()" class="text-slate-500 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <form action="{{ route('kelas.store') }}" method="POST" class="p-8 space-y-5">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Nama Mata Kuliah</label>
                    <input type="text" name="name" required placeholder="Contoh: Pemrograman Web" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-5 py-3 text-sm text-white focus:border-amber-400 outline-none transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Ruangan / Seksi</label>
                    <input type="text" name="section" required placeholder="Contoh: Ruang A-301" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-5 py-3 text-sm text-white focus:border-amber-400 outline-none transition-all">
                </div>
                <button type="submit" class="w-full bg-amber-400 text-slate-900 py-4 rounded-xl font-black text-xs uppercase tracking-[0.2em] shadow-lg hover:bg-amber-500 transition-all mt-4">
                    Buat Kelas Sekarang
                </button>
            </form>
        </div>
    </div>

    <script>
        function openModal() { document.getElementById('actionModal').classList.remove('hidden'); }
        function closeModal() { document.getElementById('actionModal').classList.add('hidden'); }
    </script>
</body>
</html>