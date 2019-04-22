<?php

namespace App\Providers;

use Maatwebsite\Excel\Sheet;
use Illuminate\Support\ServiceProvider;

class ExcelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Untuk styling cell pada laporan excel
        Sheet::macro('styleCells', function (Sheet $sheet, $cellRange, array $style) {

            if (is_array($cellRange)) {

                foreach ($cellRange as $cell) {
                   $sheet->getDelegate()->getStyle($cell)->applyFromArray($style);
                }

            } elseif (is_string($cellRange)) {
                $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
            }
           
        });

        // Untuk set kebutuhan height row laporan
        Sheet::macro('setRowHeight', function (Sheet $sheet, int $cellRange, int $value) {

            $sheet->getDelegate()->getRowDimension($cellRange, true)->setRowHeight($value);   
        
        });

        // Untuk set kebutuhan lebar column laporan
        Sheet::macro('setColumnWidth', function (Sheet $sheet, string $cellRange, int $value) {

            $sheet->getDelegate()->getColumnDimension($cellRange, true)->setWidth($value);   
        
        });

        // Untuk set kebutuhan wrap text
        Sheet::macro('setWrapText', function (Sheet $sheet, string $cellRange, array $style) {

            $sheet->getDelegate()->getStyle($cellRange)->getAlignment()->applyFromArray($style);   
        
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
