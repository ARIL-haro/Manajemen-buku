<!-- TODO: tuliskan tampilan view web buku anda disini -->
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manajemen Buku</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
  <div class="max-w-6xl mx-auto bg-white p-6 m-6 rounded shadow">
    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Manajemen Buku</h1>
      <button id="tambahBukuBtn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Tambah Buku
      </button>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
      {{ session('success') }}
    </div>
    @endif

    <!-- Filter -->
    <div class="flex gap-4 mb-6">
      <form method="GET" action="{{ route('buku.index') }}" class="flex gap-4 w-full">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul buku..." class="w-full border px-3 py-2 rounded">
        <select name="kategori" class="border px-3 py-2 rounded">
          <option value="">Semua Kategori</option>
          <option value="Novel" {{ request('kategori') == 'Novel' ? 'selected' : '' }}>Novel</option>
          <option value="Ensiklopedia" {{ request('kategori') == 'Ensiklopedia' ? 'selected' : '' }}>Ensiklopedia</option>
          <option value="Biografi" {{ request('kategori') == 'Biografi' ? 'selected' : '' }}>Biografi</option>
        </select>
      </form>
    </div>

    <!-- Form Buku (Hidden by default, shown when adding/editing) -->
    <div id="formBuku" class="{{ isset($edit) ? 'block' : 'hidden' }} mb-6">
      <h2 class="text-xl font-semibold mb-2">Form Buku</h2>
      <form action="{{ isset($edit) ? route('buku.update', $edit->id) : route('buku.store') }}" method="POST">
        @csrf
        @if(isset($edit))
        @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          <input type="text" name="judul" value="{{ old('judul', isset($edit) ? $edit->judul : '') }}" placeholder="Judul Buku" class="border px-3 py-2 rounded" required>
          <input type="text" name="pengarang" value="{{ old('pengarang', isset($edit) ? $edit->pengarang : '') }}" placeholder="Pengarang" class="border px-3 py-2 rounded" required>
          <input type="text" name="tahun_terbit" value="{{ old('tahun_terbit', isset($edit) ? $edit->tahun_terbit : '') }}" placeholder="Tahun Terbit" class="border px-3 py-2 rounded" required>
          <input type="text" name="penerbit" value="{{ old('penerbit', isset($edit) ? $edit->penerbit : '') }}" placeholder="Penerbit" class="border px-3 py-2 rounded" required>
          <input type="text" name="kategori" value="{{ old('kategori', isset($edit) ? $edit->kategori : '') }}" placeholder="Kategori" class="border px-3 py-2 rounded md:col-span-2" required>
        </div>
        <div class="flex gap-2">
          <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan</button>
          <button type="button" id="batalBtn" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Batal</button>
        </div>
      </form>
    </div>

    <!-- Daftar Buku -->
    <div>
      <h2 class="text-xl font-semibold mb-2">Daftar Buku</h2>
      <div class="overflow-x-auto">
        <table class="w-full text-left border">
          <thead class="bg-gray-200">
            <tr>
              <th class="p-2">JUDUL</th>
              <th class="p-2">PENGARANG</th>
              <th class="p-2">TAHUN</th>
              <th class="p-2">PENERBIT</th>
              <th class="p-2">KATEGORI</th>
              <th class="p-2">AKSI</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($bukus as $buku)
            <tr class="border-t">
              <td class="p-2">{{ $buku->judul }}</td>
              <td class="p-2">{{ $buku->pengarang }}</td>
              <td class="p-2">{{ $buku->tahun_terbit }}</td>
              <td class="p-2">{{ $buku->penerbit }}</td>
              <td class="p-2">{{ $buku->kategori }}</td>
              <td class="p-2 space-x-2">
                <a href="{{ route('buku.edit', $buku->id) }}" class="bg-yellow-400 px-3 py-1 rounded text-white hover:bg-yellow-500">Edit</a>
                <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                  @csrf
                  @method('DELETE')
                  <button class="bg-red-600 px-3 py-1 rounded text-white hover:bg-red-700">Hapus</button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center p-4 text-gray-500">Tidak ada data buku</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    @if($bukus->count() > 0)
    <div class="flex justify-between items-center mt-4 text-sm text-gray-600">
      <span>Menampilkan {{ $bukus->firstItem() }} - {{ $bukus->lastItem() }} dari {{ $bukus->total() }} buku</span>
      <div>{{ $bukus->links() }}</div>
    </div>
    @endif
  </div>

  <script>
    // Toggle form visibility
    document.getElementById('tambahBukuBtn').addEventListener('click', function() {
      document.getElementById('formBuku').classList.remove('hidden');
    });

    if (document.getElementById('batalBtn')) {
      document.getElementById('batalBtn').addEventListener('click', function() {
        document.getElementById('formBuku').classList.add('hidden');
      });
    }
  </script>
</body>

</html>