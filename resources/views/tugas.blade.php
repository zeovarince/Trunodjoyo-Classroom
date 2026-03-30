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
        <select id="filter-kelas" onchange="filterTasks()" class="w-full bg-slate-800 border border-slate-700 text-white text-sm rounded-xl px-4 py-2.5 outline-none focus:border-amber-400 transition-all appearance-none cursor-pointer">
            <option value="all">Semua Kelas</option>
            
            {{-- PERBAIKAN DI SINI: Mengambil semua kelas yang diikuti/diajar user --}}
            @php
                $user = Auth::user();
                $daftarKelas = $user->role == 'dosen' ? $user->taughtClassrooms : $user->joinedClassrooms;
            @endphp
            
            @if($daftarKelas && $daftarKelas->count() > 0)
                @foreach($daftarKelas as $kelas)
                    <option value="{{ $kelas->name }}">{{ $kelas->name }}</option>
                @endforeach
            @endif
            
        </select>
        <div class="absolute inset-y-0 right-3 flex items-center pt-5 pointer-events-none text-slate-400">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
        </div>
    </div>
</div>

{{-- MENU TAB TUGAS --}}
<div class="flex items-center gap-2 border-b border-slate-700 mb-6">
    <button id="btn-ditugaskan" onclick="switchTab('ditugaskan')" class="tab-btn px-6 py-3 text-sm font-bold border-b-2 border-amber-400 text-amber-400 transition-all">
        Ditugaskan <span class="ml-1 bg-amber-400 text-slate-900 px-2 py-0.5 rounded-full text-xs">{{ $ditugaskan->count() }}</span>
    </button>
    <button id="btn-belum" onclick="switchTab('belum')" class="tab-btn px-6 py-3 text-sm font-medium text-slate-400 hover:text-white hover:border-b-2 hover:border-slate-500 transition-all">
        Belum Diserahkan <span class="ml-1 bg-slate-700 text-white px-2 py-0.5 rounded-full text-xs">{{ $belumDiserahkan->count() }}</span>
    </button>
    <button id="btn-selesai" onclick="switchTab('selesai')" class="tab-btn px-6 py-3 text-sm font-medium text-slate-400 hover:text-white hover:border-b-2 hover:border-slate-500 transition-all">
        Selesai <span class="ml-1 bg-slate-700 text-white px-2 py-0.5 rounded-full text-xs">{{ $selesai->count() }}</span>
    </button>
</div>

