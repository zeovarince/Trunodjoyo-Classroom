<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-yellow-400">
            Edit Kelas
        </h2>
    </x-slot>

    <div class="bg-[#1E293B] p-6 rounded">
        <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nama" class="block text-white font-medium mb-2">Nama Kelas</label>
                <input type="text" name="nama" id="nama" value="{{ $kelas->nama }}"
                       class="w-full px-3 py-2 rounded border border-gray-300 focus:outline-none focus:ring focus:border-yellow-400">
            </div>

            <button type="submit" class="bg-[#FBBF24] text-black px-4 py-2 rounded">
                Update
            </button>
        </form>
    </div>
</x-app-layout>