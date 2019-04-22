<?php  

namespace App\Exports\Operasional\Style;

use Illuminate\Http\Request;

abstract class AbstractGlobalLaporanStyle
{
	/**
    * Untuk ukuran kertas yang dipilih
    *
    * @var int|string
    */
    protected $paperSize;

    /**
    * Untuk skala laporan
    *
    * @var int
    */
    protected $scale;

    /**
    * Untuk orientasi laporan (potrait/landscape)
    *
    * @var string
    */
    protected $orientation;

    /**
    * Untuk tipe huruf laporan
    *
    * @var string
    */
    protected $fontName;

    /**
    * Set property awal
    *
    * @param Illuminate\Http\Request $request
    * @return void
    */
	protected function __construct(Request $request)
	{
		$this->fontName   	= $request->font;

		$this->scale        = $request->scale;

		$this->paperSize    = $request->paperSize;

        $this->orientation  = $request->orientation; 
	}

	abstract public function applyStyle();

	abstract public function setLaporanHeader();

	abstract public function setLaporanIsi();

	abstract public function setLaporanFooter();
}