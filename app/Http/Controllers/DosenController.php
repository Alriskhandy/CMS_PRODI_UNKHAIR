<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    function index()
    {
        $dosen = Dosen::all();
        return view('backend.dosen.index', compact('dosen'));
    }

    function create()
    {
        return view('backend.dosen.create');
    }

    function edit($id)
    {
        $dosen = Dosen::findOrFail($id);
        return view('backend.dosen.edit', compact('dosen'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'nip' => 'required|numeric',
                'jabatan' => 'required|string|max:255',
                'foto' => 'required|file|mimes:jpg,png,jpeg|max:5120',
            ]);

            // Simpan file foto ke storage/public/Foto_Dosen
            $filePath = $request->file('foto')->store('Foto_Dosen', 'public');

            // Simpan data dosen ke database
            $dosen = new Dosen();
            $dosen->nama = $validated['nama'];
            $dosen->nip = $validated['nip'];
            $dosen->jabatan = $validated['jabatan'];
            $dosen->foto = $filePath; // Simpan path foto
            $dosen->save();

            notify()->success('Data Dosen berhasil ditambahkan!');
            return redirect()->route('dosen.index');
        } catch (\Throwable $th) {
            notify()->error('Data Dosen gagal dibuat! - ' . $th->getMessage());
            return redirect()->route('dosen.index')->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $dosen = Dosen::findOrFail($id);

            // Validasi input
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'nip' => 'required|numeric',
                'jabatan' => 'required|string|max:255',
                'foto' => 'nullable|file|mimes:jpg,png,jpeg|max:5120',
            ]);

            // Update data dasar
            $dosen->nama = $validated['nama'];
            $dosen->nip = $validated['nip'];
            $dosen->jabatan = $validated['jabatan'];

            // Cek apakah ada file foto baru
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($dosen->foto && Storage::disk('public')->exists($dosen->foto)) {
                    Storage::disk('public')->delete($dosen->foto);
                }

                // Upload foto baru
                $filePath = $request->file('foto')->store('Foto_Dosen', 'public');
                $dosen->foto = $filePath;
            }

            $dosen->save();

            notify()->success('Data Dosen berhasil diperbarui!');
            return redirect()->route('dosen.index');
        } catch (\Throwable $th) {
            notify()->error('Data Dosen gagal diperbarui! - ' . $th->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $dosen = Dosen::findOrFail($id);

            // Hapus foto dari storage jika ada
            if ($dosen->foto && Storage::disk('public')->exists($dosen->foto)) {
                Storage::disk('public')->delete($dosen->foto);
            }

            // Hapus data dari database
            $dosen->delete();

            notify()->success('Data Dosen berhasil dihapus!');
            return redirect()->route('dosen.index');
        } catch (\Throwable $th) {
            notify()->error('Gagal menghapus Data Dosen! - ' . $th->getMessage());
            return redirect()->back();
        }
    }
}
