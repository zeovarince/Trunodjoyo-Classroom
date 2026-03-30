@extends('layouts.master')

@section('header_title', 'Tugas: ' . $assignment->title)

@section('content')
<div class="max-w-6xl mx-auto">
    <nav class="flex mb-6 text-sm font-medium text-slate-500">
        <a href="{{ route('tugas') }}" class="hover:text-amber-400">Daftar Tugas</a>
        <span class="mx-2">/</span>
        <span class="text-slate-300">Detail Tugas</span>
    </nav>

    @if (session('success'))
        <div class="mb-6 rounded-xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-300 px-4 py-3 text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-rose-500/30 bg-rose-500/10 text-rose-300 px-4 py-3 text-sm">
            <p class="font-bold mb-1">Gagal mengumpulkan tugas:</p>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-slate-800 border border-slate-700 rounded-3xl p-8 shadow-xl">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 bg-amber-400/10 rounded-2xl flex items-center justify-center text-amber-400 border border-amber-400/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-white tracking-tight">{{ $assignment->title }}</h1>
                        <p class="text-slate-400 text-sm font-medium">
                            Kelas: {{ $assignment->lpp->classroom->name ?? '-' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-6 py-4 border-y border-slate-700/50 mb-6">
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">Tenggat Waktu</p>
                        <p class="text-sm text-rose-400 font-bold">{{ \Carbon\Carbon::parse($assignment->deadline)->translatedFormat('d M Y, H:i') }} WIB</p>
                    </div>
                    <div class="w-px h-8 bg-slate-700"></div>
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">Poin Maksimal</p>
                        <p class="text-sm text-amber-400 font-bold">{{ $assignment->max_exp ?? 100 }} Poin</p>
                    </div>
                </div>

                <div class="prose prose-invert max-w-none text-slate-300">
                    <p class="mb-4">Instruksi tugas:</p>
                    <div class="text-sm leading-relaxed">
                        {{ $assignment->description ?: 'Tidak ada deskripsi tambahan untuk tugas ini.' }}
                    </div>
                </div>

                @if($assignment->lpp && ($assignment->lpp->file_path || $assignment->lpp->attachments->count() > 0))
                    <div class="mt-8">
                        <h4 class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4">Lampiran Materi</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @if($assignment->lpp->file_path)
                                <div class="rounded-xl border border-slate-700 bg-slate-900/60 p-3">
                                    <a href="{{ route('lpp.file.preview', $assignment->lpp->id) }}" class="block text-sm font-bold text-slate-100 hover:text-amber-300 truncate">
                                        Buka Lampiran Utama
                                    </a>
                                    <a href="{{ route('lpp.file.preview', $assignment->lpp->id) }}" target="_blank" rel="noopener" class="mt-2 inline-block text-[11px] text-sky-300 hover:text-sky-200 underline underline-offset-4">Buka di tab baru</a>
                                </div>
                            @endif

                            @foreach($assignment->lpp->attachments as $attachment)
                                @if($attachment->attachment_type === 'file' && $attachment->file_path)
                                    <div class="rounded-xl border border-slate-700 bg-slate-900/60 p-3">
                                        <a href="{{ route('lpp.attachment.file.preview', $attachment->id) }}" class="block text-sm font-bold text-slate-100 hover:text-amber-300 truncate">{{ basename($attachment->file_path) }}</a>
                                        <a href="{{ route('lpp.attachment.file.preview', $attachment->id) }}" target="_blank" rel="noopener" class="mt-2 inline-block text-[11px] text-sky-300 hover:text-sky-200 underline underline-offset-4">Buka di tab baru</a>
                                    </div>
                                @elseif($attachment->attachment_type === 'link' && $attachment->link_url)
                                    <a href="{{ $attachment->link_url }}" target="_blank" rel="noopener" class="flex items-center justify-center rounded-xl border border-slate-700 bg-slate-900/60 px-3 py-4 text-xs text-sky-300 hover:text-sky-200 text-center">Link Lampiran</a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-slate-800 border border-slate-700 rounded-3xl p-6 shadow-xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-amber-400"></div>
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-white">Tugas Anda</h3>
                    @if($submission)
                        <span class="px-2 py-1 bg-emerald-500/20 text-emerald-300 text-[10px] font-black rounded uppercase tracking-tighter">Telah Diserahkan</span>
                    @else
                        <span class="px-2 py-1 bg-slate-700 text-slate-400 text-[10px] font-black rounded uppercase tracking-tighter">Ditugaskan</span>
                    @endif
                </div>

                @if($submission)
                    <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 p-4 space-y-3">
                        <p class="text-xs text-emerald-300 font-bold">Diserahkan: {{ $submission->created_at->translatedFormat('d M Y, H:i') }} WIB</p>

                        @if($submission->grade !== null)
                            <p class="text-sm font-black text-amber-300">Nilai: {{ $submission->grade }} / {{ $assignment->max_exp ?? 100 }}</p>
                        @else
                            <p class="text-xs text-slate-300">Nilai: menunggu penilaian dosen</p>
                        @endif

                        @if($submission->file_path)
                            <iframe src="{{ route('submissions.file.preview', $submission->id) }}" class="w-full h-56 rounded-lg border border-emerald-500/20 bg-slate-900"></iframe>
                        @elseif($submission->link_url)
                            <a href="{{ $submission->link_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-300 hover:text-emerald-200 underline underline-offset-4">Buka Link Pengumpulan</a>
                        @endif

                        <form action="{{ route('submissions.unsubmit', $submission->id) }}" method="POST" onsubmit="return confirm('Yakin ingin unsubmit? Setelah ini kamu bisa submit ulang.')">
                            @csrf
                            <button type="submit" class="w-full bg-rose-500/20 border border-rose-400/30 text-rose-300 py-2 rounded-xl font-black text-xs tracking-wider hover:bg-rose-500/30">Unsubmit</button>
                        </form>
                    </div>
                @else
                    <form action="{{ route('lpp.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
                        <input type="hidden" name="lpp_id" value="{{ $assignment->lpp_id }}">

                        <label class="border-2 border-dashed border-slate-700 rounded-2xl p-8 flex flex-col items-center justify-center text-center group hover:border-amber-400/50 transition-all cursor-pointer mb-4 bg-slate-900/30" for="file">
                            <div class="w-12 h-12 bg-slate-800 rounded-full flex items-center justify-center text-slate-500 mb-3 group-hover:scale-110 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            </div>
                            <p class="text-xs font-bold text-slate-300">Pilih File Tugas (Opsional)</p>
                            <p class="text-[10px] text-slate-500 mt-1 uppercase tracking-widest font-bold">PDF / DOC / DOCX (Maks 2MB)</p>
                            <input id="file" type="file" name="file" class="hidden" accept=".pdf,.doc,.docx">
                        </label>

                        <div>
                            <label for="link_url" class="block text-[11px] text-slate-400 font-bold uppercase tracking-widest mb-2">Atau Kirim Link</label>
                            <input id="link_url" type="url" name="link_url" value="{{ old('link_url') }}" placeholder="https://github.com/... atau https://drive.google.com/..." class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-xs text-white focus:border-amber-400 outline-none">
                        </div>

                        <p class="text-[11px] text-slate-500">Isi minimal salah satu: file atau link.</p>

                        <button type="submit" class="w-full bg-amber-400 hover:bg-amber-500 text-[#0F172A] py-3 rounded-xl font-black text-sm transition-all shadow-lg shadow-amber-400/10">
                            Serahkan Sekarang
                        </button>
                    </form>
                @endif
            </div>

            <div class="bg-slate-800 border border-slate-700 rounded-3xl p-6 shadow-xl">
                <h3 class="font-bold text-white mb-2 text-sm">Status Deadline</h3>
                @if(\Carbon\Carbon::parse($assignment->deadline)->isPast())
                    <p class="text-xs text-rose-300">Deadline sudah lewat. Sistem menutup pengumpulan tambahan.</p>
                @else
                    <p class="text-xs text-emerald-300">Deadline masih aktif. Pastikan file final sudah benar sebelum submit.</p>
                @endif
            </div>

            @if(isset($submissionHistory) && $submissionHistory->count() > 0)
                <div class="bg-slate-800 border border-slate-700 rounded-3xl p-6 shadow-xl">
                    <h3 class="font-bold text-white mb-3 text-sm">Riwayat Pengumpulan</h3>
                    <div class="space-y-3 max-h-64 overflow-y-auto pr-1">
                        @foreach($submissionHistory->take(10) as $item)
                            <div class="rounded-xl border border-slate-700 bg-slate-900/40 p-3">
                                <p class="text-[11px] text-slate-400 mb-2">{{ $item->created_at->translatedFormat('d M Y, H:i') }} WIB</p>
                                @if($item->file_path)
                                    <iframe src="{{ route('submissions.file.preview', $item->id) }}" class="w-full h-56 rounded-lg border border-slate-700 bg-slate-900"></iframe>
                                @elseif($item->link_url)
                                    <a href="{{ $item->link_url }}" target="_blank" rel="noopener" class="text-xs font-bold text-amber-300 hover:text-amber-200 underline underline-offset-4">Buka Link Versi Ini</a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection