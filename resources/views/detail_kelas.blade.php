@extends('layouts.master')

@section('header_title', 'Pemrograman Web - Kelas A')

@section('content')
<div class="relative h-60 rounded-3xl overflow-hidden mb-8 border border-slate-700 shadow-2xl">
    <div class="absolute inset-0 bg-gradient-to-br from-amber-500 via-amber-600 to-amber-800 opacity-90"></div>
    <div class="absolute inset-0 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>
    
    <div class="absolute bottom-8 left-10">
        <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-[10px] font-bold text-white uppercase tracking-widest border border-white/30 mb-3 inline-block">
            Teknik Informatika
        </span>
        <h1 class="text-4xl font-black text-white drop-shadow-xl tracking-tight">Pemrograman Web</h1>
        <p class="text-amber-100 text-lg font-medium">Semester 3 • Ruang A-301</p>
    </div>
</div>

<div class="flex items-center gap-8 border-b border-slate-700 mb-8 px-2">
    <a href="/kelas/detail" 
       class="pb-4 text-sm transition-all {{ request()->is('kelas/detail') ? 'font-bold border-b-2 border-amber-400 text-amber-400' : 'font-medium text-slate-400 hover:text-white' }}">
       Forum
    </a>

    <a href="/tugas" 
       class="pb-4 text-sm transition-all {{ request()->is('tugas') ? 'font-bold border-b-2 border-amber-400 text-amber-400' : 'font-medium text-slate-400 hover:text-white' }}">
       Tugas Kelas
    </a>

    <a href="/anggota" 
       class="pb-4 text-sm transition-all {{ request()->is('kelas/anggota') ? 'font-bold border-b-2 border-amber-400 text-amber-400' : 'font-medium text-slate-400 hover:text-white' }}">
       Anggota
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    
    <div class="space-y-6">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 shadow-lg">
            <h4 class="text-xs font-black text-amber-400 uppercase tracking-widest mb-4">Mendatang</h4>
            <p class="text-xs text-slate-400 leading-relaxed mb-4">Wah, tidak ada tugas yang perlu segera diserahkan!</p>
            <a href="/tugas" class="text-xs font-bold text-amber-400 hover:text-amber-300 transition-all underline underline-offset-4">Lihat Semua</a>
        </div>
    </div>

    <div class="lg:col-span-3 space-y-6">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-4 flex items-center gap-4 shadow-lg group focus-within:border-amber-400 transition-all">
            <div class="w-10 h-10 rounded-full bg-slate-700 border border-slate-600 flex items-center justify-center text-amber-400 font-bold text-xs shadow-inner">ZD</div>
            <input type="text" placeholder="Bagikan sesuatu dengan kelas..." 
                   class="flex-1 bg-transparent border-none outline-none text-sm text-slate-300 placeholder:text-slate-500">
            <button class="p-2 text-slate-400 hover:text-amber-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
            </button>
        </div>

        <div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden shadow-lg hover:border-slate-500 transition-all cursor-pointer">
            <div class="p-6 flex items-start gap-5">
                <div class="w-12 h-12 bg-amber-400/10 rounded-xl flex items-center justify-center text-amber-400 border border-amber-400/20 shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <a href="/tugas/detail" >
                        <h3 class="font-bold text-white text-lg group-hover:text-amber-400 transition-colors">Materi 01: Pengenalan Laravel & Arsitektur MVC</h3>
                        <span class="text-[10px] text-slate-500 font-mono">26 MAR 2026</span>
                        </a>
                    </div>
                    <p class="text-sm text-slate-400 mt-2 line-clamp-2">Silahkan pelajari dokumentasi awal mengenai struktur folder Laravel dan bagaimana cara kerja Routing.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection