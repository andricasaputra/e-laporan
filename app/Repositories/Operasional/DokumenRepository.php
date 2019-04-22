<?php

namespace App\Repositories\Operasional;

use App\Models\Operasional\Dokumen\PemakaianDokumenKh;
use App\Models\Operasional\Dokumen\PemakaianDokumenKt;
use App\Models\Operasional\Admin\MasterDokumen as Dokumen;
use App\Models\Operasional\Dokumen\PembatalanDokKh as PembatalanKh;
use App\Models\Operasional\Dokumen\PembatalanDokKt as PembatalanKt;
use App\Models\Operasional\Dokumen\PenerimaanDokumenKh as PenerimaanKh;
use App\Models\Operasional\Dokumen\PenerimaanDokumenKt as PenerimaanKt;

class DokumenRepository
{
	/**
     * Menyimpan data tahun
     *
     * @var string|int
     */
	private $year;

	/**
     * Menyimpan data bulan
     *
     * @var string|int
     */
	private $month;

	/**
     * Menyimpan data wilkerId
     *
     * @var string|int
     */
	private $wilkerId;

	/**
     * Menyimpan kumpulan parameter untuk model
     *
     * @var array
     */
	private $params;

	/**
     * Untuk set semua property yang ada di class ini 
     * -> dipanggil pada constructor class HomeKtController atau HomeKhController
     *
     * @param int|null $year
     * @param int|null $month
     * @param int|null $wilkerId
     * @return void 
     */
    public function __construct($year = null, $month = null, $wilkerId = null)
    {
        $this->year         = $year ?? false;

        $this->month        = $month ?? false;

        $this->wilkerId     = $wilkerId ?? false;

        $this->params  		= [

        	'year' => $this->year, 
        	'month' => $this->month, 
        	'wilkerId' => $this->wilkerId

        ];
    }

	/**
     * Untuk mendapatkan penerimaan dokumen berdasarkan nama dokumen KT
     *
     * @return mixed
     */
	public function penerimaanTableKt()
	{
		return PenerimaanKt::getByNamaDokumenKt($this->params);
	}

	/**
     * Untuk mendapatkan penerimaan dokumen berdasarkan nama dokumen KH
     *
     * @return mixed
     */
	public function penerimaanTableKh()
	{
		return PenerimaanKh::getByNamaDokumenKh($this->params);
	}

	/**
     * Untuk mendapatkan pembatalan dokumen
     *
     * @return mixed
     */
	public function pembatalanTableKt()
	{
		return PembatalanKt::getPembatalan($this->params);
	}

	/**
     * Untuk mendapatkan pembatalan dokumen
     *
     * @return mixed
     */
	public function pembatalanTableKh()
	{
		return PembatalanKh::getPembatalan($this->params);
	}

	/**
     * Mapping data KT
     *
     * @return array
     */
	public function dokumenKtDataSource()
	{
		return [

			'persediaan' => $this->transformPersediaanDokumenKt(),
			'penerimaan' => $this->transformPenerimaanDokumenKt(),
			'pemakaian'  => $this->transformPemakaianDokumenKt(),
			'pembatalan' => PembatalanKt::getJumlahKtDokumen($this->params)

		];
	}

	/**
     * Mapping data KH
     *
     * @return array
     */
	public function dokumenKhDataSource()
	{
		return [

			'persediaan' => $this->transformPersediaanDokumenKh(),
			'penerimaan' => $this->transformPenerimaanDokumenKh(),
			'pemakaian'  => $this->transformPemakaianDokumenKh(),
			'pembatalan' => PembatalanKh::getJumlahKhDokumen($this->params)

		];
	}

	/**
     * Modify data persediaan dokumen KT
     *
     * @return array
     */
	public function transformPersediaanDokumenKt()
	{
		return PenerimaanKt::getJumlahKtDokumen($this->params)
				->groupBy([ function($item, $key){

					return [$item->dokumen['dokumen']];

				}, function($item, $key){

					return [$item->wilker->getOriginal('nama_wilker')];

				}])->map(function($items){

					return $items->map(function($item){

						return $item->map(function($item){

							return [

								'total' 	=> (int) $item->total,
								'no_seri' 	=> $item->no_seri,
								'dokumen' 	=> null === $item->dokumen ?: str_replace('-', '', $item->dokumen->dokumen),
								'wilker' 	=> null === $item->wilker ?: $item->wilker->getOriginal('nama_wilker'),

							];

						});

					});

				});
	}

