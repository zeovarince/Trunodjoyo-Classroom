@extends('layouts.master')

@section('header_title', 'Profil Pengguna')

@section('content')
@php
    $themeColor = $isDosen ? 'rose-500' : 'amber-400';
    $themeText = $isDosen ? 'text-rose-500' : 'text-amber-400';
    $themeBg = $isDosen ? 'bg-rose-500' : 'bg-amber-400';
    $avatarUrl = $user->avatar ? route('profile.avatar', $user->id) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background='.($isDosen ? 'F43F5E' : 'FBBF24').'&color=0F172A&size=256&bold=true';
    $frameLabel = $frameLabels[$level] ?? 'Bronze Frame';
@endphp

<div class="max-w-4xl mx-auto">
    @if(session('success'))
        <div class="mb-6 rounded-xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-300 px-4 py-3 text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-rose-500/30 bg-rose-500/10 text-rose-300 px-4 py-3 text-sm">
            <p class="font-bold mb-1">Terdapat kesalahan input:</p>
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($isDosen)
        <div class="mb-8 rounded-[44px] border border-slate-600/80 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 p-5 md:p-7 relative overflow-hidden">
            <div class="absolute -top-14 -left-10 w-44 h-44 rounded-full bg-rose-500/10 blur-3xl"></div>
            <div class="absolute -bottom-16 -right-8 w-52 h-52 rounded-full bg-cyan-400/10 blur-3xl"></div>

            <div class="relative z-10 flex flex-col gap-5">
                <div class="flex items-center justify-between gap-4">
                    <div class="space-y-3">
                        <span class="inline-flex items-center gap-2 rounded-full border border-rose-400/40 bg-rose-500/10 px-3 py-1 text-[10px] font-black uppercase tracking-[0.2em] text-rose-300">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-300"></span>
                            Dosen Aktif
                        </span>
                        <img src="{{ asset('images/dosen.png') }}" alt="Dosen UTM" class="h-20 md:h-24 w-auto object-contain rounded-xl bg-white/95 px-3 py-2 shadow-lg">
                    </div>

                    <div class="w-24 h-24 md:w-28 md:h-28 rounded-full border-4 border-slate-300 overflow-hidden shadow-2xl ring-4 ring-rose-400/20">
                        <img src="{{ $avatarUrl }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    </div>
                </div>

                <div>
                    <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight">{{ $user->name }}</h1>
                    <p class="text-slate-300 font-medium mt-1">
                        NIP/NIDN. {{ $user->npm ?: '-' }} • {{ $user->prodi ?: '-' }}
                    </p>
                    <div class="mt-4 flex flex-wrap items-center gap-2">
                        <span class="px-3 py-1 rounded-full bg-white/10 border border-white/15 text-[10px] font-bold uppercase tracking-wider text-slate-200">{{ $user->fakultas ?: 'Fakultas -' }}</span>
                        <span class="px-3 py-1 rounded-full bg-rose-500/15 border border-rose-400/30 text-[10px] font-bold uppercase tracking-wider text-rose-200">Pahlawan Tanpa Jasa</span>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="relative mb-8">
            <div class="h-56 rounded-3xl bg-gradient-to-r from-amber-300 via-amber-400 to-amber-500 border border-amber-200/40 overflow-hidden relative shadow-2xl shadow-amber-900/20">
                <div class="absolute -top-10 -left-6 w-40 h-40 rounded-full bg-white/25 blur-2xl"></div>
                <div class="absolute -bottom-14 right-10 w-44 h-44 rounded-full bg-amber-900/20 blur-3xl"></div>
                <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_20%_20%,#ffffff_1px,transparent_1px)] bg-[length:16px_16px]"></div>

                <div class="absolute top-5 right-5 flex items-center gap-2">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-black/25 border border-black/20 text-[10px] font-black uppercase tracking-wider text-amber-50">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-100"></span>
                        Rank Lv. {{ $level }}
                    </span>
                    <span class="px-3 py-1 rounded-full bg-white/75 border border-amber-100 text-[10px] font-black uppercase tracking-wider text-amber-900">
                        {{ number_format($exp) }} XP
                    </span>
                </div>
            </div>

            <div class="absolute -bottom-12 left-8 flex items-end gap-6">
                <div class="relative w-32 h-32 rounded-3xl bg-[#0F172A] border-4 border-[#0F172A] overflow-hidden shadow-2xl">
                    <img src="{{ $avatarUrl }}" alt="{{ $user->name }}" class="w-full h-full object-cover relative z-[1]">
                    @if($frameImage)
                        <img src="{{ asset($frameImage) }}" alt="Frame Level {{ $level }}" class="absolute inset-0 w-full h-full object-contain scale-[1.16] pointer-events-none z-[2]">
                    @endif
                </div>
                
                <div class="mb-4">
                    <h1 class="text-3xl font-black text-white tracking-tight">{{ $user->name }}</h1>
                    <p class="text-slate-800 font-bold mt-1 mb-3">
                        NIM. {{ $user->npm ?: '-' }} • {{ $user->prodi ?: '-' }}
                    </p>
                    
                    <div class="flex items-center gap-3">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-950/20 border border-amber-900/30 rounded-full text-[10px] font-black text-amber-900 uppercase tracking-widest">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-900"></span>
                            Student
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-16">
        
        <div class="md:col-span-1 space-y-6">
            <div class="bg-slate-800 border border-slate-700 rounded-3xl p-6 shadow-lg flex flex-col">
                <h3 class="text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-6">Informasi Akun</h3>
                
                <div class="space-y-5 flex-1">
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase font-black tracking-wider">Universitas</p>
                        <p class="text-sm text-white font-bold">Trunojoyo Madura</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase font-black tracking-wider">Fakultas</p>
                        <p class="text-sm text-white font-bold">{{ $user->fakultas ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase font-black tracking-wider">{{ $isDosen ? 'NIP/NIDN' : 'Nomor Induk Mahasiswa' }}</p>
                        <p class="text-sm text-white font-mono font-bold">{{ $user->npm ?: '-' }}</p>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-700/50 space-y-3">
                    <button onclick="toggleEditProfileForm()" type="button" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl {{ $themeBg }} text-slate-900 hover:opacity-90 transition-all text-xs font-black uppercase tracking-widest">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        Edit Profil
                    </button>

                    <form id="editProfileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="hidden space-y-3 rounded-xl border border-slate-700 bg-slate-900/40 p-4">
                        @csrf
                        <div>
                            <label class="text-[10px] text-slate-500 uppercase font-black tracking-widest">Nama</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="mt-1 w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white outline-none focus:border-amber-400">
                        </div>
                        <div>
                            <label class="text-[10px] text-slate-500 uppercase font-black tracking-widest">Program Studi</label>
                            <input type="text" name="prodi" value="{{ old('prodi', $user->prodi) }}" class="mt-1 w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white outline-none focus:border-amber-400">
                        </div>
                        <div>
                            <label class="text-[10px] text-slate-500 uppercase font-black tracking-widest">Fakultas</label>
                            <input type="text" name="fakultas" value="{{ old('fakultas', $user->fakultas) }}" class="mt-1 w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white outline-none focus:border-amber-400">
                        </div>
                        <div>
                            <label class="text-[10px] text-slate-500 uppercase font-black tracking-widest">Foto Profil</label>
                            <input type="file" name="avatar" accept=".jpg,.jpeg,.png,.webp" class="mt-1 w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-xs text-slate-300 file:mr-3 file:rounded file:border-0 file:bg-slate-700 file:text-white file:px-3 file:py-2">
                        </div>
                        <button type="submit" class="w-full bg-emerald-500 text-slate-900 py-2 rounded-lg font-black text-xs uppercase tracking-widest">Simpan Profil</button>
                    </form>

                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-slate-900 text-rose-500 border border-rose-500/20 hover:bg-rose-500/10 transition-all text-xs font-bold uppercase tracking-wider">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="md:col-span-2 space-y-6">
            
            @if(!$isDosen)
                <div class="bg-slate-800 border border-slate-700 rounded-3xl p-8 shadow-lg relative overflow-hidden h-full">
                    <div class="absolute top-4 right-6 text-8xl font-black text-white/5 pointer-events-none italic">LV.{{ $level }}</div>

                    <h3 class="text-xs font-black {{ $themeText }} uppercase tracking-[0.2em] mb-8">Learning Progress</h3>

                    <div class="space-y-10 relative z-10">
                        <div>
                            <div class="flex justify-between items-end mb-4">
                                <div>
                                    <span class="text-5xl font-black text-white italic">Level {{ $level }}</span>
                                    <span class="text-slate-500 ml-3 font-bold uppercase text-xs tracking-widest">Scholar Rank</span>
                                </div>
                                <span class="{{ $themeText }} font-mono text-sm font-bold">{{ number_format($exp) }} / {{ number_format($currentLevelMax) }} XP</span>
                            </div>
                            <progress value="{{ $progressPercent }}" max="100" class="w-full h-4 rounded-full overflow-hidden [&::-webkit-progress-bar]:bg-slate-900 [&::-webkit-progress-value]:bg-amber-400 [&::-moz-progress-bar]:bg-amber-400"></progress>
                            <p class="text-[11px] text-slate-400 mt-2">EXP didapat dari ketepatan waktu submit: jauh sebelum deadline (30), mepet (20), pas deadline (10).</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-6 bg-slate-900/50 rounded-2xl border border-slate-700/50 group hover:border-amber-400/30 transition-all">
                                <p class="text-3xl font-black text-white group-hover:scale-110 transition-transform origin-left">{{ $activeClassesCount }}</p>
                                <p class="text-[10px] text-slate-500 uppercase font-black tracking-widest mt-1">Kelas Aktif</p>
                            </div>
                            <div class="p-6 bg-slate-900/50 rounded-2xl border border-slate-700/50 group hover:border-amber-400/30 transition-all">
                                <p class="text-3xl font-black text-white group-hover:scale-110 transition-transform origin-left">{{ $completedTasksCount }}</p>
                                <p class="text-[10px] text-slate-500 uppercase font-black tracking-widest mt-1">Tugas Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-slate-800 border border-slate-700 rounded-3xl p-8 shadow-lg relative overflow-hidden h-full flex flex-col justify-center border-t-4 border-t-rose-500">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-rose-500/10 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10 text-center md:text-left">
                        <h3 class="text-xs font-black text-rose-500 uppercase tracking-[0.2em] mb-4 italic">Lecturer Dashboard</h3>
                        <h2 class="text-4xl font-black text-white leading-tight">Selamat Datang,<br>Dosen Pengajar.</h2>
                        <p class="text-slate-400 mt-4 max-w-sm text-sm leading-relaxed font-medium">
                            Anda memiliki akses penuh untuk mengelola kelas, membagikan kode akses, dan memberikan penilaian kepada mahasiswa secara real-time.
                        </p>
                        
                        <div class="grid grid-cols-2 gap-4 mt-10">
                            <div class="p-5 bg-rose-500/5 rounded-2xl border border-rose-500/10">
                                <p class="text-2xl font-black text-white">{{ $activeClassesCount }}</p>
                                <p class="text-[10px] text-slate-500 uppercase font-black mt-1 tracking-tighter">Kelas Diampu</p>
                            </div>
                            <div class="p-5 bg-rose-500/5 rounded-2xl border border-rose-500/10">
                                <p class="text-2xl font-black text-white">{{ $mentoredStudentsCount }}</p>
                                <p class="text-[10px] text-slate-500 uppercase font-black mt-1 tracking-tighter">Mahasiswa Binaan</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

<script>
    function toggleEditProfileForm() {
        document.getElementById('editProfileForm').classList.toggle('hidden');
    }
</script>
@endsection