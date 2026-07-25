<?php

namespace App\Http\Controllers\Users;

use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NewsController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi data dari form
        $request->validate([
            'title'    => 'required|string|max:255',
            'kategori' => 'required|string',
            'caption'  => 'required|string|max:1000',
            'image'    => 'required|image|mimes:jpeg,png,jpg|max:10240', // Maksimal 10MB
        ]);

        // 2. Simpan gambar ke folder storage/app/public/news_images
        $imagePath = $request->file('image')->store('news_images', 'public');

        // 3. Simpan nama/path gambar dan teks ke Database
        News::create([
            'title'    => $request->title,
            'kategori' => $request->kategori,
            'caption'  => $request->caption,
            'image'    => $imagePath,
        ]);

        return response()->json(['message' => 'Berita berhasil mengudara, dawg!']);
    }

    public function getHomepageNews()
    {
        // Ambil 6 berita terbaru
        $news = News::latest()->take(6)->get()->map(function($item) {
            return [
                'id'       => $item->id,
                'title'    => $item->title,
                'kategori' => $item->kategori,
                'image'    => $item->image, // Path fotonya
                'excerpt'  => Str::limit($item->caption, 100), // Potong caption jadi 100 huruf aja
                'date'     => Carbon::parse($item->created_at)->translatedFormat('d M Y'), // Format: 20 Jul 2026
            ];
        });

        return response()->json($news);
    }

    public function getAllNews()
    {
        // Ambil semua berita, urutkan dari yang terbaru
        $news = News::latest()->get()->map(function($item) {
            
            // Kita pisahin tanggal dan bulan/tahun buat badge kalender lu
            $dateParsed = \Carbon\Carbon::parse($item->created_at);

            return [
                'id'        => $item->id,
                'title'     => $item->title,
                'caption'   => $item->caption, // Teks full tanpa dipotong
                'image'     => $item->image,
                'day'       => $dateParsed->format('d'), // Ambil tanggalnya aja (misal: 18)
                'monthYear' => $dateParsed->translatedFormat('M Y'), // Ambil bulan & tahun (misal: Jul 2026)
            ];
        });

        return response()->json($news);
    }

    public function destroy($id)
    {
        try {
            $news = \App\Models\News::findOrFail($id);

            // Hapus file gambar fisik jika ada
            if ($news->image && file_exists(public_path($news->image))) {
                File::delete(public_path($news->image));
            }

            // Hapus data dari database
            $news->delete();

            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil dihapus dari sistem!'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus berita: ' . $e->getMessage()
            ], 500);
        }
    }
}
