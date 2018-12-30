{{-- 1. 
Tipe Dokumen Harus Berupa Excel!
2. 
File laporan harus dipisahkan per bulan & sesuai jenis permohonan masing2 (domas, dokel, ekspor, impor) 
-> kaintanya dengan rule nomor 6
3.
File Laporan Harus asli dari iqfast tanpa perubahan apapun
jika file mengalami perubahan atau tidak sesuai maka file akan dianggap bukan hasil export dari iqfast
4. 
Wilker si user pengupload harus sesuai dengan wilker pada dokumen yang diupload
->excel row ke 1
5. 
Jenis karantina si user (kh/ kt) harus sesuai dengan jenis karantina pada dokumen yang 
diupload
6.
jenis permohonan (domas, dokel, ekspor, impor) harus sesuai dengan jenis permohonan
pada masing2 halaman (misalnya si user sedang berada pada halaman upload dokel tetapi dokumen yang di upload ternyata domas maka si user akan mendapatkan pesan error)
7.
Kasus yang sering terjadi ketika export data dari IQFAST notifikasi sukses belum keluar,
Tetapi laporan excel sudah dibuka, ini mengakibatkan semua total pnbp pada laporan menjadi 0 maka export data 
akan gagal. contoh Dokumen pelepasan KT 12 tetapi total pnbp 0 -> ini kesalahan ketika export data dari iqfast --}}

<div class="col-md-3 offset-md-1 col-sm-12">
  <div class="card">
    <div class="card-body">
        <ul class="list-group">
          <li class="list-group-item active">Keterangan : </li>
        </ul>
        <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
            <p class="mb-1"><b>Tipe Dokumen Harus Berupa Excel!</b></p>
          </a>
          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
            <p class="mb-1"><b> File Laporan Harus asli dari iqfast tanpa perubahan apapun </b> jika file mengalami perubahan atau tidak sesuai maka file akan dianggap <b> bukan hasil export dari iqfast </b></p>
          </a>
          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
            <p class="mb-1">File laporan harus dipisahkan <b> per bulan </b> & sesuai jenis permohonan masing -masing <b> (domas, dokel, ekspor, impor) </b> </p>
          </a>
          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
            <p class="mb-1"><b>Untuk kegiatan yang nihil, laporan operasional tetap wajib diupload!</b></p>
          </a>
          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
            <p class="mb-1">Pastikan <b> Total PNBP tidak 0 </b> untuk dokumen pelepasan yang dikenakan tarif PNBP</p>
          </a>
          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
            <p class="mb-1">Periksa kembali file laporan anda sebelum mengupload ke server database!</p>
          </a>
          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
            <p class="mb-1"><b>Pilihan wilker telah disesuaikan untuk masing - masing pegawai </b>, <span style="color: red; font-style: italic;"> untuk pegawai yang bertugas di lebih dari satu wilker harap lebih teliti dalam pemilihan wilker, kesalahan pemilihan wilker akan berakibat data operasional menjadi kacau! </span></p>
          </a>
          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
            <p class="mb-1">Apabila ada perubahan data pada laporan yang diupload, silahkan unggah kembali laporan terbaru anda. Sistim akan secara otomatis mengupdate data menjadi yang terbaru</p>
          </a>
          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
            <p class="mb-1">Data operasional yang telah diupload <b> dapat ditarik kembali dalam kurun waktu satu minggu </b>setelah data berhasil diupload, <b> selebihnya data akan terkunci dan dianggap valid! </b></p>
          </a>
        </div>
    </div>
  </div>
</div>