@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-gray-100 rounded-lg shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-700">List Pemesanan Lapangan</h2>
        <a href="{{ route('pesanan.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-lg shadow-md transition duration-300">
            + Pemesanan Baru
        </a>
    </div>

    <!--filter filter -->
    <form method="GET" action="{{ route('pesanan.index') }}" class="mb-6 bg-white p-4 rounded-lg shadow-md">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- filter no lap -->
            <div>
                <label for="nomor_lapangan" class="block text-sm font-medium text-gray-700 mb-1">No Lapangan</label>
                <select name="nomor_lapangan" id="nomor_lapangan" class="border p-2 rounded-lg focus:ring-2 focus:ring-blue-500 w-full">
                    <option value="">Semua Lapangan</option>
                    <option value="1" {{ request('nomor_lapangan') == 1 ? 'selected' : '' }}>Lapangan 1</option>
                    <option value="2" {{ request('nomor_lapangan') == 2 ? 'selected' : '' }}>Lapangan 2</option>
                </select>
            </div>

            <!-- filter tanggal awal-->
            <div>
                <label for="tanggal_awal" class="block text-sm font-medium text-gray-700 mb-1">Rentang Awal Booking</label>
                <input type="date" name="tanggal_awal" id="tanggal_awal" class="border p-2 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" value="{{ request('tanggal_awal') }}">
            </div>

            <!-- filter tanggal akhir -->
            <div>
                <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700 mb-1">Rentang Akhir Booking</label>
                <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="border p-2 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" value="{{ request('tanggal_akhir') }}">
            </div>

            <!--filter jam -->
            <div>
                <label for="jam_pemakaian" class="block text-sm font-medium text-gray-700 mb-1">Jam Pemakaian</label>
                <select name="jam_pemakaian" id="jam_pemakaian" class="border p-2 rounded-lg focus:ring-2 focus:ring-blue-500 w-full">
                    <option value="">Semua Jam</option>
                    @foreach($jam_pemakaian as $jam)
                        <option value="{{ $jam->jam_mulai }}-{{ $jam->jam_selesai }}" 
                            {{ request('jam_pemakaian') == $jam->jam_mulai . '-' . $jam->jam_selesai ? 'selected' : '' }}>
                            {{ $jam->jam_mulai }} - {{ $jam->jam_selesai }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- tampilkan --}}
            <div class="flex items-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300 w-full">
                    Tampilkan
                </button>
            </div>
        </div>
    </form>

    <!--tabel -->
    <div class="overflow-x-auto">
        <table class="w-full bg-white rounded-lg shadow-md text-sm">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="border p-3 text-center">No</th>
                    <th class="border p-3 text-left">Nama Pemesan</th>
                    <th class="border p-3 text-left">Nomor WhatsApp</th>
                    <th class="border p-3 text-center">Tanggal Booking</th>
                    <th class="border p-3 text-center">Nomor Lapangan</th>
                    <th class="border p-3 text-center">Jam Pemakaian</th>
                    <th class="border p-3 text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanan as $index => $p)
                    <tr class="border hover:bg-gray-100 transition duration-300">
                        <td class="border p-3 text-center">{{ $index + 1 }}</td>
                        <td class="border p-3">{{ $p->nama_pemesan }}</td>
                        <td class="border p-3">{{ $p->wa_pemesan }}</td>
                        <td class="border p-3 text-center">{{ $p->tanggal }}</td>
                        <td class="border p-3 text-center">{{ $p->jadwal->nomor_lapangan ?? '-' }}</td>
                        <td class="border p-3 text-center">
                            {{ $p->jadwal->jam_mulai ?? '-' }} - {{ $p->jadwal->jam_selesai ?? '-' }}
                        </td>
                        <td class="border p-3 text-center">
                            <div class="flex justify-center space-x-2">
                                {{-- edit --}}
                                <a href="{{ route('pesanan.edit', $p->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg shadow-md transition duration-300">
                                    Edit
                                </a>
                                {{-- delete --}}
                                <form action="{{ route('pesanan.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg shadow-md transition duration-300">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center p-4 text-gray-500">Tidak ada data yang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection