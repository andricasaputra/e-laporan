<?php 

namespace App\Imports\Operasional\Process;

use Carbon\Carbon;

abstract class ImportMaster
{
    /**
     * Untuk menyimpan model instance
     *
     * @var App\Contracts\ModelOperasionalInterface
     */
    protected $model;

    /**
     * Untuk menyimpan kolom index dari table untuk kebutuhan batch update
     *
     * @var string 
     */
    protected  $index = 'no_permohonan';

    /**
     * Untuk menyimpan request
     *
     * @var Request 
     */
    protected $request;

    /**
     * Untuk menyimpan type karantina
     *
     * @var string 
     */
    protected $typeKarantina;

    /**
     * Untuk menyimpan tanggal laporan
     *
     * @var string 
     */
    protected $tanggalLaporan;

    /**
     * Untuk menyimpan tipe dokumen - dokumen dari KT yang mempunyai tarif PNBP
     *
     * @var array 
     */
    protected $dokumenKt = ['KT9', 'KT10', 'KT12'];

    /**
     *Untuk menyimpan tipe dokumen - dokumen dari KH yang mempunyai tarif PNBP
     *
     * @var array 
     */
    protected $dokumenKh = ['KH11', 'KH12', 'KH13', 'KH14'];

    /**
     * Untuk menyimpan type dari feedback setelah upload
     *
     * @var string 
     */
    protected $feedbackType = 'success';

    /**
     * Untuk menyimpan konten dari feedback setelah upload
     *
     * @var string 
     */
    protected $feedbackContent = '';

    /**
     * Untuk menyimpan konten dari feedback setelah upload
     *
     * @var bool 
     */
    protected $notificationTrigger = false;

	/**
     * Untuk menampung tipe dan konten dari feedback yang akan 
     * kita berikan kepada user setalah mengupload dokumen
     *
     * @param string $type
     * @param string $content
     * @return void
     */
	public abstract function setFeedback(string $type, string $content);

    /**
     * Untuk mengambil pesan feedback
     *
     * @return void
     */
    public abstract function getFeedback();

	/**
	 * Transform tanggal menjadi object dari carbon
	 *
	 * @param string $value
	 * @param string $format
	 * @return \Carbon\Carbon|null
	 */
	protected function transformDate($value, $format = 'Y-m-d')
	{
	    try {

	        return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));

	    } catch (\ErrorException $e) {

	        return Carbon::createFromFormat($format, $value);
	    }
	}

	/**
     * Untuk memformat tanggal - tanggal pada laporan dengan 
     * format Y-m-d, ini untuk menghindari kesalahan translasi
     * tanggal pada dokumen excel, karena terdapat kemungkinan
     * tanggal akan dirubah secara otomatis menjadi interger/ float oleh excel
     *
     * @param srting $tanggal
     * @return string
     */
    protected function formatTanggal($tanggal)
    {
        return $this->transformDate($tanggal)->format('Y-m-d');
    }

    /**
     * Untuk membuat format nomor kwitansi
     * yang kita ambil dari data  nomor permohonan 
     *
     * @param srting $datas
     * @return string
     */
    protected function formatNoKwitansi($datas)
    {
        // Jika terdapat no seri & pnbp maka rangkai nomor kwitansi
        if (! is_null($datas['no_seri']) && (int) $datas['total_pnbp'] !== 0) {

            $ex = explode('.', $datas['nomor_dok_pelepasan']);

            return "$ex[0].$ex[1].$ex[2].$ex[3].KWI.$ex[5].$ex[6]/1";
        }
    }

}