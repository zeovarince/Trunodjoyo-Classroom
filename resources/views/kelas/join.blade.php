<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-yellow-400">
            Join Kelas
        </h2>
    </x-slot>

    <div class="bg-[#1E293B] p-6 rounded text-white">
        <form action="{{ route('kelas.storeJoin') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="kode" class="block font-medium mb-2">Masukkan Kode Kelas</label>
                <input type="text" name="kode" id="kode"
                       class="w-full px-3 py-2 rounded border border-gray-300 text-black"
                       placeholder="Contoh: ABC123">
            </div>

            <button type="submit" class="bg-[#FBBF24] text-black px-4 py-2 rounded">
                Join
            </button>
        </form>
    </div>
</x-app-layout>