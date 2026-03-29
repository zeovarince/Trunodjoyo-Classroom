@extends('layouts.master')

@section('header_title', 'Dashboard Utama')

@section('content')
@php
    $user = Auth::user();
    $isDosen = $user->role == 'dosen';
    
    $themeColor = 'amber-400';
    $themeText = 'text-amber-400';
    $themeBg = 'bg-amber-400';
    $themeHover = 'hover:border-amber-400';
    $themeShadow = 'hover:shadow-amber-400/10';
    $themeBtnHover = 'group-hover:bg-amber-400';
@endphp

<div class="mb-10 flex justify-between items-end">
    <div>
        <div class="flex items-center gap-4">
            <h1 class="text-3xl font-black tracking-tight text-white">
                Halo, {{ explode(' ', $user->name)[0] }}! 👋
            </h1>
            @if($isDosen)
                <span class="px-3 py-1 bg-amber-400/10 border border-amber-400/20 rounded-full text-[10px] font-black text-amber-400 uppercase tracking-widest">
                    Dosen Aktif
                </span>
            @endif
        </div>
        <p class="text-slate-400 mt-1 font-medium">
            Anda sedang mengelola <span class="{{ $themeText }} font-black text-lg">{{ $classrooms->count() }}</span> kelas mata kuliah semester ini.
        </p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    
    @foreach($classrooms as $kelas)
    <div class="group relative bg-slate-800 border border-slate-700 rounded-3xl overflow-hidden {{ $themeHover }} transition-all duration-500 shadow-xl {{ $themeShadow }} flex flex-col">
        
        {{-- Header Kartu --}}
        <div class="h-28 bg-gradient-to-br from-amber-400 to-amber-600 p-5 relative flex flex-col justify-end">
            <div class="absolute top-3 right-3 flex gap-2">
                {{-- Tombol Edit --}}
                <button onclick="openEditModal('{{ $kelas->id }}', '{{ $kelas->name }}', '{{ $kelas->section }}')" class="bg-slate-900/40 backdrop-blur-md p-2 rounded-lg text-white hover:bg-amber-500 hover:text-slate-900 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                </button>
                
                {{-- Tombol Hapus --}}
                <form action="/kelas/{{ $kelas->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-slate-900/40 backdrop-blur-md p-2 rounded-lg text-white hover:bg-red-500 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                </form>
            </div>
            <h2 class="text-slate-900 font-black text-xl leading-tight truncate">{{ $kelas->name }}</h2>
            <p class="text-slate-900/70 text-xs font-bold italic tracking-wide">{{ $kelas->section }} • {{ $kelas->code }}</p>
        </div>

        <div class="p-6 flex-1">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-9 h-9 rounded-xl bg-slate-900 border border-slate-700 flex items-center justify-center text-xs font-black {{ $themeText }} shadow-inner">
                    {{ strtoupper(substr($kelas->name, 0, 2)) }}
                </div>
                <div class="text-sm">
                    <p class="font-bold text-white leading-none">Status: Aktif</p>
                    <p class="text-slate-500 text-[10px] uppercase font-bold mt-1 tracking-wider">Terakhir Update: {{ $kelas->updated_at->diffForHumans() }}</p>
                </div>
            </div>

            <div class="space-y-2">
                <div class="flex justify-between text-[10px] text-slate-500 uppercase font-black tracking-widest">
                    <span>Mahasiswa Bergabung</span>
                    <span class="{{ $themeText }}">{{ $kelas->total_students ?? 0 }} Siswa</span>
                </div>
                <div class="w-full h-1.5 bg-slate-900 rounded-full overflow-hidden border border-slate-700/50">
                    <div class="{{ $themeBg }} h-full rounded-full" style="width: 15%"></div>
                </div>
            </div>
        </div>

        <div class="px-6 pb-6 mt-auto">
            <a href="/kelas/{{ $kelas->id }}" class="block w-full text-center py-3 bg-slate-700/50 {{ $themeBtnHover }} group-hover:text-slate-900 rounded-xl text-xs font-black uppercase tracking-[0.2em] transition-all duration-300 border border-slate-700 group-hover:border-transparent group-hover:shadow-lg">
                Buka Panel Dosen
            </a>
        </div>
    </div>
    @endforeach

    {{-- Tombol Tambah --}}
    <div onclick="openModal()" class="border-2 border-dashed border-slate-700 rounded-3xl p-8 flex flex-col items-center justify-center text-center group hover:border-amber-400 transition-all cursor-pointer bg-slate-800/30 hover:bg-slate-800/50">
        <div class="w-12 h-12 rounded-2xl bg-slate-800 flex items-center justify-center text-slate-500 group-hover:bg-amber-400 group-hover:text-slate-900 transition-all mb-4 shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        </div>
        <p class="text-xs font-black uppercase tracking-widest text-slate-500 group-hover:text-white transition-colors">
            Buat Mata Kuliah Baru
        </p>
    </div>
</div>

{{-- MODAL EDIT KELAS --}}
<div id="editModal" class="fixed inset-0 z-[70] hidden flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-md transition-all">
    <div class="bg-slate-800 border border-slate-700 w-full max-w-md rounded-3xl shadow-2xl overflow-hidden transform scale-95 transition-transform duration-300" id="editModalContent">
        <div class="p-6 border-b border-slate-700 flex justify-between items-center text-amber-400">
            <h3 class="text-xl font-black uppercase tracking-tight">Edit Mata Kuliah</h3>
            <button onclick="closeEditModal()" class="text-slate-500 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        
        <form id="editForm" method="POST" class="p-8 space-y-5">
            @csrf
            @method('PUT')
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Nama Mata Kuliah</label>
                <input type="text" name="name" id="edit_name" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-5 py-3 text-sm text-white focus:border-amber-400 outline-none transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-500 uppercase ml-1">Ruangan / Seksi</label>
                <input type="text" name="section" id="edit_section" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-5 py-3 text-sm text-white focus:border-amber-400 outline-none transition-all">
            </div>
            <button type="submit" class="w-full bg-amber-400 text-slate-900 py-4 rounded-xl font-black text-xs uppercase tracking-[0.2em] shadow-lg shadow-amber-400/20 hover:bg-amber-500 transition-all mt-4">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, name, section) {
        const modal = document.getElementById('editModal');
        const content = document.getElementById('editModalContent');
        const form = document.getElementById('editForm');
        
        // Set values
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_section').value = section;
        form.action = '/kelas/' + id;

        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        const content = document.getElementById('editModalContent');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }
</script>
@endsection