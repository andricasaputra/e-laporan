<?php

namespace App\Contracts;

interface ModelOperasionalInterface
{
	public function getBulanAttribute($value);

    public function scopeSortTableDetail($query, $year = false, $month = false, $wilker_id = false);

    public function scopeCountFrekuensi($query, $year, $month = false, $wilker_id = false);

    public function scopeCountPemakaianDokumen($query, $year, $month = false, $wilker_id = false);

    public function scopeCountFrekuensiKomoditi($query, $year, $month = false, $wilker_id = false);
}