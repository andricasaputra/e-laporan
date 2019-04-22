<?php

namespace App\Contracts\Operasional;

interface ModelReportBillingInterface
{
	/**
     * Untuk mengatur tampilan tanggal billing
     *
     * @param string $value
     * @return string
     */
	public function getTglBillingAttribute($value);

	/**
     * Untuk menyimpan wilker
     *
     * @return string
     */
	public function wilker();
}