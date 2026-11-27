<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermsAndCondition extends Model
{
    public const KEY = 'general';

    public const DEFAULT_CONTENT = <<<'CONTENT'
Syarat dan Ketentuan Penggunaan PetHaven

1. PetHaven membantu mempertemukan pemilik atau shelter dengan calon adopter. Informasi pada setiap iklan disediakan oleh pengiklan dan pengguna perlu memeriksanya sebelum mengambil keputusan.

2. Pengguna wajib memberikan informasi yang jujur, menjaga komunikasi dengan sopan, dan tidak mengunggah konten yang melanggar hukum atau merugikan pihak lain.

3. Pengiklan bertanggung jawab atas kebenaran informasi, foto, kondisi kesehatan, status kepemilikan, dan dokumen hewan yang dicantumkan pada iklan.

4. Calon adopter harus memastikan kesiapan waktu, biaya, tempat tinggal, dan kemampuan untuk memenuhi kebutuhan hewan sepanjang hidupnya. Adopsi tidak boleh dilakukan sebagai hadiah atau untuk tujuan yang membahayakan hewan.

5. Pengguna disarankan bertemu dan memeriksa kondisi hewan secara langsung sebelum menyepakati adopsi atau transaksi. Jangan mengirim pembayaran atau data sensitif sebelum memastikan identitas dan kesepakatan dengan pihak lain.

6. PetHaven dapat meninjau, membatasi, atau menghapus iklan dan akun yang diduga melanggar ketentuan. Pengguna dapat melaporkan informasi yang tidak akurat atau aktivitas yang mencurigakan.

7. Pengguna bertanggung jawab menjaga keamanan akun dan tidak membagikan kata sandi kepada orang lain.

8. PetHaven dapat memperbarui ketentuan ini. Pengguna dianjurkan meninjau halaman ini secara berkala.

Dengan menggunakan PetHaven, pengguna menyatakan telah membaca dan menyetujui ketentuan ini serta bersedia mematuhi peraturan yang berlaku.
CONTENT;

    protected $fillable = ['key', 'content'];
}
