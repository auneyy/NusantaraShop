<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            // KATEGORI: GETTING STARTED
            [
                'title' => 'Cara Membuat Akun di BatikKraton',
                'content' => '<h3>Langkah-langkah Membuat Akun</h3>
                <ol>
                    <li><strong>Klik tombol "Daftar"</strong> di pojok kanan atas halaman</li>
                    <li><strong>Isi formulir pendaftaran</strong> dengan:
                        <ul>
                            <li>Nama lengkap</li>
                            <li>Alamat email aktif</li>
                            <li>Nomor telepon</li>
                            <li>Password (minimal 8 karakter)</li>
                        </ul>
                    </li>
                    <li><strong>Verifikasi email</strong> - Cek inbox email Anda dan klik link verifikasi</li>
                    <li><strong>Lengkapi profil</strong> - Tambahkan alamat pengiriman untuk mempermudah checkout</li>
                </ol>
                <p><strong>Tips:</strong> Gunakan email yang sering Anda cek agar tidak ketinggalan promo dan update pesanan!</p>',
                'category' => 'getting-started',
                'is_featured' => true,
                'is_published' => true,
                'order' => 1
            ],
            [
                'title' => 'Cara Berbelanja di BatikKraton',
                'content' => '<h3>Panduan Belanja Mudah</h3>
                <h4>1. Jelajahi Produk</h4>
                <p>Browse koleksi batik kami melalui menu kategori atau gunakan fitur pencarian.</p>
                
                <h4>2. Pilih Produk</h4>
                <ul>
                    <li>Klik produk yang Anda suka</li>
                    <li>Pilih ukuran dan warna (jika tersedia)</li>
                    <li>Periksa detail produk dan harga</li>
                    <li>Klik "Tambah ke Keranjang"</li>
                </ul>
                
                <h4>3. Checkout</h4>
                <ol>
                    <li>Buka keranjang belanja</li>
                    <li>Tinjau pesanan Anda</li>
                    <li>Pilih metode pengiriman</li>
                    <li>Pilih metode pembayaran</li>
                    <li>Konfirmasi pesanan</li>
                </ol>
                
                <h4>4. Pembayaran</h4>
                <p>Ikuti instruksi pembayaran sesuai metode yang dipilih. Setelah pembayaran dikonfirmasi, pesanan Anda akan segera diproses.</p>',
                'category' => 'getting-started',
                'is_featured' => true,
                'is_published' => true,
                'order' => 2
            ],
            [
                'title' => 'Mengenal Jenis-Jenis Batik di BatikKraton',
                'content' => '<h3>Koleksi Batik Kami</h3>
                
                <h4>Batik Cap</h4>
                <p>Batik yang dibuat menggunakan cap/stempel tembaga. Motif lebih seragam dengan harga lebih terjangkau.</p>
                <ul>
                    <li>Waktu produksi lebih cepat</li>
                    <li>Harga lebih ekonomis</li>
                    <li>Cocok untuk seragam kantor</li>
                </ul>
                
                <h4>Batik Tulis</h4>
                <p>Batik yang dibuat dengan canting, sepenuhnya dikerjakan tangan. Setiap motif unik dan bernilai seni tinggi.</p>
                <ul>
                    <li>Proses pembuatan 1-3 bulan</li>
                    <li>Setiap piece unik</li>
                    <li>Nilai investasi tinggi</li>
                    <li>Cocok untuk acara formal</li>
                </ul>
                
                <h4>Batik Kombinasi</h4>
                <p>Perpaduan teknik cap dan tulis untuk menghasilkan batik dengan detail lebih rumit namun harga lebih terjangkau dari batik tulis.</p>
                
                <p><strong>Cara membedakan:</strong> Batik tulis memiliki motif yang tembus di kedua sisi kain dengan warna yang sama intens, sedangkan batik cap biasanya lebih pudar di sisi belakang.</p>',
                'category' => 'getting-started',
                'is_featured' => false,
                'is_published' => true,
                'order' => 3
            ],

            // KATEGORI: ACCOUNT & BILLING
            [
                'title' => 'Metode Pembayaran yang Tersedia',
                'content' => '<h3>Pilihan Pembayaran BatikKraton</h3>
                
                <h4>Transfer Bank</h4>
                <p>Transfer langsung ke rekening kami:</p>
                <ul>
                    <li>BCA: 1234567890 (a.n. BatikKraton)</li>
                    <li>Mandiri: 0987654321 (a.n. BatikKraton)</li>
                    <li>BNI: 1122334455 (a.n. BatikKraton)</li>
                </ul>
                <p><em>Konfirmasi pembayaran max 2x24 jam setelah checkout</em></p>
                
                <h4>E-Wallet</h4>
                <ul>
                    <li>GoPay</li>
                    <li>OVO</li>
                    <li>DANA</li>
                    <li>ShopeePay</li>
                </ul>
                
                <h4>Virtual Account</h4>
                <p>Dapatkan nomor VA otomatis setelah checkout untuk kemudahan pembayaran.</p>
                
                <h4>COD (Cash on Delivery)</h4>
                <p>Tersedia untuk wilayah tertentu. Bayar langsung saat barang diterima.</p>
                
                <p><strong>Catatan:</strong> Semua metode pembayaran aman dan terenkripsi.</p>',
                'category' => 'account-billing',
                'is_featured' => true,
                'is_published' => true,
                'order' => 4
            ],
            [
                'title' => 'Cara Melacak Pesanan Anda',
                'content' => '<h3>Tracking Pesanan</h3>
                
                <h4>Melalui Akun Anda</h4>
                <ol>
                    <li>Login ke akun BatikKraton</li>
                    <li>Klik menu "Pesanan Saya"</li>
                    <li>Pilih pesanan yang ingin dilacak</li>
                    <li>Klik "Lacak Pengiriman"</li>
                </ol>
                
                <h4>Melalui Email</h4>
                <p>Setelah pesanan dikirim, Anda akan menerima email berisi nomor resi pengiriman. Gunakan nomor resi tersebut untuk tracking di website ekspedisi:</p>
                <ul>
                    <li>JNE: www.jne.co.id</li>
                    <li>J&T: www.jet.co.id</li>
                    <li>SiCepat: www.sicepat.com</li>
                </ul>
                
                <h4>Status Pesanan</h4>
                <ul>
                    <li><strong>Menunggu Pembayaran:</strong> Pesanan menunggu konfirmasi pembayaran</li>
                    <li><strong>Diproses:</strong> Pesanan sedang disiapkan</li>
                    <li><strong>Dikirim:</strong> Pesanan sudah diserahkan ke kurir</li>
                    <li><strong>Selesai:</strong> Pesanan sudah diterima</li>
                </ul>',
                'category' => 'account-billing',
                'is_featured' => false,
                'is_published' => true,
                'order' => 5
            ],
            [
                'title' => 'Cara Mengubah Alamat Pengiriman',
                'content' => '<h3>Update Alamat Pengiriman</h3>
                
                <h4>Sebelum Checkout</h4>
                <ol>
                    <li>Login ke akun Anda</li>
                    <li>Klik menu "Profil Saya"</li>
                    <li>Pilih "Alamat"</li>
                    <li>Klik "Tambah Alamat" atau "Edit" pada alamat yang ada</li>
                    <li>Isi detail alamat lengkap</li>
                    <li>Centang "Jadikan alamat utama" jika perlu</li>
                    <li>Klik "Simpan"</li>
                </ol>
                
                <h4>Saat Checkout</h4>
                <p>Anda bisa memilih alamat pengiriman yang berbeda langsung di halaman checkout.</p>
                
                <h4>Setelah Pesanan Dibuat</h4>
                <p><strong>Penting:</strong> Jika pesanan sudah diproses, alamat tidak bisa diubah. Segera hubungi Customer Service kami melalui WhatsApp untuk bantuan.</p>
                
                <p><strong>Tips:</strong> Simpan beberapa alamat (rumah, kantor, dll) untuk kemudahan berbelanja di masa depan.</p>',
                'category' => 'account-billing',
                'is_featured' => false,
                'is_published' => true,
                'order' => 6
            ],

            // KATEGORI: TROUBLESHOOTING
            [
                'title' => 'Cara Merawat Batik Agar Awet',
                'content' => '<h3>Panduan Perawatan Batik</h3>
                
                <h4>Mencuci Batik</h4>
                <ul>
                    <li><strong>Cuci dengan tangan</strong> menggunakan air dingin atau suam-suam kuku</li>
                    <li>Gunakan <strong>deterjen khusus batik</strong> atau shampo bayi</li>
                    <li><strong>Jangan dikucek</strong> terlalu keras, cukup diremas-remas lembut</li>
                    <li>Jangan gunakan pemutih atau pelembut pakaian</li>
                    <li>Pisahkan pencucian batik dari pakaian lain</li>
                </ul>
                
                <h4>Mengeringkan</h4>
                <ul>
                    <li>Jemur di <strong>tempat teduh</strong>, hindari sinar matahari langsung</li>
                    <li>Jemur dalam keadaan <strong>dibalik</strong> (bagian dalam di luar)</li>
                    <li>Jangan diperas terlalu kuat</li>
                </ul>
                
                <h4>Menyetrika</h4>
                <ul>
                    <li>Setrika dalam keadaan <strong>setengah kering</strong></li>
                    <li>Gunakan <strong>suhu sedang</strong></li>
                    <li>Setrika dari <strong>bagian dalam</strong> (dibalik)</li>
                    <li>Bisa menggunakan kain pelapis saat menyetrika</li>
                </ul>
                
                <h4>Penyimpanan</h4>
                <ul>
                    <li>Simpan di <strong>lemari tertutup</strong></li>
                    <li>Gunakan <strong>gantungan</strong> atau lipat rapi</li>
                    <li>Beri kapur barus untuk mencegah ngengat</li>
                    <li>Hindari tempat lembab</li>
                </ul>
                
                <p><strong>Catatan Penting:</strong> Batik tulis memerlukan perawatan ekstra hati-hati karena proses pewarnaan alami.</p>',
                'category' => 'troubleshooting',
                'is_featured' => true,
                'is_published' => true,
                'order' => 7
            ],
            [
                'title' => 'Kebijakan Return dan Penukaran Barang',
                'content' => '<h3>Syarat Return & Penukaran</h3>
                
                <h4>Kapan Bisa Return/Tukar?</h4>
                <ul>
                    <li>Barang rusak atau cacat produksi</li>
                    <li>Barang tidak sesuai pesanan</li>
                    <li>Barang hilang/rusak saat pengiriman</li>
                </ul>
                
                <h4>Syarat Return</h4>
                <ol>
                    <li>Maksimal <strong>3 hari</strong> setelah barang diterima</li>
                    <li>Barang dalam kondisi <strong>belum dipakai</strong></li>
                    <li>Tag/label masih terpasang</li>
                    <li>Kemasan masih lengkap</li>
                    <li>Sertakan video unboxing (untuk klaim kerusakan)</li>
                </ol>
                
                <h4>Cara Mengajukan Return</h4>
                <ol>
                    <li>Hubungi Customer Service via WhatsApp</li>
                    <li>Kirim foto/video bukti</li>
                    <li>Isi formulir return</li>
                    <li>Kirim barang ke alamat yang diberikan</li>
                    <li>Tunggu verifikasi (max 5 hari kerja)</li>
                </ol>
                
                <h4>Biaya Return</h4>
                <ul>
                    <li><strong>GRATIS</strong> jika kesalahan dari toko</li>
                    <li><strong>Ditanggung pembeli</strong> jika alasan pribadi</li>
                </ul>
                
                <h4>Pengembalian Dana</h4>
                <p>Setelah return disetujui, dana akan dikembalikan dalam 7-14 hari kerja ke metode pembayaran awal atau saldo toko (sesuai pilihan).</p>
                
                <p><strong>Catatan:</strong> Produk custom/pesanan khusus tidak dapat ditukar/dikembalikan kecuali ada cacat produksi.</p>',
                'category' => 'troubleshooting',
                'is_featured' => true,
                'is_published' => true,
                'order' => 8
            ],
            [
                'title' => 'Lupa Password - Cara Reset',
                'content' => '<h3>Reset Password Akun</h3>
                
                <h4>Langkah-langkah Reset Password</h4>
                <ol>
                    <li>Klik <strong>"Lupa Password"</strong> di halaman login</li>
                    <li>Masukkan <strong>email</strong> yang terdaftar</li>
                    <li>Cek <strong>inbox email</strong> Anda</li>
                    <li>Klik <strong>link reset password</strong> di email</li>
                    <li>Masukkan <strong>password baru</strong> (minimal 8 karakter)</li>
                    <li>Konfirmasi password baru</li>
                    <li>Klik <strong>"Reset Password"</strong></li>
                </ol>
                
                <h4>Tips Password Aman</h4>
                <ul>
                    <li>Minimal 8 karakter</li>
                    <li>Kombinasi huruf besar & kecil</li>
                    <li>Tambahkan angka</li>
                    <li>Gunakan karakter khusus (!@#$%)</li>
                    <li>Jangan gunakan info pribadi (tanggal lahir, nama)</li>
                </ul>
                
                <h4>Tidak Menerima Email Reset?</h4>
                <ol>
                    <li>Cek folder <strong>Spam/Junk</strong></li>
                    <li>Pastikan email yang dimasukkan <strong>benar</strong></li>
                    <li>Tunggu <strong>5-10 menit</strong></li>
                    <li>Coba <strong>kirim ulang</strong> link reset</li>
                    <li>Hubungi CS jika masih bermasalah</li>
                </ol>
                
                <p><strong>Keamanan:</strong> Link reset password hanya berlaku 1 jam. Jangan bagikan link ke siapapun!</p>',
                'category' => 'troubleshooting',
                'is_featured' => false,
                'is_published' => true,
                'order' => 9
            ],
            [
                'title' => 'Pesanan Belum Sampai - Apa yang Harus Dilakukan?',
                'content' => '<h3>Troubleshooting Keterlambatan Pesanan</h3>
                
                <h4>1. Cek Status Pengiriman</h4>
                <ul>
                    <li>Login ke akun Anda</li>
                    <li>Buka "Pesanan Saya"</li>
                    <li>Cek nomor resi dan tracking di website ekspedisi</li>
                </ul>
                
                <h4>2. Estimasi Keterlambatan Normal</h4>
                <ul>
                    <li><strong>Dalam kota:</strong> 1-2 hari</li>
                    <li><strong>Luar kota (Jawa):</strong> 2-4 hari</li>
                    <li><strong>Luar Jawa:</strong> 3-7 hari</li>
                    <li><strong>Papua & kepulauan:</strong> 5-14 hari</li>
                </ul>
                
                <h4>3. Penyebab Keterlambatan</h4>
                <ul>
                    <li>Cuaca buruk</li>
                    <li>Hari libur/weekend</li>
                    <li>Kepadatan kiriman (Harbolnas, Ramadan)</li>
                    <li>Force majeure (bencana alam)</li>
                    <li>Alamat tidak lengkap/salah</li>
                    <li>Penerima tidak ada di tempat</li>
                </ul>
                
                <h4>4. Apa yang Harus Dilakukan?</h4>
                <ol>
                    <li>Hubungi <strong>kurir ekspedisi</strong> terlebih dahulu</li>
                    <li>Pastikan <strong>nomor telepon aktif</strong> dan bisa dihubungi</li>
                    <li>Jika sudah lewat estimasi >3 hari, <strong>hubungi CS kami</strong></li>
                    <li>Kami akan bantu koordinasi dengan ekspedisi</li>
                </ol>
                
                <h4>5. Jika Paket Hilang</h4>
                <p>Jika tracking menunjukkan paket hilang atau tidak bergerak lebih dari 7 hari:</p>
                <ol>
                    <li>Laporkan ke CS BatikKraton</li>
                    <li>Kami akan proses <strong>klaim ke ekspedisi</strong></li>
                    <li>Pesanan akan dikirim ulang atau dana dikembalikan</li>
                    <li>Proses klaim 7-14 hari kerja</li>
                </ol>
                
                <p><strong>Jaminan:</strong> Semua pesanan diasuransikan. Anda tidak akan rugi jika paket hilang/rusak!</p>',
                'category' => 'troubleshooting',
                'is_featured' => false,
                'is_published' => true,
                'order' => 10
            ],
        ];

        foreach ($articles as $article) {
            Article::create([
                'title' => $article['title'],
                'slug' => Str::slug($article['title']),
                'content' => $article['content'],
                'category' => $article['category'],
                'is_featured' => $article['is_featured'],
                'is_published' => $article['is_published'],
                'order' => $article['order']
            ]);
        }
    }
}