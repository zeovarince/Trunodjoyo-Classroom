@extends('layouts.master')

@section('header_title', 'Profil Pengguna')

@section('content')
@php
    $user = auth()->user();
    $isDosen = $user->role == 'dosen';
    
    // Logika Hitung Level (Hanya untuk Mahasiswa)
    $level = floor($user->exp / 100) + 1;
    $target_xp = $level * 100 + 500;
    $progress_percent = min(100, ($user->exp / $target_xp) * 100);
    
    // Tema Warna
    $themeColor = $isDosen ? 'rose-500' : 'amber-400';
    $themeText = $isDosen ? 'text-rose-500' : 'text-amber-400';
    $themeBg = $isDosen ? 'bg-rose-500' : 'bg-amber-400';
@endphp

<div class="max-w-4xl mx-auto">
    <div class="relative mb-8">
        <div class="h-48 rounded-3xl bg-gradient-to-r {{ $isDosen ? 'from-rose-900 to-slate-800' : 'from-slate-800 to-[#1E293B]' }} border border-slate-700 overflow-hidden relative">
            <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/circuit-board.png');"></div>
        </div>

        <div class="absolute -bottom-12 left-8 flex items-end gap-6">
            <div class="w-32 h-32 rounded-3xl bg-[#0F172A] border-4 border-[#0F172A] overflow-hidden shadow-2xl relative">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background={{ str_replace('#', '', ($isDosen ? 'F43F5E' : 'FBBF24')) }}&color=0F172A&size=256&bold=true" alt="{{ $user->name }}" class="w-full h-full object-cover">
            </div>
            
            <div class="mb-4">
                <h1 class="text-3xl font-black text-white tracking-tight">{{ $user->name }}</h1>
                <p class="text-slate-400 font-medium mt-1 mb-3">
                    {{ $isDosen ? 'NIP/NIDN.' : 'NIM.' }} {{ $user->npm }} • {{ $user->prodi }}
                </p>
                
                <div class="flex items-center gap-3">
                    @if($isDosen)
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-rose-500/10 border border-rose-500/20 rounded-full text-[10px] font-black text-rose-500 uppercase tracking-widest">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                            Lecturer
                        </div>
                    @else
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-400/10 border border-amber-400/20 rounded-full text-[10px] font-black text-amber-400 uppercase tracking-widest">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                            Student
                        </div>
                    @endif
                    <p class="{{ $themeText }} font-bold uppercase tracking-widest text-xs">
                        {{ $isDosen ? 'Tenaga Pengajar' : 'Informatics Student' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-16">
        
        <div class="md:col-span-1 space-y-6">
            <div class="bg-slate-800 border border-slate-700 rounded-3xl p-6 shadow-lg flex flex-col">
                <h3 class="text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-6">Informasi Akun</h3>
                
                <div class="space-y-5 flex-1">
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase font-black tracking-wider">Universitas</p>
                        <p class="text-sm text-white font-bold">Trunojoyo Madura</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase font-black tracking-wider">Fakultas</p>
                        <p class="text-sm text-white font-bold">Teknik</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase font-black tracking-wider">{{ $isDosen ? 'NIP/NIDN' : 'Nomor Induk Mahasiswa' }}</p>
                        <p class="text-sm text-white font-mono font-bold">{{ $user->npm }}</p>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-700/50 space-y-3">
                    <button class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl {{ $themeBg }} text-slate-900 hover:opacity-90 transition-all text-xs font-black uppercase tracking-widest">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        Edit Profil
                    </button>

                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-slate-900 text-rose-500 border border-rose-500/20 hover:bg-rose-500/10 transition-all text-xs font-bold uppercase tracking-wider">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="md:col-span-2 space-y-6">
            
            @if(!$isDosen)
                <div class="bg-slate-800 border border-slate-700 rounded-3xl p-8 shadow-lg relative overflow-hidden h-full">
                    <div class="absolute top-4 right-6 text-8xl font-black text-white/5 pointer-events-none italic">LV.{{ $level }}</div>

                    <h3 class="text-xs font-black {{ $themeText }} uppercase tracking-[0.2em] mb-8">Learning Progress</h3>

                    <div class="space-y-10 relative z-10">
                        <div>
                            <div class="flex justify-between items-end mb-4">
                                <div>
                                    <span class="text-5xl font-black text-white italic">Level {{ $level }}</span>
                                    <span class="text-slate-500 ml-3 font-bold uppercase text-xs tracking-widest">Scholar Rank</span>
                                </div>
                                <span class="{{ $themeText }} font-mono text-sm font-bold">{{ number_format($user->exp) }} / {{ number_format($target_xp) }} XP</span>
                            </div>
                            <div class="w-full h-5 bg-slate-900 rounded-full border border-slate-700 p-1 overflow-hidden">
                                <div class="h-full {{ $themeBg }} rounded-full shadow-[0_0_20px_rgba(251,191,36,0.3)] transition-all duration-1000" style="width: {{ $progress_percent }}%"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-6 bg-slate-900/50 rounded-2xl border border-slate-700/50 group hover:border-amber-400/30 transition-all">
                                <p class="text-3xl font-black text-white group-hover:scale-110 transition-transform origin-left">12</p>
                                <p class="text-[10px] text-slate-500 uppercase font-black tracking-widest mt-1">Kelas Aktif</p>
                            </div>
                            <div class="p-6 bg-slate-900/50 rounded-2xl border border-slate-700/50 group hover:border-amber-400/30 transition-all">
                                <p class="text-3xl font-black text-white group-hover:scale-110 transition-transform origin-left">45</p>
                                <p class="text-[10px] text-slate-500 uppercase font-black tracking-widest mt-1">Tugas Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-slate-800 border border-slate-700 rounded-3xl p-8 shadow-lg relative overflow-hidden h-full flex flex-col justify-center border-t-4 border-t-rose-500">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-rose-500/10 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10 text-center md:text-left">
                        <h3 class="text-xs font-black text-rose-500 uppercase tracking-[0.2em] mb-4 italic">Lecturer Dashboard</h3>
                        <h2 class="text-4xl font-black text-white leading-tight">Selamat Datang,<br>Dosen Pengajar.</h2>
                        <p class="text-slate-400 mt-4 max-w-sm text-sm leading-relaxed font-medium">
                            Anda memiliki akses penuh untuk mengelola kelas, membagikan kode akses, dan memberikan penilaian kepada mahasiswa secara real-time.
                        </p>
                        
                        <div class="grid grid-cols-2 gap-4 mt-10">
                            <div class="p-5 bg-rose-500/5 rounded-2xl border border-rose-500/10">
                                <p class="text-2xl font-black text-white">08</p>
                                <p class="text-[10px] text-slate-500 uppercase font-black mt-1 tracking-tighter">Kelas Diampu</p>
                            </div>
                            <div class="p-5 bg-rose-500/5 rounded-2xl border border-rose-500/10">
                                <p class="text-2xl font-black text-white">240+</p>
                                <p class="text-[10px] text-slate-500 uppercase font-black mt-1 tracking-tighter">Mahasiswa Binaan</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection