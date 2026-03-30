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

</div>

{{-- ================== UPLOAD FILE ================== --}}
<div class="bg-[#1E293B] p-6 rounded-xl shadow mb-6">
    <h2 class="text-lg font-bold text-[#FBBF24] mb-3">
        📤 Upload Tugas
    </h2>

    <form action="{{ route('lpp.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="lpp_id" value="{{ $lpp->id }}">

        <input 
            type="file" 
            name="file" 
            required
            class="w-full p-2 bg-[#0F172A] border border-slate-700 rounded text-white"
        >

        <button class="mt-3 px-4 py-2 bg-blue-500 text-white rounded font-bold">
            Upload
        </button>
    </form>
</div>

<!-- ================== DISKUSI ================== -->
<div class="bg-[#1E293B] p-6 rounded-xl shadow">
    <h2 class="text-xl font-bold text-[#FBBF24] mb-4">
        💬 Diskusi
    </h2>

    <form method="POST" action="{{ route('thread.store') }}" class="mb-4">
        @csrf

        <input type="hidden" name="lpp_id" value="{{ $lpp->id }}">

        <textarea 
            name="content"
            class="w-full p-3 rounded bg-[#0F172A] border border-slate-700 text-white"
            placeholder="Tulis diskusi..."
            required
        ></textarea>

        <button 
            class="mt-2 px-4 py-2 bg-yellow-400 text-black rounded font-bold">
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

@endsection