<?php

namespace App\Contracts\Operasional;

interface ModelPembatalanInterface
{
    public function scopeSortTableDetail($query, array $params);

    public function scopeCountFrekuensiByPermohonan($query, array $params);

    public function scopeCountFrekuensiByKomoditi($query, array $params);

    public function scopeCountPemakaianDokumen($query, array $params);
}