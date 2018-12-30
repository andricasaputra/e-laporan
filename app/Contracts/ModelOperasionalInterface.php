<?php

namespace App\Contracts;

interface ModelOperasionalInterface
{
	public function getBulanAttribute($value);

    public function scopeSortTableDetail($query, $year = null, $month = null, $wilker_id = null);

    public function scopeCountFrekuensi($query, $year, $month = null, $wilker_id = null);

    public function scopeCountPemakaianDokumen($query, $year, $month = null, $wilker_id = null);

    public function scopeCountFrekuensiKomoditi($query, $year, $month = null, $wilker_id = null);
}