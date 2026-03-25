<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrunodjoyoClassroom</title>
<script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-slate-900 text-white font-sans antialiased flex h-screen overflow-hidden">
<aside class="w-64 bg-slate-800 border-r border-slate-700 flex flex-col hidden md:flex">
        
        <div class="h-16 flex items-center px-6 border-b border-slate-700">
            <span class="text-xl font-bold text-amber-400">Trunodjoyo<span class="text-white">Class</span></span>
        </div>

<nav class="flex-1 overflow-y-auto py-4">
    <ul class="space-y-2 px-3">
        <li>
            <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ Request::is('/') ? 'bg-slate-700 text-amber-400 font-semibold' : 'text-slate-400 hover:bg-slate-700 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>
        </li>
        
        <li>
<a href="/tugas" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ Request::is('tugas') ? 'bg-slate-700 text-amber-400 font-semibold' : 'text-slate-400 hover:bg-slate-700 hover:text-white' }}">                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Daftar Tugas
            </a>
        </li>
    </ul>
</nav>

<div class="p-4 border-t border-slate-700 bg-slate-800/50">
    <div class="flex items-center gap-3">
        <div class="relative">
            <img src="https://ui-avatars.com/api/?name=Zaki+User&background=FBBF24&color=0F172A" 
                 class="w-10 h-10 rounded-full border-2 border-amber-400 p-0.5 shadow-[0_0_10px_rgba(251,191,36,0.3)]">
            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-slate-800 rounded-full"></div>
        </div>
        <div class="overflow-hidden">
            <p class="text-sm font-bold truncate">Zaki Developer</p>
            <p class="text-[10px] text-amber-400 font-mono uppercase tracking-widest">Level 15 • 2500 EXP</p>
        </div>
    </div>
</div>
        
    </aside>
    <div class="flex-1 flex flex-col h-screen">
        
        <header class="h-16 bg-slate-800 border-b border-slate-700 flex items-center justify-between px-6">
            <div class="text-slate-400 text-sm">
                @yield('header_title', 'Beranda')
            </div>
            
            <div class="flex items-center gap-4">
                <button class="bg-amber-400 text-slate-900 px-4 py-2 rounded-md font-semibold hover:bg-amber-500 transition-colors">
                    + Buat / Gabung Kelas
                </button>
                
                <div class="w-8 h-8 rounded-full bg-slate-700 border-2 border-amber-400"></div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
        
    </div>
    </body>
</html>