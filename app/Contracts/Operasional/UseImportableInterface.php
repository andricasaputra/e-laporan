<?php 

namespace App\Contracts\Operasional;

use Illuminate\Support\Collection;

interface UseImportableInterface
{
	/**
     * @param string|UploadedFile|null $filePath
     * @param string|null              $disk
     * @param string|null              $readerType
     *
     * @throws NoFilePathGivenException
     * @return Collection
     */
	public function toCollection($filePath = null, string $disk = null, string $readerType = null) : Collection;
}