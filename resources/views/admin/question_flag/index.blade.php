<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Soal CTF</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">

<div class="container mx-auto px-10 mt-10">
    <h1 class="text-3xl font-bold mb-6">Daftar Soal CTF</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.question_flag.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            + Tambah Soal
        </a>
    </div>

    <div class="bg-gray-800 p-4 rounded">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-700 text-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Judul</th>
                    <th class="px-4 py-2 text-left">Deskripsi</th>
                    <th class="px-4 py-2 text-left">Attachment</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($questions as $q)
                <tr class="border-b border-gray-700">
                    <td class="px-4 py-2">{{ $q->flag_id }}</td>
                    <td class="px-4 py-2">{{ $q->title }}</td>
                    <td class="px-4 py-2">{{ $q->description }}</td>
                    <td class="px-4 py-2">
                        @if($q->attachment)
                            <a href="{{ asset('storage/' . $q->attachment) }}" class="text-blue-400 underline" target="_blank">Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('admin.question_flag.edit', $q->flag_id) }}" class="text-yellow-400">Edit</a>
                        <form action="{{ route('admin.question_flag.destroy', $q->flag_id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
