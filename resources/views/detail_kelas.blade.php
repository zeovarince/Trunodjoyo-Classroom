    @extends('layouts.master')

    @section('header_title', $classroom->name)

    @section('content')
    @php
        $isDosen = Auth::user()->role == 'dosen';
    @endphp

    <div class="relative h-60 rounded-3xl overflow-hidden mb-8 border border-slate-700 shadow-2xl">
        <div class="absolute inset-0 bg-gradient-to-br from-amber-500 via-amber-600 to-amber-800 opacity-90"></div>
        <div class="absolute inset-0 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>
        
        <div class="absolute bottom-8 left-10">
            <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-[10px] font-bold text-white uppercase tracking-widest border border-white/30 mb-3 inline-block">
                Teknik Informatika
            </span>
            <h1 class="text-4xl font-black text-white drop-shadow-xl tracking-tight">{{ $classroom->name }}</h1>
            <p class="text-amber-100 text-lg font-medium">Semester 3 • {{ $classroom->section }}</p>
        </div>
    </div>

    <div class="flex items-center gap-8 border-b border-slate-700 mb-8 px-2">
        <a href="/kelas/{{ $classroom->id }}" class="pb-4 text-sm transition-all font-bold border-b-2 border-amber-400 text-amber-400">Forum</a>
        <a href="/tugas" class="pb-4 text-sm transition-all font-medium text-slate-400 hover:text-white">Tugas Kelas</a>
        <a href="/anggota" class="pb-4 text-sm transition-all font-medium text-slate-400 hover:text-white">Anggota</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <div class="space-y-6">
            <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 shadow-lg">
                <h4 class="text-xs font-black text-amber-400 uppercase tracking-widest mb-4">Info Kelas</h4>
                <p class="text-xs text-slate-400 leading-relaxed mb-4">
                    Dosen: <strong>{{ optional($classroom->dosen)->name ?? 'Tidak diketahui' }}</strong><br><br>
                    Jumlah Anggota: {{ $classroom->students->count() ?? 0 }} Siswa
                </p>
                <a href="/tugas" class="text-xs font-bold text-amber-400 hover:text-amber-300 transition-all underline underline-offset-4">Lihat Tugas</a>
            </div>
        </div>

        <div class="lg:col-span-3 space-y-6">
            
            @if($isDosen)
            <div onclick="openCreateLppModal()" class="bg-slate-800 border border-slate-700 rounded-2xl p-4 flex items-center gap-4 shadow-lg group hover:border-amber-400 transition-all cursor-pointer">
                <div class="w-10 h-10 rounded-full bg-slate-700 border border-slate-600 flex items-center justify-center text-amber-400 font-bold text-xs shadow-inner">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="flex-1 text-sm text-slate-400 group-hover:text-slate-300 transition-colors">
                    Bagikan materi baru dengan kelas...
                </div>
                <button class="p-2 text-slate-400 group-hover:text-amber-400 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                </button>
            </div>
            @endif

            @forelse($classroom->lpps as $materi)
            <div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden shadow-lg hover:border-slate-500 transition-all">
                <div class="p-6 flex items-start gap-5">
                    <div class="w-12 h-12 bg-amber-400/10 rounded-xl flex items-center justify-center text-amber-400 border border-amber-400/20 shadow-inner shrink-0 cursor-pointer" onclick="window.location.href='{{ route('lpp.show', $materi->id) }}'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <div class="flex-1 cursor-pointer" onclick="window.location.href='{{ route('lpp.show', $materi->id) }}'">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold text-white text-lg hover:text-amber-400 transition-colors">{{ $materi->title }}</h3>
                            <span class="text-[10px] text-slate-500 font-mono uppercase">{{ $materi->created_at->translatedFormat('d M Y') }}</span>
                        </div>
                        <p class="text-sm text-slate-400 mt-2 line-clamp-2">{{ $materi->description }}</p>
                    </div>
                    
                    @if($isDosen)
                    <div class="shrink-0 flex items-center gap-1 ml-4 border-l border-slate-700 pl-4">
                        <button onclick="openEditLppModal('{{ $materi->id }}', '{{ addslashes($materi->title) }}', '{{ addslashes($materi->description) }}')" class="p-2 text-slate-500 hover:text-amber-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                        </button>
                        <form action="{{ route('lpp.destroy', $materi->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-slate-500 hover:text-red-400 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 text-center shadow-lg">
                <p class="text-slate-400 text-sm italic">Belum ada materi atau tugas yang dibagikan di kelas ini.</p>
            </div>
            @endforelse

        </div>
    </div>

    @if($isDosen)
    {{-- MODAL BUAT MATERI --}}
    <div id="createLppModal" class="fixed inset-0 z-[70] hidden flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-md transition-all">
        <div class="bg-slate-800 border border-slate-700 w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden">
            <div class="p-6 border-b border-slate-700 flex justify-between items-center text-amber-400">
                <h3 class="text-xl font-black uppercase tracking-tight">Buat Materi Baru</h3>
                <button onclick="closeCreateLppModal()" class="text-slate-500 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <form action="{{ route('lpp.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-5">
                @csrf
                <input type="hidden" name="classroom_id" value="{{ $classroom->id }}">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Judul Materi</label>
                    <input type="text" name="title" required placeholder="Contoh: Pertemuan 1 - Pengenalan Web" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-5 py-3 text-sm text-white focus:border-amber-400 outline-none transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Deskripsi / Arahan</label>
                    <textarea name="description" rows="3" required placeholder="Silakan pelajari materi berikut ini..." class="w-full bg-slate-900 border border-slate-700 rounded-xl px-5 py-3 text-sm text-white focus:border-amber-400 outline-none transition-all resize-none"></textarea>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-1">File Materi (PDF)</label>
                    <input type="file" name="file" accept=".pdf" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-5 py-2 text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-amber-400 file:text-slate-900 hover:file:bg-amber-500 transition-all cursor-pointer">
                </div>
                <button type="submit" class="w-full bg-amber-400 text-slate-900 py-4 rounded-xl font-black text-xs uppercase tracking-[0.2em] shadow-lg hover:bg-amber-500 transition-all mt-4">Bagikan Materi</button>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT MATERI --}}
    <div id="editLppModal" class="fixed inset-0 z-[70] hidden flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-md transition-all">
        <div class="bg-slate-800 border border-slate-700 w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden">
            <div class="p-6 border-b border-slate-700 flex justify-between items-center text-amber-400">
                <h3 class="text-xl font-black uppercase tracking-tight">Edit Materi</h3>
                <button onclick="closeEditLppModal()" class="text-slate-500 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <form id="editLppForm" method="POST" enctype="multipart/form-data" class="p-8 space-y-5">
                @csrf
                @method('PUT')
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Judul Materi</label>
                    <input type="text" name="title" id="edit_lpp_title" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-5 py-3 text-sm text-white focus:border-amber-400 outline-none transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Deskripsi / Arahan</label>
                    <textarea name="description" id="edit_lpp_desc" rows="3" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-5 py-3 text-sm text-white focus:border-amber-400 outline-none transition-all resize-none"></textarea>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Ganti File Materi (Opsional)</label>
                    <input type="file" name="file" accept=".pdf" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-5 py-2 text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-slate-700 file:text-white hover:file:bg-slate-600 transition-all cursor-pointer">
                    <p class="text-[10px] text-slate-500 mt-1 ml-1">*Kosongkan jika tidak ingin mengganti file sebelumnya.</p>
                </div>
                <button type="submit" class="w-full bg-amber-400 text-slate-900 py-4 rounded-xl font-black text-xs uppercase tracking-[0.2em] shadow-lg hover:bg-amber-500 transition-all mt-4">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <script>
        function openCreateLppModal() { document.getElementById('createLppModal').classList.remove('hidden'); }
        function closeCreateLppModal() { document.getElementById('createLppModal').classList.add('hidden'); }
        
        function openEditLppModal(id, title, desc) {
            document.getElementById('editLppModal').classList.remove('hidden');
            document.getElementById('edit_lpp_title').value = title;
            document.getElementById('edit_lpp_desc').value = desc;
            document.getElementById('editLppForm').action = '/lpp/' + id;
        }
        function closeEditLppModal() { document.getElementById('editLppModal').classList.add('hidden'); }
    </script>
    @endif
    @endsection