@extends('layouts.master')

@section('header_title', 'Anggota: Pemrograman Web A')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-10 pb-6 border-b border-slate-700/50">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight">Anggota Kelas</h1>
            <p class="text-slate-400 text-sm mt-1">Pemrograman Web • Kelas A-301</p>
        </div>
        <div class="text-right">
            <span class="text-[10px] text-amber-400 font-black uppercase tracking-[0.2em]">Total</span>
            <p class="text-2xl font-bold text-white">32 Orang</p>
        </div>
    </div>

    <div class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-amber-400 flex items-center gap-3">
                Pengajar
                <span class="h-px w-20 bg-amber-400/20"></span>
            </h2>
        </div>
        
        <div class="space-y-3">
            <div class="group flex items-center justify-between p-4 bg-slate-800/40 border border-slate-700 rounded-2xl hover:border-amber-400/50 transition-all">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name=Aris+Sudaryanto&background=FBBF24&color=0F172A" class="w-12 h-12 rounded-xl border-2 border-amber-400 p-0.5">
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-amber-400 rounded-full flex items-center justify-center border-2 border-slate-800">
                            <svg class="w-2 h-2 text-slate-900" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold text-white group-hover:text-amber-400 transition-colors">Dr. Aris Sudaryanto, S.Kom., M.T.</h4>
                        <p class="text-[10px] text-slate-500 uppercase font-black tracking-widest">Dosen Pengampu</p>
                    </div>
                </div>
                <button class="p-2 text-slate-500 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                </button>
            </div>
        </div>
    </div>

    <div>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-white flex items-center gap-3">
                Teman Sekelas
                <span class="h-px w-20 bg-slate-700"></span>
            </h2>
            <span class="text-xs font-bold text-slate-500">31 Siswa</span>
        </div>

        <div class="grid gap-3">
            @php
                $students = ['Ainur Raftuzzaki', 'Budi Santoso', 'Siti Aminah', 'Dian Pratama'];
            @endphp

            @foreach($students as $student)
            <div class="flex items-center justify-between p-4 bg-slate-800/20 border border-slate-700/50 rounded-2xl hover:bg-slate-800 transition-all">
                <div class="flex items-center gap-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($student) }}&background=334155&color=fff" class="w-10 h-10 rounded-xl">
                    <div>
                        <h4 class="text-sm font-bold text-slate-200">{{ $student }}</h4>
                        <p class="text-[9px] text-slate-500 font-mono tracking-tighter">MHS-{{ rand(1000, 9999) }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="text-right mr-3 hidden md:block">
                        <p class="text-[10px] text-amber-400/50 font-bold uppercase">Rank</p>
                        <p class="text-xs font-black text-white">#{{ rand(1, 100) }}</p>
                    </div>
                    <button class="p-2 text-slate-600 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" /></svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection