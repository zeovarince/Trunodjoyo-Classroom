@extends('layouts.master')

@section('header_title', 'Rekap Daftar Tugas')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-amber-400">Tugas Mendatang</h1>
    <p class="text-slate-400 text-sm">Selesaikan tugasmu sebelum deadline untuk mendapatkan EXP!</p>
</div>

<div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden shadow-xl">
    <table class="w-full text-left border-collapse">
        <thead class="bg-slate-700/50 text-slate-400 text-xs uppercase tracking-widest">
            <tr>
                <th class="px-6 py-4 font-semibold">Mata Kuliah</th>
                <th class="px-6 py-4 font-semibold">Judul Tugas</th>
                <th class="px-6 py-4 font-semibold text-center">Deadline</th>
                <th class="px-6 py-4 font-semibold text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-slate-300 divide-y divide-slate-700">
            <tr class="hover:bg-slate-700/30 transition-colors group">
                <td class="px-6 py-4">
                    <span class="text-white font-medium">Pemrograman Web</span>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm">Implementasi Blade Template & Tailwind</p>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="px-3 py-1 bg-red-500/10 text-red-400 border border-red-500/20 rounded-full text-[10px] font-bold">
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
                <td class="px-6 py-4 text-white font-medium">Basis Data</td>
                <td class="px-6 py-4 text-sm">Perancangan ERD Toko Kelontong</td>
                <td class="px-6 py-4 text-center">
                    <span class="px-3 py-1 bg-amber-400/10 text-amber-400 border border-amber-400/20 rounded-full text-[10px] font-bold">
                        30 Mar 2026
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
@endsection