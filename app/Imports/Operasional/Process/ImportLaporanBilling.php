<?php

declare(strict_types = 1);

namespace App\Imports\Operasional\Process;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Mavinoo\LaravelBatch\LaravelBatchFacade as Batch;
use App\Contracts\Operasional\ModelReportBillingInterface as Model;

class ImportLaporanBilling extends ImportMaster implements ToCollection, WithMultipleSheets, WithHeadingRow
{
    /**
     * Untuk menyimpan kolom index dari table untuk kebutuhan batch update
     *
     * @var string 
     */
    protected  $index = 'no_kwitansi';

    /**
     * Set kebutuhan upload property
     *
     * @param App\Contracts\Operasional\ModelReportBillingInterface $model
     * @param Request $request
     * @param Carbon $tanggalLaporan
     * @return void
     */
	public function __construct(Model $model, Request $request, Carbon $tanggalLaporan)
	{
		$this->model 		  = $model;

		$this->request 		  = $request;

        $this->tanggalLaporan = $tanggalLaporan;
	}

    /**
     * Method untuk menjalankan proses upload
     *
     * @param Collection $row
     * @return void
     */
    public function collection(Collection $rows)
    {
    	// Pertama kita akan menyiapkan kebutuhan data untuk diupload,
    	// disini data dari laporan akan tambahkan beberapa field seperti 
    	// wilker_id, user_id, modifikasi format tanggal, dsb 
    	$datas = $this->prepareDatas($rows);

    	// Kemudian kita akan menjalankan proses upload, apabila data sudah pernah
    	// diupload sebelumnya maka kita hanya perlu mengupdate data lama saja
    	$this->runProcessUpload($datas); 

    	// berikan feedback berupa pesan flash kepada user untuk berhasil atau gagalnya proses import
    	return $this->getFeedback();
    }

    /**
     * Mengambil sheet pertama saja pada dokumen excel
     *
     * @return array
     */
    public function sheets(): array
    {
        return [0 => $this];
    }

    /**
     * Mengambil data dari row ke 7, 
     * row ke 7 adalah header, row ke 8 dst adalah data
     *
     * @return int
     */
    public function headingRow(): int
    {
        return 6;
    }

    /**
     * Menyiapkan data untuk proses upload, disini data akan 
     * kita custom untuk keperluan insert/update ke database
     *
     * @param array $rows
     * @return Illuminate\Support\Collection
     */
    private function prepareDatas(Collection $rows)
    {
        // Disini kita akan lakukan penambahan beberapa data dan format beberapa tanggal
        // seperti wilker_id, user_id, no_kwitansi dan modifikasi format tanggal, dsb 
    	return $rows->map(function($row) {

	        $row['tgl_kwitansi'] = $this->formatTanggal($row['tgl_kwitansi']);

	        $row['tgl_bayar']  = $this->formatTanggal($row['tgl_bayar']);

            $row['jumlah']  = (int) $row['jumlah'];

            $row['kode_transaksi_simponi']  = (int) $row['kode_transaksi_simponi'];

            $row->put('created_at', now())
                ->prepend($this->tanggalLaporan, 'bulan')
                ->prepend($this->request->wilker_id, 'wilker_id')
                ->prepend($this->request->user_id, 'user_id');
                
	        return $row->all();

    	}); 
    }

    /**
     * Digunakan untuk pengecekan tarif pnbp pada laporan yang diupload
     * untuk kasus tarif 0 pada permohonan yang seharusnya terdapat 
     * jasa karantina, biasanya kesalahan dalam export laporan pada IQFAST
     *
     * @param array $datas
     * @return bool
     */
    private function validateWilkerUser($datas)
    {
        // Cari nama wilker berdasarkan user yang sedang aktif
        $wilker = $datas->whereIn('wilker', auth()->user()->wilker()->pluck('nama_wilker'))->count();

        // Check wilker user harus sama dengan user wilker yang diupload
        if ($wilker === 0) {

            $this->setFeedback('warning', 'Laporan Yang Anda Upload Tidak Sesuai Dengan Wilker Anda');

            return false;

        }

        return true;

    }

    /**
     * Digunakan untuk pengecekan apakah laporan sudah pernah diupload
     * atau belum, jika laporan sudah pernah diupload, maka update
     * sebaliknya, insert data baru ke database
     *
     * @param array $datas
     * @return int
     */
    private function forInsertOrUpdate($datas)
    {
        // Pengecekan Laporan Bulanan Sudah Pernah Diupload atau belum, 
        // jika sudah lakukan update, jika belum insert baru
        $no_kwitansi = $datas->pluck($this->index)->all();

        $result      = $this->model::whereIn($this->index, $no_kwitansi)->first();

        return $result  === null ? 0 : $result->count();
    }

	/**
     * Method delegasi untuk menjalankan proses upload yang file
     *
     * @return bool|void
     */
    private function runProcessUpload(Collection $datas)
    {
        // Pengecekan PNBP yang tidak boleh 0 pada dokumen pelepasan yang dikenakan tarif
        if (! $this->validateWilkerUser($datas)) return false;

        // Jika Laporan belum pernah diupload, maka insert 
        $datas->when((int) $this->forInsertOrUpdate($datas) === 0, function ($datas) {

            $this->model->insert( $datas->all() ); 

            $this->notificationTrigger = true;

            $this->setFeedback('success', 'Laporan Berhasil Diupload!');

        // Jika Laporan sudah pernah diupload, maka update
        }, function($datas){

            Batch::update($this->model, $datas->all(), $this->index);

            $this->setFeedback('success', 'Laporan Berhasil Diperbarui!');

        });                   
    }

    /**
     * Untuk menampung tipe dan konten dari feedback yang akan 
     * kita berikan kepada user setalah mengupload dokumen
     *
     * @param string $type
     * @param string $content
     * @return void
     */
	public function setFeedback(string $type, string $content)
	{
		$this->feedbackType 	= $type;

		$this->feedbackContent 	= $content;

		return $this;
	}

    /**
     * Untuk mengambil pesan feedback
     *
     * @return void
     */
    public function getFeedback()
    {
        session()->flash($this->feedbackType, $this->feedbackContent);

        return $this->notificationTrigger();
    }

    /**
     * Untuk trigger notifikasi
     *
     * @return void
     */
    public function notificationTrigger()
    {
        return $this->notificationTrigger;
    }
}
