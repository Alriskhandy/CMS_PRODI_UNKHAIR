<?php

namespace App\Http\Controllers;

use App\Models\RPS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RPSController extends Controller
{
    public function index()
    {
        $rps = RPS::first();
        return view('backend.rps.index', compact('rps'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'file' => 'required|file|mimes:pdf|max:5120',
                'deskripsi' => 'string|max:255|nullable',
            ]);

            // Simpan file ke storage/public/RPS
            $filePath = $request->file('file')->store('RPS', 'public');

            // Simpan data ke database
            $rps = new RPS();
            $rps->file = $filePath; // <- tambahkan ini
            $rps->deskripsi = $validated['deskripsi'];
            $rps->save();

            notify()->success('Rencana Pembelajaran Semester berhasil ditambahkan!');
            return redirect()->route('rps.index');
        } catch (\Throwable $th) {
            notify()->error('Rencana Pembelajaran Semester gagal ditambahkan! - ' . $th->getMessage());
            return redirect()->route('rps.index')->withInput();
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $rps = RPS::findOrFail($id);
            // Validasi input
            $validated = $request->validate([
                'file' => 'required|file|mimes:pdf|max:5120',
                'deskripsi' => 'string|max:255|nullable',

            ]);

            // Update tahun ajaran
            $rps->deskripsi = $validated['deskripsi'];

            // Cek apakah ada file baru
            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($rps->file && Storage::disk('public')->exists($rps->file)) {
                    Storage::disk('public')->delete($rps->file);
                }

                // Upload file baru
                $filePath = $request->file('file')->store('RPS', 'public');
                $rps->file = $filePath;
            }

            $rps->save();
            notify()->success('RPS berhasil diperbarui!');
            return redirect()->route('rps.index');
        } catch (\Throwable $th) {
            notify()->error('RPS gagal diperbarui! - ' . $th->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $rps = RPS::findOrFail($id);

            // Hapus file dari storage/public/RPS jika ada
            if (!empty($rps->file) && Storage::disk('public')->exists($rps->file)) {
                Storage::disk('public')->delete($rps->file);
            }

            // Hapus data dari database
            $rps->delete();

            notify()->success('Rencana Pembelajaran Semester berhasil dihapus!');
            return redirect()->route('rps.index');
        } catch (\Throwable $th) {
            notify()->error('Gagal menghapus RPS! - ' . $th->getMessage());
            return redirect()->back();
        }
    }
}
