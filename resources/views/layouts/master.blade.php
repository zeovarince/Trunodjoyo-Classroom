<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trunodjoyo Class</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white font-sans antialiased">

    <header class="fixed top-0 left-0 right-0 h-16 bg-slate-800 border-b border-slate-700 flex items-center justify-between px-6 z-50">
        <div class="flex items-center gap-3">
    <div class="w-11 h-11 flex items-center justify-center p-0.5 relative">        
        <img src="{{ asset('images/Logo-utm.png') }}" alt="UTM" class="w-full h-full object-contain relative z-10">
    </div>

    <span class="text-xl font-bold text-amber-400 tracking-tighter">
        Trunodjoyo <span class="text-white">Classroom</span>
    </span>
</div>
        
        <div class="flex items-center gap-4">
            <div class="hidden md:block text-slate-400 text-sm font-medium mr-4">
                @yield('header_title', 'Beranda')
            </div>

            <button onclick="openModal()" class="bg-amber-400 text-slate-900 px-4 py-2 rounded-lg font-bold hover:bg-amber-500 transition-all text-sm shadow-lg shadow-amber-400/10">
                Buat Kelas
            </button>
            
            <div class="w-9 h-9 rounded-full border-2 border-amber-400 overflow-hidden bg-slate-700">
                <img src="https://ui-avatars.com/api/?name=Zaki+Developer&background=FBBF24&color=0F172A" class="w-full h-full">
            </div>
        </div>
    </header>

    <aside class="fixed top-16 left-0 bottom-0 w-64 bg-slate-800 border-r border-slate-700 flex flex-col z-40 hidden md:flex">
        <nav class="flex-1 overflow-y-auto py-6">
            <ul class="space-y-2 px-4">
                <li>
                    <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::is('/') ? 'bg-slate-700 text-amber-400 font-bold shadow-inner' : 'text-slate-400 hover:bg-slate-700 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="/tugas" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::is('tugas') ? 'bg-slate-700 text-amber-400 font-bold shadow-inner' : 'text-slate-400 hover:bg-slate-700 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Daftar Tugas
                    </a>
                </li>
            </ul>
        </nav>

        <div class="p-4 border-t border-slate-700 bg-slate-800/80">
            <div class="flex items-center gap-3 p-2 rounded-xl bg-slate-900/40 border border-slate-700/50">
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name=Zaki+User&background=FBBF24&color=0F172A" class="w-10 h-10 rounded-full border border-amber-400/50">
                    <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-slate-800 rounded-full"></div>
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-bold text-white truncate">Zaki Developer</p>
                    <p class="text-[9px] text-amber-400 font-mono uppercase tracking-tighter">LV.15 • 2500 XP</p>
                </div>
            </div>
        </div>
    </aside>

    <main class="md:ml-64 pt-16 min-h-screen">
        <div class="p-8">
            @yield('content')
        </div>
    </main>

    <div id="actionModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm">
    <div class="bg-[#1E293B] border border-slate-700 w-full max-w-md rounded-2xl shadow-2xl overflow-hidden">
        
        <div class="p-6 border-b border-slate-700 flex justify-between items-center text-amber-400">
            <h3 class="text-xl font-bold">Aksi Kelas</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        
        <div class="p-6 space-y-4">
            <div onclick="showCreateForm()" class="group p-4 bg-slate-800 border border-slate-700 rounded-xl hover:border-amber-400 cursor-pointer transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-amber-400 rounded-lg flex items-center justify-center text-[#0F172A]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-white group-hover:text-amber-400">Buat Kelas Baru</h4>
                        <p class="text-[10px] text-slate-400 uppercase">Khusus Dosen</p>
                    </div>
                </div>

                <div id="createClassForm" class="hidden mt-4 pt-4 border-t border-slate-700 space-y-3">
                    <input type="text" name="nama_matkul" placeholder="Nama Mata Kuliah" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-sm focus:border-amber-400 outline-none">
                    <input type="text" name="seksi" placeholder="Ruangan (Contoh: A-301)" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-sm focus:border-amber-400 outline-none">
                    <button class="w-full bg-amber-400 text-[#0F172A] py-2 rounded-lg font-bold text-sm">Simpan Kelas</button>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

    <script>
        const modal = document.getElementById('actionModal');

        function openModal() { modal.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
        function closeModal() { modal.classList.add('hidden'); document.body.style.overflow = 'auto'; }

        function showForm(type) {
            const create = document.getElementById('createClassForm');
            const join = document.getElementById('joinClassForm');
            
            if(type === 'create') {
                create.classList.toggle('hidden');
                join.classList.add('hidden');
            } else {
                join.classList.toggle('hidden');
                create.classList.add('hidden');
            }
        }

        function showCreateForm() {
        document.getElementById('createClassForm').classList.toggle('hidden');
        document.getElementById('joinClassForm').classList.add('hidden'); // Tutup form yang lain
    }

    function showJoinForm() {
        document.getElementById('joinClassForm').classList.toggle('hidden');
        document.getElementById('createClassForm').classList.add('hidden'); // Tutup form yang lain
    }
    </script>

</body>
</html>