<div class="space-y-4">
    <div class="flex items-center gap-4 py-2">
        <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]" id="tab-subtitle">Daftar Tugas Baru</span>
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
            
            {{-- 1. TAB DITUGASKAN --}}
            <tbody id="tab-ditugaskan" class="tab-content text-slate-300 divide-y divide-slate-700">
                @forelse($ditugaskan as $tugas)
                <tr class="task-row hover:bg-slate-700/30 transition-colors" data-matkul="{{ $tugas->lpp->classroom->name ?? '-' }}">
                    <td class="px-6 py-4"><span class="text-white font-semibold">{{ $tugas->lpp->classroom->name ?? '-' }}</span></td>
                    <td class="px-6 py-4"><p class="text-sm">{{ $tugas->title }}</p></td>
                    <td class="px-6 py-4 text-center text-xs">
                        <span class="px-3 py-1 bg-amber-500/10 text-amber-400 border border-amber-500/20 rounded-full font-bold">
                            {{ \Carbon\Carbon::parse($tugas->deadline)->translatedFormat('d M Y') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('tugas.detail', $tugas->id) }}" class="text-amber-400 hover:text-amber-300 text-sm font-bold underline decoration-2 underline-offset-4">Kerjakan</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-8 text-center text-slate-500 text-sm italic">Hore! Tidak ada tugas baru.</td></tr>
                @endforelse
            </tbody>

            {{-- 2. TAB BELUM DISERAHKAN --}}
            <tbody id="tab-belum" class="tab-content hidden text-slate-300 divide-y divide-slate-700">
                @forelse($belumDiserahkan as $tugas)
                <tr class="task-row hover:bg-slate-700/30 transition-colors" data-matkul="{{ $tugas->lpp->classroom->name ?? '-' }}">
                    <td class="px-6 py-4"><span class="text-white font-semibold">{{ $tugas->lpp->classroom->name ?? '-' }}</span></td>
                    <td class="px-6 py-4"><p class="text-sm">{{ $tugas->title }}</p></td>
                    <td class="px-6 py-4 text-center text-xs">
                        <span class="px-3 py-1 bg-red-500/10 text-red-400 border border-red-500/20 rounded-full font-bold">
                            Terlambat ({{ \Carbon\Carbon::parse($tugas->deadline)->translatedFormat('d M') }})
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('tugas.detail', $tugas->id) }}" class="text-red-400 hover:text-red-300 text-sm font-bold underline decoration-2 underline-offset-4">Tetap Kerjakan</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-8 text-center text-slate-500 text-sm italic">Hebat! Tidak ada tugas yang terlewat.</td></tr>
                @endforelse
            </tbody>

            {{-- 3. TAB SELESAI --}}
            <tbody id="tab-selesai" class="tab-content hidden text-slate-300 divide-y divide-slate-700">
                @forelse($selesai as $tugas)
                <tr class="task-row hover:bg-slate-700/30 transition-colors" data-matkul="{{ $tugas->lpp->classroom->name ?? '-' }}">
                    <td class="px-6 py-4"><span class="text-white font-semibold">{{ $tugas->lpp->classroom->name ?? '-' }}</span></td>
                    <td class="px-6 py-4"><p class="text-sm">{{ $tugas->title }}</p></td>
                    <td class="px-6 py-4 text-center text-xs">
                        <span class="px-3 py-1 bg-green-500/10 text-green-400 border border-green-500/20 rounded-full font-bold">
                            Sudah Dinilai / Selesai
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('tugas.detail', $tugas->id) }}" class="text-slate-400 hover:text-white text-sm font-bold underline decoration-2 underline-offset-4">Lihat Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-8 text-center text-slate-500 text-sm italic">Belum ada tugas yang diselesaikan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    // FUNGSI PINDAH TAB
    function switchTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.getElementById('tab-' + tabName).classList.remove('hidden');

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.className = 'tab-btn px-6 py-3 text-sm font-medium text-slate-400 hover:text-white hover:border-b-2 hover:border-slate-500 transition-all';
            let badge = btn.querySelector('span');
            badge.className = 'ml-1 bg-slate-700 text-white px-2 py-0.5 rounded-full text-xs';
        });

        let activeBtn = document.getElementById('btn-' + tabName);
        activeBtn.className = 'tab-btn px-6 py-3 text-sm font-bold border-b-2 border-amber-400 text-amber-400 transition-all';
        activeBtn.querySelector('span').className = 'ml-1 bg-amber-400 text-slate-900 px-2 py-0.5 rounded-full text-xs font-black';

        let subtitle = "Daftar Tugas Baru";
        if(tabName === 'belum') subtitle = "Tugas Terlewat Deadline";
        if(tabName === 'selesai') subtitle = "Tugas Selesai Dikerjakan";
        document.getElementById('tab-subtitle').innerText = subtitle;
    }

    // FUNGSI FILTER 
    function filterTasks() {
        const selectedMatkul = document.getElementById('filter-kelas').value;
        const allTaskRows = document.querySelectorAll('.task-row');

        allTaskRows.forEach(row => {
            const rowMatkul = row.getAttribute('data-matkul');
            
            if (selectedMatkul === 'all' || selectedMatkul === rowMatkul) {
                row.style.display = ''; 
            } else {
                row.style.display = 'none'; 
            }
        });
    }
</script>
@endsection