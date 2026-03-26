@extends('layouts.master')

@section('header_title', 'Rekap Daftar Tugas')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-amber-400">Tugas Mendatang</h1>
        <p class="text-slate-400 text-sm">Kelola progres belajarmu di sini.</p>
    </div>

    <div class="relative min-w-[200px]">
        <label class="block text-[10px] font-bold text-amber-400 uppercase tracking-widest mb-1 ml-1">Filter Kelas</label>
        <select class="w-full bg-slate-800 border border-slate-700 text-white text-sm rounded-xl px-4 py-2.5 outline-none focus:border-amber-400 transition-all appearance-none cursor-pointer">
            <option value="all">Semua Kelas</option>
            <option value="web">Pemrograman Web</option>
            <option value="db">Basis Data</option>
            <option value="imk">IMK</option>
        </select>
        <div class="absolute inset-y-0 right-3 flex items-center pt-5 pointer-events-none text-slate-400">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
        </div>
    </div>
</div>

<div class="flex items-center gap-2 border-b border-slate-700 mb-6">
    <button class="px-6 py-3 text-sm font-bold border-b-2 border-amber-400 text-amber-400 transition-all">
        Ditugaskan
    </button>
    <button class="px-6 py-3 text-sm font-medium text-slate-400 hover:text-white hover:border-b-2 hover:border-slate-500 transition-all">
        Belum Diserahkan
    </button>
    <button class="px-6 py-3 text-sm font-medium text-slate-400 hover:text-white hover:border-b-2 hover:border-slate-500 transition-all">
        Selesai
    </button>
</div>

<div class="space-y-4">
    <div class="flex items-center gap-4 py-2">
        <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Minggu Ini</span>
        <div class="flex-1 h-[1px] bg-slate-800"></div>
    </div>

    <div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden shadow-xl">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-700/50 text-slate-400 text-[10px] uppercase tracking-widest">
                <tr>
                    <th class="px-6 py-4 font-bold">Mata Kuliah</th>
                    <th class="px-6 py-4 font-bold">Judul Tugas</th>
                    <th class="px-6 py-4 font-bold text-center">Deadline</th>
                    <th class="px-6 py-4 font-bold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-slate-300 divide-y divide-slate-700">
                <tr class="hover:bg-slate-700/30 transition-colors">
                    <td class="px-6 py-4">
                        <span class="text-white font-semibold">Pemrograman Web</span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm">Implementasi Blade Template & Tailwind</p>
                    </td>
                    <td class="px-6 py-4 text-center text-xs">
                        <span class="px-3 py-1 bg-red-500/10 text-red-400 border border-red-500/20 rounded-full font-bold">
                            27 Mar 2026
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="text-amber-400 hover:text-amber-300 text-sm font-bold underline decoration-2 underline-offset-4">
                            Kerjakan
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-slate-700/30 transition-colors">
                    <td class="px-6 py-4">
                        <span class="text-white font-semibold">Basis Data</span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm">Perancangan ERD Toko Kelontong</p>
                    </td>
                    <td class="px-6 py-4 text-center text-xs">
                        <span class="px-3 py-1 bg-red-500/10 text-red-400 border border-red-500/20 rounded-full font-bold">
                            05 April 2026
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="text-amber-400 hover:text-amber-300 text-sm font-bold underline decoration-2 underline-offset-4">
                            Kerjakan
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection