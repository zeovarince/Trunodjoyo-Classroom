@extends('layouts.master')

@section('header_title', 'Beranda')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold">Halo, Zaki! 👋</h1>
    <p class="text-slate-400">Kamu terdaftar di <span class="text-amber-400 font-bold text-lg">2</span> kelas aktif.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    
    <div class="group relative bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden hover:border-amber-400 transition-all duration-300 shadow-lg hover:shadow-amber-400/10 cursor-pointer flex flex-col">
        
        <div class="h-24 bg-gradient-to-br from-amber-400 to-amber-600 p-4 relative flex flex-col justify-end">
            <div class="absolute top-2 right-2 bg-slate-900/40 backdrop-blur-sm px-2 py-1 rounded text-[10px] text-white font-bold uppercase tracking-wider">
                TEKNIK INFORMATIKA
            </div>
            <h2 class="text-slate-900 font-bold text-lg leading-tight">Pemrograman Web</h2>
            <p class="text-slate-900/80 text-xs font-medium italic">Kelas - A</p>
        </div>

        <div class="p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 rounded-full bg-slate-700 border border-slate-600 flex items-center justify-center text-xs font-bold text-amber-400">
                    SD
                </div>
                <div class="text-sm">
                    <p class="font-semibold text-white">Senior Developer</p>
                    <p class="text-slate-400 text-xs">Dosen Pengampu</p>
                </div>
            </div>

            <div class="space-y-1 mb-5">
                <div class="flex justify-between text-[10px] text-slate-400 uppercase font-bold tracking-tighter">
                    <span>Progress Belajar</span>
                    <span>75%</span>
                </div>
                <div class="w-full h-1.5 bg-slate-700 rounded-full overflow-hidden">
                    <div class="bg-amber-400 h-full rounded-full" style="width: 75%"></div>
                </div>
            </div>
        </div>

        <div class="px-5 pb-5 mt-auto">
            <button class="w-full py-2 bg-slate-700 group-hover:bg-amber-400 group-hover:text-slate-900 rounded-lg text-sm font-bold transition-colors">
                <a href="{{ route('lpp.show', 1) }}" 
   class="block text-center w-full py-2 bg-slate-700 group-hover:bg-amber-400 group-hover:text-slate-900 rounded-lg text-sm font-bold transition-colors">
    Masuk Kelas
</a>
            </button>
        </div>
    </div>
    <div class="group relative bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden hover:border-amber-400 transition-all duration-300 shadow-lg hover:shadow-amber-400/10 cursor-pointer flex flex-col">
        <div class="h-24 bg-gradient-to-br from-amber-400 to-amber-600 p-4 relative flex flex-col justify-end">
            <div class="absolute top-2 right-2 bg-slate-900/40 backdrop-blur-sm px-2 py-1 rounded text-[10px] text-white font-bold uppercase tracking-wider">
                TEKNIK INFORMATIKA
            </div>
            <h2 class="text-slate-900 font-bold text-lg leading-tight">Basis Data</h2>
            <p class="text-slate-900/80 text-xs font-medium italic">Kelas - B</p>
        </div>
        <div class="p-5 flex-1">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 rounded-full bg-slate-700 border border-slate-600 flex items-center justify-center text-xs font-bold text-amber-400">
                    BD
                </div>
                <div class="text-sm">
                    <p class="font-semibold text-white">Bu Dosen Basisdata</p>
                    <p class="text-slate-400 text-xs">Dosen Pengampu</p>
                </div>
            </div>
            <div class="space-y-1 mb-5">
                <div class="flex justify-between text-[10px] text-slate-400 uppercase font-bold tracking-tighter">
                    <span>Progress Belajar</span>
                    <span>25%</span>
                </div>
                <div class="w-full h-1.5 bg-slate-700 rounded-full overflow-hidden">
                    <div class="bg-amber-400 h-full rounded-full" style="width: 25%"></div>
                </div>
            </div>
        </div>
        <div class="px-5 pb-5 mt-auto">
            <button class="w-full py-2 bg-slate-700 group-hover:bg-amber-400 group-hover:text-slate-900 rounded-lg text-sm font-bold transition-colors">
    Masuk Kelas
            </button>
        </div>
    </div>
    </div>
@endsection