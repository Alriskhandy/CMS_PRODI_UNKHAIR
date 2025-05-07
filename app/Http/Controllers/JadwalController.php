<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JadwalController extends Controller
{
    function index()
    {
        $jadwal = Jadwal::all();
        return view('backend.jadwal.index', compact('jadwal'));
    }

    public function show($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        return view('backend.jadwal.detail', compact('jadwal'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'tahun_ajaran' => 'required|string|max:255',
                'file' => 'required|file|mimes:pdf|max:2048',
            ]);

            // Simpan file ke storage/public/jadwal
            $filePath = $request->file('file')->store('jadwal', 'public');

            // Simpan data jadwal
            $jadwal = new Jadwal();
            $jadwal->tahun_ajaran = $validated['tahun_ajaran'];
            $jadwal->file = $filePath; // simpan path file
            $jadwal->save();

            notify()->success('Jadwal berhasil dibuat!');
            return redirect()->route('jadwal.index');
        } catch (\Throwable $th) {
            notify()->error('Jadwal gagal dibuat! - ' . $th->getMessage());
            return redirect()->route('jadwal.index')->withInput();
        }
    }


    public function destroy($id)
    {
        try {
            $jadwal = Jadwal::findOrFail($id);

            // Hapus file dari storage jika ada
            if ($jadwal->file && Storage::disk('public')->exists($jadwal->file)) {
                Storage::disk('public')->delete($jadwal->file);
            }

            // Hapus data dari database
            $jadwal->delete();

            notify()->success('Jadwal berhasil dihapus!', 'Success');
            return redirect()->route('jadwal.index');
        } catch (\Throwable $th) {
            notify()->error('Gagal menghapus jadwal! - ' . $th->getMessage());
            return redirect()->back();
        }
    }
}
