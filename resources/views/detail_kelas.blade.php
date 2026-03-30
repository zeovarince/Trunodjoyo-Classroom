@extends('layouts.master')

@section('header_title', $classroom->name)

@section('content')
@php
    $isDosen = Auth::user()->role === 'dosen';
@endphp

{{-- ====================== HERO KELAS ====================== --}}
<div class="relative h-60 rounded-3xl overflow-hidden mb-8 border border-slate-700 shadow-2xl">
    <div class="absolute inset-0 bg-gradient-to-br from-amber-500 via-amber-600 to-amber-800 opacity-90"></div>
    <div class="absolute inset-0 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>

    <div class="absolute bottom-8 left-10">
        <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-[10px] font-bold text-white uppercase tracking-widest border border-white/30 mb-3 inline-block">
            Teknik Informatika
        </span>
        <h1 class="text-4xl font-black text-white drop-shadow-xl tracking-tight">{{ $classroom->name }}</h1>
        <p class="text-amber-100 text-lg font-medium">Kelas {{ $classroom->section }}</p>
    </div>
</div>

{{-- ====================== NAV TAB (POV DOSEN/MAHASISWA) ====================== --}}
<div class="flex items-center gap-8 border-b border-slate-700 mb-8 px-2">
    <a href="{{ route('kelas.show', ['id' => $classroom->id, 'tab' => 'forum']) }}"
       class="pb-4 text-sm transition-all {{ $tab === 'forum' ? 'font-bold border-b-2 border-amber-400 text-amber-400' : 'font-medium text-slate-400 hover:text-white' }}">
        Forum
    </a>
    <a href="{{ route('kelas.show', ['id' => $classroom->id, 'tab' => 'tugas']) }}"
       class="pb-4 text-sm transition-all {{ $tab === 'tugas' ? 'font-bold border-b-2 border-amber-400 text-amber-400' : 'font-medium text-slate-400 hover:text-white' }}">
        Tugas Kelas
    </a>
    <a href="{{ route('kelas.show', ['id' => $classroom->id, 'tab' => 'orang']) }}"
       class="pb-4 text-sm transition-all {{ $tab === 'orang' ? 'font-bold border-b-2 border-amber-400 text-amber-400' : 'font-medium text-slate-400 hover:text-white' }}">
        Orang
    </a>
</div>

