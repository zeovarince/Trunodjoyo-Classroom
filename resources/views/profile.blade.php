@extends('layouts.master')

@section('header_title', 'Profil Pengguna')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="relative mb-8">
        <div class="h-48 rounded-3xl bg-gradient-to-r from-slate-800 to-[#1E293B] border border-slate-700 overflow-hidden relative">
            <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/circuit-board.png');"></div>
        </div>

        <div class="absolute -bottom-12 left-8 flex items-end gap-6">
            <div class="w-32 h-32 rounded-3xl bg-[#0F172A] border-4 border-[#0F172A] overflow-hidden shadow-2xl">
                <img src="https://ui-avatars.com/api/?name=Ainur+Raftuzzaki&background=FBBF24&color=0F172A&size=256" alt="Zaki" class="w-full h-full object-cover">
            </div>
            <div class="mb-4">
                <h1 class="text-3xl font-black text-white tracking-tight">Ainur Raftuzzaki</h1>
                <p class="text-amber-400 font-bold uppercase tracking-widest text-xs">Front-End / UI Engineer</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-16">
        <div class="md:col-span-1 space-y-6">
            <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-lg">
                <h3 class="text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-4">Data Akademik</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase font-bold">Universitas</p>
                        <p class="text-sm text-white font-medium">Trunojoyo Madura</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase font-bold">Program Studi</p>
                        <p class="text-sm text-white font-medium">Teknik Informatika</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase font-bold">NIM</p>
                        <p class="text-sm text-white font-mono">2104111000xx</p>
                    </div>
                </div>
                <div class="flex items-center justify-left gap-4 mt-4 w-full">

                <button class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-amber-400 border border-amber-400/20 hover:border-amber-400/50 hover:bg-amber-400/10 transition-all text-xs font-bold shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Edit Profil
                </button>

                <button class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-rose-400 border border-rose-400/20 hover:border-rose-400/50 hover:bg-rose-400/10 transition-all text-xs font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    </svg>
                    Keluar
                </button>

            </div>
            </div>
            
        </div>

        <div class="md:col-span-2 space-y-6">
            <div class="bg-slate-800 border border-slate-700 rounded-2xl p-8 shadow-lg relative overflow-hidden">
                <div class="absolute top-4 right-6 text-7xl font-black text-white/5 pointer-events-none">LV.15</div>

                <h3 class="text-xs font-black text-amber-400 uppercase tracking-[0.2em] mb-6">Learning Progress</h3>

                <div class="space-y-8">
                    <div>
                        <div class="flex justify-between items-end mb-3">
                            <div>
                                <span class="text-4xl font-black text-white">Level 15</span>
                                <span class="text-slate-500 ml-2 font-bold">Scholar</span>
                            </div>
                            <span class="text-amber-400 font-mono text-sm">2,500 / 3,000 XP</span>
                        </div>
                        <div class="w-full h-4 bg-slate-900 rounded-full border border-slate-700 p-0.5">
                            <div class="h-full bg-gradient-to-r from-amber-600 to-amber-400 rounded-full shadow-[0_0_15px_rgba(251,191,36,0.3)]" style="width: 83%"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-slate-900/50 rounded-xl border border-slate-700/50">
                            <p class="text-2xl font-black text-white">12</p>
                            <p class="text-[10px] text-slate-500 uppercase font-bold">Kelas Diikuti</p>
                        </div>
                        <div class="p-4 bg-slate-900/50 rounded-xl border border-slate-700/50">
                            <p class="text-2xl font-black text-white">45</p>
                            <p class="text-[10px] text-slate-500 uppercase font-bold">Tugas Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection