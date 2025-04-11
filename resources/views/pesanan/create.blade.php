<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-xl w-full sm:w-96">
        <h2 class="text-2xl font-semibold mb-6 text-indigo-600 text-center">Form Pemesanan Lapangan</h2>


        @if(session('success'))
            <div class="bg-green-500 text-white p-3 mb-4 rounded-lg text-center">
                {{ session('success') }}
            </div>
        @endif


        @if(session('error'))
            <div class="bg-red-500 text-white p-3 mb-4 rounded-lg text-center">
                {{ session('error') }}
            </div>
        @endif

        < @if ($errors->any())
            <div class="bg-red-500 text-white p-3 mb-4 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

            <form action="{{ route('pesanan.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pemesan</label>
                    <input type="text" name="nama_pemesan"
                        class="w-full border border-gray-300 rounded-lg p-3 mb-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        value="{{ old('nama_pemesan') }}" required placeholder="Masukkan nama pemesan">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp</label>
                    <input type="text" name="wa_pemesan"
                        class="w-full border border-gray-300 rounded-lg p-3 mb-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        value="{{ old('wa_pemesan') }}" required placeholder="Masukkan nomor WhatsApp">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pemesanan</label>
                    <input type="date" name="tanggal"
                        class="w-full border border-gray-300 rounded-lg p-3 mb-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        value="{{ old('tanggal') }}" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Jadwal Lapangan</label>
                    <select name="jadwal_id"
                        class="w-full border border-gray-300 rounded-lg p-3 mb-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                        <option value="">Pilih Jadwal</option>
                        @foreach($jadwal as $j)
                            <option value="{{ $j->id }}" {{ old('jadwal_id') == $j->id ? 'selected' : '' }}>
                                Lapangan {{ $j->nomor_lapangan }}: {{ $j->jam_mulai }} - {{ $j->jam_selesai }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-between items-center mt-4">
                    <a href="{{ route('pesanan.index') }}" class="text-gray-500 text-sm hover:underline">← Kembali</a>
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Pesan
                        Lapangan</button>
                </div>
            </form>
    </div>
</body>

</html>