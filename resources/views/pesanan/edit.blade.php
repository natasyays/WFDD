@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Edit Pesanan</h2>

        @if(session('error'))
            <div class="bg-red-500 text-white p-2 mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('pesanan.update', $pesanan->id) }}">
            @csrf
            @method('PUT')

            <label>Nama Pemesan:</label>
            <input type="text" name="nama_pemesan" value="{{ $pesanan->nama_pemesan }}"
                class="w-full px-3 py-2 border border-gray-300 rounded mb-4" required>

            <label>Nomor WhatsApp:</label>
            <input type="text" name="wa_pemesan" value="{{ $pesanan->wa_pemesan }}"
                class="w-full px-3 py-2 border border-gray-300 rounded mb-4" required>

            <label>Tanggal Booking:</label>
            <input type="date" name="tanggal" value="{{ $pesanan->tanggal }}"
                class="w-full px-3 py-2 border border-gray-300 rounded mb-4" required>

            <label>Jadwal:</label>
            <select name="jadwal_id" class="w-full px-3 py-2 border border-gray-300 rounded mb-4" required>
                @foreach($jadwal as $j)
                    <option value="{{ $j->id }}" {{ $pesanan->jadwal_id == $j->id ? 'selected' : '' }}>
                        Lapangan {{ $j->nomor_lapangan }} | {{ $j->jam_mulai }} - {{ $j->jam_selesai }}
                    </option>
                @endforeach
            </select>

            <div class="flex justify-between items-center mt-4">
                <a href="{{ route('pesanan.index') }}" class="text-gray-500 text-sm hover:underline">← Kembali</a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Pesan</button>
            </div>
        </form>
    </div>
@endsection