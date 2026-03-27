@extends('layouts.master')

@section('header_title', 'Tugas: Implementasi CRUD Laravel')

@section('content')
<div class="max-w-6xl mx-auto">
    <nav class="flex mb-6 text-sm font-medium text-slate-500">
        <a href="/tugas" class="hover:text-amber-400">Daftar Tugas</a>
        <span class="mx-2">/</span>
        <span class="text-slate-300">Detail Tugas</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-slate-800 border border-slate-700 rounded-3xl p-8 shadow-xl">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 bg-amber-400/10 rounded-2xl flex items-center justify-center text-amber-400 border border-amber-400/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-white tracking-tight">Implementasi CRUD & Migrations</h1>
                        <p class="text-slate-400 text-sm font-medium">Dosen: Dr. Aris Sudaryanto • 26 Mar 2026</p>
                    </div>
                </div>

                <div class="flex items-center gap-6 py-4 border-y border-slate-700/50 mb-6">
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">Tenggat Waktu</p>
                        <p class="text-sm text-rose-400 font-bold">Besok, 23:59 WIB</p>
                    </div>
                    <div class="w-px h-8 bg-slate-700"></div>
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">Poin Maksimal</p>
                        <p class="text-sm text-amber-400 font-bold">100 Poin</p>
                    </div>
                </div>

                <div class="prose prose-invert max-w-none text-slate-300">
                    <p class="mb-4">Silahkan kerjakan tugas praktikum minggu ini dengan ketentuan sebagai berikut:</p>
                    <ul class="list-disc pl-5 space-y-2 mb-6 text-sm">
                        <li>Buatlah skema database menggunakan Laravel Migrations.</li>
                        <li>Implementasikan fungsi Create, Read, Update, dan Delete pada entitas 'Produk'.</li>
                        <li>Gunakan Tailwind CSS untuk styling (seperti yang kita pelajari di kelas).</li>
                        <li>Kumpulkan dalam bentuk link GitHub atau file ZIP.</li>
                    </ul>
                </div>

                <div class="mt-8">
                    <h4 class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4">Lampiran Materi</h4>
                    <div class="flex flex-wrap gap-3">
                        <div class="flex items-center gap-3 p-3 bg-slate-900/50 border border-slate-700 rounded-xl hover:border-amber-400 transition-all cursor-pointer group">
                            <div class="w-8 h-8 bg-rose-500/20 text-rose-500 rounded flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                            </div>
                            <span class="text-xs font-bold text-slate-300 group-hover:text-white">Modul_CRUD.pdf</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-slate-800 border border-slate-700 rounded-3xl p-6 shadow-xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-amber-400"></div>
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-white">Tugas Anda</h3>
                    <span class="px-2 py-1 bg-slate-700 text-slate-400 text-[10px] font-black rounded uppercase tracking-tighter">Ditugaskan</span>
                </div>

                <div class="border-2 border-dashed border-slate-700 rounded-2xl p-8 flex flex-col items-center justify-center text-center group hover:border-amber-400/50 transition-all cursor-pointer mb-4 bg-slate-900/30">
                    <div class="w-12 h-12 bg-slate-800 rounded-full flex items-center justify-center text-slate-500 mb-3 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    </div>
                    <p class="text-xs font-bold text-slate-300">Tambah atau Buat</p>
                    <p class="text-[10px] text-slate-500 mt-1 uppercase tracking-widest font-bold">File / Link / Google Drive</p>
                </div>

                <button class="w-full bg-amber-400 hover:bg-amber-500 text-[#0F172A] py-3 rounded-xl font-black text-sm transition-all shadow-lg shadow-amber-400/10">
                    Serahkan Sekarang
                </button>
            </div>

            <div class="bg-slate-800 border border-slate-700 rounded-3xl p-6 shadow-xl">
                <h3 class="font-bold text-white mb-4 text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                    Komentar Pribadi
                </h3>
                <div class="flex items-center gap-3">
                    <input type="text" placeholder="Tambahkan komentar..." class="flex-1 bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-xs text-white focus:border-amber-400 outline-none">
                    <button class="text-amber-400 hover:text-amber-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" /></svg>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection