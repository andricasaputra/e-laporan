<?php

namespace App\Contracts;

interface ModelOperasionalInterface
{
    public function scopeSortTableDetail($query, array $params);

    public function scopeCountFrekuensiByPermohonan($query, array $params);

    public function scopeCountFrekuensiByKomoditi($query, array $params);

    public function scopeCountPemakaianDokumen($query, array $params);
}