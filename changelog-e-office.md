## e-office-v2 | writed on : 22/04/2019

# E-Laporan Operasional v2
# E-IKM v1

# SYSTEM UPDATE

* Upgrade PHP version dari 7.2 ke 7.3
* Upgrade Laravel Framework dari 5.7 ke 5.8
* Upgrade Maatwesite Excel Package dari v2.0 ke v.3.1 
* Penambahan Model Caching dari Genea Lab
* Pergantian Cache driver dari file ke Redis

# INFO UPDATE APLIKASI (TO USER)

* Penambahan Upload Laporan Billing Dari Simponi Barantan | E-Laporan Operasional

# TODO For Next Update

* Penambahan Laporan BKU (Buku Kas Umum) | E-Laporan Operasional
* Pergantian Skema Pelaporan Penerimaan dan Pemakaian Dokumen Terkait Blank Certificate | E-Laporan Operasional
* Penambahan Halaman Informasi Dalam Bentuk Grafik/Chart | E-Laporan Operasional
* Pergantian Tampilan Halaman Statistik | E-Laporan Operasional
* Penambahan Custom Download Laporan | E-Laporan Operasional

* Chunk Jumlah Print Rekapitulasi Responden IKM / Cicil print | E-IKM

----------------------------------------------------------------------------------------------------------

## e-office-v1 | writed on : 20/02/2019

# E-Laporan Operasional v1
# E-IKM v1

# SYSTEM UPDATE

* Perbaikan views table migration (add where condition)
* Perbaikan data frekuensi chart pada home/ dashboard

# FOR ADMIN PAGE

* Add database management (backup & restore)
* File backup tersimpan di dalam storage folder, tipe file adalah sql & zip
* File restore harus berupa .sql untuk saat ini

# INFO UPDATE APLIKASI (TO USER)

* Perbaikan kolom volume pada download excel rekapitulasi komoditi

----------------------------------------------------------------------------------------------------------

## e-office-v1 | writed on : 22/01/2019

# E-Laporan Operasional v1
# E-IKM v1

# TODO

* upadate pembatalan_dok_kh column bulan dari int -> date
* upadate pembatalan_dok_kt column bulan dari int -> date

# SYSTEM UPDATE

* Refactory code to laravel style (no more if else on model)
* Add views table, khusus untuk fungsi agregasi untuk digunakan sebagai perhitungan data & statistik
* Add ajax untuk load ringkasan data pada landing page

# FOR ADMIN PAGE

* Add master dokumen
* Add pengumuman

# INFO UPDATE APLIKASI (TO USER)

* Add upload (serah terima, reekspor, pembatalan dokumen)
* Add opsi pencarian pada tabel log pengiriman laporan
  + opsi (tahun, bulan, type permohonan)
* Add download laporan (rekapitulasi, operasional, permakaian dokumen)
* Add penerimaan, pemakaian, pembatalan dokumen beserta info dan detailnya
* Add kolom volume, negara asal & tujuan pada tabel rekapitulasi komoditi

----------------------------------------------------------------------------------------------------------