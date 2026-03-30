@extends('layouts.master')

@section('header_title', 'Detail Kelas')

@section('content')
@php
    $isDosen = Auth::user()->role === 'dosen';
@endphp

{{-- ====================== HEADER POSTING ====================== --}}
<div class="bg-slate-800 p-6 rounded-xl shadow mb-6 border border-slate-700">
    <div class="flex flex-wrap items-center gap-2 mb-3">
        <span class="text-[10px] px-2 py-1 rounded-full font-black uppercase tracking-widest {{ $lpp->type === 'assignment' ? 'bg-rose-500/20 text-rose-300' : 'bg-amber-500/20 text-amber-300' }}">
            {{ $lpp->type === 'assignment' ? 'Tugas' : 'Pengumuman' }}
        </span>
        @if($lpp->topic)
            <span class="text-[10px] px-2 py-1 rounded-full font-bold uppercase tracking-widest bg-slate-700 text-slate-300">{{ $lpp->topic }}</span>
        @endif
    </div>

    <h1 class="text-2xl font-bold text-amber-400 mb-2">{{ $lpp->title }}</h1>
    <p class="text-slate-300 mb-3">{{ $lpp->description }}</p>

    @if($lpp->type === 'assignment')
        <div class="flex flex-wrap gap-4 text-xs mt-3">
            <span class="text-rose-300 font-bold">Deadline: {{ optional($lpp->deadline)->translatedFormat('d M Y H:i') ?? '-' }}</span>
            <span class="text-amber-300 font-bold">Poin Maks: {{ $lpp->max_points ?? '-' }}</span>
            <span class="text-slate-400">Publish: {{ optional($lpp->publish_at)->translatedFormat('d M Y H:i') ?? 'Langsung' }}</span>
        </div>
    @endif

    {{-- Lampiran posting (single + multiple) --}}
    @if($lpp->file_path || $lpp->attachments->count() > 0)
        <div class="mt-4 pt-4 border-t border-slate-700 grid grid-cols-1 md:grid-cols-2 gap-3">
            @if($lpp->file_path)
                <div class="rounded-xl border border-slate-700 bg-slate-900/60 p-3">
                    <a href="{{ route('lpp.file.preview', $lpp->id) }}" class="block text-sm font-bold text-slate-100 hover:text-amber-300 truncate">Buka File Utama</a>
                    <a href="{{ route('lpp.file.preview', $lpp->id) }}" target="_blank" rel="noopener" class="mt-2 inline-block text-[11px] text-sky-300 hover:text-sky-200 underline underline-offset-4">Buka di tab baru</a>
                </div>
            @endif

            @foreach($lpp->attachments as $attachment)
                @if($attachment->attachment_type === 'file' && $attachment->file_path)
                    <div class="rounded-xl border border-slate-700 bg-slate-900/60 p-3">
                        <a href="{{ route('lpp.attachment.file.preview', $attachment->id) }}" class="block text-sm font-bold text-slate-100 hover:text-amber-300 truncate">{{ basename($attachment->file_path) }}</a>
                        <a href="{{ route('lpp.attachment.file.preview', $attachment->id) }}" target="_blank" rel="noopener" class="mt-2 inline-block text-[11px] text-sky-300 hover:text-sky-200 underline underline-offset-4">Buka di tab baru</a>
                    </div>
                @elseif($attachment->attachment_type === 'link' && $attachment->link_url)
                    <a href="{{ $attachment->link_url }}" target="_blank" rel="noopener" class="flex items-center justify-center rounded-xl border border-slate-700 bg-slate-900/60 px-3 py-4 text-xs text-sky-300 hover:text-sky-200 text-center">Link lampiran</a>
                @endif
            @endforeach
        </div>
    @endif
</div>

{{-- ====================== PANEL DOSEN: NILAI PENGUMPULAN ====================== --}}
@if($isDosen && $lpp->type === 'assignment')
<div class="bg-slate-800 p-6 rounded-xl shadow mb-6 border border-slate-700">
    <h2 class="text-lg font-bold text-amber-400 mb-4">Penilaian Pengumpulan Mahasiswa</h2>

    @if(session('success'))
        <div class="mb-4 rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-3 py-2 text-xs text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

    @forelse($lpp->classroom->students as $student)
        @php
            $submission = $latestSubmissions[$student->id] ?? null;
        @endphp

        <div class="rounded-xl border border-slate-700 p-4 mb-3 bg-slate-900/20">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-3">
                <div>
                    <p class="text-sm font-bold text-yellow-300">{{ $student->name }}</p>
                    <p class="text-[11px] text-slate-500">{{ $student->npm ?? 'NPM belum diisi' }}</p>

                    @if($submission)
                        <p class="text-[11px] text-slate-400 mt-2">Kumpul: {{ $submission->created_at->translatedFormat('d M Y H:i') }}</p>
                        @if($submission->file_path)
                            <iframe src="{{ route('submissions.file.preview', $submission->id) }}" class="w-full mt-2 h-56 rounded-lg border border-slate-700 bg-slate-900"></iframe>
                        @endif
                        @if($submission->link_url)
                            <a href="{{ $submission->link_url }}" target="_blank" rel="noopener" class="block text-xs text-sky-300 hover:text-sky-200 underline underline-offset-4">Buka link</a>
                        @endif
                    @else
                        <p class="text-xs text-rose-300 mt-2">Belum mengumpulkan</p>
                    @endif
                </div>

                @if($submission)
                    <form action="{{ route('submissions.grade', $submission->id) }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        <input type="number" name="grade" min="0" max="{{ $lpp->max_points ?? 100 }}" value="{{ $submission->grade }}" class="w-24 bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-xs text-white">
                        <button type="submit" class="px-3 py-2 bg-amber-400 text-slate-900 text-xs rounded-lg font-black">Simpan Nilai</button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p class="text-slate-400 text-sm">Belum ada mahasiswa pada kelas ini.</p>
    @endforelse