	/**
     * Modify data persediaan dokumen KH
     *
     * @return array
     */
	public function transformPersediaanDokumenKh()
	{
		return PenerimaanKh::getJumlahKhDokumen($this->params)
				->groupBy([ function($item, $key){

					return [$item->dokumen['dokumen']];

				}, function($item, $key){

					return [$item->wilker->getOriginal('nama_wilker')];

				}])->map(function($items){

					return $items->map(function($item){

						return $item->map(function($item){

							return [

								'total' 	=> (int) $item->total,
								'no_seri' 	=> $item->no_seri,
								'dokumen' 	=> null === $item->dokumen ?: str_replace('-', '', $item->dokumen->dokumen),
								'wilker' 	=> null === $item->wilker ?: $item->wilker->getOriginal('nama_wilker'),

							];

						});

					});

				});
	}

	/**
     * Modify data penerimaan dokumen KT
     * group berdasarkan dokumen, wilker, kemudian modif beberapa propertinya
     *
     * @return array
     */
	public function transformPenerimaanDokumenKt()
	{
		return PenerimaanKt::getJumlahKtDokumen($this->params)
				->groupBy([ function($item, $key){

					return [$item->dokumen['dokumen']];

				}, function($item, $key){

					return [$item->wilker->getOriginal('nama_wilker')];

				}])->map(function($items){

					return $items->map(function($item){

						return $item->map(function($item){

							return [

								'total' 	=> (int) $item->total,
								'no_seri' 	=> $item->no_seri,
								'dokumen' 	=> null === $item->dokumen ?: str_replace('-', '', $item->dokumen->dokumen),
								'wilker' 	=> null === $item->wilker ?: $item->wilker->getOriginal('nama_wilker'),

							];

						});

					});

				});
	}

	/**
     * Modify data penerimaan dokumen KH
     * group berdasarkan dokumen, wilker, kemudian modif beberapa propertinya
     *
     * @return array
     */
	public function transformPenerimaanDokumenKh()
	{
		return PenerimaanKh::getJumlahKhDokumen($this->params)
				->groupBy([ function($item, $key){

					return [$item->dokumen['dokumen']];

				}, function($item, $key){

					return [$item->wilker->getOriginal('nama_wilker')];

				}])->map(function($items){

					return $items->map(function($item){

						return $item->map(function($item){

							return [

								'total' 	=> (int) $item->total,
								'no_seri' 	=> $item->no_seri,
								'dokumen' 	=> null === $item->dokumen ?: str_replace('-', '', $item->dokumen->dokumen),
								'wilker' 	=> null === $item->wilker ?: $item->wilker->getOriginal('nama_wilker'),

							];

						});

					});

				});
	}

	/**
     * Modify data pemakaian dokumen KT
     * group berdasarkan dokumen, wilker, kemudian modif beberapa propertinya
     *
     * @return array
     */
	public function transformPemakaianDokumenKt()
	{
		return PemakaianDokumenKt::getJumlahKtDokumen($this->params)
				->groupBy([ function($item, $key){

					return [$item['dokumen']];

				}, function($item, $key){

					return [$item->wilker->getOriginal('nama_wilker')];

				}])->map(function($item){

					return $item->map(function($item){

						return [

							'total' 	=> $item->sum('total'),
							'no_seri' 	=> $this->setNoSeriPemakaian($item),
							'dokumen' 	=> $item->first()->dokumen,
						];
					
					});

				});
	}

	/**
     * Modify data pemakaian dokumen KH
     * group berdasarkan dokumen, wilker, kemudian modif beberapa propertinya
     *
     * @return array
     */
	public function transformPemakaianDokumenKh()
	{
		return PemakaianDokumenKh::getJumlahKhDokumen($this->params)
				->groupBy([ function($item, $key){

					return [$item['dokumen']];

				}, function($item, $key){

					return [$item->wilker->getOriginal('nama_wilker')];

				}])->map(function($item){

					return $item->map(function($item){

						return [

							'total' 	=> $item->sum('total'),
							'no_seri' 	=> $this->setNoSeriPemakaian($item),
							'dokumen' 	=> $item->first()->dokumen,
						];
					
					});

				});
	}

	/**
     * Modify no seri pemakaian dokumen
     * sortir berdasarkan no seri dokumen (asc), 
     * apabila total dokumen hanya satu, maka hilangkan "-", ex : 12345-12345 -> 12345
     * apabila lebih dari satu maka concat dari yang terkecil - terbesar saja
     *
     * @param string $item
     * @return string
     */
	public function setNoSeriPemakaian($item)
	{
		$imp = implode(',', $item->sortBy('no_seri')->pluck('no_seri')->all());

		$exp = explode('-', $imp);

		if ($item->sum('total') == 1) {

			return str_replace(',', '', $exp[0]);

		}

		return str_replace(',', '', $exp[0]) .'-'. str_replace(',', '', end($exp));
	}

}