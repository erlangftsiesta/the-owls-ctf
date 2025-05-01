<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Soal CTF</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">

<div class="container mx-auto px-10 mt-10">
    <h1 class="text-3xl font-bold mb-6">Tambah Soal CTF</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.question_flag.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="bg-gray-800 p-6 rounded">

            <!-- Judul -->
            <div class="mb-4">
                <label for="title" class="block text-lg">Judul Soal</label>
                <input type="text" id="title" name="title" class="w-full px-4 py-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-600" required>
            </div>

            <!-- Deskripsi -->
            <div class="mb-4">
                <label for="description" class="block text-lg">Deskripsi Soal</label>
                <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-600" required></textarea>
            </div>

            <!-- Type -->
            <div class="mb-4">
                <label for="description" class="block text-lg">Type</label>
                <select class="form-control w-full px-4 py-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-600" required   " id="type" name="type" required>
                    <option value="" disabled selected>Pilih Tipe</option>
                    <option value="cryptography" {{ old('type') == 'cryptography' ? 'selected' : '' }}>cryptography</option>
                    <option value="web-exploitation" {{ old('type') == 'web-exploitation' ? 'selected' : '' }}>web-exploitation</option>
                </select>
            </div>

            <!-- Attachment -->
            <div class="mb-4">
                <label for="attachment" class="block text-lg">Attachment (Opsional)</label>
                <input type="file" id="attachment" name="attachment" class="w-full px-4 py-2 rounded bg-gray-700 text-white focus:outline-none">
            </div>

            <!-- The Flag -->
            <div class="mb-4">
                <label for="the_flag" class="block text-lg">The Flag</label>
                <input type="text" id="the_flag" name="the_flag" class="w-full px-4 py-2 rounded bg-gray-700 text-white focus:outline-none" required>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded">
                    Simpan Soal
                </button>
            </div>
        </div>
    </form>

</div>

</body>
</html>
