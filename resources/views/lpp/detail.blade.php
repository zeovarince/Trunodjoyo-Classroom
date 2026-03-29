@extends('layouts.master')

@section('header_title', 'Detail LPP')

@section('content')
<div class="bg-[#1E293B] p-6 rounded-xl shadow mb-6">
    <h1 class="text-2xl font-bold text-[#FBBF24] mb-2">
        {{ $lpp->title }}
    </h1>

    <p class="text-slate-300 mb-3">
        {{ $lpp->description }}
    </p>

    @if($lpp->file_path)
        <a href="{{ asset($lpp->file_path) }}" target="_blank"
           class="inline-block px-4 py-2 bg-green-500 text-black rounded font-bold">
             Lihat Materi
        </a>
    @endif
</div>

    <!-- ================== TUGAS ================== -->
    <div class="bg-[#1E293B] p-6 rounded-xl shadow mb-6">
        <h2 class="text-xl font-bold text-[#FBBF24] mb-4">
            📝 Tugas
        </h2>

        @forelse($assignments as $a)
            <div class="border-b border-slate-700 py-3">
                <h4 class="font-semibold text-white">{{ $a->title }}</h4>
                <p class="text-slate-400 text-sm">{{ $a->description }}</p>
                <small class="text-[#FBBF24]">
                    Deadline: {{ $a->deadline }}
                </small>
            </div>
        @empty
            <p class="text-slate-400">Belum ada tugas.</p>
        @endforelse
    </div>

    <!-- ================== DISKUSI ================== -->
    <div class="bg-[#1E293B] p-6 rounded-xl shadow">
        <h2 class="text-xl font-bold text-[#FBBF24] mb-4">
            💬 Diskusi
        </h2>

        <!-- FORM DISKUSI -->
        <form method="POST" action="{{ route('thread.store') }}" class="mb-4">
            @csrf
            <input type="hidden" name="lpp_id" value="{{ $lpp->id }}">

            <textarea 
                name="content"
                class="w-full p-3 rounded bg-[#0F172A] border border-slate-700 text-white focus:outline-none focus:ring-2 focus:ring-[#FBBF24]"
                placeholder="Tulis diskusi..."
                required
            ></textarea>

            <button 
                class="mt-2 px-4 py-2 bg-[#FBBF24] text-black rounded font-bold hover:opacity-90 transition">
                Kirim
            </button>
        </form>

        <!-- LIST THREAD -->
        @forelse($threads as $t)
            <div class="border-b border-slate-700 py-3">
                <p class="text-sm font-bold text-[#FBBF24]">
                    {{ $t->user->name ?? 'User' }}
                </p>
                <p class="text-white">{{ $t->content }}</p>
                <small class="text-slate-400 text-xs">
                    {{ $t->created_at }}
                </small>
            </div>
        @empty
            <p class="text-slate-400">Belum ada diskusi.</p>
        @endforelse

    </div>

</div>
@endsection