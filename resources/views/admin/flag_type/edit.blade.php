<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tipe Flag - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-800 text-white">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Edit Tipe Flag</h1>

        <a href="{{ route('admin.flag_type.index') }}" class="text-blue-500 mb-4 inline-block">&larr; Kembali ke Daftar Tipe Flag</a>

        <form action="{{ route('admin.flag_type.update', $flagType->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="type" class="block text-lg">Tipe Flag</label>
                <input type="text" id="type" name="type" class="w-full px-4 py-2 rounded bg-gray-600 text-white focus:outline-none" value="{{ old('type', $flagType->type) }}">
                @error('type')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded">Perbarui Tipe Flag</button>
        </form>
    </div>
</body>
</html>
