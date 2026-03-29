<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-[#FBBF24]">
            Buat Kelas Baru
        </h2>
    </x-slot>

    <div class="bg-[#1E293B] p-6 rounded-lg shadow text-white max-w-lg">
        <form action="{{ route('kelas.store') }}" method="POST">
            @csrf

            <!-- Nama Kelas -->
            <div class="mb-4">
                <label for="nama" class="block font-medium mb-2">Nama Kelas</label>
                <input type="text" name="nama" id="nama" 
                       class="w-full px-3 py-2 rounded border border-gray-600 bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#FBBF24]"
                       placeholder="Contoh: Grafkom 1A" required>
                @error('nama')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end">
                <button type="submit" 
                        class="bg-[#FBBF24] text-black font-bold px-4 py-2 rounded hover:bg-yellow-500 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>