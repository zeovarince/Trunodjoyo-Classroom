<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trunodjoyo Class - {{ auth()->user()->role == 'dosen' ? 'Panel Dosen' : 'Portal Mahasiswa' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #1e293b; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-900 text-white font-sans antialiased overflow-x-hidden">

    @php
        $user = auth()->user();
        $isDosen = $user->role == 'dosen';
        $themeColor = $isDosen ? 'rose-500' : 'amber-400';
        $themeBg = $isDosen ? 'bg-rose-500' : 'bg-amber-400';
        $themeText = $isDosen ? 'text-rose-500' : 'text-amber-400';
        $themeBorder = $isDosen ? 'border-rose-500/20' : 'border-amber-400/20';
    @endphp

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
            <div class="hidden md:block text-slate-500 text-[10px] uppercase font-black tracking-widest mr-4">
                @yield('header_title', 'Beranda')
            </div>

            <button onclick="openModal()" class="{{ $themeBg }} text-slate-900 px-4 py-2 rounded-xl font-black hover:opacity-90 transition-all text-xs uppercase tracking-wider shadow-lg flex items-center gap-2">
                @if($isDosen)
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                    <span>Buat Kelas</span>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" /></svg>
                    <span>Gabung Kelas</span>
                @endif
            </button>
            
            <a href="/profile" class="flex items-center gap-3 hover:bg-slate-700/50 p-1.5 rounded-2xl transition-all group">
                <div class="w-9 h-9 rounded-xl border {{ $themeBorder }} overflow-hidden bg-slate-800 group-hover:border-white transition-colors">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0F172A&color={{ str_replace('#', '', ($isDosen ? 'F43F5E' : 'FBBF24')) }}&bold=true" class="w-full h-full object-cover">
                </div>
            </a>
        </div>
    </header>

    <aside class="fixed top-16 left-0 bottom-0 w-64 bg-slate-800 border-r border-slate-700 flex flex-col z-40 hidden md:flex">
        <nav class="flex-1 overflow-y-auto py-6 custom-scrollbar">
            <div class="px-6 mb-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Menu Utama</div>
            <ul class="space-y-1 px-3">
                <li>
                    <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::is('/') ? 'bg-slate-900/50 ' . $themeText . ' font-bold shadow-inner border border-slate-700' : 'text-slate-400 hover:bg-slate-700 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="/tugas" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::is('tugas') ? 'bg-slate-900/50 ' . $themeText . ' font-bold shadow-inner border border-slate-700' : 'text-slate-400 hover:bg-slate-700 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        {{ $isDosen ? 'Koreksi Tugas' : 'Daftar Tugas' }}
                    </a>
                </li>
            </ul>

            <div class="px-6 mt-8 mb-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Akademik</div>
            <ul class="space-y-1 px-3">
                <li>
                    <a href="/anggota" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-700 hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        {{ $isDosen ? 'Daftar Mahasiswa' : 'Teman Sekelas' }}
                    </a>
                </li>
            </ul>
        </nav>

        <div class="p-4 border-t border-slate-700 bg-slate-800/80">
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-900/50 border border-slate-700/50 relative overflow-hidden group">
                <div class="absolute inset-0 {{ $themeBg }} opacity-0 group-hover:opacity-5 transition-opacity"></div>
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background={{ $isDosen ? 'F43F5E' : 'FBBF24' }}&color=0F172A&bold=true" class="w-10 h-10 rounded-xl shadow-lg">
                    <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 {{ $themeBg }} border-2 border-slate-800 rounded-full"></div>
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-black text-white truncate">{{ $user->name }}</p>
                    @if(!$isDosen)
                        <p class="text-[9px] {{ $themeText }} font-mono font-bold uppercase tracking-tighter">
                            LV.{{ floor($user->exp / 100) + 1 }} • {{ number_format($user->exp) }} XP
                        </p>
                    @else
                        <p class="text-[9px] text-rose-500 font-bold uppercase tracking-tighter">Verified Lecturer</p>
                    @endif
                </div>
            </div>
        </div>
    </aside>

    <main class="md:ml-64 pt-16 min-h-screen">
        <div class="p-6 md:p-10">
            @yield('content')
        </div>
    </main>

    <div id="actionModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-md transition-all">
        <div class="bg-slate-800 border border-slate-700 w-full max-w-md rounded-3xl shadow-2xl overflow-hidden transform scale-95 transition-transform duration-300" id="modalContent">
            
            <div class="p-6 border-b border-slate-700 flex justify-between items-center {{ $themeText }}">
                <h3 class="text-xl font-black uppercase tracking-tight">{{ $isDosen ? 'Buat Kelas Baru' : 'Gabung ke Kelas' }}</h3>
                <button onclick="closeModal()" class="text-slate-500 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <div class="p-8">
                @if($isDosen)
                    <div class="space-y-5">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Nama Mata Kuliah</label>
                            <input type="text" placeholder="Contoh: Pemrograman Web" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-5 py-3 text-sm text-white focus:border-rose-500 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Ruangan / Seksi</label>
                            <input type="text" placeholder="Contoh: Ruang A-301" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-5 py-3 text-sm text-white focus:border-rose-500 outline-none transition-all">
                        </div>
                        <button class="w-full bg-rose-500 text-white py-4 rounded-xl font-black text-xs uppercase tracking-[0.2em] shadow-lg shadow-rose-500/20 hover:bg-rose-600 transition-all mt-4">
                            Buat Kelas Sekarang
                        </button>
                    </div>
                @else
                    <div class="space-y-6 text-center">
                        <div class="w-20 h-20 bg-amber-400/10 rounded-3xl flex items-center justify-center text-amber-400 mx-auto mb-2 border border-amber-400/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        <div class="space-y-2">
                            <h4 class="text-white font-bold text-lg">Masukkan Kode Kelas</h4>
                            <p class="text-xs text-slate-400">Mintalah kode 6 digit kepada dosen pengajar untuk bergabung.</p>
                        </div>
                        <input type="text" placeholder="KODE-6" class="w-full bg-slate-900 border border-slate-700 rounded-2xl px-5 py-4 text-center text-2xl font-black text-amber-400 focus:border-amber-400 outline-none transition-all tracking-[0.5em] placeholder:tracking-normal placeholder:text-sm">
                        <button class="w-full bg-amber-400 text-slate-900 py-4 rounded-xl font-black text-xs uppercase tracking-[0.2em] shadow-lg shadow-amber-400/20 hover:bg-amber-500 transition-all">
                            Cari Kelas
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('actionModal');
        const modalContent = document.getElementById('modalContent');

        function openModal() { 
            modal.classList.remove('hidden'); 
            setTimeout(() => {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
            document.body.style.overflow = 'hidden'; 
        }

        function closeModal() { 
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden'); 
            }, 200);
            document.body.style.overflow = 'auto'; 
        }

        // Close modal on click outside
        modal.addEventListener('click', (e) => {
            if(e.target === modal) closeModal();
        });
    </script>

</body>
</html>