@if(session('success'))
    <div class="mb-6 rounded-xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-300 px-4 py-3 text-sm font-semibold">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-6 rounded-xl border border-rose-500/30 bg-rose-500/10 text-rose-300 px-4 py-3 text-sm">
        <p class="font-bold mb-1">Terdapat kesalahan input:</p>
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

    {{-- ====================== SIDEBAR INFO KELAS ====================== --}}
    <div class="space-y-6">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 shadow-lg">
            <h4 class="text-xs font-black text-amber-400 uppercase tracking-widest mb-4">Info Kelas</h4>
            <p class="text-xs text-slate-400 leading-relaxed mb-4">
                Dosen: <strong>{{ optional($classroom->dosen)->name ?? 'Tidak diketahui' }}</strong><br><br>
                Jumlah Anggota: {{ $classroom->students->count() }} Mahasiswa
            </p>
            <p class="text-[11px] text-slate-500">
                Kode Kelas: <span class="text-amber-300 font-bold">{{ $classroom->code }}</span>
            </p>
        </div>
    </div>

    <div class="lg:col-span-3 space-y-6">

        {{-- ====================== TAB: FORUM ====================== --}}
        @if($tab === 'forum')
            @if($isDosen)
                <div onclick="openCreateLppModal()" class="bg-slate-800 border border-slate-700 rounded-2xl p-4 flex items-center gap-4 shadow-lg group hover:border-amber-400 transition-all cursor-pointer">
                    <div class="w-10 h-10 rounded-full bg-slate-700 border border-slate-600 flex items-center justify-center text-amber-400 font-bold text-xs shadow-inner">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="flex-1 text-sm text-slate-400 group-hover:text-slate-300 transition-colors">
                        Buat pengumuman atau tugas baru...
                    </div>
                    <button class="p-2 text-slate-400 group-hover:text-amber-400 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    </button>
                </div>
            @endif

            @forelse($forumPosts as $post)
                <div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden shadow-lg hover:border-slate-500 transition-all">
                    <div class="p-6 flex items-start gap-5">
                        <div class="w-12 h-12 {{ $post->type === 'assignment' ? 'bg-rose-400/10 text-rose-400 border-rose-400/20' : 'bg-amber-400/10 text-amber-400 border-amber-400/20' }} rounded-xl flex items-center justify-center border shadow-inner shrink-0">
                            @if($post->type === 'assignment')
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 10H5m14 4H5m14-8H5m14 12H5" /></svg>
                            @endif
                        </div>

                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="text-[10px] px-2 py-1 rounded-full font-black uppercase tracking-widest {{ $post->type === 'assignment' ? 'bg-rose-500/20 text-rose-300' : 'bg-amber-500/20 text-amber-300' }}">
                                    {{ $post->type === 'assignment' ? 'Tugas' : 'Pengumuman' }}
                                </span>
                                @if($post->topic)
                                    <span class="text-[10px] px-2 py-1 rounded-full font-bold uppercase tracking-widest bg-slate-700 text-slate-300">
                                        Topik: {{ $post->topic }}
                                    </span>
                                @endif
                                @if($post->publish_at)
                                    <span class="text-[10px] text-slate-400">Publish: {{ $post->publish_at->translatedFormat('d M Y H:i') }}</span>
                                @endif
                            </div>

                            <h3 class="font-bold text-white text-lg">{{ $post->title }}</h3>
                            <p class="text-sm text-slate-400 mt-2">{{ $post->description }}</p>

                            @if($post->type === 'assignment')
                                <div class="mt-3 flex flex-wrap gap-4 text-xs">
                                    <span class="text-rose-300 font-bold">Deadline: {{ optional($post->deadline)->translatedFormat('d M Y H:i') ?? '-' }}</span>
                                    <span class="text-amber-300 font-bold">Maks Poin: {{ $post->max_points ?? '-' }}</span>
                                    <span class="text-emerald-300 font-bold">Terkumpul: {{ $post->submissions->groupBy('user_id')->count() }} mahasiswa</span>
                                </div>
                            @endif

                            {{-- Lampiran banyak file/link --}}
                            @if($post->attachments->count() > 0 || $post->file_path)
                                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @if($post->file_path)
                                        <div class="rounded-xl border border-slate-700 bg-slate-900/60 p-3">
                                            <a href="{{ route('lpp.file.preview', $post->id) }}" class="block text-sm font-bold text-slate-100 hover:text-amber-300 truncate">
                                                Buka File Utama
                                            </a>
                                            <a href="{{ route('lpp.file.preview', $post->id) }}" target="_blank" rel="noopener" class="mt-2 inline-block text-[11px] text-sky-300 hover:text-sky-200 underline underline-offset-4">
                                                Buka di tab baru
                                            </a>
                                        </div>
                                    @endif

                                    @foreach($post->attachments as $attachment)
                                        @if($attachment->attachment_type === 'file' && $attachment->file_path)
                                            <div class="rounded-xl border border-slate-700 bg-slate-900/60 p-3">
                                                <a href="{{ route('lpp.attachment.file.preview', $attachment->id) }}" class="block text-sm font-bold text-slate-100 hover:text-amber-300 truncate">
                                                    {{ basename($attachment->file_path) }}
                                                </a>
                                                <a href="{{ route('lpp.attachment.file.preview', $attachment->id) }}" target="_blank" rel="noopener" class="mt-2 inline-block text-[11px] text-sky-300 hover:text-sky-200 underline underline-offset-4">
                                                    Buka di tab baru
                                                </a>
                                            </div>
                                        @elseif($attachment->attachment_type === 'link' && $attachment->link_url)
                                            <a href="{{ $attachment->link_url }}" target="_blank" rel="noopener" class="flex items-center justify-center rounded-xl border border-slate-700 bg-slate-900/60 px-3 py-4 text-xs text-sky-300 hover:text-sky-200 text-center">
                                                Link lampiran
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            <div class="mt-4 flex items-center gap-3">
                                <a href="{{ route('lpp.show', $post->id) }}" class="text-sm font-bold text-amber-400 hover:text-amber-300 underline underline-offset-4">
                                    {{ $post->type === 'assignment' ? 'Buka Tugas & Pengumpulan' : 'Buka Detail Forum' }}
                                </a>

                                @if($isDosen)
                                    <form action="{{ route('lpp.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Yakin hapus posting ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-bold text-rose-400 hover:text-rose-300">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 text-center shadow-lg">
                    <p class="text-slate-400 text-sm italic">Belum ada posting pada forum kelas ini.</p>
                </div>
            @endforelse
        @endif

        {{-- ====================== TAB: TUGAS KELAS (GROUP BY TOPIK) ====================== --}}
        @if($tab === 'tugas')
            @forelse($tasksByTopic as $topicName => $taskItems)
                <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 shadow-lg">
                    <h3 class="text-lg font-black text-amber-400 mb-4">{{ $topicName }}</h3>

                    <div class="space-y-3">
                        @foreach($taskItems as $task)
                            <div class="rounded-xl border border-slate-700 bg-slate-900/30 p-4">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                                    <div>
                                        <h4 class="text-sm font-bold text-white">{{ $task->title }}</h4>
                                        <p class="text-xs text-slate-400 mt-1">{{ \Illuminate\Support\Str::limit($task->description, 120) }}</p>
                                    </div>
                                    <div class="text-xs text-right">
                                        <p class="text-rose-300 font-bold">Deadline: {{ optional($task->deadline)->translatedFormat('d M Y H:i') ?? '-' }}</p>
                                        <p class="text-amber-300 font-bold">Maks Poin: {{ $task->max_points ?? '-' }}</p>
                                    </div>
                                </div>

                                <div class="mt-3 flex justify-between items-center">
                                    <span class="text-[11px] text-slate-500">{{ $task->submissions->groupBy('user_id')->count() }} sudah mengumpulkan</span>
                                    <a href="{{ route('lpp.show', $task->id) }}" class="text-xs font-bold text-amber-400 hover:text-amber-300 underline underline-offset-4">
                                        {{ $isDosen ? 'Lihat Pengumpulan & Nilai' : 'Lihat Detail Tugas' }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 text-center shadow-lg">
                    <p class="text-slate-400 text-sm italic">Belum ada tugas di kelas ini.</p>
                </div>
            @endforelse
        @endif

        {{-- ====================== TAB: ORANG (DOSEN + MAHASISWA TERPISAH) ====================== --}}
        @if($tab === 'orang')
            <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 shadow-lg">
                <h3 class="text-lg font-black text-amber-400 mb-4">Dosen Pengampu</h3>
                <div class="flex items-center gap-4 p-4 rounded-xl border border-amber-400/20 bg-amber-400/5">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(optional($classroom->dosen)->name ?? 'Dosen') }}&background=FBBF24&color=0F172A"
                         class="w-12 h-12 rounded-xl border-2 border-amber-400 p-0.5">
                    <div>
                        <p class="text-white font-bold">{{ optional($classroom->dosen)->name ?? 'Tidak diketahui' }}</p>
                        <p class="text-[10px] text-amber-300 uppercase font-black tracking-widest">Pengampu</p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-black text-white">Mahasiswa Kelas</h3>
                    <span class="text-xs font-bold text-slate-400">{{ $classroom->students->count() }} orang</span>
                </div>

                <div class="space-y-2">
                    @forelse($classroom->students as $student)
                        <div class="flex items-center justify-between p-3 rounded-xl border border-slate-700 bg-slate-900/20">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=334155&color=fff" class="w-10 h-10 rounded-xl">
                                <div>
                                    <p class="text-sm font-bold text-slate-100">{{ $student->name }}</p>
                                    <p class="text-[10px] text-slate-500 uppercase tracking-widest">{{ $student->npm ?? 'NPM belum diisi' }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500 italic">Belum ada mahasiswa terdaftar.</p>
                    @endforelse
                </div>
            </div>
        @endif
    </div>
</div>

{{-- ====================== MODAL DOSEN: BUAT POSTING ====================== --}}
@if($isDosen)
<div id="createLppModal" class="fixed inset-0 z-[70] hidden overflow-y-auto p-4 bg-slate-950/90 backdrop-blur-md transition-all">
    <div class="bg-slate-800 border border-slate-700 w-full max-w-5xl rounded-3xl shadow-2xl overflow-hidden mx-auto my-6 max-h-[90vh] flex flex-col">
        <div class="p-6 border-b border-slate-700 flex justify-between items-center text-amber-400 sticky top-0 bg-slate-800 z-10">
            <h3 class="text-xl font-black uppercase tracking-tight">Buat Posting Kelas</h3>
            <button onclick="closeCreateLppModal()" class="text-slate-500 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <form action="{{ route('lpp.store') }}" method="POST" enctype="multipart/form-data" class="p-8 overflow-y-auto space-y-6">
            @csrf
            <input type="hidden" name="classroom_id" value="{{ $classroom->id }}">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Jenis Posting</label>
                    <select name="type" id="post_type" onchange="toggleAssignmentFields()" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-5 py-3 text-sm text-white focus:border-amber-400 outline-none transition-all">
                        <option value="announcement">Pengumuman</option>
                        <option value="assignment">Tugas</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Topik</label>
                    <input type="text" name="topic" placeholder="Masukan Topik" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-5 py-3 text-sm text-white focus:border-amber-400 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Judul</label>
                    <input type="text" name="title" required placeholder="Masukan judul" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-5 py-3 text-sm text-white focus:border-amber-400 outline-none transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="space-y-2 md:col-span-1">
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Jadwal Publish</label>
                    <input type="datetime-local" name="publish_at" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-xs text-white focus:border-amber-400 outline-none transition-all">
                </div>

                <div id="assignment_deadline_group" class="space-y-2 md:col-span-1 hidden">
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Deadline Tugas</label>
                    <input type="datetime-local" name="deadline" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-xs text-white focus:border-amber-400 outline-none transition-all">
                </div>

                <div id="assignment_points_group" class="space-y-2 md:col-span-1 hidden">
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Poin Maksimal</label>
                    <input type="number" name="max_points" min="1" max="1000" value="100" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-xs text-white focus:border-amber-400 outline-none transition-all">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Deskripsi</label>
                <textarea name="description" rows="3" required placeholder="Deskripsi" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-5 py-3 text-sm text-white focus:border-amber-400 outline-none transition-all resize-none"></textarea>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Lampiran File (1 Pilihan, Bisa Banyak)</label>
                <input type="file" name="files[]" multiple class="w-full bg-slate-900 border border-slate-700 rounded-xl px-5 py-2 text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-amber-400 file:text-slate-900 hover:file:bg-amber-500 transition-all cursor-pointer">
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Link Lampiran</label>
                <div id="link-inputs" class="space-y-2">
                    <input type="url" name="attachment_links[]" placeholder="Masukan Url" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-xs text-white focus:border-amber-400 outline-none transition-all">
                </div>
                <button type="button" onclick="addLinkInput()" class="text-xs font-bold text-amber-400 hover:text-amber-300">+ Tambah link lagi</button>
            </div>

            <button type="submit" class="w-full bg-amber-400 text-slate-900 py-4 rounded-xl font-black text-xs uppercase tracking-[0.2em] shadow-lg hover:bg-amber-500 transition-all mt-4">
                Bagikan Posting
            </button>
        </form>
    </div>
</div>

<script>
    function openCreateLppModal() {
        document.getElementById('createLppModal').classList.remove('hidden');
    }

    function closeCreateLppModal() {
        document.getElementById('createLppModal').classList.add('hidden');
    }

    function toggleAssignmentFields() {
        const isAssignment = document.getElementById('post_type').value === 'assignment';
        document.getElementById('assignment_deadline_group').classList.toggle('hidden', !isAssignment);
        document.getElementById('assignment_points_group').classList.toggle('hidden', !isAssignment);
    }

    function addLinkInput() {
        const wrapper = document.getElementById('link-inputs');
        const input = document.createElement('input');
        input.type = 'url';
        input.name = 'attachment_links[]';
        input.placeholder = 'Masukan URL lampiran';
        input.className = 'w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-xs text-white focus:border-amber-400 outline-none transition-all';
        wrapper.appendChild(input);
    }
</script>
@endif
@endsection
