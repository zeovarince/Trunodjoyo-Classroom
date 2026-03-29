<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-[#FBBF24]">
            Daftar Kelas
        </h2>
    </x-slot>

    <div class="bg-[#1E293B] p-6 rounded-lg shadow">
        <!-- Tombol Buat Kelas -->
        <a href="{{ route('kelas.create') }}" 
           class="bg-[#FBBF24] text-black px-4 py-2 rounded font-bold hover:bg-yellow-500 transition">
            + Buat Kelas
        </a>

        <!-- List Kelas -->
        <ul class="mt-6 space-y-4 text-white">
            @foreach($kelas as $k)
                <li class="flex justify-between items-center bg-gray-800 rounded-lg px-4 py-3 shadow">
                    <div>
                        <span class="font-semibold">{{ $k->nama }}</span>
                        <span class="text-gray-400 ml-2">(Kode: {{ $k->kode }})</span>
                    </div>
                    <div class="flex gap-2">
                        <!-- Tombol Edit -->
                        <a href="{{ route('kelas.edit', $k->id) }}" 
                           class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                            Edit
                        </a>
                        <!-- Tombol Hapus -->
                        <form action="{{ route('kelas.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Yakin hapus kelas ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>