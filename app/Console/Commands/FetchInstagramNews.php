<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FetchInstagramNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'instagram:fetch-news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Otomatis mengambil postingan Instagram @birologistik_ntb dan menyimpannya ke berita';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mulai mengambil data dari Instagram (@birologistik_ntb)...');
        
        $username = 'birologistik_ntb';
        $rapidApiKey = env('RAPIDAPI_KEY');
        
        if (empty($rapidApiKey)) {
            $this->error("API Key RapidAPI belum diatur!");
            $this->info("Karena sistem perlindungan Instagram sangat ketat, kita menggunakan layanan RapidAPI (gratis) untuk mengambil data.");
            $this->info("Silakan ikuti langkah ini:");
            $this->info("1. Buat akun gratis di https://rapidapi.com/");
            $this->info("2. Cari 'Instagram Scraper API' (oleh nykto) atau kunjungi https://rapidapi.com/mrngstar/api/instagram-scraper-api2");
            $this->info("3. Berlangganan paket Basic (Free).");
            $this->info("4. Salin 'X-RapidAPI-Key' dan masukkan ke file .env Anda dengan nama RAPIDAPI_KEY=kunci_anda_disini");
            return;
        }

        // Endpoint API dari RapidAPI 'Instagram Scraper API'
        $url = "https://instagram-scraper-api2.p.rapidapi.com/v1.2/posts?username_or_id_or_url={$username}";
        
        try {
            $response = Http::withHeaders([
                'X-RapidAPI-Host' => 'instagram-scraper-api2.p.rapidapi.com',
                'X-RapidAPI-Key' => $rapidApiKey,
            ])->timeout(30)->get($url);
            
            if (!$response->successful()) {
                $this->error("Gagal mengambil data dari API: " . $response->status());
                return;
            }
            
            $data = $response->json();
            
            if (!isset($data['data']['items'])) {
                $this->error('Gagal mem-parsing JSON atau data kosong.');
                return;
            }

            $count = 0;
            $adminUser = User::first(); // Ambil user admin untuk user_id
            
            foreach ($data['data']['items'] as $item) {
                // Ekstrak ID postingan
                $instagramId = $item['id'] ?? null;
                $code = $item['code'] ?? null;
                $link = "https://www.instagram.com/p/{$code}/";
                
                if (!$instagramId) continue;
                
                // Cek apakah postingan ini sudah ada di database (menghindari duplikasi)
                if (News::where('instagram_id', $instagramId)->exists()) {
                    continue; 
                }
                
                // Ambil deskripsi/caption
                $description = $item['caption']['text'] ?? 'Update Instagram birologistik_ntb';
                
                // Ambil URL gambar (thumbnail)
                $imageUrl = $item['thumbnail_url'] ?? null;
                if (!$imageUrl && isset($item['image_versions2']['candidates'][0]['url'])) {
                    $imageUrl = $item['image_versions2']['candidates'][0]['url'];
                }
                
                // Ekstrak judul (ambil kalimat pertama dari caption)
                $lines = explode("\n", $description);
                $title = trim($lines[0]);
                if (strlen($title) > 100) {
                    $title = substr($title, 0, 100) . '...';
                }
                if (empty(trim($title))) {
                    $title = 'Update Instagram birologistik_ntb';
                }

                // Download gambar secara lokal agar tidak expired
                $localImagePath = null;
                if ($imageUrl) {
                    try {
                        $imageContents = Http::timeout(20)->get($imageUrl)->body();
                        $filename = 'news/ig_' . Str::random(20) . '.jpg';
                        Storage::disk('public')->put($filename, $imageContents);
                        $localImagePath = $filename;
                    } catch (\Exception $e) {
                        $this->warn("Gagal mendownload gambar untuk: {$title}");
                    }
                }
                
                // Buat Slug yang unik
                $slug = Str::slug($title) . '-' . Str::random(6);
                
                News::create([
                    'title' => $title,
                    'slug' => $slug,
                    'content' => nl2br(htmlspecialchars($description)),
                    'thumbnail' => $localImagePath,
                    'instagram_url' => $link,
                    'instagram_id' => $instagramId,
                    'user_id' => $adminUser ? $adminUser->id : 1,
                ]);
                
                $this->info("Berhasil menambahkan postingan: {$title}");
                $count++;
                
                // Batasi mengambil max 5 postingan baru dalam satu kali jalan
                if ($count >= 5) break;
            }
            
            if ($count > 0) {
                $this->info("Selesai! {$count} postingan baru berhasil ditambahkan.");
            } else {
                $this->info("Selesai! Tidak ada postingan baru (semua sudah tersinkronisasi).");
            }
            
        } catch (\Exception $e) {
            $this->error("Terjadi kesalahan: " . $e->getMessage());
        }
    }
}
