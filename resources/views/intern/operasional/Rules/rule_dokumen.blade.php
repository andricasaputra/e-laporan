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
            <p class="mb-1">Jumlah untuk dokumen adalah dalam satuan <b>set</b></p>
          </a>
          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
            <p class="mb-1">Untuk nomor seri dokumen yang lebih dari 1 dapat ditulis menggunakan strip (-), contoh: 000001-000005</p>
          </a>
          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
            <p class="mb-1">Tekan tombol (+) untuk menambahkan nomor seri lainnya, biasanya untuk nomor seri yang tidak bersambung</p>
          </a>
          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
            <p class="mb-1"><b>Pilihan wilker telah disesuaikan untuk masing - masing pegawai </b>, <span style="color: red; font-style: italic;"> untuk pegawai yang bertugas di lebih dari satu wilker harap lebih teliti dalam pemilihan wilker, kesalahan pemilihan wilker akan berakibat data operasional menjadi kacau! </span></p>
          </a>
          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
            <p class="mb-1">Apabila terjadi kesalahan input, data penerimaan dapat diubah kembali dengan menekan tombol edit pada log penerimaan dokumen dibagian menu dokumen (halaman sebelumnya)</p>
          </a>
        </div>
    </div>
  </div>
</div>