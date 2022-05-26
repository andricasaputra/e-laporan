<?php

namespace App\Models\Penugasan;

use App\Models\Wilker;

trait QueryScopePenugasan
{
     

     /**
     * One to many relations
     *
     * @return void
     */
    public function wilker()
    {
      return $this->belongsTo(Wilker::class);
    }

    /**
     * Untuk Mensortir Detail Table (Table Global)
     *
     * @param $query
     * @param array $arguments
     * @return void
     */
    public function scopeSortTableDetail($query, array $arguments)
    {
        $query->whereYear('bulan', $arguments[0] ?? date('Y'));

        $query->when($arguments[1] && $arguments[1] != 'all', function ($query) use ($arguments) {

          return $query->whereMonth('bulan', $arguments[1]);

        });

        $query->when(! is_null($arguments[2]) && (int) $arguments[2] !== 1, function ($query) use ($arguments) {

          return $query->whereWilkerId($arguments[2]);

        });

        return $query;
    }
}