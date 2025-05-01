<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipe Flag - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-800 text-white">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Tipe Flag</h1>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.flag_type.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Tipe Flag</a>

        <table class="min-w-full table-auto border-collapse bg-gray-700 rounded">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Tipe Flag</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($flagTypes as $flagType)
                    <tr class="border-t border-b border-gray-600">
                        <td class="px-6 py-4">{{ $flagType->type }}</td>
                        <td class="px-6 py-4">{{ $flagType->type }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.flag_type.edit', $flagType->type) }}" class="text-yellow-500 hover:text-yellow-300">Edit</a>
                            <form action="{{ route('admin.flag_type.destroy', $flagType->type) }}" method="POST" class="inline-block ml-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-300">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $flagTypes->links() }}
    </div>
</body>
</html>
