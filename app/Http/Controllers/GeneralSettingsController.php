<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use ZipArchive;

class GeneralSettingsController extends Controller
{
    /**
     * Menampilkan halaman pengaturan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua pengaturan dari tabel general_settings
        $settings = DB::table('general_settings')->pluck('value', 'key');

        // Tampilkan halaman dengan pengaturan
        return view('backend.settings.index', ['settings' => $settings]);
    }

    /**
     * Memperbarui pengaturan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // dd($request->site_logo);
        try {
            // Tentukan tab yang sedang diupdate
            $tab = $request->input('tab');
            // Definisikan keys untuk setiap tab
            $tabKeys = [
                'site' => ['site_name', 'site_logo', 'app_url'],
                'email' => ['mail_mailer', 'mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption', 'mail_from_address', 'mail_from_name'],
                'database' => ['database_connection', 'database_host', 'database_port', 'database_name']
            ];

            // Validasi input berdasarkan tab yang dipilih
            $validationRules = [
                'site' => [
                    'site_name' => 'string|max:255',
                    'site_logo' => 'image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
                    'app_url' => 'string|max:255',
                ],
                'email' => [
                    'mail_mailer' => 'string|max:255',
                    'mail_host' => 'string|max:255',
                    'mail_port' => 'string|max:255',
                    'mail_username' => 'string|max:255',
                    'mail_password' => 'string|max:255',
                    'mail_encryption' => 'string|max:255',
                    'mail_from_address' => 'email|max:255',
                    'mail_from_name' => 'string|max:255',
                ],
                'database' => [
                    'database_connection' => 'string|max:255',
                    'database_host' => 'string|max:255',
                    'database_port' => 'string|max:255',
                    'database_name' => 'string|max:255',
                ]
            ];

            // Lakukan validasi
            $validatedData = $request->validate($validationRules[$tab]);

            // Proses upload logo jika ada
            if ($request->hasFile('site_logo')) {
                // Ambil path logo yang lama dari database
                $existingLogo = DB::table('general_settings')->where('key', 'site_logo')->value('value');

                // Hapus file lama jika ada
                if ($existingLogo && Storage::disk('public')->exists($existingLogo)) {
                    Storage::disk('public')->delete($existingLogo);
                }

                $logoPath = $request->file('site_logo')->store('logo', 'public');
                $validatedData['site_logo'] = $logoPath; // Simpan path logo untuk diupdate ke database
            }

            // Update hanya keys yang ada di tab saat ini
            foreach ($tabKeys[$tab] as $key) {
                if (array_key_exists($key, $validatedData)) { // Pastikan key ada dalam validated data
                    DB::table('general_settings')->where('key', $key)->update([
                        'value' => $validatedData[$key],
                        'updated_at' => now()
                    ]);
                }
            }

            // Redirect dengan pesan sukses
            notify()->success('Settings berhasil diperbarui.');
            return redirect()->back()->with('tab', $tab); // Menyimpan tab aktif

        } catch (\Throwable $th) {
            // Menangani kesalahan saat pembaruan
            notify()->error('Settings gagal diperbarui. ' . $th->getMessage());
            return redirect()->back()->with('tab', $tab); // Menyimpan tab aktif
        }
    }




    // protected function updateEnv($key, $value)
    // {
    //     $path = base_path('.env');

    //     // Ambil isi dari file .env
    //     $content = file_get_contents($path);

    //     // Pastikan nilai dibungkus dengan kutip jika ada spasi
    //     if (strpos($value, ' ') !== false) {
    //         $value = '"' . $value . '"';
    //     }

    //     // Setiap key yang diupdate
    //     $pattern = '/' . preg_quote($key) . '=.*/';
    //     $content = preg_replace($pattern, $key . '=' . $value, $content);

    //     // Simpan kembali ke file .env
    //     file_put_contents($path, $content);

    //     // Refresh konfigurasi
    //     Artisan::call('config:cache'); // Refresh konfigurasi untuk mengambil nilai baru

    //     return redirect()->back();
    // }

    public function downloadStorageBackup()
    {
        try {
            // Nama file zip yang akan diunduh
            $fileName = 'storage_backup_' . date('Y_m_d_His') . '.zip';

            // Membuat objek ZipArchive
            $zip = new ZipArchive();
            $tmpFile = tempnam(sys_get_temp_dir(), 'zip'); // File sementara di memori

            if ($zip->open($tmpFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
                return response()->json(['error' => 'Tidak dapat membuat file zip.'], 500);
            }

            // Menambahkan semua file dari storage/app/public ke dalam zip
            $files = Storage::allFiles('public');
            foreach ($files as $file) {
                $absolutePath = storage_path('app/' . $file);
                if (file_exists($absolutePath)) {
                    $zip->addFile($absolutePath, $file);
                }
            }

            // Tutup arsip zip
            $zip->close();

            // Membersihkan buffer output sebelum streaming
            if (ob_get_level()) {
                ob_end_clean();
            }

            // Membaca file zip dan mengirimkan sebagai respons unduhan
            return response()->streamDownload(function () use ($tmpFile) {
                readfile($tmpFile);
            }, $fileName, [
                'Content-Type' => 'application/zip',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]);

            // Hapus file sementara setelah dikirim
            // unlink($tmpFile);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat membuat backup storage: ' . $e->getMessage()], 500);
        }
    }
}