</div>
@endif

{{-- ====================== PANEL MAHASISWA: PENGUMPULAN ====================== --}}
@if(!$isDosen && $lpp->type === 'assignment')
<div class="bg-slate-800 p-6 rounded-xl shadow mb-6 border border-slate-700">
    <h2 class="text-lg font-bold text-amber-400 mb-3">Pengumpulan Mahasiswa</h2>

    @if($currentUserSubmission)
        <div class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-4">
            <p class="text-sm font-bold text-emerald-300">Status: Telah Dikumpulkan</p>
            <p class="text-xs text-slate-300 mt-1">Waktu kirim: {{ $currentUserSubmission->created_at->translatedFormat('d M Y H:i') }}</p>

            @if($currentUserSubmission->grade !== null)
                <p class="text-xs text-amber-300 font-bold mt-2">Nilai Anda: {{ $currentUserSubmission->grade }} / {{ $lpp->max_points ?? 100 }}</p>
            @else
                <p class="text-xs text-slate-400 mt-2">Nilai: menunggu penilaian dosen</p>
            @endif

            @if($currentUserSubmission->file_path)
                <div class="mt-3">
                    <iframe src="{{ route('submissions.file.preview', $currentUserSubmission->id) }}" class="w-full h-72 rounded-lg border border-slate-700 bg-slate-900"></iframe>
                </div>
            @endif

            @if($currentUserSubmission->link_url)
                <a href="{{ $currentUserSubmission->link_url }}" target="_blank" rel="noopener" class="inline-block mt-3 text-xs text-sky-300 hover:text-sky-200 underline underline-offset-4">Buka link pengumpulan</a>
            @endif

            <form action="{{ route('submissions.unsubmit', $currentUserSubmission->id) }}" method="POST" class="mt-3" onsubmit="return confirm('Yakin ingin unsubmit? Setelah unsubmit, Anda bisa kirim ulang.')">
                @csrf
                <button type="submit" class="px-4 py-2 text-xs font-black rounded-lg bg-rose-500/20 text-rose-300 border border-rose-400/30 hover:bg-rose-500/30">Unsubmit</button>
            </form>
        </div>
    @else
        <form action="{{ route('lpp.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="lpp_id" value="{{ $lpp->id }}">

            <input type="file" name="file" class="w-full p-2 bg-slate-900 border border-slate-700 rounded text-white">

            <input type="url" name="link_url" placeholder="Atau tempel link GitHub/Drive" class="w-full mt-3 p-2 bg-slate-900 border border-slate-700 rounded text-white">

            <p class="text-xs text-slate-400 mt-2">Isi minimal salah satu: file atau link.</p>

            <button class="mt-3 px-4 py-2 bg-amber-400 text-slate-900 rounded font-bold">Kirim Pengumpulan</button>
        </form>
    @endif
</div>
@endif

{{-- ====================== DISKUSI ====================== --}}
<div class="bg-slate-800 p-6 rounded-xl shadow border border-slate-700">
    <h2 class="text-xl font-bold text-amber-400 mb-4">Diskusi</h2>

    <form method="POST" action="{{ route('thread.store') }}" class="mb-4">
        @csrf
        <input type="hidden" name="lpp_id" value="{{ $lpp->id }}">

        <textarea name="content" class="w-full p-3 rounded bg-slate-900 border border-slate-700 text-white" placeholder="Tulis diskusi..." required></textarea>

        <button class="mt-2 px-4 py-2 bg-amber-400 text-slate-900 rounded font-bold">Kirim</button>
    </form>

    @forelse($threads as $t)
        <div class="border-b border-slate-700 py-3">
            <p class="text-sm font-bold text-amber-300">{{ $t->user->name ?? 'User' }}</p>
            <p class="text-white text-sm">{{ $t->content }}</p>
            <small class="text-slate-400 text-xs">{{ $t->created_at->translatedFormat('d M Y H:i') }}</small>
        </div>
    @empty
        <p class="text-slate-400">Belum ada diskusi.</p>
    @endforelse
</div>
@endsection
