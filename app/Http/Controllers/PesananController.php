<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Jadwal;

class PesananController extends Controller
{
    // view index
    public function index(Request $request)
    {
        $query = Pesanan::query();

        //filter no lap
        if ($request->filled('nomor_lapangan')) {
            $query->whereHas('jadwal', function ($q) use ($request) {
                $q->where('nomor_lapangan', $request->nomor_lapangan);
            });
        }

        // filter tanggal
        if ($request->filled('tanggal_awal')) {
            $query->where('tanggal', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->where('tanggal', '<=', $request->tanggal_akhir);
        }

        // filter jam
        if ($request->filled('jam_pemakaian')) {
            [$jam_mulai, $jam_selesai] = explode('-', $request->jam_pemakaian);
            $query->whereHas('jadwal', function ($q) use ($jam_mulai, $jam_selesai) {
                $q->where('jam_mulai', '>=', $jam_mulai)
                    ->where('jam_selesai', '<=', $jam_selesai);
            });
        }

        // data jam
        $jam_pemakaian = Jadwal::select('jam_mulai', 'jam_selesai')
            ->distinct()
            ->orderBy('jam_mulai')
            ->get();

        $pesanan = $query->with('jadwal')->get();

        return view('pesanan.index', compact('pesanan', 'jam_pemakaian'));
    }

    // ke view pesan
    public function create()
    {
        $jadwal = Jadwal::all();
        return view('pesanan.create', compact('jadwal'));
    }

    //simper data
    public function store(Request $request)
    {
        //validasi input
        $request->validate([
            'nama_pemesan' => 'required|string|max:100',
            'wa_pemesan' => 'required|string|min:11|max:13',
            'tanggal' => 'required|date',
            'jadwal_id' => 'required|exists:jadwal,id',
        ]);

        //jadwal bentrok
        $bentrok = Pesanan::where('jadwal_id', $request->jadwal_id)
            ->where('tanggal', $request->tanggal)
            ->exists();

        if ($bentrok) {
            return redirect()->back()->with('error', 'Jadwal sudah dipesan, silakan pilih jadwal lain.');
        }

        //simpen data
        Pesanan::create([
            'nama_pemesan' => $request->nama_pemesan,
            'wa_pemesan' => $request->wa_pemesan,
            'tanggal' => $request->tanggal,
            'jadwal_id' => $request->jadwal_id,
        ]);

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dibuat!');
    }

    // ke view edit
    public function edit($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $jadwal = Jadwal::all();
        return view('pesanan.edit', compact('pesanan', 'jadwal'));
    }

    // simpen update
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_pemesan' => 'required|string|max:100',
            'wa_pemesan' => 'required|string|min:10|max:15',
            'tanggal' => 'required|date',
            'jadwal_id' => 'required|exists:jadwal,id',
        ]);

        //cek bentrok
        $bentrok = Pesanan::where('jadwal_id', $request->jadwal_id)
            ->where('tanggal', $request->tanggal)
            ->where('id', '!=', $id)
            ->exists();

        if ($bentrok) {
            return redirect()->back()->with('error', 'Jadwal sudah dipesan, silakan pilih jadwal lain.');
        }

        // update
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update([
            'nama_pemesan' => $request->nama_pemesan,
            'wa_pemesan' => $request->wa_pemesan,
            'tanggal' => $request->tanggal,
            'jadwal_id' => $request->jadwal_id,
        ]);

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil diperbarui!');
    }
    // delete
    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dihapus!');
    }
}