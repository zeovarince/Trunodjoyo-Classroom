@extends('layouts.master')

@section('header_title', 'Dashboard Utama')

@section('content')
@php
    $user = auth()->user();
    $isDosen = $user->role == 'dosen';
    $themeColor = $isDosen ? 'rose-500' : 'amber-400';
    $themeText = $isDosen ? 'text-rose-500' : 'text-amber-400';
    $themeBg = $isDosen ? 'bg-rose-500' : 'bg-amber-400';
    $themeHover = $isDosen ? 'hover:border-rose-500' : 'hover:border-amber-400';
    $themeShadow = $isDosen ? 'hover:shadow-rose-500/10' : 'hover:shadow-amber-400/10';
    $themeBtnHover = $isDosen ? 'group-hover:bg-rose-500' : 'group-hover:bg-amber-400';
@endphp

<div class="mb-10">
    <div class="flex items-center gap-4">
        <h1 class="text-3xl font-black tracking-tight text-white">
            Halo, {{ explode(' ', $user->name)[0] }}! 👋
        </h1>
        @if($isDosen)
            <span class="px-3 py-1 bg-rose-500/10 border border-rose-500/20 rounded-full text-[10px] font-black text-rose-500 uppercase tracking-widest">
                Dosen Aktif
            </span>
        @endif
    </div>
    <p class="text-slate-400 mt-1 font-medium">
        @if($isDosen)
            Anda sedang mengelola <span class="{{ $themeText }} font-black text-lg">2</span> kelas mata kuliah semester ini.
        @else
            Kamu terdaftar di <span class="{{ $themeText }} font-black text-lg">2</span> kelas aktif. Semangat belajarnya!
        @endif
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    
    <div class="group relative bg-slate-800 border border-slate-700 rounded-3xl overflow-hidden {{ $themeHover }} transition-all duration-500 shadow-xl {{ $themeShadow }} flex flex-col">
        
        <div class="h-28 bg-gradient-to-br {{ $isDosen ? 'from-rose-500 to-rose-700' : 'from-amber-400 to-amber-600' }} p-5 relative flex flex-col justify-end">
            <div class="absolute top-3 right-3 bg-slate-900/40 backdrop-blur-md px-2 py-1 rounded-lg text-[9px] text-white font-black uppercase tracking-[0.1em]">
                TEKNIK INFORMATIKA
            </div>
            <h2 class="text-slate-900 font-black text-xl leading-tight truncate">Pemrograman Web</h2>
            <p class="text-slate-900/70 text-xs font-bold italic tracking-wide">Seksi A • Semester 3</p>
        </div>

        <div class="p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-9 h-9 rounded-xl bg-slate-900 border border-slate-700 flex items-center justify-center text-xs font-black {{ $themeText }} shadow-inner">
                    PW
                </div>
                <div class="text-sm">
                    <p class="font-bold text-white leading-none">
                        {{ $isDosen ? 'Kelola Kelas' : 'Dr. Senior Developer' }}
                    </p>
                    <p class="text-slate-500 text-[10px] uppercase font-bold mt-1 tracking-wider">
                        {{ $isDosen ? 'Status: Aktif' : 'Dosen Pengampu' }}
                    </p>
                </div>
            </div>

            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-[10px] text-slate-500 uppercase font-black tracking-widest">
                    <span>{{ $isDosen ? 'Mahasiswa Bergabung' : 'Progress Tugas' }}</span>
                    <span class="{{ $themeText }}">{{ $isDosen ? '38 Siswa' : '75%' }}</span>
                </div>
                <div class="w-full h-2 bg-slate-900 rounded-full overflow-hidden p-0.5 border border-slate-700/50">
                    <div class="{{ $themeBg }} h-full rounded-full shadow-[0_0_10px_rgba(251,191,36,0.2)]" style="width: 75%"></div>
                </div>
            </div>
        </div>

        <div class="px-6 pb-6 mt-auto">
            <a href="/kelas/1" class="block w-full text-center py-3 bg-slate-700/50 {{ $themeBtnHover }} group-hover:text-slate-900 rounded-xl text-xs font-black uppercase tracking-[0.2em] transition-all duration-300 border border-slate-700 group-hover:border-transparent group-hover:shadow-lg">
                {{ $isDosen ? 'Buka Panel Dosen' : 'Masuk Kelas' }}
            </a>
        </div>
    </div>

    <div class="group relative bg-slate-800 border border-slate-700 rounded-3xl overflow-hidden {{ $themeHover }} transition-all duration-500 shadow-xl {{ $themeShadow }} flex flex-col">
        
        <div class="h-28 bg-gradient-to-br {{ $isDosen ? 'from-rose-600 to-rose-800' : 'from-amber-500 to-amber-700' }} p-5 relative flex flex-col justify-end">
            <div class="absolute top-3 right-3 bg-slate-900/40 backdrop-blur-md px-2 py-1 rounded-lg text-[9px] text-white font-black uppercase tracking-[0.1em]">
                TEKNIK INFORMATIKA
            </div>
            <h2 class="text-slate-900 font-black text-xl leading-tight truncate">Basis Data</h2>
            <p class="text-slate-900/70 text-xs font-bold italic tracking-wide">Seksi B • Semester 3</p>
        </div>

        <div class="p-6 flex-1">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-9 h-9 rounded-xl bg-slate-900 border border-slate-700 flex items-center justify-center text-xs font-black {{ $themeText }} shadow-inner">
                    BD
                </div>
                <div class="text-sm">
                    <p class="font-bold text-white leading-none">
                        {{ $isDosen ? 'Kelola Kelas' : 'Ibu Dosen Database' }}
                    </p>
                    <p class="text-slate-500 text-[10px] uppercase font-bold mt-1 tracking-wider">
                        {{ $isDosen ? 'Status: Aktif' : 'Dosen Pengampu' }}
                    </p>
                </div>
            </div>

            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-[10px] text-slate-500 uppercase font-black tracking-widest">
                    <span>{{ $isDosen ? 'Mahasiswa Bergabung' : 'Progress Tugas' }}</span>
                    <span class="{{ $themeText }}">{{ $isDosen ? '42 Siswa' : '25%' }}</span>
                </div>
                <div class="w-full h-2 bg-slate-900 rounded-full overflow-hidden p-0.5 border border-slate-700/50">
                    <div class="{{ $themeBg }} h-full rounded-full shadow-[0_0_10px_rgba(251,191,36,0.2)]" style="width: 25%"></div>
                </div>
            </div>
        </div>

        <div class="px-6 pb-6 mt-auto">
            <a href="/kelas/2" class="block w-full text-center py-3 bg-slate-700/50 {{ $themeBtnHover }} group-hover:text-slate-900 rounded-xl text-xs font-black uppercase tracking-[0.2em] transition-all duration-300 border border-slate-700 group-hover:border-transparent group-hover:shadow-lg">
                {{ $isDosen ? 'Buka Panel Dosen' : 'Masuk Kelas' }}
            </a>
        </div>
    </div>

    <div class="border-2 border-dashed border-slate-700 rounded-3xl p-8 flex flex-col items-center justify-center text-center group hover:border-{{ $themeColor }} transition-colors cursor-pointer" onclick="openModal()">
        <div class="w-12 h-12 rounded-2xl bg-slate-800 flex items-center justify-center text-slate-500 group-hover:{{ $themeBg }} group-hover:text-slate-900 transition-all mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        </div>
        <p class="text-xs font-black uppercase tracking-widest text-slate-500 group-hover:text-white transition-colors">
            {{ $isDosen ? 'Buat Mata Kuliah Baru' : 'Gabung Kelas Lainnya' }}
        </p>
    </div>

</div>
@endsection