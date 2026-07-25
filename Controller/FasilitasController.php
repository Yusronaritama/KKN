<?php

namespace App\Http\Controllers\Users;

use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\Fasilitas;

class FasilitasController extends Controller
{
    public function index()
    {
        return view('Users.Dashboard.fasilitas');
    }

    public function store(Request $request)
    {
        try {
            // Validasi data inputan form (kategori dibatasi sesuai pilihan sistem)
            $validated = $request->validate([
                'namalokasi' => 'required|string|max:255',
                'coordinate' => 'required|string|max:255',
                'nomerhp'    => 'nullable|string|max:50',
                'deskripsi'  => 'nullable|string',
                'kategori'   => 'required|string|in:Pemerintahan,Kesehatan,Aparat', // Validasi pilihan kategori
                'image'      => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            ]);

            $imagePath = null;

            // Jika ada file gambar yang di-upload
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                
                // Cek & buat folder public/images/fasilitas otomatis jika belum ada
                $destinationPath = public_path('images/fasilitas');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                // Pindahkan file ke folder public
                $file->move($destinationPath, $filename);
                $imagePath = '/images/fasilitas/' . $filename;
            }

            // Simpan ke Database
            Fasilitas::create([
                'namalokasi' => $validated['namalokasi'],
                'kategori'   => $validated['kategori'],
                'coordinate' => $validated['coordinate'],
                'nomerhp'    => $request->nomerhp ?? null,
                'deskripsi'  => $request->deskripsi ?? null,
                'image'      => $imagePath,
            ]);

            return response()->json([
                'success' => true, 
                'message' => 'Fasilitas berhasil disimpan ke database!'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan di server: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAll()
    {
        try {
            $fasilitas = Fasilitas::all()->map(function ($item) {
                // Ubah string koordinat jadi array float buat Leaflet
                $coords = array_map('floatval', explode(',', $item->coordinate));

                return [
                    'id'         => $item->id,
                    'nama'       => $item->namalokasi,
                    'kategori'   => $item->kategori, // Mengambil kategori langsung dari database (Pemerintahan / Kesehatan / Aparat)
                    'kordinat'   => $coords,
                    'nomerhp'    => $item->nomerhp,
                    'deskripsi'  => $item->deskripsi,
                    'gambar'     => $item->image ? asset($item->image) : 'https://images.unsplash.com/photo-1541884488340-023a9d701e85?q=80&w=400&auto=format&fit=crop',
                    'markerObj'  => null
                ];
            });

            return response()->json($fasilitas, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $fasilitas = Fasilitas::findOrFail($id);

            // Hapus file gambar fisik dari folder public jika ada
            if ($fasilitas->image && file_exists(public_path($fasilitas->image))) {
                File::delete(public_path($fasilitas->image));
            }

            // Hapus data dari database
            $fasilitas->delete();

            return response()->json([
                'success' => true,
                'message' => 'Fasilitas berhasil dihapus dari database!'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}
